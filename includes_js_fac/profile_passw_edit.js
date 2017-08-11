//profile_passw_edit.js
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
		}
		return;		
	}).fail(function(xhr, textStatus, errorThrown) {
	  alert(errorThrown);
	}).always(function() {
	   $.spin('false');
	});
		

	$("#save_passw").on('click', function(event) {
	   var passw = $.trim($("#passw").val());
	   if (passw.length < 5){
		   	   new PNotify({
				  title: 'La contraseña es inválida',
				  text: 'Debe tener 5 caracteres como mínimo.',
				  type: 'info'
			   });
			   return;
	   }
	   if (passw == ""){
		   	   new PNotify({
				  title: 'El campo esta vacío',
				  text: 'Teclee una contraseña válida.',
				  type: 'info'
			   });
			   return;
	   }
	   var verif = $.trim($("#verify").val());
	   if (verif == ""){
		   	   new PNotify({
				  title: 'El campo esta vacío',
				  text: 'Repita nuevamente la contraseña.',
				  type: 'info'
			   });
			   return;
	   }	   
	   if(passw != verif){
		  $('#myModalInfoLabel').html('No coinciden las contraseñas');
		  $('#contenidoInfo').html('Debe teclear la misma contraseña en ambos campos');
		  $('#message-info').modal('show');
	   } else {
		  $('#myModalWarningLabel').html('<i class="fa fa-exclamation-circle"></i> Cambiar la contraseña');
		  $('#contenidoWarning').html('¿Esta seguro de realizar el cambio de contraseña?');
		  $('#message-warning').modal('show');  
	   }
     });

	 $('#aceptar-info').on('click', function(event) {
	   $('#message-info').modal('hide');
     });

	 $('#aceptar-sucess').on('click', function(event) {
	   $('#message-sucess').modal('hide');
     });
	 
	$('#aceptar-warning').on('click', function(event) {
		
	   $('#message-warning').modal('hide');
	   var passw = $.trim($("#passw").val());
	   $("#passw").val("");
	   $("#verify").val("");   

	   $.ajax({
		 type: 'POST',
		 url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/savedata_customer.php',
		 data: {'tbl':'access', 'data_01':passw},
		 dataType: 'json',
		 beforeSend: function(xhr) {
		   $.spin('true');      
		 }	
	     }).done(function(data) {
		  if(data.result == "Ok!"){
			   new PNotify({
				  title: 'Cambio de contraseña',
				  text: 'El proceso ha sido realizado con éxito.',
				  type: 'success'
			   });  
		  } else {
			   new PNotify({
				  title: 'Cambio de contraseña',
				  text: 'El proceso no pudo ser realizado.',
				  type: 'error'
			   });	
		  }
		  return;
	     }).fail(function(xhr, textStatus, errorThrown) {    
		    alert(errThrown);
	     }).always(function() {
		    $.spin('false');
	   });			   
	   		  
     });	 
	 
	 
	 $('#cerrar-info').on('click', function(event) {
	   $('#message-info').modal('hide');
     });
	 
	$('#cerrar-sucess').on('click', function(event) {
	   $('#message-sucess').modal('hide');
     });
	 
	$('#cerrar-warning').on('click', function(event) {
	   $('#message-warning').modal('hide');
	   $("#passw").val("");
	   $("#verify").val("");   
     });	 
  
	$(document).on("click", "#asign_pattern", function() {
	   	window.location = "profile_pattern_create.html";
		return;
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



