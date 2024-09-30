<?php

declare(strict_types=1);

namespace Src\Client\Utils;

use InvalidArgumentException;

class UrlUtils
{
    public function prepareUrl(
        string $baseUrl,
        string $endpoint
    ): string {
        if (trim($endpoint) === '') {
            throw new InvalidArgumentException("Endpoint \"$endpoint\" is not valid.");
        }

        if (filter_var($baseUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Base url \"$baseUrl\" is not valid.");
        }

        $base = rtrim($baseUrl, '/');
        $endpoint = ltrim($endpoint, '/');

        $url = "{$base}/{$endpoint}";

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Url \"$url\" is not valid.");
        }

        return $url;
    }
}
