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
        @foreach($reservations as $reservation)
        <tr>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->created_at }}</td>
            <td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
            <td>{{ $reservation->phone }}</td>
            <td>{{ $reservation->email }}</td>
            <td>{{ $reservation->children }}</td>
            <td>{{ $reservation->adults }}</td>
            <td>{{ $reservation->getTotalGuests() }}</td>
            <td>{{ $reservation->getStatusText() }}</td>
            <td>
                {!! Form::open(array('url' => URL::to('admin/reservations/' . $reservation->id), 'method' => 'post', 'files'=> true, 'id' => 'reservation-row-form', 'data-reservation-id' => ''.$reservation->id)) !!}
                {!! Form::select('status', $reservation->getAvailableStatuses(), $reservation->status, array('class' => 'form-control', 'placeholder' => '-- Status --', 'style' => 'width: 120px; display: inline-block;'))!!}
                <button type="submit" class="btn btn-primary">Save</button>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $reservations->render() !!}
    </div>
@else
    No records
@endif

@stop