//profile.js
$(document).ready(function() {
	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_user.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.authorized == "Yes"){
		  $('#login_user').text(data.login_user);
	      $("#login_user_right").html(data.login_user);
		  $("#login_user_avatar").html(data.name_user);
		  if(data.ruta_logo != ""){
		    $("#profile_logo").attr("src", data.ruta_logo);
		  }
		  var domicilio = 'Calle ' + data.calle_fiscal + ' ' + data.noExterior_fiscal + '</br>';
		  domicilio = domicilio + 'Colonia ' + data.colonia_fiscal + '</br>';
		  domicilio = domicilio + 'Del. ' + data.municipio_fiscal + '</br>';
		  domicilio = domicilio + 'C.P. ' + data.codigoPostal_fiscal + '</br>';
		  domicilio = domicilio + 'Estado ' + data.estado_fiscal + '</br>';
		  domicilio = domicilio + 'Ciudad ' + data.ciudad_fiscal + '</br>';
		  domicilio = domicilio + 'País ' + data.pais_fiscal + '</br>';
		  $("#domicilio_fiscal").html(domicilio);
		  $("#data_contribuyente").html(data.tipo_persona);
		  $("#data_certificado").html(data.num_Certificado);
		  $("#data_regimen").html(data.tipo_regimen);
		  $("#data_rfc").html(data.RFC_SAT);
		  $("#data_curp").html(data.CURP_emisor);
		  $("#data_nombre").html(data.nombre_SAT);
		  $("#data_regpatronal").html(data.RegistroPatronal);
		  $("#data_correo").html(data.correo_fiscal);
		  return;
		} else {
		  window.location.href = "http://cdcom.dynalias.com/facturalion2/includes_php_fac/_logout.php";
		  return;	
		}
	}).fail(function(xhr, textStatus, errorThrown) {
	  alert(errorThrown);
	}).always(function() {
	   $.spin('false');
	});	
	
	$('#logout').on("click", function(){
		$.ajax({
		url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/_logout.php',
		dataType: 'json',
		beforeSend: function(xhr) {
		  $.spin('true');
		}
		}).done(function(data) {
		   if(data.result == "Ok!"){
		      window.location = "index.html";
		   }
		   return;
		}).fail(function(xhr, textStatus, errorThrown) {
		  alert(errorThrown);
		}).always(function() {
		   $.spin('false');
		});
	});		
	
});



