<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\Currency;
use Src\Dto\Responses\CurrencyRate;
use Src\Dto\Responses\Factories\CurrencyRateFactoryInterface;
use Src\Dto\Responses\Factories\CurrencyRatesFactory;
use Src\Dto\Responses\Factories\CurrencyRatesFactoryInterface;
use Src\Dto\Responses\Rate;

class CurrencyRatesFactoryTest extends TestCase
{
    private CurrencyRateFactoryInterface|MockObject $currencyRateFactoryMock;

    private CurrencyRatesFactoryInterface $currencyRatesFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyRateFactoryMock = $this->createMock(CurrencyRateFactoryInterface::class);

        $this->currencyRatesFactory = new CurrencyRatesFactory(
            $this->currencyRateFactoryMock
        );
    }

    public function testCreateFromArrayWithEmptyDataReturnsEmptyArray(): void
    {
        $data = [];

        $this->currencyRateFactoryMock
            ->expects($this->never())
            ->method('create');

        $result = $this->currencyRatesFactory->createFromArray($data);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testCreateFromArraySuccessfully(): void
    {
        $data = [
            'USD' => 1.0,
            'EUR' => 0.85,
            'RUB' => 0.53,
        ];

        $expectedCurrencyRates = [
            'USD' => new CurrencyRate(new Currency('USD'), new Rate(1.0)),
            'EUR' => new CurrencyRate(new Currency('EUR'), new Rate(0.85)),
            'RUB' => new CurrencyRate(new Currency('RUB'), new Rate(0.53)),
        ];

        $this->currencyRateFactoryMock
            ->expects($this->exactly(3))
            ->method('create')
            ->willReturnCallback(function (string $currencyCode) use ($expectedCurrencyRates) {
                return $expectedCurrencyRates[$currencyCode]
                    ?? throw new InvalidArgumentException("Invalid currency code \"$currencyCode\".");
            });

        $result = $this->currencyRatesFactory->createFromArray($data);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertSame(array_values($expectedCurrencyRates), $result);
    }
}
