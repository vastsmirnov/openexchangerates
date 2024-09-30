<?php

declare(strict_types=1);

namespace Src\Dto\Params;

readonly class LatestRatesInfoParams
{
    /**
     * @param string $byCurrency
     * @param string[] $targetCurrencyCodes
     * @param bool $showAlternative
     */
    public function __construct(
        public string $byCurrency = 'USD',
        public array $targetCurrencyCodes = [],
        public bool $showAlternative = false
    ) {
    }
}
