<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$idgral        = $_SESSION['idgral_user'];
$prefix_user   = $_SESSION['prefix_table_user'];
$expediente	   = "C".$prefix_user."_Expediente";
$fecha_actual  = date("Y-m-d H:i:s");
$vfecha_actual  = date("Y.m.d_H.i.s");

$table_select = $_POST['tbl'];
switch ($table_select) {
	case "access":
		$passw = $_POST['data_01'];
	    $sql   = "UPDATE facturacion_cuentas_acceso SET ";
	    $sql  .= "password = '$passw' ";
	    $sql  .= "WHERE idgral = '$idgral'";
		break;
	case "pattern":
		$pattern = $_POST['data_01'];
	    $sql   = "UPDATE facturacion_cuentas_acceso SET ";
	    $sql  .= "login_pattern = '$pattern' ";
	    $sql  .= "WHERE idgral = '$idgral'";
		break;		
	case "series":
		$sql = "SELECT * FROM facturacion_series WHERE idgral = '$idgral'";
		break;
	case "stamp":
		$sql = "SELECT * FROM facturacion_timbrados WHERE idgral = '$idgral'";
		break;		
}

		
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

//Consulta
$result = mysqli_query($link, $sql);
if(!$result) {
	$message_error  = "File : savedate_customer.php"."\r\n";
	$message_error .= "Fecha: $fecha_actual"."\r\n";
	$message_error .= "--------------------------------------------------- Error ---------------------------------------------------"."\r\n";
	$message_error .= mysqli_error($link)."\r\n";
	$message_error .= "---------------------------------------------------- SQL ----------------------------------------------------"."\r\n";
	$message_error .= $sql."\r\n";
	$name		    = "error_".$vfecha_actual.".txt";
	$file_name      = $_SERVER['DOCUMENT_ROOT']."/facturalion/clientes/".$expediente."/facturas/debug/".$name;
	$file_debug     = fopen ($file_name, "w");
	fwrite($file_debug, $message_error);
	fclose($file_debug);	
	$result= "No";
} else {
	$message_error = "null";
	$result= "Ok!";
}

$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$type_browser = $_SESSION['session_type_browser'];

$data_cache = array(
'result'=>$result,
'type_browser'=>$type_browser
);
header('Content-type: application/json');
echo json_encode($data_cache);
?>