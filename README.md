# Weather project

[![Test Suite](https://github.com/MarkelovSergey/koleso/actions/workflows/tests.yml/badge.svg)](https://github.com/MarkelovSergey/koleso/actions/workflows/tests.yml)
[![Tests Code Style](https://img.shields.io/github/actions/workflow/status/MarkelovSergey/koleso/lint.yml?branch=main&label=Code%20Style&style=flat-square)](https://github.com/MarkelovSergey/koleso/actions?query=workflow%3Alint+branch%3Amain)

Free [Weather API](https://www.weatherapi.com/) has a free plan, register to get a key.

## Installation

```bash
git clone git@github.com:MarkelovSergey/koleso.git
cd koleso
mv .env.sample .env # Add WEATHER_API_KEY
docker compose up -d
docker compose run --rm app composer install
```

## Usage

```bash
docker compose run --rm -e CITY=Miami app
```

## Testing

```bash
composer test
```

## Documentation

Check out the [documentation](https://app.swaggerhub.com/apis-docs/WeatherAPI.com/WeatherAPI/1.0.2).