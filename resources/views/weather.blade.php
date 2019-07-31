@extends('layouts.app')

{{-- Page title --}}
@section('title'){{ 'Погода' }} @parent
@endsection

{{-- Page content --}}
@section('content')

    <div class="container">
        <a href="https://yandex.ru/pogoda/moscow/">
            <img src="{{ asset('images/yandex.weather.svg') }}"/>
        </a>
        <h1>Погода</h1>
        @if($error)
            {{ $error }}
        @endif

        {!! Form::open(array('url' => URL::to('/weather'), 'method' => 'post', 'id' => 'weather-form')) !!}

        <div class="row">
            <div class="col-xs-12 col-sm-8">
                {!!  Form::text('location', $location, ['placeholder' => 'Название населенного пункта, страны или региона', 'size' => 46])  !!}
                {!!  Form::button('Поиск', ['type' => 'submit'])  !!}
            </div>
            <div class="col-xs-12 col-sm-8">
                <b>Населенный пункт</b>
            </div>
            <div class="col-xs-12 col-sm-4">
                <b>Температура, &deg;С</b>
            </div>
            <div class="col-xs-12 col-sm-8">
                {{ $location }}
            </div>
            <div class="col-xs-12 col-sm-4">
                {{ $temperature }}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
