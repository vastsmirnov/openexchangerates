<?php

declare(strict_types=1);

namespace Src\Dto\Responses;

readonly class RateDto
{
    public function __construct(
        public float $value
    ) {
    }
}
