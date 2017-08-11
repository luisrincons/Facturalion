//index.js
$(document).ready(function() {
	var pattern_access = "";
	if(localStorage['pattern_data']){
	    pattern_access = localStorage.getItem('pattern_data');
	} else {
		pattern_access = "empty";
	}

	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/_detect_browser.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.browser == "mobile" && pattern_access != "empty"){
	      window.location.href = "index_mobile.html";
		} else {
		  window.location.href = "index_desktop.html";
		}
		return;	
	}).fail(function(xhr, textStatus, errorThrown) {
	  //alert(errorThrown);
	  $.spin('false');
	  new PNotify({
		  title: 'Error en la conexión',
		  text: errorThrown,
		  type: 'error',
		  delay: 1000
	  });		  
	  return;	  
	}).always(function() {
	   $.spin('false');
	});	
});
