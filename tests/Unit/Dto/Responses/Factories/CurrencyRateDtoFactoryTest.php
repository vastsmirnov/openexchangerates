<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\CurrencyDto;
use Src\Dto\Responses\CurrencyRateDto;
use Src\Dto\Responses\Factories\CurrencyDtoFactoryInterface;
use Src\Dto\Responses\Factories\CurrencyRateDtoFactory;
use Src\Dto\Responses\Factories\CurrencyRateDtoFactoryInterface;
use Src\Dto\Responses\Factories\RateDtoFactoryInterface;
use Src\Dto\Responses\RateDto;

class CurrencyRateDtoFactoryTest extends TestCase
{
    private CurrencyDtoFactoryInterface|MockObject  $currencyDtoFactoryMock;

    private RateDtoFactoryInterface|MockObject $rateDtoFactoryMock;

    private CurrencyRateDtoFactoryInterface $currencyRateDtoFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyDtoFactoryMock = $this->createMock(CurrencyDtoFactoryInterface::class);
        $this->rateDtoFactoryMock = $this->createMock(RateDtoFactoryInterface::class);

        $this->currencyRateDtoFactory = new CurrencyRateDtoFactory(
            $this->currencyDtoFactoryMock,
            $this->rateDtoFactoryMock
        );
    }

    public function testCreateReturnsCurrencyRateWithValidDependencies(): void
    {
        $currencyCode = 'USD';
        $rateValue = 1.2345;
        $currency = new CurrencyDto($currencyCode);
        $rate = new RateDto($rateValue);

        $this->currencyDtoFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($currencyCode)
            ->willReturn($currency);

        $this->rateDtoFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with($rateValue)
            ->willReturn($rate);

        $result = $this->currencyRateDtoFactory->create($currencyCode, $rateValue);

        $this->assertInstanceOf(CurrencyRateDto::class, $result);
        $this->assertSame($currency, $result->currency);
        $this->assertSame($currency->code, $result->currency->code);
        $this->assertSame($rate, $result->rate);
        $this->assertSame($rate->value, $result->rate->value);
    }
}
