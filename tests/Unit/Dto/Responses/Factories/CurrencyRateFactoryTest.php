<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\Currency;
use Src\Dto\Responses\CurrencyRate;
use Src\Dto\Responses\Factories\CurrencyFactoryInterface;
use Src\Dto\Responses\Factories\CurrencyRateFactory;
use Src\Dto\Responses\Factories\CurrencyRateFactoryInterface;
use Src\Dto\Responses\Factories\RateFactoryInterface;
use Src\Dto\Responses\Rate;

class CurrencyRateFactoryTest extends TestCase
{
    private CurrencyFactoryInterface|MockObject  $currencyFactoryMock;

    private RateFactoryInterface|MockObject $rateFactoryMock;

    private CurrencyRateFactoryInterface $currencyRateFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyFactoryMock = $this->createMock(CurrencyFactoryInterface::class);
        $this->rateFactoryMock = $this->createMock(RateFactoryInterface::class);

        $this->currencyRateFactory = new CurrencyRateFactory(
            $this->currencyFactoryMock,
            $this->rateFactoryMock
        );
    }

    public function testCreateReturnsCurrencyRateWithValidDependencies(): void
    {
        $currencyCode = 'USD';
        $rateValue = 1.2345;
        $currency = new Currency($currencyCode);
        $rate = new Rate($rateValue);

        $this->currencyFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($currencyCode)
            ->willReturn($currency);

        $this->rateFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($rateValue)
            ->willReturn($rate);

        $result = $this->currencyRateFactory->create($currencyCode, $rateValue);

        $this->assertInstanceOf(CurrencyRate::class, $result);
        $this->assertSame($currency, $result->currency);
        $this->assertSame($currency->code, $result->currency->code);
        $this->assertSame($rate, $result->rate);
        $this->assertSame($rate->value, $result->rate->value);
    }
}
