<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\Factories\DateTimeImmutableFactory;
use Src\Dto\Responses\Factories\DateTimeImmutableFactoryInterface;

class DateTimeImmutableFactoryTest extends TestCase
{
    private DateTimeImmutableFactoryInterface $dateTimeImmutableFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dateTimeImmutableFactory = new DateTimeImmutableFactory();
    }

    public function testCreateByTimestampReturnsValidDateTimeImmutable(): void
    {
        $timestamp = 1609459200;
        $expectedDateTime = (new DateTimeImmutable())->setTimestamp($timestamp);

        $result = $this->dateTimeImmutableFactory->createByTimestamp($timestamp);

        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertSame($expectedDateTime->getTimestamp(), $result->getTimestamp());
        $this->assertSame($expectedDateTime->getTimezone()->getName(), $result->getTimezone()->getName());
    }
}