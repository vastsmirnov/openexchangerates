<?php

declare(strict_types=1);

namespace Src\Dto\Responses;

readonly class Currency
{
    public function __construct(
        public string $code
    ) {
    }
}
