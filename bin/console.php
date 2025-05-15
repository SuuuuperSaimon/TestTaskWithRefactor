<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application;
use App\Service\BinListProvider;
use App\Service\ExchangeRatesApiProvider;
use App\Service\EUCountryValidator;
use App\Service\FileTransactionReader;
use App\Service\FileGetContentsHttpClient;
use App\Service\CommissionCalculatorService;

if ($argc < 2) {
    echo "Usage: php bin/console.php input.txt" . PHP_EOL;
    exit(1);
}

$httpClient = new FileGetContentsHttpClient();
$binProvider = new BinListProvider($httpClient);
$exchangeRateProvider = new ExchangeRatesApiProvider($httpClient);
$countryValidator = new EuCountryValidator();
$transactionReader = new FileTransactionReader();

$commissionCalculator = new CommissionCalculatorService(
    $binProvider,
    $exchangeRateProvider,
    $countryValidator
);

$app = new Application(
    $transactionReader,
    $commissionCalculator
);

$app->process($argv[1]);
