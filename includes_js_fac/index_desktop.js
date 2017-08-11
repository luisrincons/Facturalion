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
	  //alert(errorThrown);
	  $.spin('false');
	  new PNotify({
		  title: 'Error en la conexión',
		  text: errorThrown,
		  type: 'error',
		  delay: 500
	  });
  }).always(function() {
    $.spin('false');
  });
}