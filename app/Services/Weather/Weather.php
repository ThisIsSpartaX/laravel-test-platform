<?php

namespace App\Services\Weather;

use App\Services\Geocoding\YandexGeocoding;

/**
 * Class Weather
 * @package App\Services\Weather
 */
class Weather
{
    /** var Weather */
    private $weather_service;

    private $data;

    /**
     * Weather constructor.
     */
    public function __construct()
    {
        $this->weather_service = new YandexWeather();
        $this->geocoding_service = new YandexGeocoding();
    }

    /**
     * Get weather data by address
     *
     * @param string $address
     *
     * @return Weather|null
     */
    public function get(string $address): ?Weather
    {
        //Get address coordinates form Geocoding Service
        $coordinates = $this->getCoordinates($address);

        if(!$coordinates) {
            return null;
        }

        //Get weather data from Weather Service
        $this->getWeather($coordinates['lan'], $coordinates['lon']);
        return $this;
    }

    /**
     * Get coordinates for address
     *
     * @param string $address
     *
     * @return array|null
     */
    private function getCoordinates(string $address): ?array
    {
        return $this->geocoding_service->getCoordinates($address);
    }

    /**
     * Get weather data by coordinates
     *
     * @param string $lat
     * @param string $lon
     *
     * @return void
     */
    private function getWeather(string $lat, string $lon): void
    {
        $this->weather_service->get($lat, $lon);
        $this->data = $this->weather_service->getData();
    }

    /**
     * Get weather data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get temperature from weather data
     *
     * @return string
     */
    public function getTemperature(): string
    {
        return $this->data['temperature'];
    }
}