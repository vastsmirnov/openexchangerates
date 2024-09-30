<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\CurrencyRate;

final class CurrencyRateFactory implements CurrencyRateFactoryInterface
{
    public function __construct(
        private CurrencyFactoryInterface $currencyFactory,
        private RateFactoryInterface $rateFactory
    ) {
    }

    public function create(string $currencyCode, float $rate): CurrencyRate
    {
        return new CurrencyRate(
            $this->currencyFactory->create($currencyCode),
            $this->rateFactory->create($rate)
        );
    }
}
