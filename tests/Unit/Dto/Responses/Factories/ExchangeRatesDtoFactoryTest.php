<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\CurrencyDto;
use Src\Dto\Responses\CurrencyRateDto;
use Src\Dto\Responses\ExchangeCurrencyRatesDto;
use Src\Dto\Responses\Factories\CurrencyDtoFactoryInterface;
use Src\Dto\Responses\Factories\CurrencyRatesDtoFactoryInterface;
use Src\Dto\Responses\Factories\DateTimeImmutableFactoryInterface;
use Src\Dto\Responses\Factories\ExchangeRatesDtoFactory;
use Src\Dto\Responses\Factories\ExchangeRatesDtoFactoryInterface;
use Src\Dto\Responses\RateDto;

class ExchangeRatesDtoFactoryTest extends TestCase
{
    private CurrencyDtoFactoryInterface|MockObject $currencyDtoFactoryMock;

    private DateTimeImmutableFactoryInterface|MockObject $dateTimeImmutableFactoryMock;

    private CurrencyRatesDtoFactoryInterface|MockObject $currencyRatesDtoFactoryMock;

    private ExchangeRatesDtoFactoryInterface $exchangeRatesDtoFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyDtoFactoryMock = $this->createMock(CurrencyDtoFactoryInterface::class);
        $this->dateTimeImmutableFactoryMock = $this->createMock(DateTimeImmutableFactoryInterface::class);
        $this->currencyRatesDtoFactoryMock = $this->createMock(CurrencyRatesDtoFactoryInterface::class);

        $this->exchangeRatesDtoFactory = new ExchangeRatesDtoFactory(
            $this->currencyDtoFactoryMock,
            $this->dateTimeImmutableFactoryMock,
            $this->currencyRatesDtoFactoryMock
        );
    }

    public function testCreateFromArrayReturnsExchangeCurrencyRatesWithValidData(): void
    {
        $rates = [
            'EUR' => 0.85,
            'RUB' => 0.53,
        ];
        $data = [
            'base' => 'USD',
            'timestamp' => 1609459200,
            'rates' => $rates
        ];
        $timestamp = 1609459200;

        $targetCurrency = new CurrencyDto('USD');
        $dateTime = (new DateTimeImmutable())->setTimestamp($timestamp);
        $currencyRates = [
            new CurrencyRateDto(new CurrencyDto('EUR'), new RateDto(0.85)),
            new CurrencyRateDto(new CurrencyDto('RUB'), new RateDto(0.53)),
        ];

        $exchangeCurrencyRates = new ExchangeCurrencyRatesDto($targetCurrency, $dateTime, $currencyRates);

        $this->currencyDtoFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with('USD')
            ->willReturn($targetCurrency);

        $this->dateTimeImmutableFactoryMock
            ->expects($this->once())
            ->method('createByTimestamp')
            ->with($timestamp)
            ->willReturn($dateTime);

        $expectedCurrencyRates = [
            new CurrencyRateDto(new CurrencyDto('EUR'), new RateDto(0.85)),
            new CurrencyRateDto(new CurrencyDto('RUB'), new RateDto(0.53)),
        ];

        $this->currencyRatesDtoFactoryMock
            ->expects($this->once())
            ->method('createFromArray')
            ->with($rates)
            ->willReturn($expectedCurrencyRates);

        $result = $this->exchangeRatesDtoFactory->createFromArray($data);

        $this->assertInstanceOf(ExchangeCurrencyRatesDto::class, $result);
        $this->assertSame($exchangeCurrencyRates->targetCurrency, $result->targetCurrency);
        $this->assertSame($exchangeCurrencyRates->datetime, $result->datetime);
        $this->assertEquals($exchangeCurrencyRates->currencyRates, $result->currencyRates);
    }

    public function testCreateFromArrayThrowsExceptionWhenBaseIsMissing(): void
    {
        $data = [
            'timestamp' => 1609459200,
            'rates' => [
                'EUR' => 0.85,
            ],
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Base is missing.');

        $this->exchangeRatesDtoFactory->createFromArray($data);
    }

    public function testCreateFromArrayThrowsExceptionWhenTimestampIsMissing(): void
    {
        $data = [
            'base' => 'USD',
            'rates' => [
                'EUR' => 0.85,
            ],
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Timestamp is missing.');

        $this->exchangeRatesDtoFactory->createFromArray($data);
    }

    public function testCreateFromArrayThrowsExceptionWhenRatesIsMissing(): void
    {
        $data = [
            'base' => 'USD',
            'timestamp' => 1609459200,
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Rates is missing.');

        $this->exchangeRatesDtoFactory->createFromArray($data);
    }
}
