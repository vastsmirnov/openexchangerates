<?php

declare(strict_types=1);

namespace Src\Client\Exceptions;

class ExceptionResolver implements ExceptionResolverInterface
{
    private const array EXCEPTION_MAP = [
        'not_found' => NotFoundException::class,
        'missing_app_id' => MissingAppIdException::class,
        'invalid_app_id' => InvalidAppIdException::class,
        'not_allowed' => NotAllowedException::class,
        'access_restricted' => AccessRestrictedException::class,
        'invalid_base' => InvalidBaseException::class,

    ];

    public function resolve(string $jsonBody): ExchangeRatesException
    {
        $decodedJson = json_decode($jsonBody, true);
        if (!is_array($decodedJson)) {
            return new UnknownException('Failed decode error.');
        }

        $message = $decodedJson['message'] ?? null;
        $description = $decodedJson['description'] ?? null;
        if (!is_string($message) || !is_string($description)) {
            return new UnknownException('Invalid json message or description.');
        }

        $targetExceptionClass = self::EXCEPTION_MAP[$message] ?? null;
        if ($targetExceptionClass === null) {
            return new UnknownException($message, $description);
        }

        return new $targetExceptionClass($message, $description);
    }
}