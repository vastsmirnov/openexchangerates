<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use InvalidArgumentException;
use Src\Dto\Responses\CurrencyDto;

final class CurrencyDtoFactory implements CurrencyDtoFactoryInterface
{
    public function create(string $currencyCode): CurrencyDto
    {
        if (trim($currencyCode) === '') {
            throw new InvalidArgumentException('Currency code can not be empty.');
        }

        return new CurrencyDto($currencyCode);
    }
}
