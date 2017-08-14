//invoices_actions_invoice.js
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
		  $('#month_selected_value').html(data.item_month_name_value);
		  $('#year_selected_value').html(data.item_year_selected_value);
		  $('#customer_selected_value').html(data.item_name_customer_selected_value);
		  $('#number_invoice_selected_value').html(data.item_number_invoice_selected_value);
		  var id = data.item_invoice_selected_value;
		  getdata_invoice_selected(id);
		  return;
		} else {
		  window.location.href = "http://cdcom.dynalias.com/facturalion2/includes_php_fac/_logout.php";
		  return;	
		}
	}).fail(function(xhr, textStatus, errorThrown) {
		//textStatus
		//jqXHR.responseText;
        if (jqXHR.status === 0) {
		   window.location.href = "page_000.html";
        } else if (jqXHR.status == 404) {
		   window.location.href = "page_404.html";
        } else if (jqXHR.status == 500) {
		   window.location.href = "page_500.html";
        } else if (textStatus === 'parsererror') {
			window.location.href = "page_jsonerror.html";
        } else if (textStatus === 'timeout') {
			window.location.href = "page_time_out.html";
        } else if (textStatus === 'abort') {
			window.location.href = "page_error.html";
        } else {
		   window.location.href = "page_unknown.html";
        }
		return;
	}).always(function() {
	   $.spin('false');
	});
	
	$('#logout').on("click", function(){
		$.ajax({
		url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/_logout.php',
		dataType: 'json',
		beforeSend: function(xhr) {
		  $.spin('true');
		}
		}).done(function(data) {
		   if(data.result == "Ok!"){
		      window.location = "index.html";
		   }
		   return;
		}).fail(function(xhr, textStatus, errorThrown) {
		//textStatus
		//jqXHR.responseText;
        if (jqXHR.status === 0) {
		   window.location.href = "page_000.html";
        } else if (jqXHR.status == 404) {
		   window.location.href = "page_404.html";
        } else if (jqXHR.status == 500) {
		   window.location.href = "page_500.html";
        } else if (textStatus === 'parsererror') {
			window.location.href = "page_jsonerror.html";
        } else if (textStatus === 'timeout') {
			window.location.href = "page_time_out.html";
        } else if (textStatus === 'abort') {
			window.location.href = "page_error.html";
        } else {
		   window.location.href = "page_unknown.html";
        }
		return;
		}).always(function() {
		   $.spin('false');
		});
	});		
	
});

function getdata_invoice_selected(idgral){
	$("#content_invoice").load("http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_invoice.php");     
}
