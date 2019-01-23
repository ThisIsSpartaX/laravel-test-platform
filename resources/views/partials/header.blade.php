<li class="{!! Route::is('admin') ? 'active' : '' !!}">
    <a href="{{ route('admin') }}">Dashboard</a>
</li>
@guest
@else
<li class="{!! (Route::is('admin.reservations') || Route::is('admin.reservations.edit')) ? 'active' : '' !!}">
    <a href="{{ route('admin.reservations') }}">Reservations</a>
</li>
@endif