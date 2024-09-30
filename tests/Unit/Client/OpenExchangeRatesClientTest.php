<?php

declare(strict_types=1);

namespace Tests\Unit\Client;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Src\Client\Exceptions\ExceptionResolverInterface;
use Src\Client\Exceptions\ExchangeRatesException;
use Src\Client\OpenExchangeRatesClient;
use Src\Client\OpenExchangeRatesClientInterface;
use Src\Client\Utils\UrlUtils;
use Src\Client\ValueObjects\AppId;
use Src\Client\ValueObjects\BaseUrl;

class OpenExchangeRatesClientTest extends TestCase
{
    private ClientInterface|MockObject $httpClientMock;

    private ExceptionResolverInterface|MockObject $exceptionResolverMock;

    private UrlUtils|MockObject $urlUtilsMock;

    private BaseUrl $baseUrl;

    private AppId $appId;

    private bool $isPrettyPrint;

    private OpenExchangeRatesClientInterface $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClientMock = $this->createMock(ClientInterface::class);
        $this->exceptionResolverMock = $this->createMock(ExceptionResolverInterface::class);
        $this->urlUtilsMock = $this->createMock(UrlUtils::class);

        $this->baseUrl = new BaseUrl('https://api.openexchangerates.org');
        $this->appId = new AppId('test_app_id');
        $this->isPrettyPrint = false;

        $this->client = new OpenExchangeRatesClient(
            $this->httpClientMock,
            $this->exceptionResolverMock,
            $this->urlUtilsMock,
            $this->baseUrl,
            $this->appId,
            $this->isPrettyPrint
        );
    }

    public function testGetReturnsDecodedJsonOnSuccess(): void
    {
        $endpoint = 'latest.json';
        $params = ['base' => 'USD'];
        $expectedUrl = 'https://api.openexchangerates.org/latest.json';
        $expectedQuery = array_merge($params, [
            'app_id' => 'test_app_id',
            'prettyprint' => false,
        ]);
        $responseBody = json_encode(['rates' => ['EUR' => 0.85]], JSON_THROW_ON_ERROR);
        $expectedResult = ['rates' => ['EUR' => 0.85]];

        $this->urlUtilsMock
            ->expects($this->once())
            ->method('prepareUrl')
            ->with($this->baseUrl->value, $endpoint)
            ->willReturn($expectedUrl);

        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('__toString')->willReturn($responseBody);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamMock);

        $this->httpClientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                $expectedUrl,
                [
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'query' => $expectedQuery
                ]
            )
            ->willReturn($responseMock);

        $result = $this->client->get($endpoint, $params);

        $this->assertSame($expectedResult, $result);
    }

    public function testGetThrowsResolvedExceptionOnClientException(): void
    {
        $endpoint = 'latest.json';
        $params = ['base' => 'USD'];
        $expectedUrl = 'https://api.openexchangerates.org/latest.json';
        $expectedQuery = array_merge($params, [
            'app_id' => 'test_app_id',
            'prettyprint' => false,
        ]);
        $responseBody = json_encode(
            [
                'error' => true,
                'status' => 401,
                'message' => 'invalid_app_id',
                'description' => 'invalid_app_id_description'
            ],
            JSON_THROW_ON_ERROR
        );

        $this->urlUtilsMock
            ->expects($this->once())
            ->method('prepareUrl')
            ->with($this->baseUrl->value, $endpoint)
            ->willReturn($expectedUrl);

        $request = new Request('GET', $expectedUrl);
        $response = new Response(401, [], $responseBody);
        $clientException = new ClientException('Bad Request', $request, $response);

        $this->httpClientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                $expectedUrl,
                [
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'query' => $expectedQuery
                ]
            )
            ->willThrowException($clientException);

        $resolvedException = $this->createMock(ExchangeRatesException::class);
        $this->exceptionResolverMock
            ->expects($this->once())
            ->method('resolve')
            ->with($responseBody)
            ->willReturn($resolvedException);

        $this->expectException(ExchangeRatesException::class);

        $this->client->get($endpoint, $params);
    }

    public function testGetThrowsInvalidArgumentExceptionOnJsonDecodeFailure(): void
    {
        $endpoint = 'latest.json';
        $params = [];
        $expectedUrl = 'https://api.openexchangerates.org/latest.json';
        $expectedQuery = [
            'app_id' => 'test_app_id',
            'prettyprint' => false,
        ];
        $invalidJson = 'invalid-json';

        $this->urlUtilsMock
            ->expects($this->once())
            ->method('prepareUrl')
            ->with($this->baseUrl->value, $endpoint)
            ->willReturn($expectedUrl);

        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('__toString')->willReturn($invalidJson);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamMock);

        $this->httpClientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                $expectedUrl,
                [
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'query' => $expectedQuery
                ]
            )
            ->willReturn($responseMock);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Json decode failed.');

        $this->client->get($endpoint, $params);
    }

    public function testGetThrowsRuntimeExceptionOnOtherExceptions(): void
    {
        $endpoint = 'latest.json';
        $params = [];
        $expectedUrl = 'https://api.openexchangerates.org/latest.json';
        $expectedQuery = [
            'app_id' => 'test_app_id',
            'prettyprint' => false,
        ];
        $runtimeException = new Exception();

        $this->urlUtilsMock
            ->expects($this->once())
            ->method('prepareUrl')
            ->with($this->baseUrl->value, $endpoint)
            ->willReturn($expectedUrl);

        $this->httpClientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                $expectedUrl,
                [
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'query' => $expectedQuery
                ]
            )
            ->willThrowException($runtimeException);

        $this->expectException(RuntimeException::class);

        $this->client->get($endpoint, $params);
    }
}
