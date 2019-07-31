<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Weather\Weather;

class WeatherController extends Controller
{
    /**
     * Weather page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $error = '';
        $temperature = '';
        $location = '';

        if($request->get('location')) {

            dd($request->get('location'));

            $location = $request->get('location');

            $weather = new Weather();
            if($weather->get($location)) {
                $temperature = $weather->getTemperature();
            } else {
                $error = 'Не удалось получить температуру для указанного региона: "'.$location.'"';
            }
        }

        return view('weather', compact('location', 'temperature', 'error'));
    }
}
