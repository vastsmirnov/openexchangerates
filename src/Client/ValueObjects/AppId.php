<?php

declare(strict_types=1);

namespace Src\Client\ValueObjects;

use InvalidArgumentException;

readonly class AppId
{
    public string $value;

    public function __construct(
        string $value
    ) {
        if (trim($value) === '') {
            throw new InvalidArgumentException('App id con not be empty.');
        }

        $this->value = $value;
    }
}
