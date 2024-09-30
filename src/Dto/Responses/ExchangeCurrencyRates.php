<?php

declare(strict_types=1);

namespace Src\Dto\Responses;

use DateTimeImmutable;

readonly class ExchangeCurrencyRates
{
    /**
     * @param Currency $targetCurrency
     * @param DateTimeImmutable $datetime
     * @param CurrencyRate[] $currencyRates
     */
    public function __construct(
        public Currency $targetCurrency,
        public DateTimeImmutable $datetime,
        public array $currencyRates
    ) {
    }
}
