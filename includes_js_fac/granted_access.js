//config_site.js
$(document).ready(function() {
	$.ajax({
	url: 'http://cdcom.dynalias.com/facturalion2/includes_php_fac/getdata_user.php',
	dataType: 'json',
	beforeSend: function(xhr) {
      $.spin('true');
	}
	}).done(function(data) {
		if(data.authorized == "Yes"){
		  $('#nombre_usuario').text(data.login_user);
		  return;
		} else {
		  Logout();
		  return;	
		}
	}).fail(function(xhr, textStatus, errorThrown) {
	  alert(errorThrown);
	}).always(function() {
	   $.spin('false');
	});
	
  $('#logout').on("click", function(){
    Logout();
  });
	
});

function Logout(){
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
}