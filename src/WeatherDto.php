<?php

declare(strict_types=1);

namespace MarkelovSergey\Koleso;

class WeatherDto
{
    public function __construct(
        public string $city,
        public string $today,
        public string $tomorrow,
    ) {
    }
}
