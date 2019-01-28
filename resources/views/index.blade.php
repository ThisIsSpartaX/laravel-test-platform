@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>
            Reservation System
        </h1>
        <a href="{{ route('reservations.create') }}">Signup for Wait List</a>
    </div>
@endsection
