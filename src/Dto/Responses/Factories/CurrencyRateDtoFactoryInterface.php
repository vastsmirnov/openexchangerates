<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\CurrencyRateDto;

interface CurrencyRateDtoFactoryInterface
{
    public function create(string $currencyCode, float $rate): CurrencyRateDto;
}
