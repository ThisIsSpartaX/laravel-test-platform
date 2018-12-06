<?php

namespace App\Services\Geocoding;

use App\Services\Geocoding\Contracts\Geocoding;
use GuzzleHttp\Client as HttpClient;

class YandexGeocoding implements Geocoding
{
    private const ENDPOINT_URI = 'https://geocode-maps.yandex.ru/1.x';

    /** @var HttpClient */
    private $client;

    /** @var string */
    private $key;

    /**
     * YandexGeocoding constructor.
     */
    public function __construct()
    {
        $this->client = new HttpClient;
        $this->key = config('services.yandex_geocoding.key');
    }

    /**
     * Get GeoObject for requested address
     *
     * @param string $address
     *
     * @return array|null
     */
    public function get(string $address): ?array
    {
        $response = $this->client->get($this->buildUrl(['geocode' => $address]));

        return $this->parseResponse($response);
    }

    /**
     * Parse response object
     *
     * @param $response
     * @return array|null
     */
    private function parseResponse($response): ?array
    {
        $geoObject = null;

        $responseData = json_decode($response->getBody(), true);
        if(isset($responseData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']) && $responseData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']) {
            $geoObject = $responseData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject'] ;
        }

        return $geoObject;
    }

    /**
     * Get address coordinates
     *
     * @param string $address
     *
     * @return array|null
     */
    public function getCoordinates(string $address): ?array
    {
        $geoObject = $this->get($address);

        if($geoObject == null) {
            return null;
        }

        $coordinatesStr = $geoObject['Point']['pos'];

        $coordinates = [
            'lan' => substr($coordinatesStr, 10, 9),
            'lon' => substr($coordinatesStr, 0, 9)
        ];

        return $coordinates;
    }

    /**
     * Get gateway endpoint
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return self::ENDPOINT_URI;
    }

    /**
     * Build URL for GET request
     *
     * @param array $params
     * @return string
     */
    public function buildUrl(array $params): string
    {
        return $this->getEndpoint() . '?format=json&apikey=' .$this->key . '&' . http_build_query($params);
    }
}