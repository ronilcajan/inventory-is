$(document).ready(function(){
    var total_qty = 0, total_discount = 0, total_paid = 0;
    var qty = $('#sales-report tr .qty').get();
    var discount = $('#sales-report tr .discount').get();
    var paid = $('#sales-report tr .paid').get();

    $(qty).each(function(){
        total_qty += parseInt($(this).text().replace(/₱/g, "").replace(/,/g, ""));
    });
    $(discount).each(function(){
        total_discount += parseInt($(this).text().replace(/₱/g, "").replace(/,/g, ""));
    });
    $(paid).each(function(){
        total_paid += parseInt($(this).text().replace(/₱/g, "").replace(/,/g, ""));
    });

    $('#total_qty').html(total_qty+ ' items');
    $('#total_discount').html('₱ '+ parseFloat(total_discount).toFixed(2));
    $('#total_paid').html('₱ '+ parseFloat(total_paid).toFixed(2));
});