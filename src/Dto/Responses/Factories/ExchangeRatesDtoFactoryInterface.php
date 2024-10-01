<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\ExchangeCurrencyRatesDto;

interface ExchangeRatesDtoFactoryInterface
{
    /**
     * @param array<string, mixed> $data
     * @return ExchangeCurrencyRatesDto
     *
     * @example
     *  <code>
     *      $data = [
     *          "base" => "USD",
     *          "timestamp" => 1609459200,
     *          "rates" => [
     *              "EUR" => 0.85,
     *              "RUB" => 0.53,
     *          ]
     *      ];
     *  </code>
     */
    public function createFromArray(array $data): ExchangeCurrencyRatesDto;
}
