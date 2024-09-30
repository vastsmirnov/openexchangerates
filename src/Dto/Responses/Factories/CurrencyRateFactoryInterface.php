<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\CurrencyRate;

interface CurrencyRateFactoryInterface
{
    public function create(string $currencyCode, float $rate): CurrencyRate;
}