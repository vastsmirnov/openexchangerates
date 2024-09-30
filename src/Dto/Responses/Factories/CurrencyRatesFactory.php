<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

final class CurrencyRatesFactory implements CurrencyRatesFactoryInterface
{
    public function __construct(
        private CurrencyRateFactoryInterface $currencyRateFactory,
    ) {
    }

    public function createFromArray(array $data): array
    {
        $rates = [];
        foreach ($data as $currencyCode => $rate) {
            $rates[] = $this->currencyRateFactory->create($currencyCode, (float) $rate);
        }

        return $rates;
    }
}
