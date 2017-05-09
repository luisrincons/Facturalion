//ready.js
$(document).ready(function() {
	$('#wait_data').attr("src", "images_fac/gif/reload.gif");
	$('#wait_data').show();
	$.post("includes_php_fac/getdata_user.php", function(){
		
	})
	.done(function(result) {
	   $('#wait_name').hide();
       var data = eval("(" + result + ")");
	   $("#nombre_usuario").html(data.name_user);
	   $("#wait_icon").attr("src", data.icon_user);
	   $('#wait_icon').show();
	   return;	
	});	
});



