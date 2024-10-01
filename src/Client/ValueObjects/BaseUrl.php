<?php

declare(strict_types=1);

namespace Src\Client\ValueObjects;

use InvalidArgumentException;

readonly class BaseUrl
{
    public string $value;

    public function __construct(
        string $value
    ) {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Url \"$value\" is invalid.");
        }

        $this->value = $value;
    }
}
