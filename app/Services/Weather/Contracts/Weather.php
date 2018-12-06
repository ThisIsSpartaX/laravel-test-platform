<?php

namespace App\Services\Weather\Contracts;

interface Weather
{
    public function get(string $lat, string $lon);

    public function getEndpoint();
}