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
	}).fail(function(jqXHR, textStatus, errorThrown) {
		var code_error = "";
        if (jqXHR.status === 0) {
           code_error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
           code_error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
           code_error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
           code_error = 'Requested JSON parse failed.';
        } else if (textStatus === 'timeout') {
           code_error = 'Time out error.';
        } else if (textStatus === 'abort') {
           code_error = 'Ajax request aborted.';
        } else {
           code_error = 'Uncaught Error: ' + jqXHR.responseText;
        }
		$.spin('false');
		new PNotify({
		    title: code_error,
			text: errorThrown,
			type: 'error',
			delay: 2500
		});		  
		return;	  
	}).always(function() {
	   $.spin('false');
	});	
});
