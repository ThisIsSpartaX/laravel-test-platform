<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Weather\Weather;

class WeatherController extends Controller
{
    /**
     * Weather page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $location = 'город Брянск, Россия';
        $error = '';
        $temperature = '';

        $weather = new Weather();
        if($weather->get($location)) {
            $temperature = $weather->getTemperature();
        } else {
            $error = 'Не удалось получить температуру для указанного региона: "'.$location.'"';
        }

        return view('weather', compact('location', 'temperature', 'error'));
    }
}
