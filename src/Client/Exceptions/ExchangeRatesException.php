<?php

declare(strict_types=1);

namespace Src\Client\Exceptions;

use RuntimeException;
use Throwable;

class ExchangeRatesException extends RuntimeException
{
    private string $description;

    public function __construct(
        string $message = "",
        string $description = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->description = $description;

        parent::__construct($message, $code, $previous);
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
