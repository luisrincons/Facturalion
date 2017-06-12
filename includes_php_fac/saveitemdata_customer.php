<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$_SESSION['itemdata_selected_customer'] = $_POST['id'];
$idgral = $_SESSION['itemdata_selected_customer'];

$prefijo_tabla = $_SESSION['prefix_table_user'];
$tabla = $prefijo_tabla."_facturacion_customers";
		
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql = "SELECT * FROM ".$tabla." WHERE idgral = '$idgral'";
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

$_SESSION['itemdata_selected_name_customer'] = "";
//Consulta
if(!$data = mysqli_query($link, $sql)) die();
if ($row = mysqli_fetch_array($data)) {
	$tipo_persona = $row["tipo_persona"];
	if($tipo_persona == 'Moral'){
	   $nombre_cliente = $row["nombre_empresa_moral"];
	} else {
	   $nombre_cliente = $row["nombre_persona_fisica"]." ".trim($row["paterno_persona_fisica"]." ".trim($row["materno_persona_fisica"]));
	}	
    $_SESSION['itemdata_selected_name_customer'] = $nombre_cliente;
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$data_cache = array(
'result'=>'Ok!'
);
header('Content-type: application/json');
echo json_encode($data_cache);
?>