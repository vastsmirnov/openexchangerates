<?php

declare(strict_types=1);

namespace Src\Client;

use InvalidArgumentException;
use RuntimeException;
use Src\Client\Exceptions\AccessRestrictedException;
use Src\Client\Exceptions\InvalidAppIdException;
use Src\Client\Exceptions\InvalidBaseException;
use Src\Client\Exceptions\MissingAppIdException;
use Src\Client\Exceptions\NotAllowedException;
use Src\Client\Exceptions\NotFoundException;
use Src\Client\Exceptions\UnknownException;

interface OpenExchangeRatesClientInterface
{
    /**
     * @param string $endpoint
     * @param array<string, string> $params
     * @return array<string, mixed>
     * @throws AccessRestrictedException Access restricted for repeated over-use, or other reason from error description.
     * @throws InvalidAppIdException Client provided an invalid App ID.
     * @throws InvalidBaseException Client requested rates for an unsupported base currency.
     * @throws MissingAppIdException Client did not provide an App ID.
     * @throws NotAllowedException Client doesn’t have permission to access requested route/feature.
     * @throws NotFoundException Client requested a non-existent resource/route.
     * @throws UnknownException If not resolve API error.
     * @throws InvalidArgumentException Invalid json from response.
     * @throws RuntimeException Other case.
     *
     * @example
     *  <code>
     *      $result = [
     *
     *      ];
     *  </code>
     */
    public function get(string $endpoint, array $params = []): array;
}
