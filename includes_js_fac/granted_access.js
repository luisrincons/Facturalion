//config_site.js
$(document).ready(function() {
	$.ajax({
	url: 'includes_php_fac/getdata_user.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.authorized == "Yes"){
		  $('#nombre_usuario').text(data.login_user);
		  return;
		} else {
		  window.location.href = "includes_php_fac/_logout.php";
		  return;	
		}
	}).fail(function(xhr, textStatus, errorThrown) {
	  alert(errorThrown);
	}).always(function() {
	   $.spin('false');
	});
	
});