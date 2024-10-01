<?php

declare(strict_types=1);

namespace Src\Dto\Responses;

readonly class CurrencyDto
{
    public function __construct(
        public string $code
    ) {
    }
}
