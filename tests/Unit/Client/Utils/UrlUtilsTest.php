<?php

declare(strict_types=1);

namespace Tests\Unit\Client\Utils;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Client\Utils\UrlUtils;

class UrlUtilsTest extends TestCase
{
    private UrlUtils $urlUtils;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlUtils = new UrlUtils();
    }

    #[DataProvider('validUrlProvider')]
    public function testPrepareUrlWithValidInputs(string $baseUrl, string $endpoint, string $expectedUrl): void
    {
        $result = $this->urlUtils->prepareUrl($baseUrl, $endpoint);
        $this->assertEquals($expectedUrl, $result);
    }

    public static function validUrlProvider(): array
    {
        return [
            ['https://api.example.com', 'endpoint', 'https://api.example.com/endpoint'],
            ['https://api.example.com/', 'endpoint', 'https://api.example.com/endpoint'],
            ['https://api.example.com', '/endpoint', 'https://api.example.com/endpoint'],
            ['https://api.example.com/', '/endpoint', 'https://api.example.com/endpoint'],
        ];
    }

    #[DataProvider('invalidUrlProvider')]
    public function testPrepareUrlWithInvalidInputs(string $baseUrl, string $endpoint): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->urlUtils->prepareUrl($baseUrl, $endpoint);
    }

    public static function invalidUrlProvider(): array
    {
        return [
            ['https://api.example.com/', ''],
            ['', '/endpoint'],
            ['', ''],
            [' ', ' '],
            ['://api.example.com/', 'endpoint'],
            ['https://api.example.com/', ' /endpoint ', 'https://api.example.com/endpoint'],
        ];
    }
}