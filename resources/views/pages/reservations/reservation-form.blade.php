<h1>
    Create Reservation
</h1>
<div class="form-block" style="max-width: 500px;">
{!! Form::open(array('url' => URL::to('/reservations/'), 'method' => 'post', 'files'=> true, 'id' => 'reservation-form')) !!}

<!-- Notifications -->
    @include('admin.notifications')
    <br/>

    <div class="">
        <div class="">
            <div class="form-group">
                {!! Form::label('first_name', 'First Name: *', ['class' => 'input__label']) !!}
                {!! Form::text('first_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('last_name', 'Last Name: *', ['class' => 'input__label']) !!}
                {!! Form::text('last_name', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone', 'Phone: *', ['class' => 'input__label']) !!}
                {!! Form::text('phone', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email: *', ['class' => 'input__label']) !!}
                {!! Form::email('email', null, array('class' => 'form-control', 'required' => 'required')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('children', 'Children:', ['class' => 'input__label']) !!}
                {!! Form::number('children', null, array('class' => 'form-control', 'id' => 'reservation_children', 'min' => '0', 'max' => '10')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('adults', 'Adults: *', ['class' => 'input__label']) !!}
                {!! Form::number('adults', null, array('class' => 'form-control', 'required' => 'required', 'id' => 'reservation_adults', 'min' => '1', 'max' => '20')) !!}
            </div>
            <div class="form-group text-left">
                <b>Total Guests:</b> <span id="total-guests" class="h4"></span>
            </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="#" class="btn btn-default">Cancel</a>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>