<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use InvalidArgumentException;
use Src\Dto\Responses\ExchangeCurrencyRatesDto;

final class ExchangeRatesDtoFactory implements ExchangeRatesDtoFactoryInterface
{
    public function __construct(
        private CurrencyDtoFactoryInterface $currencyDtoFactory,
        private DateTimeImmutableFactoryInterface $dateTimeImmutableFactory,
        private CurrencyRatesDtoFactoryInterface $currencyRatesDtoFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function createFromArray(array $data): ExchangeCurrencyRatesDto
    {
        $code = $data['base'] ?? throw new InvalidArgumentException('Base is missing.');
        $timestamp = $data['timestamp'] ?? throw new InvalidArgumentException('Timestamp is missing.');
        $ratesData = $data['rates'] ?? throw new InvalidArgumentException('Rates is missing.');

        return new ExchangeCurrencyRatesDto(
            $this->currencyDtoFactory->create($code),
            $this->dateTimeImmutableFactory->createByTimestamp($timestamp),
            $this->currencyRatesDtoFactory->createFromArray($ratesData)
        );
    }
}
