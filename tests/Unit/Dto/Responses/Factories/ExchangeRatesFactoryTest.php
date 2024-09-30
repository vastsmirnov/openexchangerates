<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\Currency;
use Src\Dto\Responses\CurrencyRate;
use Src\Dto\Responses\ExchangeCurrencyRates;
use Src\Dto\Responses\Factories\CurrencyFactoryInterface;
use Src\Dto\Responses\Factories\CurrencyRatesFactoryInterface;
use Src\Dto\Responses\Factories\DateTimeImmutableFactoryInterface;
use Src\Dto\Responses\Factories\ExchangeRatesFactory;
use Src\Dto\Responses\Factories\ExchangeRatesFactoryInterface;
use Src\Dto\Responses\Rate;

class ExchangeRatesFactoryTest extends TestCase
{
    private CurrencyFactoryInterface|MockObject $currencyFactoryMock;

    private DateTimeImmutableFactoryInterface|MockObject $dateTimeImmutableFactoryMock;

    private CurrencyRatesFactoryInterface|MockObject $currencyRatesFactoryMock;

    private ExchangeRatesFactoryInterface $exchangeRatesFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyFactoryMock = $this->createMock(CurrencyFactoryInterface::class);
        $this->dateTimeImmutableFactoryMock = $this->createMock(DateTimeImmutableFactoryInterface::class);
        $this->currencyRatesFactoryMock = $this->createMock(CurrencyRatesFactoryInterface::class);

        $this->exchangeRatesFactory = new ExchangeRatesFactory(
            $this->currencyFactoryMock,
            $this->dateTimeImmutableFactoryMock,
            $this->currencyRatesFactoryMock
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

        $targetCurrency = new Currency('USD');
        $dateTime = (new DateTimeImmutable())->setTimestamp($timestamp);
        $currencyRates = [
            new CurrencyRate(new Currency('EUR'), new Rate(0.85)),
            new CurrencyRate(new Currency('RUB'), new Rate(0.53)),
        ];

        $exchangeCurrencyRates = new ExchangeCurrencyRates($targetCurrency, $dateTime, $currencyRates);

        $this->currencyFactoryMock
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
            new CurrencyRate(new Currency('EUR'), new Rate(0.85)),
            new CurrencyRate(new Currency('RUB'), new Rate(0.53)),
        ];

        $this->currencyRatesFactoryMock
            ->expects($this->once())
            ->method('createFromArray')
            ->with($rates)
            ->willReturn($expectedCurrencyRates);

        $result = $this->exchangeRatesFactory->createFromArray($data);

        $this->assertInstanceOf(ExchangeCurrencyRates::class, $result);
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

        $this->exchangeRatesFactory->createFromArray($data);
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

        $this->exchangeRatesFactory->createFromArray($data);
    }

    public function testCreateFromArrayThrowsExceptionWhenRatesIsMissing(): void
    {
        $data = [
            'base' => 'USD',
            'timestamp' => 1609459200,
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Rates is missing.');

        $this->exchangeRatesFactory->createFromArray($data);
    }
}
