@extends('layouts.app')

{{-- Page title --}}
@section('title'){{ 'Signup for Wait List' }} @parent
@endsection

@section('content')
    <div class="container">
        @include('pages.reservations.reservation-form')
    </div>
@endsection
