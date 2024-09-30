<?php

declare(strict_types=1);

namespace Src\Dto\Params\Mappers;

use Src\Dto\Params\LatestRatesInfoParams;

final class LatestRatesInfoParamsMapper implements LatestRatesInfoParamsMapperInterface
{
    /**
     * @inheritDoc
     */
    public function toQueryParams(LatestRatesInfoParams $params): array
    {
        $result = [
            'base' => $params->byCurrency,
            'show_alternative' => $params->showAlternative
        ];

        if ($params->targetCurrencyCodes !== []) {
            $result['symbols'] = implode(',', $params->targetCurrencyCodes);
        }

        return $result;
    }
}
