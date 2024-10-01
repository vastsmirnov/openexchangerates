<?php

namespace Src\Dto\Params\Mappers;

use Src\Dto\Params\LatestRatesInfoParamsDto;

interface LatestRatesInfoParamsMapperInterface
{
    /**
     * @param LatestRatesInfoParamsDto $params
     * @return array<string, string>
     *
     * @example
     *  <code>
     *      $params = [
     *          "base" => "BTC",
     *          "symbols" => "EUR,RUB"
     *      ];
     *  </code>
     */
    public function toQueryParams(LatestRatesInfoParamsDto $params): array;
}
