<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\CurrencyDto;

interface CurrencyDtoFactoryInterface
{
    public function create(string $currencyCode): CurrencyDto;
}
