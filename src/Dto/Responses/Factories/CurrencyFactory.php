<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use InvalidArgumentException;
use Src\Dto\Responses\Currency;

final class CurrencyFactory implements CurrencyFactoryInterface
{
    public function create(string $currencyCode): Currency
    {
        if (trim($currencyCode) === '') {
            throw new InvalidArgumentException('Currency code can not be empty.');
        }

        return new Currency($currencyCode);
    }
}
