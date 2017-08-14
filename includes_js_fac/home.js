//home.js
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
	
	CargarDatosTimbrado();
	
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
	 
});

function CargarDatosTimbrado(){
	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_total_stamp.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		  $('#timbrado_comprados').html(data.timbrado_comprados);
		  $('#timbrado_vigentes').html(data.timbrado_vigentes);
		  $('#timbrado_cancelados').html(data.timbrado_cancelados);
		  $('#timbrado_timbrados').html(data.timbrado_timbrados);
		  $('#timbrados').html(data.timbrados);
		  $('#cancelados').html(data.cancelados);
		  $('#vigentes').html(data.vigentes);
		  $('#clientes').html(data.clientes);
		  $('#productos').html(data.productos);
		  $('#fecha_compra').html(data.fecha_compra);

		  $('#timbrado_restantes').html(data.timbrado_restantes);
		  var porcentaje_restantes = parseInt(data.porcentaje_timbres_restantes);
		  if(porcentaje_restantes == 0){porcentaje_restantes = 0.1;}
		  
		  var opts = {
			  lines: 12, // The number of lines to draw
			  angle: 0, // The length of each line
			  lineWidth: 0.4, // The line thickness
			  pointer: {
				length: 0.75, // The radius of the inner circle
				strokeWidth: 0.042, // The rotation offset
				color: '#1D212A' // Fill color
			  },
			  limitMax: 'false', // If true, the pointer will not go past the end of the gauge
			  colorStart: '#1ABC9C', // Colors
			  colorStop: '#1ABC9C', // just experiment with them
			  strokeColor: '#F0F3F3', // to see which ones work best for you
			  generateGradient: true
		  };
		  var target = document.getElementById('foo'), // your canvas element
		  gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
		  gauge.maxValue = 100; // set max gauge value
		  gauge.animationSpeed = 32; // set animation speed (32 is default value)
		  gauge.set(porcentaje_restantes); // set actual value
		  gauge.setTextField(document.getElementById("gauge-text"));
		  
		  return;
	}).fail(function(xhr, textStatus, errorThrown) {
	  alert(errorThrown);
	}).always(function() {
	   $.spin('false');
	});
}



