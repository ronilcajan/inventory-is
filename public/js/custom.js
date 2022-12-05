// show password when toggle
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

function editPerm(data){
    var id = $(data).attr('data-id');
    var permission = $(data).attr('data-name');
    var desc = $(data).attr('data-des');
    
    $('#permission_id').val(id);
    $('#pname').val(permission);
    $('#pdesc').text(desc);
}

function editRole(data){
    var id = $(data).attr('data-id');
    var role = $(data).attr('data-name');
    var desc = $(data).attr('data-des');
    var permission = $(data).attr('data-perm');
   
    $('#role_id').val(id);
    $('#role_name').val(role);
    $('#role_desc').text(desc);

    $.each(JSON.parse(permission), function (i, elem) {
       var checked = $('#permi-'+elem);
       checked.prop('checked', !this.checked);
       console.log(checked);
    });
}

function editUser(data){
    var id = $(data).attr('data-id');
    var username = $(data).attr('data-uname');
    var role = $(data).attr('data-role');
    var lname = $(data).attr('data-lname');
    var fname = $(data).attr('data-fname');
    var contact = $(data).attr('data-contact');
   
    $('#user_id').val(id);
    $('#username').val(username);
    $('#lname').val(lname);
    $('#fname').val(fname);
    $('#contact_no').val(contact);

    $.each(JSON.parse(role), function (i, elem) {
        $('#roles_id').val(elem).change();
    });
}

function editSupplier(data){
    var id = $(data).attr('data-id');
    var name = $(data).attr('data-name');
    var email = $(data).attr('data-email');
    var contact_no = $(data).attr('data-contact_no');
    var company = $(data).attr('data-company');
    var address = $(data).attr('data-address');

    $('#sup_id').val(id);
    $('#name').val(name);
    $('#email').val(email);
    $('#contact_no').val(contact_no);
    $('#company').val(company);
    $('#address').text(address);
}

function editCategory(data){
    var id = $(data).attr('data-id');
    var name = $(data).attr('data-name');
    var desc = $(data).attr('data-desc');

    $('#category_id').val(id);
    $('#name').val(name);
    $('#description').val(desc);
}

function moveProducts(data){
    var id = $(data).attr('data-id');
    var name = $(data).attr('data-name');
    var qty = $(data).attr('data-quantity');
    var unit = $(data).attr('data-unit');
    var price = $(data).attr('data-price');

    $('#prod_id').val(id);
    $('#product').val(name);
    $('#quantity').val(qty);
    $('#unit').val(unit);
    $('#stock_out_qty').attr({"max":qty});
    $('#mark_up').attr({"min": price});
    $('#price').val(parseFloat(price));
}

$("#supplier_id").select2({
    theme: "bootstrap-5",
    containerCssClass: "select2--small",
    dropdownCssClass: "select2--small",
    dropdownAutoWidth : true,
    width: 'auto'
});

$("#category").select2({
    theme: "bootstrap-5",
    containerCssClass: "select2--small",
    dropdownCssClass: "select2--small",
});
function select2Barcode(){
    $(".barcode").select2({
        theme: "bootstrap-5",
        containerCssClass: "select2--small",
        dropdownCssClass: "select2--small",
        dropdownAutoWidth : true,
        width: 'auto',
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: SITE_URL+'/search_barcode',
            type: 'post',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.barcode+' - '+item.name,
                          id: item.id,
                      }
                  })
              };
            },
        }
    });
}

select2Barcode();
// check products in delivery page
function loadProducts(that){
    var id = $(that).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/admin/orders/findProduct',
        data:{id:id},
        success:function(data) {
            console.log(data)
            $(that).closest('tr').find('td input.product_name').val(data.name);
            $(that).closest('tr').find('td input.product_price').val(parseFloat(data.price).toFixed(2));
        }
     });
}

// add button in delivery page
var count = $('table#order_table tbody tr:last').index() + 1;
function addRow(){
    count += 1;
    var html_code = ''; 
    html_code += '<tr>';
    html_code += '<td class="cell">'+count+'</td>';
    html_code += '<td><select class="form-control barcode" name="product_id[]" onchange="loadProducts(this)" required><option value="">Search Barcode or Item</option></select></td>';
    html_code += '<td class="cell"><input type="text" class="form-control product_name" readonly></td>';
    html_code += '<td class="cell"><input type="text" class="form-control product_qty" name="product_qty[]" onchange="calculateTotalAmount(this)" required></td>';
    html_code += '<td class="cell"><input type="number" class="form-control product_price" name="product_price[]" onchange="calculateTotalAmount1(this)" required></td>';
    html_code += '<td class="cell"><input type="number" class="form-control product_amount" name=product_amount[]" readonly></td>';
    html_code += '<td class="cell text-center""><button type="button" class="btn btn-danger text-white" onclick="removeButton(this)"><i class="fa-solid fa-minus"></i></button></td>';
    $("#order_table").append(html_code);
    select2Barcode();
}
// remove button in delivery page
function removeButton(that){
    $(that).closest("tr").remove();
}
// calculate total amount in delivery page
function calculateTotalAmount(that){

    var qty = $(that).closest("tr").find('td input.product_qty').val();
    var price = $(that).closest("tr").find('td input.product_price').val();
  
    $(that).closest("tr").find('td input.product_amount').val(parseFloat(qty*price).toFixed(2));

    var totalqty = calculateTotalQTY();

    var totalamount = 0;
    $('#order_table tr td input.product_amount').each(function(){
        totalamount += parseFloat($(this).val());
    });

    $('#totalQty').val(parseInt(totalqty));
    $('#grandTotal').val((parseFloat(totalamount).toFixed(2)));
}
// calculate total qty in delivery page
function calculateTotalQTY(){
    var totalqty = 0;
    $('#order_table tr td input.product_qty').each(function(){
        totalqty += parseInt($(this).val());
    });
    return totalqty;
}
// calculate total in delivery page
function calculateTotal(){
    var total = 0;
    $('#order_table tr td input.product_amount').each(function(){
        total += parseFloat($(this).val());
    });
    return total;
}
// calculate total amount in delivery page
function calculateTotalAmount1(that){
    var qty = $(that).closest("tr").find('td input.product_qty').val();
    var price = $(that).closest("tr").find('td input.product_price').val();
    $(that).closest("tr").find('td input.product_amount').val(parseFloat(qty*price).toFixed(2));

    var totalamount = 0;
    $('#order_table tr td input.product_amount').each(function(){
        totalamount += parseFloat($(this).val());
    });

    $('#grandTotal').val((parseFloat(totalamount).toFixed(2)));

}

//add spinner on button
function loading() {
    $(".btn .spinner-border").show();
    $(".btn .btn-text").html("Loading");
}

//print page
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

// add percentage on warehouse page
function addpercent(that){
    var markup = 0;
    var initial = 0;
    var percent = parseInt($(that).val());
    var price = parseFloat($('#price').val());
    var vat = parseInt($('#vat').text());
   
console.log(vat)
    initial = price + (price * (percent/100));
    markup = initial + (initial * (vat/100));

    $('#mark_up').val(markup);
}

// add comma dynamically on numbers
function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
$('#sale_discount, #payment_cash').keyup(function () {
    var value = $(this).val().replace(/,/g,'');
    console.log(value);
    $(this).val(addCommas(value));
});