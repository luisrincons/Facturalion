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
