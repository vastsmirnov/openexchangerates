<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\RateDto;

interface RateDtoFactoryInterface
{
    public function create(float $value): RateDto;
}
