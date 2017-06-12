<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$prefijo_tabla = $_SESSION['prefix_table_user'];
$Table_Invoice = $prefijo_tabla."_facturacion_invoice";
$Table_Customers = $prefijo_tabla."_facturacion_customers";
$Table_Products = $prefijo_tabla."_facturacion_products";

$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$timbrados = 0;
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $timbrados = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$timbrados = number_format($timbrados);

$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
$sql .= "WHERE status_cfdi <> 'vigente'";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$cancelados = 0;
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $cancelados = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$cancelados = number_format($cancelados);


$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
$sql .= "WHERE status_cfdi = 'vigente'";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$vigentes = 0;
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $vigentes = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$cancelados = number_format($cancelados);


$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Customers." ";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$clientes = 0;
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $clientes = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$clientes = number_format($clientes);

$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Products." ";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$productos = 0;
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $productos = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$productos = number_format($productos);


$data_cache = array(
"timbrados"=>"$timbrados",
"cancelados"=>"$cancelados",
"vigentes"=>"$vigentes",
"clientes"=>"$clientes",
"productos"=>"$productos"
);

header('Content-type: application/json');
echo json_encode($data_cache);

?>