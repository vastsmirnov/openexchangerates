<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\Currency;
use Src\Dto\Responses\Factories\CurrencyFactory;
use Src\Dto\Responses\Factories\CurrencyFactoryInterface;

class CurrencyFactoryTest extends TestCase
{
    private CurrencyFactoryInterface $currencyFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyFactory = new CurrencyFactory();
    }

    public function testCreateWithValidInputs(): void
    {
        $validCode = 'USD';
        $currency = $this->currencyFactory->create($validCode);

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame($validCode, $currency->code);
    }

    #[DataProvider('invalidInputProvider')]
    public function testCreateCurrencyCodeWithInvalidInput(string $invalidInput): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency code can not be empty.');

        $this->currencyFactory->create($invalidInput);
    }

    /**
     * @return array<array<string>>
     */
    public static function invalidInputProvider(): array
    {
        return [
            [''],
            [' '],
        ];
    }
}
