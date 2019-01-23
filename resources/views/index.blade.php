@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>
            Reservation System
        </h1>
        <a href="{{ route('reservations.create') }}">Create Reservation</a>
    </div>
@endsection
