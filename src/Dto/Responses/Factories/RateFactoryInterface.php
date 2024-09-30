<?php

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\Rate;

interface RateFactoryInterface
{
    public function create(float $value): Rate;
}