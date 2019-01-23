<tr id="order-product-{{ $product->id }}" class="product-row">
    <td class="col-sm-6">
        <b>{{ $product->name }}</b>
        {!! Form::hidden('product_id['.$product->id.']', $product->id) !!}
    </td>
    <td class="col-sm-2">
        <b>@money($product->price)</b>
    </td>
    <td class="col-sm-2">
        <div>
            {!! Form::number('product['.$product->id.'][quantity]', $quantity, array('class' => 'order-product-quantity form-control', 'required' => 'required', 'min' => '1', 'data-product-id' => $product->id)) !!}
        </div>
    </td>
    <td class="text-center col-sm-3">
        <b>@money($sum)</b>
    </td>
    <td class="col-sm-2 text-center">
        <div>
            <a id="order-product-remove" href="#" class="btn text-danger" data-product-id="{{ $product->id }}"><i class="glyphicon glyphicon-remove-sign"></i></a>
        </div>
    </td>
</tr>