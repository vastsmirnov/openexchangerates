<?php

declare(strict_types=1);

namespace Src\Dto\Responses;

readonly class CurrencyRateDto
{
    public function __construct(
        public CurrencyDto $currency,
        public RateDto $rate
    ) {
    }
}
