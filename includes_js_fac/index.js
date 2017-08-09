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
		  window.location.href = "index_mobile.html";
		  return;
		} else {
		  window.location.href = "index_desktop.html";
		  return;	
		}
	}).fail(function(xhr, textStatus, errorThrown) {
	  //alert(errorThrown);
	  $.spin('false');
	  window.location.href = "index_desktop.html";
	  return;	  
	}).always(function() {
	   $.spin('false');
	});	 
	 
});
