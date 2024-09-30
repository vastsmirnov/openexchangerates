<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use Src\Dto\Responses\Rate;

final class RateFactory implements RateFactoryInterface
{
    public function create(float $value): Rate
    {
        return new Rate($value);
    }
}
