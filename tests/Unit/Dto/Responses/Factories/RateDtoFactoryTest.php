<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\Factories\RateDtoFactory;
use Src\Dto\Responses\Factories\RateDtoFactoryInterface;
use Src\Dto\Responses\RateDto;

class RateDtoFactoryTest extends TestCase
{
    private RateDtoFactoryInterface $rateDtoFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rateDtoFactory = new RateDtoFactory();
    }

    public function testCreateWithPositiveValue(): void
    {
        $value = 0.85;
        $rate = $this->rateDtoFactory->create($value);

        $this->assertInstanceOf(RateDto::class, $rate);
        $this->assertEquals($value, $rate->value);
    }
}
