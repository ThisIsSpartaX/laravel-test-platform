@foreach($orders as $order)
    <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->partner->name }}</td>
        <td>{{-- $order->calculateSum() --}}</td>
        <td>
            @foreach($order->orderProducts as $orderProduct)
                dwadawd
                {{ $orderProduct->id }}
                {{ $orderProduct->id }} {{ $orderProduct->quantity }}<br>
        @endforeach
        <td>{{ $order->getStatusText() }}</td>
    </tr>
@endforeach