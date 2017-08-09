<?php
date_default_timezone_set('America/Mexico_City');

//mkdir($_SERVER['DOCUMENT_ROOT']."/backend/imagenes/customers/".$id_unique, 0777);
    $fecha_actual  = date("Y.m.d_H.i.s");
    $expediente    = "C000_Expediente";
	$message_error = "XXXXXXXXXXX";
	$name		   = "error_".$fecha_actual.".txt";
	$file_name = $_SERVER['DOCUMENT_ROOT']."/facturalion/clientes/".$expediente."/facturas/debug/".$name;
	$file_debug = fopen ($file_name, "w");
	fwrite($file_debug, $message_error);
	fclose($file_debug);

?>