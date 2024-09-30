<?php

declare(strict_types=1);

namespace Src\Dto\Responses;

readonly class CurrencyRate
{
    public function __construct(
        public Currency $currency,
        public Rate $rate
    ) {}
}
