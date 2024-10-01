<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

final class CurrencyRatesDtoFactory implements CurrencyRatesDtoFactoryInterface
{
    public function __construct(
        private CurrencyRateDtoFactoryInterface $currencyRateDtoFactory,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function createFromArray(array $data): array
    {
        $rates = [];
        foreach ($data as $currencyCode => $rate) {
            $rates[] = $this->currencyRateDtoFactory->create($currencyCode, (float) $rate);
        }

        return $rates;
    }
}
