<?php

declare(strict_types=1);

namespace Tests\Unit\Client\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Client\ValueObjects\BaseUrl;

class BaseUrlTest extends TestCase
{
    public function testCanCreateBaseUrlWithValidUrl(): void
    {
        $validUrl = 'https://www.example.com';
        $baseUrl = new BaseUrl($validUrl);
        $this->assertSame($validUrl, $baseUrl->value);
    }

    public function testCannotCreateBaseUrlWithInvalidUrl(): void
    {
        $invalidUrl = 'invalid-url';
        $this->expectException(InvalidArgumentException::class);
        new BaseUrl($invalidUrl);
    }

    public function testCannotCreateBaseUrlWithEmptyString(): void
    {
        $emptyUrl = '';
        $this->expectException(InvalidArgumentException::class);
        new BaseUrl($emptyUrl);
    }

    public function testCannotCreateBaseUrlWithWhitespace(): void
    {
        $whitespaceUrl = '    ';
        $this->expectException(InvalidArgumentException::class);
        new BaseUrl($whitespaceUrl);
    }

    public function testCannotCreateBaseUrlWithoutScheme(): void
    {
        $invalidUrl = 'www.example.com/api';
        $this->expectException(InvalidArgumentException::class);
        new BaseUrl($invalidUrl);
    }

    public function testCannotCreateBaseUrlWithoutDomain(): void
    {
        $invalidUrl = 'https:///api';
        $this->expectException(InvalidArgumentException::class);
        new BaseUrl($invalidUrl);
    }
}
