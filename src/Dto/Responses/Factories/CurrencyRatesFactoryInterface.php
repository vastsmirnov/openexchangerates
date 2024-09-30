<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\CurrencyRate;

interface CurrencyRatesFactoryInterface
{
    /**
     * @param array<string, float> $data
     * @return CurrencyRate[]
     */
    public function createFromArray(array $data): array;
}
