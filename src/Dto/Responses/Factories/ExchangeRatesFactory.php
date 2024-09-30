<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use InvalidArgumentException;
use Src\Dto\Responses\ExchangeCurrencyRates;

final class ExchangeRatesFactory implements ExchangeRatesFactoryInterface
{
    public function __construct(
        private CurrencyFactoryInterface $currencyFactory,
        private DateTimeImmutableFactoryInterface $dateTimeImmutableFactory,
        private CurrencyRatesFactoryInterface $currencyRatesFactory
    ) {}

    public function createFromArray(array $data): ExchangeCurrencyRates
    {
        $code = $data['base'] ?? throw new InvalidArgumentException('Base is missing.');
        $timestamp = $data['timestamp'] ?? throw new InvalidArgumentException('Timestamp is missing.');
        $ratesData = $data['rates'] ?? throw new InvalidArgumentException('Rates is missing.');

        return new ExchangeCurrencyRates(
            $this->currencyFactory->create($code),
            $this->dateTimeImmutableFactory->createByTimestamp($timestamp),
            $this->currencyRatesFactory->createFromArray($ratesData)
        );
    }
}
