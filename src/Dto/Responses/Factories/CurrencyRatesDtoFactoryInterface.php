<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\CurrencyRateDto;

interface CurrencyRatesDtoFactoryInterface
{
    /**
     * @param array<string, float> $data
     * @return CurrencyRateDto[]
     *
     * @example
     *  <code>
     *      $data = [
     *          "USD" => 1.0,
     *          "EUR" => 0.85,
     *         "RUB" => 0.53,
     *      ];
     *  </code>
     */
    public function createFromArray(array $data): array;
}
