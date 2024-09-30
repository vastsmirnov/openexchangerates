<?php

declare(strict_types=1);

namespace Tests\Unit\Client\Exceptions;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Client\Exceptions\AccessRestrictedException;
use Src\Client\Exceptions\ExceptionResolver;
use Src\Client\Exceptions\InvalidAppIdException;
use Src\Client\Exceptions\InvalidBaseException;
use Src\Client\Exceptions\MissingAppIdException;
use Src\Client\Exceptions\NotAllowedException;
use Src\Client\Exceptions\NotFoundException;
use Src\Client\Exceptions\UnknownException;

class ExceptionResolverTest extends TestCase
{
    private ExceptionResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new ExceptionResolver();
    }

    #[DataProvider('validExceptionDataProvider')]
    public function testResolveValidExceptions(string $jsonBody, string $expectedExceptionClass): void
    {
        $exception = $this->resolver->resolve($jsonBody);
        $this->assertInstanceOf($expectedExceptionClass, $exception);
        $decoded = json_decode($jsonBody, true);
        $this->assertEquals($decoded['message'], $exception->getMessage());
        $this->assertEquals($decoded['description'], $exception->getDescription());
    }

    public static function validExceptionDataProvider(): array
    {
        return [
            [
                json_encode(['message' => 'not_found', 'description' => 'not_found_description']),
                NotFoundException::class,
            ],
            [
                json_encode(['message' => 'missing_app_id', 'description' => 'missing_app_id_description']),
                MissingAppIdException::class,
            ],
            [
                json_encode(['message' => 'invalid_app_id', 'description' => 'invalid_app_id_description']),
                InvalidAppIdException::class,
            ],
            [
                json_encode(['message' => 'not_allowed', 'description' => 'not_allowed_description']),
                NotAllowedException::class,
            ],
            [
                json_encode(['message' => 'access_restricted', 'description' => 'access_restricted_description']),
                AccessRestrictedException::class,
            ],
            [
                json_encode(['message' => 'invalid_base', 'description' => 'invalid_base_description']),
                InvalidBaseException::class,
            ],
        ];
    }

    public function testResolveUnknownExceptionWithInvalidJson(): void
    {
        $invalidJson = 'invalid json string';
        $exception = $this->resolver->resolve($invalidJson);
        $this->assertInstanceOf(UnknownException::class, $exception);
    }

    public function testResolveUnknownExceptionWhenMessageNotMapped(): void
    {
        $jsonBody = json_encode(['message' => 'unknown_error', 'description' => 'An unknown error occurred']);
        $exception = $this->resolver->resolve($jsonBody);
        $this->assertInstanceOf(UnknownException::class, $exception);
    }


}