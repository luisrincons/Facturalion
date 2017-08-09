//invoices_consult_customer.js
$(document).ready(function() {
	
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
		  $('#number_invoice_selected_value').html(data.item_number_invoice_selected_value);
		  var id = data.item_invoice_selected_value;
		  getdata_invoice_selected(id);
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

function getdata_invoice_selected(idgral){
	$("#content_invoice").load("http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_invoice.php");     
}
