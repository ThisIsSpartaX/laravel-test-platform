<?php

namespace App\Services\Geocoding\Contracts;

interface Geocoding
{
    public function get(string $address);

    public function getEndpoint();
}