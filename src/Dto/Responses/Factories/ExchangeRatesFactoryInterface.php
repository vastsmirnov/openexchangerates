<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\ExchangeCurrencyRates;

interface ExchangeRatesFactoryInterface
{
    /**
     * @param array<string, mixed> $data
     * @return ExchangeCurrencyRates
     */
    public function createFromArray(array $data): ExchangeCurrencyRates;
}
