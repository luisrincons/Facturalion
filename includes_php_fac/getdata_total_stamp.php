<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$prefijo_tabla = $_SESSION['prefix_table_user'];
$Table_Invoice = $prefijo_tabla."_facturacion_invoice";
$Table_Customers = $prefijo_tabla."_facturacion_customers";
$Table_Products = $prefijo_tabla."_facturacion_products";

$fecha_compra = date("Y-m-d");
$fecha_actual = date("Y-m-d");

$comprados = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT serie_factura, MAX(fecha_compra_timbres) as fecha_compra, ";
$sql .= "timbres_comprados, folio_inicial, folio_final FROM facturacion_series ";
$sql .= "WHERE prefijo_tabla = '$prefijo_tabla'";
//echo $sql;

if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) {
   $comprados = $row['timbres_comprados'];
   $fecha_compra = substr($row['fecha_compra'], 0, 10) ;
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$comprados = number_format($comprados);

$timbrado_timbrados = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
$sql .= "WHERE date_invoice BETWEEN '$fecha_compra' AND '$fecha_actual'";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $timbrado_timbrados = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$timbrado_timbrados = number_format($timbrado_timbrados);

$timbrado_vigentes = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
$sql .= "WHERE date_invoice BETWEEN '$fecha_compra' AND '$fecha_actual' ";
$sql .= "AND status_cfdi = 'vigente'";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $timbrado_vigentes = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$timbrado_vigentes = number_format($timbrado_vigentes);

$timbrado_cancelados = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
$sql .= "WHERE date_invoice BETWEEN '$fecha_compra' AND '$fecha_actual' ";
$sql .= "AND status_cfdi <> 'vigente'";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $timbrado_cancelados = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$timbrado_cancelados = number_format($timbrado_cancelados);

$timbrados = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $timbrados = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$timbrados = number_format($timbrados);

$cancelados = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
$sql .= "WHERE status_cfdi <> 'vigente'";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $cancelados = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$cancelados = number_format($cancelados);

$vigentes = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Invoice." ";
$sql .= "WHERE status_cfdi = 'vigente'";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $vigentes = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$vigentes = number_format($vigentes);

$utilizados = $timbrado_vigentes + $timbrado_cancelados;

//$comprados -> 100%
//$restantes -> x
$restantes = $comprados - $utilizados;
$porcentaje_timbres_restantes = ($restantes*100)/$comprados;


$clientes = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Customers." ";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $clientes = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$clientes = number_format($clientes);

$productos = 0;
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql  = "SELECT COUNT(*) AS TOTAL FROM ".$Table_Products." ";
//echo $sql;
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
if($row = mysqli_fetch_array($result)) { 
   $productos = $row['TOTAL'];
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
$productos = number_format($productos);


$data_cache = array(
"timbrado_comprados"=>"$comprados",
"timbrado_restantes"=>"$restantes",
"timbrado_timbrados"=>"$timbrado_timbrados",
"timbrado_vigentes"=>"$timbrado_vigentes",
"timbrado_cancelados"=>"$timbrado_cancelados",
"porcentaje_timbres_restantes"=>"$porcentaje_timbres_restantes",
"timbrados"=>"$timbrados",
"cancelados"=>"$cancelados",
"vigentes"=>"$vigentes",
"clientes"=>"$clientes",
"productos"=>"$productos",
"fecha_compra"=>"$fecha_compra"
);

header('Content-type: application/json');
echo json_encode($data_cache);

?>