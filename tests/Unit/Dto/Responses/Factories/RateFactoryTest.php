<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Responses\Factories;

use PHPUnit\Framework\TestCase;
use Src\Dto\Responses\Factories\RateFactory;
use Src\Dto\Responses\Factories\RateFactoryInterface;
use Src\Dto\Responses\Rate;

class RateFactoryTest extends TestCase
{
    private RateFactoryInterface $rateFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rateFactory = new RateFactory();
    }

    public function testCreateWithPositiveValue(): void
    {
        $value = 0.85;
        $rate = $this->rateFactory->create($value);

        $this->assertInstanceOf(Rate::class, $rate);
        $this->assertEquals($value, $rate->value);
    }
}