<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\ExchangeCurrencyRates;

interface ExchangeRatesFactoryInterface
{
    public function createFromArray(array $data): ExchangeCurrencyRates;
}