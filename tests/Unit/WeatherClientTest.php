<?php

namespace MarkelovSergey\Koleso\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use MarkelovSergey\Koleso\WeatherClient;
use MarkelovSergey\Koleso\WeatherDto;
use PHPUnit\Framework\TestCase;

class WeatherClientTest extends TestCase
{
    private WeatherClient $weatherClient;

    private MockHandler $mockHandler;

    protected function setUp(): void
    {
        $this->mockHandler = new MockHandler();

        $httpClient = new Client(['handler' => $this->mockHandler]);

        $this->weatherClient = new WeatherClient($httpClient, 'API_KEY');
    }

    public function testGetWeatherByCity_Success(): void
    {
        $city = 'London';

        $responseBody = <<<JSON
        {
            "location": {
                "name": "London"
            },
            "forecast": {
                "forecastday": [
                    {
                        "day": {
                            "condition": {
                                "text": "sunny"
                            }
                        }
                    },
                    {
                        "day": {
                            "condition": {
                                "text": "cloudy"
                            }
                        }
                    }
                ]
            }
        }
        JSON;

        $this->mockHandler->append(new Response(200, [], $responseBody));

        $weatherDto = $this->weatherClient->getWeatherByCity($city);

        $this->assertInstanceOf(WeatherDto::class, $weatherDto);

        $this->assertEquals('London', $weatherDto->city);

        $this->assertEquals('sunny', $weatherDto->today);

        $this->assertEquals('cloudy', $weatherDto->tomorrow);
    }

    public function testGetWeatherByCity_NoMatching(): void
    {
        $city = 'qwerty';

        $responseBody = <<<JSON
        {
            "error": {
                "code": 1006,
                "message": "No matching location found."
            }
        }
        JSON;

        $this->mockHandler->append(
            new RequestException(
                "No matching location found.",
                new Request('GET', "http://api.weatherapi.com"),
                new Response(400, [], $responseBody)
            )
        );

        $this->expectExceptionMessage('No matching location found.');

        $this->weatherClient->getWeatherByCity($city);
    }
}