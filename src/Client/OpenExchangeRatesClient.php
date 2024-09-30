<?php

declare(strict_types=1);

namespace Src\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use InvalidArgumentException;
use JsonException;
use RuntimeException;
use Src\Client\Exceptions\ExceptionResolverInterface;
use Src\Client\Utils\UrlUtils;
use Src\Client\ValueObjects\AppId;
use Src\Client\ValueObjects\BaseUrl;
use Throwable;

final class OpenExchangeRatesClient
{
    private const HEADER_ACCEPT = 'Accept';
    private const HEADER_APPLICATION_JSON = 'application/json';
    private const QUERY_PARAM_APP_ID = 'app_id';
    private const QUERY_PARAM_PRETTY_PRINT = 'prettyprint';

    private const DEFAULT_HEADERS = [
        self::HEADER_ACCEPT => self::HEADER_APPLICATION_JSON
    ];

    public function __construct(
        private ClientInterface $httpClient,
        private ExceptionResolverInterface $exceptionResolver,
        private UrlUtils $urlUtils,
        private BaseUrl $baseUrl,
        private AppId $appId,
        private bool $isPrettyPrint = false
    ) {
    }

    public function get(string $endpoint, array $params = []): array
    {
        $params[self::QUERY_PARAM_APP_ID] = $this->appId->value;
        $params[self::QUERY_PARAM_PRETTY_PRINT] = $this->isPrettyPrint;

        try {
            $response = $this->httpClient->request(
                HttpRequestMethodInterface::METHOD_GET,
                $this->urlUtils->prepareUrl($this->baseUrl->value, $endpoint),
                [
                    'headers' => self::DEFAULT_HEADERS,
                    'query' => $params
                ]
            );

            $body = (string) $response->getBody();
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR) ?? [];
        } catch (ClientException $exception) {
            $body = (string) $exception->getResponse()->getBody();
            throw $this->exceptionResolver->resolve($body);
        } catch (JsonException $exception) {
            throw new InvalidArgumentException(
                message: 'Json decode failed.',
                previous: $exception
            );
        } catch (Throwable $exception) {
            throw new RuntimeException(
                message: $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
