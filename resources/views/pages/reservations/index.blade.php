@extends('layouts.app')

{{-- Page title --}}
@section('title'){{ 'Wait List' }} @parent
@stop

{{-- Page content --}}
@section('content')

    <div class="navigation--horizontal">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs text-xs">
            <a class="text-black" href="{{ route('reservations.create') }}">Home</a> &#8226; Wait List
        </div>
        <h1>Wait List</h1>
    </div>

    <!-- Notifications -->
    @include('admin.notifications')
    <br/>

    <p class="text-right">
        <a href="{{ route('reservations.index') }}" class="btn btn-primary">Refresh</a>
    </p>

    @if ($reservations->count())
        <table id="reservations-wait-list" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Placement # (FIFO)</th>
                <th>Party (First Name)</th>
                <!--<th>Date</th>-->
                <th>Size</th>
                <th>Time Waited</th>
            </tr>
            </thead>
            <tbody>
            @include('pages.reservations.list')
        </table>
        <div class="text-center">
            {!! $reservations->render() !!}
        </div>
    @else
        No records
    @endif

@stop