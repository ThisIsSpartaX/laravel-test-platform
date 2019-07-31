<?php

namespace App\Services\Weather;

use App\Services\Weather\Contracts\Weather;
use GuzzleHttp\Client as HttpClient;

/**
 * Class YandexWeather
 * @package App\Services\Weather
 */
class YandexWeather implements Weather
{
    /** @var string */
    private $endpoint;

    /** @var HttpClient */
    private $client;

    /** @var string */
    private $key;

    /** @var array */
    private $response;

    /** @var array */
    private $data;

    /**
     * YandexWeather constructor.
     */
    public function __construct()
    {
        $this->client = new HttpClient();
        $this->key = config('services.yandex_weather.key');
        $this->endpoint = config('services.yandex_weather.endpoint');
    }

    /**
     * Get weather in city
     *
     * @param string $lat
     * @param string $lon
     *
     * @return void
     */
    public function get(string $lat, string $lon): void
    {
        $options = [
            'headers' => [
                'X-Yandex-API-Key' => $this->key,
            ]
        ];

        $response = $this->client->get($this->buildUrl(['lat' => $lat, 'lon' => $lon]), $options);



        $this->response = $responseData = json_decode($response->getBody(), true);
        $this->data['temperature'] = $responseData['fact']['temp'];
    }

    /**
     * Get gateway endpoint
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Build URL for GET request
     *
     * @param array $params
     *
     * @return string
     */
    public function buildUrl(array $params): string
    {
        return $this->getEndpoint() . '?' .http_build_query($params);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get temperature value
     *
     * @return string
     */
    public function getTemperature(): string
    {
        return $this->data['temperature'];
    }
}