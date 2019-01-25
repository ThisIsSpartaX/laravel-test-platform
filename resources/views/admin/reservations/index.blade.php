@extends('admin.layouts.default')

{{-- Page title --}}
@section('title'){{ 'Reservations' }} @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="navigation--horizontal">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-xs">
            <a class="text-black" href="{{ route('admin') }}">Dashboard</a> &#8226; Reservations
        </div>
        <h1>Reservations</h1>
    </div>

    <!-- Notifications -->
    @include('admin.notifications')
    <br/>

    <p class="text-right">
        <a href="{{ Request::fullUrl() }}" class="btn btn-primary">Refresh</a>
    </p>

@if ($reservations->count())
    <table id="reservations-list" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Date & Time</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Children</th>
            <th>Adults</th>
            <th>Total Guests</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @include('admin.reservations.list')
    </table>
    <div class="text-center">
        {!! $reservations->render() !!}
    </div>
@else
    No records
@endif

@stop