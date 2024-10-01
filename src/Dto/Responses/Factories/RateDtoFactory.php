<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\RateDto;

final class RateDtoFactory implements RateDtoFactoryInterface
{
    public function create(float $value): RateDto
    {
        return new RateDto($value);
    }
}
