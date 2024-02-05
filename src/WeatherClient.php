<?php

declare(strict_types=1);

namespace MarkelovSergey\Koleso;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WeatherClient
{
    private const BASE_URL = "http://api.weatherapi.com/v1/forecast.json";

    public function __construct(
        private Client $client,
        private string $apiKey
    ) {
    }

    public function getWeatherByCity(string $city): WeatherDto
    {
        try {
            $response = $this->client->request('GET', static::BASE_URL, [
                'query' => [
                    'key' => $this->apiKey,
                    'q' => $city,
                    'days' => 2
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $cityName = $data['location']['name'];

            $weatherToday = strtolower($data['forecast']['forecastday'][0]['day']['condition']['text']);

            $weatherTomorrow = strtolower($data['forecast']['forecastday'][1]['day']['condition']['text']);

            return new WeatherDto($cityName, $weatherToday, $weatherTomorrow);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody();
                
                $responseJson = json_decode($responseBody->getContents());

                throw new \Exception("Error: " . $responseJson->error->message);
            } else {
                throw new \Exception("Error: " . $e->getMessage());
            }
        } catch (\Exception $e) {
            throw new \Exception("Error fetching weather data for $city: " . $e->getMessage());
        }
    }

}
