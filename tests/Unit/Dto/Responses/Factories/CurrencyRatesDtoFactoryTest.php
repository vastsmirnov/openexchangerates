<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\CurrencyDto;
use Src\Dto\Responses\CurrencyRateDto;
use Src\Dto\Responses\Factories\CurrencyRateDtoFactoryInterface;
use Src\Dto\Responses\Factories\CurrencyRatesDtoFactory;
use Src\Dto\Responses\Factories\CurrencyRatesDtoFactoryInterface;
use Src\Dto\Responses\RateDto;

class CurrencyRatesDtoFactoryTest extends TestCase
{
    private CurrencyRateDtoFactoryInterface|MockObject $currencyRateDtoFactoryMock;

    private CurrencyRatesDtoFactoryInterface $currencyRatesDtoFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyRateDtoFactoryMock = $this->createMock(CurrencyRateDtoFactoryInterface::class);

        $this->currencyRatesDtoFactory = new CurrencyRatesDtoFactory(
            $this->currencyRateDtoFactoryMock
        );
    }

    public function testCreateFromArrayWithEmptyDataReturnsEmptyArray(): void
    {
        $data = [];

        $this->currencyRateDtoFactoryMock
            ->expects($this->never())
            ->method('create');

        $result = $this->currencyRatesDtoFactory->createFromArray($data);

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
            'USD' => new CurrencyRateDto(new CurrencyDto('USD'), new RateDto(1.0)),
            'EUR' => new CurrencyRateDto(new CurrencyDto('EUR'), new RateDto(0.85)),
            'RUB' => new CurrencyRateDto(new CurrencyDto('RUB'), new RateDto(0.53)),
        ];

        $this->currencyRateDtoFactoryMock
            ->expects($this->exactly(3))
            ->method('create')
            ->willReturnCallback(function (string $currencyCode) use ($expectedCurrencyRates) {
                return $expectedCurrencyRates[$currencyCode]
                    ?? throw new InvalidArgumentException("Invalid currency code \"$currencyCode\".");
            });

        $result = $this->currencyRatesDtoFactory->createFromArray($data);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertSame(array_values($expectedCurrencyRates), $result);
    }
}
