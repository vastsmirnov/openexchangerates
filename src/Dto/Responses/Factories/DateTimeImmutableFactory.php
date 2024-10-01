<?php

declare(strict_types=1);

namespace Src\Dto\Responses\Factories;

use DateTimeImmutable;

final class DateTimeImmutableFactory implements DateTimeImmutableFactoryInterface
{
    public function createByTimestamp(int $timestamp): DateTimeImmutable
    {
        return (new DateTimeImmutable())->setTimestamp($timestamp);
    }
}
