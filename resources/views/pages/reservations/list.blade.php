<?php $i = 1; ?>
@foreach($reservations as $reservation)
    <tr id="reservation-{{ $reservation->id }}" data-reservation_id="{{ $reservation->id }}">
        <td>{{ $i }}</td>
        <td>{{ $reservation->first_name }}</td>
        <!--<td>{{ $reservation->created_at }}</td>-->
        <td>{{ $reservation->getTotalGuests() }}</td>
        <td>{{ $reservation->getTimeWaited() }}</td>
    </tr>
    <?php $i++; ?>
@endforeach