@extends('layouts.app')

{{-- Page title --}}
@section('title'){{ 'Погода' }} @parent
@endsection

{{-- Page content --}}
@section('content')

    <div class="container">
        <h1>Погода</h1>
        @if($error)
            {{ $error }}
        @endif
        <div class="row">
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
    </div>

@endsection
