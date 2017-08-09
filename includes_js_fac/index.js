//index.js
$(document).ready(function() {
	
	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/_detect_browser.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.browser == "mobile"){
		  window.location.href = "http://cdcom.dynalias.com/facturalion2/index_mobile.html";
		  return;
		} else {
		  window.location.href = "http://cdcom.dynalias.com/facturalion2/index_desktop.html";
		  return;	
		}
	}).fail(function(xhr, textStatus, errorThrown) {
	  alert(errorThrown);
	}).always(function() {
	   $.spin('false');
	});	 
	 
});
