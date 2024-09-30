<?php

namespace Src\Dto\Params\Mappers;

use Src\Dto\Params\LatestRatesInfoParams;

interface LatestRatesInfoParamsMapperInterface
{
    /**
     * @param LatestRatesInfoParams $params
     * @return array<string, string>
     */
    public function toQueryParams(LatestRatesInfoParams $params): array;
}
