<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Params\Mappers;

use PHPUnit\Framework\TestCase;
use Src\Dto\Params\LatestRatesInfoParamsDto;
use Src\Dto\Params\Mappers\LatestRatesInfoParamsMapper;

class LatestRatesInfoParamsMapperTest extends TestCase
{
    private LatestRatesInfoParamsMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new LatestRatesInfoParamsMapper();
    }

    public function testToQueryParamsWithEmptyTargetCurrencyCodes(): void
    {
        $params = new LatestRatesInfoParamsDto('USD', [], true);
        $result = $this->mapper->toQueryParams($params);

        $expected = [
            'base' => 'USD',
            'show_alternative' => true
        ];

        $this->assertEquals($expected, $result);
    }

    public function testToQueryParamsWithNonEmptyTargetCurrencyCodes(): void
    {
        $params = new LatestRatesInfoParamsDto('EUR', ['USD', 'RUB'], false);
        $result = $this->mapper->toQueryParams($params);

        $expected = [
            'base' => 'EUR',
            'show_alternative' => false,
            'symbols' => 'USD,RUB'
        ];

        $this->assertEquals($expected, $result);
    }

    public function testToQueryParamsWithSingleTargetCurrencyCode(): void
    {
        $params = new LatestRatesInfoParamsDto('RUB', ['EUR'], true);
        $result = $this->mapper->toQueryParams($params);

        $expected = [
            'base' => 'RUB',
            'show_alternative' => true,
            'symbols' => 'EUR'
        ];

        $this->assertEquals($expected, $result);
    }
}
