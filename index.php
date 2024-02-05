<?php

require_once __DIR__ . "/vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

function getWeather(string $apiKey, string $city): void
{
    $baseUrl = 'http://api.weatherapi.com/v1/forecast.json';

    $client = new Client();

    try {
        $response = $client->request('GET', $baseUrl, [
            'query' => [
                'key' => $apiKey,
                'q' => $city,
                'days' => 2
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        $cityName = $data['location']['name'];

        $weatherToday = strtolower($data['forecast']['forecastday'][0]['day']['condition']['text']);

        $weatherTomorrow = strtolower($data['forecast']['forecastday'][1]['day']['condition']['text']);

        echo "Processed city $cityName | $weatherToday - $weatherTomorrow\n";
    } catch (RequestException $e) {
        if ($e->hasResponse()) {
            $responseBody = $e->getResponse()->getBody();

            $responseJson = json_decode($responseBody);

            echo "Error: " . $responseJson->error->message . "\n";
        } else {
            echo "Error: " . $e->getMessage() . "\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

if (!isset($_ENV['CITY'])) {
    echo "Usage CITY environment (docker compose run --rm -e CITY=London app)\n";
    exit();
}

if (!isset($_ENV['WEATHER_API_KEY'])) {
    echo "WEATHER_API_KEY not found (create .env in the project root and define WEATHER_API_KEY)\n";
    exit();
}

$city = $_ENV['CITY'];

$apiKey = $_ENV['WEATHER_API_KEY'];

getWeather($apiKey, $city);
