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
		var cont_error = "";
        if (jqXHR.status === 0) {
           code_error = 'Not connect';
		   cont_error = 'Verify Network';
        } else if (jqXHR.status == 404) {
           code_error = 'Code[404]';
		   cont_error = 'Requested page not found';
        } else if (jqXHR.status == 500) {
           code_error = 'Code[500].';
		   cont_error = 'Internal Server Error';
        } else if (textStatus === 'parsererror') {
           code_error = 'ParseError';
		   cont_error = 'Requested JSON parse failed.';
        } else if (textStatus === 'timeout') {
           code_error = 'Error';
		   cont_error = 'Time out';
        } else if (textStatus === 'abort') {
           code_error = 'Error';
		   cont_error = 'Abort';
        } else {
           code_error = 'Uncaught Error';
		   cont_error = jqXHR.responseText;
        }
		$.spin('false');
		new PNotify({
		    title: code_error,
			text: cont_error,
			type: 'error',
			delay: 2500
		});		  
		return;	  
	}).always(function() {
	   $.spin('false');
	});	
});
