<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\Currency;

interface CurrencyFactoryInterface
{
    public function create(string $trimmedCode): Currency;
}