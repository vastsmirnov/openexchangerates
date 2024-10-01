<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\CurrencyRateDto;

final class CurrencyRateDtoFactory implements CurrencyRateDtoFactoryInterface
{
    public function __construct(
        private CurrencyDtoFactoryInterface $currencyDtoFactory,
        private RateDtoFactoryInterface $rateDtoFactory
    ) {
    }

    public function create(string $currencyCode, float $rate): CurrencyRateDto
    {
        return new CurrencyRateDto(
            $this->currencyDtoFactory->create($currencyCode),
            $this->rateDtoFactory->create($rate)
        );
    }
}
