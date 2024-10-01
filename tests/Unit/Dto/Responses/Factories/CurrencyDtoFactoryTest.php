<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\CurrencyDto;
use Src\Dto\Responses\Factories\CurrencyDtoFactory;
use Src\Dto\Responses\Factories\CurrencyDtoFactoryInterface;

class CurrencyDtoFactoryTest extends TestCase
{
    private CurrencyDtoFactoryInterface $currencyDtoFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyDtoFactory = new CurrencyDtoFactory();
    }

    public function testCreateWithValidInputs(): void
    {
        $validCode = 'USD';
        $currency = $this->currencyDtoFactory->create($validCode);

        $this->assertInstanceOf(CurrencyDto::class, $currency);
        $this->assertSame($validCode, $currency->code);
    }

    #[DataProvider('invalidInputProvider')]
    public function testCreateCurrencyCodeWithInvalidInput(string $invalidInput): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency code can not be empty.');

        $this->currencyDtoFactory->create($invalidInput);
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
