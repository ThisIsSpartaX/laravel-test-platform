@extends('layouts.app')

{{-- Page title --}}
@section('title'){{ 'Create Reservation' }} @parent
@endsection

@section('content')
    <div class="container">
        @include('pages.reservations.reservation-form')
    </div>
@endsection
