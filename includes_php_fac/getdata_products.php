<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$prefijo_tabla = $_SESSION['prefix_table_user'];
$tabla = $prefijo_tabla."_facturacion_products";
		
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql = "SELECT * FROM ".$tabla." ORDER by name_product ASC";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($link, $sql)) die();
$html_text = "";
$item = 0;

while($row = mysqli_fetch_array($result)) { 
	$item = $item + 1;
	$idgral = $row["idgral"];
	$producto = substr($row["name_product"],0,19);
	$costo = number_format($row["cost_product"], 2, '.', ',');
	$unidad = $row["unit"];
	if($item < 10){$citem = "0$item";} else {$citem = $item;}
    $html_text .= "<a href=\"#\">";
	$html_text .= "<div class=\"item_product\" id=\"$idgral\">";
    $html_text .= "<div class=\"animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12\">";
	$html_text .= "<div class=\"tile-stats\">";
    $html_text .= "<div class=\"icon\"><i class=\"fa fa-bus\"></i></div>";
    $html_text .= "<p style=\"font-size:17px\"><b class=\"grey\">$producto</b></p>";
	$html_text .= "<p style=\"font-size:16px\">Costo $ <strong class=\"green\">$costo</strong></p>";	
	$html_text .= "<p>$unidad</p>";
    $html_text .= "</div>";
    $html_text .= "</div>";
	$html_text .= "</div>";
	$html_text .= "</a>";
}
    
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

echo $html_text;
?>
