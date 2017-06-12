//invoices_list_customer.js
$(document).ready(function() {
    /*
    $('#icons').load('http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_invoices_list_customer.php');
	$(document).on("click", ".item_invoice", function() {
	   	save_selection_item($(this).attr("id"));
	});
	*/
	
	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_user.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.authorized == "Yes"){
		  $('#login_user').text(data.login_user);
	      $('#login_user_right').html(data.login_user);	
		  $('#month_selected_value').html(data.item_month_name_value);
		  $('#year_selected_value').html(data.item_year_selected_value);
		  $('#customer_selected_value').html(data.item_name_customer_selected_value);
		  $('#number_invoice_selected_value').html(data.item_number_invoice_selected_value);
		  return;
		} else {
		  window.location.href = "http://cdcom.dynalias.com/facturalion2/includes_php_fac/_logout.php";
		  return;	
		}
	}).fail(function(xhr, textStatus, errorThrown) {
	  alert(errorThrown);
	}).always(function() {
	   $.spin('false');
	});
});

/*
function save_selection_item(idgral){
  $.ajax({
    type: 'POST',
    url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/saveitemdata_invoice.php',
	data: {'id':idgral},
    dataType: 'json',
    beforeSend: function(xhr) {
      $.spin('true');      
    }	
  }).done(function(data) {
	if(data.result == "Ok!"){
      window.location ="invoice_actions_invoice.html";
	} else {
      //No se pudo realizar la operación solicitada.
	}
  }).fail(function(xhr, textStatus, errorThrown) {    
    alert(errThrown);
  }).always(function() {
    $.spin('false');
  });
}


function found_item(idgral){
  $.ajax({
    type: 'POST',
    url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/finddata_idgral_month.php',
	data: {'id':idgral},
    dataType: 'json',
    beforeSend: function(xhr) {
      $.spin('true');      
    }	
  }).done(function(data) {
	if(data.result == "Found!"){
      window.location ="rabbits_consult.html";
	} else {

	}
  }).fail(function(xhr, textStatus, errorThrown) {    
    alert(errThrown);
  }).always(function() {
    $.spin('false');
  });
}

*/