//customers.js
$(document).ready(function() {
    $('#icons').load('http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_customers.php');
	$(document).on("click", ".item_customer", function() {
	   //found_item($(this).attr("id"));
	   alert($(this).attr("id"));
	});
	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_user.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.authorized == "Yes"){
		  $('#login_user').text(data.login_user);
	      $("#login_user_right").html(data.login_user);		  
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

function found_item(idgral){
  $.ajax({
    type: 'POST',
    url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/finddata_idgral_customer.php',
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