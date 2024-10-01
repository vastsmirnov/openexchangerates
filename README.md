### Техническое задание

Тестовое BE:
Нужно зарегистрироваться тут https://openexchangerates.org/signup/free, (https://openexchangerates.org/signup/free) получить ключ
И сделать компонент который по этому эндпойнту получает данные
https://oxr.readme.io/docs/latest-json, (https://oxr.readme.io/docs/latest-json) результат нужен в виде DTO.
К компоненту потенциально должно быть возможно прикрутить получеение данных и из других эндпойнтов этого апи.


### Описание результатов

#### Пример вызова
```php
$exchangeRatesDataSource = new ExchangeRatesDataSource(
            new OpenExchangeRatesClient(
                new Client(),
                new ExceptionResolver(),
                new UrlUtils(),
                $this->baseUrl,
                $this->appId,
                $this->isPrettyPrint
            ),
            new LatestRatesInfoParamsMapper(),
            new ExchangeRatesDtoFactory(
                new CurrencyDtoFactory(),
                new DateTimeImmutableFactory(),
                new CurrencyRatesDtoFactory(
                    new CurrencyRateDtoFactory(
                        new CurrencyDtoFactory(),
                        new RateDtoFactory()
                    )
                )
            ),
            $logger // Нужно инжектировать логгер реализующий \Psr\Log\LoggerInterface::class
           
        );
```

Также можно ознакомится в `\Tests\Integration\OpenExchangeRatesClientTest.php`.

#### PHPUnit тесты
Для запуска тестов создайте `phpunit.xml` с действующей переменой `APP_ENV`.
- Интеграционные тесты запускаются путем вызова composer scripts `composer phpunit-integration`.
- Unit тесты запускаются путем вызова composer scripts `composer phpunit-unit`.
Все тесты запускаются путем вызова composer scripts `composer phpunit-all`.

#### Качество кода и соответствие PSR12
- Код был проанализирован phpstan. Запускается путем вызова composer scripts `composer phpstan`.
- Код был проанализирован php-cs-fixer. Запускается путем вызова composer scripts `composer php-cs-fixer`.