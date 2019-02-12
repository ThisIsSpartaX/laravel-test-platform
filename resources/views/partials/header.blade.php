<li class="nav-item {!! Route::is('admin') ? 'active' : '' !!}">
    <a class="nav-link" href="{{ route('admin') }}">Dashboard</a>
</li>
<li class="nav-item {!! (Route::is('reservations.waitlist') || Route::is('reservations.waitlist')) ? 'active' : '' !!}">
    <a class="nav-link" href="{{ route('reservations.index') }}">Wait List</a>
</li>
<li class="nav-item {!! (Route::is('customers.create') || Route::is('customers.create')) ? 'active' : '' !!}">
    <a class="nav-link" href="{{ route('customers.create') }}">Customer Appreciation Club</a>
</li>
@guest
@else
<li class="nav-item {!! (Route::is('admin.reservations') || Route::is('admin.reservations.edit')) ? 'active' : '' !!}">
    <a class="nav-link" href="{{ route('admin.reservations') }}">Reservations</a>
</li>
@endif