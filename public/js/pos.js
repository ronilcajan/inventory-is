$(document).ready(function() {
    // Create two variables with names of months and days of the week in the array
    var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
    var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
    
    // Create an object newDate()
    var newDate = new Date();
    // Retrieve the current date from the Date object
    newDate.setDate(newDate.getDate());
    // At the output of the day, date, month and year    
    jQuery('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
    
    setInterval( function() {
        // Create an object newDate () and extract the second of the current time
        var seconds = new Date().getSeconds();
        // Add a leading zero to the value of seconds
        jQuery("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
        },1000);
        
    setInterval( function() {
        // Create an object newDate () and extract the minutes of the current time
        var minutes = new Date().getMinutes();
        // Add a leading zero to the minutes
        jQuery("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
        },1000);
        
    setInterval( function() {
        // Create an object newDate () and extract the clock from the current time
        var hours = new Date().getHours();
        ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; 
        // Add a leading zero to the value of hours
        jQuery("#hours").html(( hours < 10 ? "0" : "" ) + hours);
        jQuery("#ampm").html(ampm);
        }, 1000); 
});

function searchProducts(that){
    var search = $(that).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/admin/pos/search',
        data:{search:search},
        success:function(data) {
            var html_code = '';
            var img = '';
            for (i = 0; i < data.length; ++i) {
                if (data[i]['image'] == null){
                    img = SITE_URL+'/images/product.png';
                }
                if (data[i]['image'] != null){
                    img = SITE_URL+'/storage/'+data[i]['image'];
                } 
                html_code += '<div class="mt-2"><div class="app-card app-card-doc shadow-sm row p-2"><div class="col-auto">';
                html_code += '<div class="app-card-thumb"><img class="thumb-image" src="'+img+'" alt="" width="50"></div>';
                html_code += '<a class="app-card-link-mask itemSelect" href="#addQTY" data-bs-toggle="modal" data-qty="'+parseInt(data[i]['stock_out_qty'])+'" data-barcode="'+data[i]['barcode']+'" data-name="'+data[i]['name']+'" data-unit="'+data[i]['unit']+'" data-price="'+data[i]['mark_up']+'" onclick="itemSelect(this)">';
                html_code += '</a></div><div class="col-auto">';
                html_code += '<h2 class="app-doc-title mb-0"><a class="itemSelect" data-bs-toggle="modal" href="#addQTY" data-qty="'+parseInt(data[i]['stock_out_qty'])+'" data-barcode="'+data[i]['barcode']+'" data-name="'+data[i]['name']+'" data-unit="'+data[i]['unit']+'" data-price="'+data[i]['mark_up']+'" onclick="itemSelect(this)">'+data[i]['name']+'</a></h2>';
                html_code += '<div class="app-doc-meta row mt-1">';
                html_code += '<div class="col-auto"><span class="text-muted">Stocks: </span> '+parseInt(data[i]['stock_out_qty']+data[i]['stock_in_qty'])+'</div>';
                html_code += '<div class="col-auto"><span class="text-muted">Unit: </span> '+ data[i]['unit']+'</div>';
                html_code += '<div class="col-auto"><span class="text-muted">Price: </span>P '+ parseFloat(data[i]['mark_up']).toFixed(2);
                html_code += '</div></div></div></div></div>'; 
            }
            $("#product-items").html(html_code);
        }
     });
}
 
function itemSelect(that){ //products from POS to modal
    var barcode = $(that).attr('data-barcode');
    var unit = $(that).attr('data-unit');
    var mark_up = $(that).attr('data-price');
    var max_qty = $(that).attr('data-qty');
    var name = $(that).attr('data-name');

    var get_barcode =[];
    var get_qty =[];
    $('#sale-items tr td.barcode').each(function(){
        get_barcode.push($(this).text());
    });
    $('#sale-items tr td.subQTY').each(function(){
        get_qty.push($(this).text());
    });

    for(let i = 0; i <= get_barcode.length; i++){
        if(barcode == get_barcode[i]){
            max_qty -= get_qty[i]
            break
        }
    }

    $('#product_qty').val('');
    $('#product_unit').val(unit);
    $('#product_price').val(mark_up);
    $('#barcode').val(barcode);
    $('#product_name').val(name);
    $('#max_qty').html(max_qty);
    $('#unit_t').html(unit);
    $('#product_qty').prop('autofocus', true);
    setTimeout(function() { $('#product_qty').focus(); }, 1000);
}

// add item in pos page
function addItem(){ 
    var barcode = $('#barcode').val();
    var name = $('#product_name').val();
    var max_qty = parseInt($('#max_qty').text());
    var qty = parseInt($('#product_qty').val());
    var price = $('#product_price').val();
    var unit = $('#product_unit').val();
    var rowCount = $('#sale-items tbody tr').length;

    if(rowCount==0){
        if(qty != 0 && qty <= max_qty){
            var sub_total = parseFloat(price*qty);
            addPurchaseItem(rowCount,barcode,name,qty,unit,price,sub_total,max_qty)
            calculateTotal();
        }
    }else{
        var get_barcode =[];
        var get_qty =[];
        var get_rowcount =[];
        $('#sale-items tr td.barcode').each(function(){
            get_barcode.push($(this).text());
        });
        $('#sale-items tr td.subQTY').each(function(){
            get_qty.push($(this).text());
        });
        $('#sale-items tr.rowCount').each(function(){
            get_rowcount.push($(this).attr('data-count'));
        });

        if(qty != 0 && qty <= max_qty){
            var item_exist = 0;
            for(let i = 0; i <= get_barcode.length; i++){
                if(barcode == get_barcode[i]){
                    var new_qty = parseInt(get_qty[i]) + parseInt(qty);
                    var sub_total = parseFloat(price*new_qty);
                    item_exist = 1;

                    $("#sale-items tr#"+get_rowcount[i]).remove();
                    
                    var html_code = ''; 
                    html_code += '<tr id="'+get_rowcount[i]+'" class="rowCount" data-count="'+get_rowcount[i]+'">';
                    html_code += '<td class="barcode">'+barcode+'</td>';
                    html_code += '<td>'+name+'</td>';
                    html_code += '<td class="subQTY">'+numberWithCommas(new_qty)+'</td>';
                    html_code += '<td>'+unit+'</td>';
                    html_code += '<td class="price">'+parseFloat(price).toFixed(2)+'</td>';
                    html_code += '<td class="subtotal">'+numberWithCommas(sub_total.toFixed(2))+'</td>';
                    html_code += '<td><div class="card-toolbar text-right"><a href="#editQTY" data-bs-toggle="modal" data-rowcount="'+rowCount+'" data-qty="'+new_qty+'" data-max_qty="'+max_qty+'" data-barcode="'+barcode+'" data-name="'+name+'" data-unit="'+unit+'" data-price="'+price+'" data-total="'+sub_total+'" onclick="edititemSelect(this)" class="confirm-delete text-info" title="Delete"><i class="fas fa-pencil-alt"></i></a> <a href="#" data-qty="'+new_qty+'" data-total="'+sub_total+'" onclick="removeitemButton(this)" class="confirm-delete text-danger" title="Delete"><i class="fas fa-trash-alt"></i></a></div></td>';
                    html_code += '</tr>';
                    $('#search_barcode').val('');
                    $('#addQTY').modal('toggle');
                    $('#product_qty').val('');
                    $("#sale-items").append(html_code);
                    calculateTotal();
                    break
                }else{
                    item_exist = 0
                }
            }
            if(item_exist==0){
                var sub_total = parseFloat(price*qty);
                addPurchaseItem(rowCount,barcode,name,qty,unit,price,sub_total,max_qty)
                calculateTotal();
            }
           
    
        }
       
    }
}

function addPurchaseItem(rowCount,barcode,name,qty,unit,price,sub_total,max_qty){
    var html_code = ''; 
    html_code += '<tr id="rowCount-'+rowCount+'" class="rowCount" data-count="rowCount-'+rowCount+'">';
    html_code += '<td class="barcode">'+barcode+'</td>';
    html_code += '<td>'+name+'</td>';
    html_code += '<td class="subQTY">'+numberWithCommas(qty)+'</td>';
    html_code += '<td>'+unit+'</td>';
    html_code += '<td class="price">'+parseFloat(price).toFixed(2)+'</td>';
    html_code += '<td class="subtotal">'+numberWithCommas(sub_total.toFixed(2))+'</td>';
    html_code += '<td><div class="card-toolbar text-right"><a href="#editQTY" data-bs-toggle="modal" data-rowcount="'+rowCount+'" data-qty="'+qty+'" data-max_qty="'+max_qty+'" data-barcode="'+barcode+'" data-name="'+name+'" data-unit="'+unit+'" data-price="'+price+'" data-total="'+sub_total+'" onclick="edititemSelect(this)" class="confirm-delete text-info" title="Delete"><i class="fas fa-pencil-alt"></i></a> <a href="#" data-qty="'+qty+'" data-total="'+sub_total+'" onclick="removeitemButton(this)" class="confirm-delete text-danger" title="Delete"><i class="fas fa-trash-alt"></i></a></div></td>';
    html_code += '</tr>';
    $('#search_barcode').val('');
    $('#addQTY').modal('toggle');
    $('#product_qty').val('');
    $("#sale-items").append(html_code);
}

// add item in pos page
function editItem(){ 
    var barcode = $('#edit_barcode').val();
    var name = $('#product_name').val();
    var max_qty = parseInt($('#edit_max_qty1').val());
    var qty = parseInt($('#edit_product_qty').val());
    var price = $('#edit_product_price').val();
    var unit = $('#edit_product_unit').val();
    var rowcount = $('#rowcount').val();
    var rowCount = $('#sale-items tbody tr').length + 1;

    if(qty != 0 ){
        if(qty <= max_qty){
            $("#rowCount-"+rowcount).remove();
            var sub_total = parseFloat(price*qty);
            var html_code = ''; 
            html_code += '<tr id="rowCount-'+rowCount+'">';
            html_code += '<td class="barcode">'+barcode+'</td>';
            html_code += '<td>'+name+'</td>';
            html_code += '<td class="subQTY">'+numberWithCommas(qty)+'</td>';
            html_code += '<td>'+unit+'</td>';
            html_code += '<td class="price">'+parseFloat(numberWithCommas(price)).toFixed(2)+'</td>';
            html_code += '<td class="subtotal">'+numberWithCommas(sub_total.toFixed(2))+'</td>';
            html_code += '<td><div class="card-toolbar text-right"><a href="#editQTY" data-bs-toggle="modal" data-rowcount="'+rowCount+'" data-qty="'+qty+'" data-max_qty="'+max_qty+'" data-barcode="'+barcode+'" data-name="'+name+'" data-unit="'+unit+'" data-price="'+price+'" data-total="'+sub_total+'" onclick="edititemSelect(this)" class="confirm-delete text-info" title="Delete"><i class="fas fa-pencil-alt"></i></a> <a href="#" data-qty="'+qty+'" data-total="'+sub_total+'" onclick="removeitemButton(this)" class="confirm-delete text-danger" title="Delete"><i class="fas fa-trash-alt"></i></a></div></td>';
            html_code += '</tr>';
            $('#search_barcode').val('');
            $('#editQTY').modal('toggle');
            $('#edit_product_qty').val('');
            $("#sale-items").append(html_code);
            calculateTotal();
        }
    }
    
}

function edititemSelect(that){ //products from POS to edit modal
    var barcode = $(that).attr('data-barcode');
    var unit = $(that).attr('data-unit');
    var mark_up = $(that).attr('data-price');
    var max_qty = $(that).attr('data-max_qty');
    var name = $(that).attr('data-name');
    var rowcount = $(that).attr('data-rowcount');

    $('#edit_product_qty').val('');
    $('#edit_product_unit').val(unit);
    $('#edit_product_price').val(mark_up);
    $('#edit_barcode').val(barcode);
    $('#edit_product_name').val(name);
    $('#edit_max_qty').html(max_qty+' '+unit);
    $('#edit_max_qty1').val(max_qty);
    $('#edit_unit_t').html(unit);
    $('#rowcount').val(rowcount);
    $('#edit_product_qty').prop('autofocus', true);
    setTimeout(function() { $('#edit_product_qty').focus(); }, 1000);
}


// remove item in pos page
function removeitemButton(that){
    $(that).closest("tr").remove();
    calculateTotal();
}

function calculateTotal(){
    var totalqty = 0;
    var grandtotal = 0;
    var grandtotaldiscount = 0;
    var subqty = $('#sale-items tr .subQTY').get();
    var subtotal = $('#sale-items tr .subtotal').get();
    var discount = parseFloat($('#discount').text());

    $(subqty).each(function(){
        totalqty += parseInt($(this).text().replace(/,/g, ""));
    });
    $(subtotal).each(function(){
        grandtotal += parseFloat($(this).text().replace(/,/g, ""));
    });

    if(discount != 0){
        grandtotaldiscount = (grandtotal - discount);
    }else{
        grandtotaldiscount = grandtotal;
    }

    $('#grandtotal').html(numberWithCommas(grandtotaldiscount.toFixed(2)));
    $('#grandtotal1').html(numberWithCommas(grandtotaldiscount.toFixed(2)));
    $('#totalqty').html(numberWithCommas(totalqty));
    $('#subtotal').html(numberWithCommas(grandtotal.toFixed(2)));
   
}

function addDiscount(){
    var sale_discount = parseInt($('#sale_discount').val());
    var grandtotal = parseInt($('#grandtotal').text());
    var subtotal = parseInt($('#subtotal').text().replace(/,/g, ''));
    var pin = $('#pin').val();
    var pos_pin = $('#pos-pin').val();

    if(grandtotal && pin==pos_pin){
        discounted = subtotal * (sale_discount/100);
        $('#discount_percentage').html(sale_discount);
        $('#discount').html(numberWithCommas(discounted.toFixed(2)));
        $('#discountModal').modal('toggle');
        $('#sale_discount').val('');
        $('#pin').val('');
        calculateTotal();
    }

}

function payNow(){
    var grandtotal = $('#grandtotal').text();
    $('#payment_to_pay').html(grandtotal);
}

function payment_okay(){
    var payment = parseFloat($('#grandtotal').text().replace(/,/g, ""));
    var grandtotal = parseFloat($('#subtotal').text().replace(/,/g, ""));
    var paymentcash = parseFloat($('#payment_cash').val().replace(/,/g, ""));
    var discount = parseInt($('#discount_percentage').text().replace(/,/g, ""));

    var barcode = [];
    var price = [];
    var quantity = [];
    var total_quantity = 0;

    if(isNaN(discount)){
        discount = 0;
    }

    if(paymentcash >= payment){
 
        $('#sale-items tr .barcode').each(function(){
            barcode.push($(this).text());
        });
        $('#sale-items tr .subQTY').each(function(){
            quantity.push($(this).text());
            total_quantity += parseInt($(this).text());
        });
        $('#sale-items tr .price').each(function(){
            price.push($(this).text().replace(/,/g, "").replace("₱",""));
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/admin/pos/sold',
            data:{
                grandtotal:grandtotal,
                total_quantity:total_quantity,
                discount:discount,
                barcode:barcode,
                price:price,
                quantity:quantity,
                paymentcash:paymentcash
            },
            success:function(data) {
                if(data['success'] === true){
                    window.open(SITE_URL+'/admin/sales/'+data['receipt_id']);
                    $('#paynow').modal('toggle');
                    $('#payment_cash').val('');

                    $('#pos-msg').show();
                    location.reload();
                }
            }
         });
    }
}

function paymentChange(that){
    var cash = parseFloat($(that).val().replace(/,/g, ""));
    var grandtotal = parseFloat($('#grandtotal').text().replace(/,/g, ""));

    var change = cash - grandtotal;
    if(change){
        $('#payment_change').html(numberWithCommas(change.toFixed(2)));
    }
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}