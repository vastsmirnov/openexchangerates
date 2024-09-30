<?php

declare(strict_types=1);

namespace Tests\Unit\Client\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Client\ValueObjects\AppId;

class AppIdTest extends TestCase
{
    public function testCanCreateAppIdWithValidValue(): void
    {
        $validValue = '12345';
        $appId = new AppId($validValue);

        $this->assertInstanceOf(AppId::class, $appId);
        $this->assertSame($validValue, $appId->value);
    }

    public function testCannotCreateAppIdWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('App id con not be empty.');

        new AppId('');
    }

    /**
     * Проверяет, что создание экземпляра с пробельными символами выбрасывает исключение.
     */
    public function testCannotCreateAppIdWithWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('App id con not be empty.');

        new AppId('   ');
    }
}