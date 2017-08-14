//index_desktop.js
$(document).ready(function() {
  $('#accesar').on("click", function(){
    var post_login = document.getElementById('field_login').value;
	var post_passw = document.getElementById('field_passw').value;
	ValidateData(post_login, post_passw);
  });
});

function ValidateData(login, passw){
  $.ajax({
    type: 'POST',
    url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/_validate.php',
	data: {"type_access":"login", "login":login, "passw":passw},
    dataType: 'json',
    beforeSend: function(xhr) {
      $.spin('true');      
    }	
  }).done(function(data) {
		if(data.error == "empty"){
	      window.location = data.goPage;
		} else {
		  new PNotify({
			  title: 'Validación',
			  text: data.error,
			  type: 'info',
			  delay: 1000
		  });			
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
}