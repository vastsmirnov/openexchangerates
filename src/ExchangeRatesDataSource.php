<?php

declare(strict_types=1);

namespace Src;

use Src\Client\OpenExchangeRatesClientInterface;
use Src\Dto\Params\Mappers\LatestRatesInfoParamsMapperInterface;
use Src\Dto\Params\LatestRatesInfoParams;
use Src\Dto\Responses\ExchangeCurrencyRates;
use Src\Dto\Responses\Factories\ExchangeRatesFactoryInterface;

final class ExchangeRatesDataSource
{
    public function __construct(
        private OpenExchangeRatesClientInterface $client,
        private LatestRatesInfoParamsMapperInterface $paramsMapper,
        private ExchangeRatesFactoryInterface $exchangeRatesFactory
    ) {
    }

    public function getLatestRatesInfo(
        LatestRatesInfoParams $params
    ): ExchangeCurrencyRates {
        $queryParams = $this->paramsMapper->toQueryParams($params);

        $response = $this->client->get(
            'api/latest.json',
            $queryParams
        );

        return $this->exchangeRatesFactory->createFromArray($response);
    }
}
