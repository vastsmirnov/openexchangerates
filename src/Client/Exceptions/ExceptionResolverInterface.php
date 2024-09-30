<?php

declare(strict_types=1);

namespace Src\Client\Exceptions;

interface ExceptionResolverInterface
{
    public function resolve(string $jsonBody): ExchangeRatesException;
}
