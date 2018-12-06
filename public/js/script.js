$(document).ready(function() {
    $(function () {
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:m:ss'
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $('#loader').show();
        },
        complete: function(){
            $('#loader').hide();
        },
        success: function() {}
    });

    $(document).on('click', '#order-product-remove', function(e){
        e.preventDefault();
        order.removeProduct($(this).data('product-id'));
        return false;
    });

    $(document).on('click', '#order-product-add', function(e){
        e.preventDefault();
        var product_id = $(this).parents('.product-row').find('#new-product-id').val();
        var quantity = $(this).parents('.product-row').find('#new-product-quantity').val();

        order.addProduct(product_id, quantity);

        return false;
    });

    $(document).on('change', '.order-product-quantity', function(){
        order.changeQuantity($(this).data('product-id'), $(this).val());
    });
});

var order = {

    addProduct: function(product_id, quantity) {

        $.ajax({
            url: '/admin/orders/products/add',
            method: 'POST',
            dataType: 'json',
            data: {
                product_id: product_id,
                quantity: quantity
            },
            success: function(response) {

                $('#order-products-list').append(response.data.html);
                var orderSum = order.calculateSumRequest();
                order.updateSumText(orderSum);
            }
        });
    },

    changeQuantity: function(product_id, quantity) {

        $.ajax({
            url: '/admin/orders/products/add',
            method: 'POST',
            dataType: 'json',
            data: {
                product_id: product_id,
                quantity: quantity
            },
            success: function(response) {

                $('#order-product-'+product_id).replaceWith(response.data.html);
                var orderSum = order.calculateSumRequest();
                order.updateSumText(orderSum);
            }
        });
    },

    removeProduct: function(product_id) {
        var order_id = $('#order-form').data('order-id');
        $('#order-product-' + product_id).remove();
        var orderSum = order.calculateSumRequest(order_id);
        order.updateSumText(orderSum);
    },

    calculateSumRequest: function() {
        var sum = 0.00;

        $('#order-form').ajaxSubmit({
            url: '/admin/orders/products/calculate',
            method: 'POST',
            dataType: 'json',
            async: false,
            success: function(response) {
                sum = response.data.totalSum;
            }
        });

        return sum;
    },

    updateSumText: function(orderSum) {
        $('#order-sum').text(formatter.format(orderSum));
    }
};

var formatter = new Intl.NumberFormat('ru-RU', {
    style: 'decimal',
    minimumFractionDigits: 2
});

