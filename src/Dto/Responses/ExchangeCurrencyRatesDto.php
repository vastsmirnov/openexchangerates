<?php

declare(strict_types=1);

namespace Src\Dto\Responses;

use DateTimeImmutable;

readonly class ExchangeCurrencyRatesDto
{
    /**
     * @param CurrencyDto $targetCurrency
     * @param DateTimeImmutable $datetime
     * @param CurrencyRateDto[] $currencyRates
     */
    public function __construct(
        public CurrencyDto $targetCurrency,
        public DateTimeImmutable $datetime,
        public array $currencyRates
    ) {
    }
}
