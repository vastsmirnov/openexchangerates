<?php

namespace Src\Dto\Responses\Factories;

use DateTimeImmutable;

interface DateTimeImmutableFactoryInterface
{
    public function createByTimestamp(int $timestamp): DateTimeImmutable;
}
