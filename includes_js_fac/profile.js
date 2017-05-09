//profile.js
$(document).ready(function() {
	$.ajax({
	url: 'includes_php_fac/getdata_user.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.authorized == "Yes"){
		  $('#login_user').text(data.login_user);
	      $("#login_user_right").html(data.login_user);
		  $("#login_user_avatar").html(data.name_user);		  
		  var domicilio = 'Calle ' + data.calle_fiscal + ' ' + data.noExterior_fiscal + '</br>';
		  domicilio = domicilio + '&nbsp;&nbsp;&nbsp;Colonia ' + data.colonia_fiscal + '</br>';
		  domicilio = domicilio + '&nbsp;&nbsp;&nbsp;Del. ' + data.municipio_fiscal + '</br>';
		  domicilio = domicilio + '&nbsp;&nbsp;&nbsp;C.P. ' + data.codigoPostal_fiscal + '</br>';
		  domicilio = domicilio + '&nbsp;&nbsp;&nbsp;Estado ' + data.estado_fiscal + '</br>';
		  domicilio = domicilio + '&nbsp;&nbsp;&nbsp;Ciudad ' + data.ciudad_fiscal + '</br>';
		  domicilio = domicilio + '&nbsp;&nbsp;&nbsp;País ' + data.pais_fiscal + '</br>';
		  $("#domicilio_fiscal").html(domicilio);		  
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



