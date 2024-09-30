<?php

namespace Src\Dto\Responses\Factories;

interface CurrencyRatesFactoryInterface
{
    public function createFromArray(array $data): array;
}