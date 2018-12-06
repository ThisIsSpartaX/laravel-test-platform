<li class="{!! Route::is('admin') ? 'active' : '' !!}">
    <a href="{{ route('admin') }}">Административная панель</a>
</li>
<li class="{!! (Route::is('admin.orders') || Route::is('admin.orders.edit')) ? 'active' : '' !!}">
    <a href="{{ route('admin.orders') }}">Заказы</a>
</li>