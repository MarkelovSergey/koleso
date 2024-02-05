<?php

use GuzzleHttp\Client;
use MarkelovSergey\Koleso\WeatherClient;

require_once __DIR__ . "/vendor/autoload.php";

if (!isset($_ENV['CITY'])) {
    echo "Usage CITY environment (docker compose run --rm -e CITY=London app)\n";
    exit();
}

if (!isset($_ENV['WEATHER_API_KEY'])) {
    echo "WEATHER_API_KEY not found (create .env in the project root and define WEATHER_API_KEY)\n";
    exit();
}

$client = new Client();

$weather = new WeatherClient($client, $_ENV['WEATHER_API_KEY']);

$response = $weather->getWeatherByCity($_ENV['CITY']);

echo "Processed city $response->city | $response->today - $response->tomorrow\n";
