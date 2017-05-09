//invalid_login.js
$(document).ready(function() {
	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/_blank_session.php',
	dataType: 'json',
	beforeSend: function() {
      $.spin('true');
	}
	}).done(function() {
	  return;	
	}).always(function() {
	   $.spin('false');
	});
	
});