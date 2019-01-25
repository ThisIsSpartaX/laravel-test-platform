        @foreach($reservations as $reservation)
        <tr id="reservation-{{ $reservation->id }}" class="reservation-row {{ $reservation->viewed ? 'viewed' : 'not-viewed' }}" data-reservation_id="{{ $reservation->id }}">
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->created_at->format('m/d/Y g:i:s A') }}</td>
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