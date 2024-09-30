<?php

declare(strict_types=1);

namespace Src\Client;

interface OpenExchangeRatesClientInterface
{
    /**
     * @param string $endpoint
     * @param array<string, string> $params
     * @return array<string, mixed>
     */
    public function get(string $endpoint, array $params = []): array;
}
