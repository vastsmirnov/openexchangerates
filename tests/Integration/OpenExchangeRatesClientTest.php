<?php

declare(strict_types=1);

namespace Tests\Integration;

use DateTimeImmutable;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Src\Client\Exceptions\ExceptionResolver;
use Src\Client\OpenExchangeRatesClient;
use Src\Client\Utils\UrlUtils;
use Src\Client\ValueObjects\AppId;
use Src\Client\ValueObjects\BaseUrl;
use Src\Dto\Params\LatestRatesInfoParamsDto;
use Src\Dto\Params\Mappers\LatestRatesInfoParamsMapper;
use Src\Dto\Responses\CurrencyDto;
use Src\Dto\Responses\ExchangeCurrencyRatesDto;
use Src\Dto\Responses\Factories\CurrencyDtoFactory;
use Src\Dto\Responses\Factories\CurrencyRateDtoFactory;
use Src\Dto\Responses\Factories\CurrencyRatesDtoFactory;
use Src\Dto\Responses\Factories\DateTimeImmutableFactory;
use Src\Dto\Responses\Factories\ExchangeRatesDtoFactory;
use Src\Dto\Responses\Factories\RateDtoFactory;
use Src\ExchangeRatesDataSource;
use Src\ExchangeRatesDataSourceInterface;

class OpenExchangeRatesClientTest extends TestCase
{
    private LoggerInterface $loggerMock;

    private BaseUrl $baseUrl;

    private AppId $appId;

    private bool $isPrettyPrint;

    private ExchangeRatesDataSourceInterface $exchangeRatesDataSource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->baseUrl = new BaseUrl(getenv('OPEN_EXCHANGE_BASE_URL'));
        $this->appId = new AppId(getenv('APP_ID'));
        $this->isPrettyPrint = false;

        $this->exchangeRatesDataSource = new ExchangeRatesDataSource(
            new OpenExchangeRatesClient(
                new Client(),
                new ExceptionResolver(),
                new UrlUtils(),
                $this->baseUrl,
                $this->appId,
                $this->isPrettyPrint
            ),
            new LatestRatesInfoParamsMapper(),
            new ExchangeRatesDtoFactory(
                new CurrencyDtoFactory(),
                new DateTimeImmutableFactory(),
                new CurrencyRatesDtoFactory(
                    new CurrencyRateDtoFactory(
                        new CurrencyDtoFactory(),
                        new RateDtoFactory()
                    )
                )
            ),
            $this->loggerMock
        );
    }

    public function testGetLatestRatesInfoSuccessfully(): void
    {
        $byCurrency = 'USD';
        $targetCurrencyCodes = ['AED', 'AFN'];
        $result = $this->exchangeRatesDataSource->getLatestRatesInfo(
            new LatestRatesInfoParamsDto(
                $byCurrency,
                $targetCurrencyCodes
            )
        );

        $this->assertInstanceOf(ExchangeCurrencyRatesDto::class, $result);
        $this->assertInstanceOf(CurrencyDto::class, $result->targetCurrency);
        $this->assertSame($byCurrency, $result->targetCurrency->code);
        $this->assertInstanceOf(DateTimeImmutable::class, $result->datetime);

        $this->assertIsArray($result->currencyRates);
        $receivedCurrencyCodes = array_map(
            fn($rate) => $rate->currency->code,
            $result->currencyRates
        );

        $this->assertEquals($targetCurrencyCodes, $receivedCurrencyCodes);
    }
}