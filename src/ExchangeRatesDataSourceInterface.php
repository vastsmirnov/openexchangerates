<?php

declare(strict_types=1);


namespace Src;

use Src\Dto\Params\LatestRatesInfoParamsDto;
use Src\Dto\Responses\ExchangeCurrencyRatesDto;
use Throwable;

interface ExchangeRatesDataSourceInterface
{
    /**
     * @throws Throwable
     */
    public function getLatestRatesInfo(
        LatestRatesInfoParamsDto $params
    ): ExchangeCurrencyRatesDto;
}