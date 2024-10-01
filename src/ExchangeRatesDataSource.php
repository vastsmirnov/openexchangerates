<?php

declare(strict_types=1);

namespace Src;

use Psr\Log\LoggerInterface;
use Src\Client\OpenExchangeRatesClientInterface;
use Src\Dto\Params\Mappers\LatestRatesInfoParamsMapperInterface;
use Src\Dto\Params\LatestRatesInfoParamsDto;
use Src\Dto\Responses\ExchangeCurrencyRatesDto;
use Src\Dto\Responses\Factories\ExchangeRatesDtoFactoryInterface;
use Throwable;

final class ExchangeRatesDataSource implements ExchangeRatesDataSourceInterface
{
    public function __construct(
        private OpenExchangeRatesClientInterface $client,
        private LatestRatesInfoParamsMapperInterface $paramsMapper,
        private ExchangeRatesDtoFactoryInterface $exchangeRatesFactory,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getLatestRatesInfo(
        LatestRatesInfoParamsDto $params
    ): ExchangeCurrencyRatesDto {
        try {
            $queryParams = $this->paramsMapper->toQueryParams($params);

            $response = $this->client->get(
                'api/latest.json',
                $queryParams
            );

            return $this->exchangeRatesFactory->createFromArray($response);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw $exception;
        }
    }
}
