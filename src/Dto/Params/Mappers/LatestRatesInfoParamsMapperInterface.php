<?php

namespace Src\Dto\Params\Mappers;

use Src\Dto\Params\LatestRatesInfoParams;

interface LatestRatesInfoParamsMapperInterface
{
    public function toQueryParams(LatestRatesInfoParams $params): array;
}