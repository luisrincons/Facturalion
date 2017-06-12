<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$_SESSION['itemdata_selected_invoice'] = $_POST['id'];
$idgral = $_SESSION['itemdata_selected_invoice'];

$prefijo_tabla = $_SESSION['prefix_table_user'];
$tabla = $prefijo_tabla."_facturacion_invoice";
		
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql = "SELECT * FROM ".$tabla." WHERE idgral = '$idgral'";
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

$_SESSION['itemdata_selected_number_invoice'] = "";
//Consulta
if(!$data = mysqli_query($link, $sql)) die();
if ($row = mysqli_fetch_array($data)) {
	$fecha_factura = $row["date_invoice"];
	$serie_cfdi = trim($row["series_invoice"]);
	if($serie_cfdi == ""){
	   $serie_cfdi = "CFDI";
	}
	$numero_cfdi = $serie_cfdi." ".$row["number_invoice"];
	$status_cfdi = $row["status_cfdi"];
	if($status_cfdi == "vigente"){
	   $color_cfdi = "blue";
	   $color_status = "green";
	   $color_monto = "green";
	   $color_icono = "gold";
	   $color_fecha = "blue";
	} else {
	   $color_cfdi = "grey";
	   $color_status = "grey";
	   $color_monto = "grey";
	   $color_icono = "grey";
	   $color_fecha = "dark";
	}
	$monto = number_format($row["total_invoice"], 2, ".", ",");
    $_SESSION['itemdata_selected_number_invoice'] = $numero_cfdi;
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$data_cache = array(
'result'=>'Ok!'
);
header('Content-type: application/json');
echo json_encode($data_cache);

?>