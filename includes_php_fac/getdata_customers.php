<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$prefijo_tabla = $_SESSION['prefix_table_user'];
$tabla = $prefijo_tabla."_facturacion_customers";
		
$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//generamos la consulta
$sql = "SELECT * FROM ".$tabla." ORDER by nombre_persona_fisica ASC, nombre_empresa_moral ASC";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($link, $sql)) die();
$html_text = "";
$item = 0;

while($row = mysqli_fetch_array($result)) { 
	$item = $item + 1;
	$idgral = $row["idgral"];
	$tipo_persona = $row["tipo_persona"];
	if($tipo_persona == 'Moral'){
	   $nombre_cliente = $row["nombre_empresa_moral"];
	   $icono_cliente = "fa fa-home";
	} else {
	   $nombre_cliente = $row["nombre_persona_fisica"];
	   $icono_cliente = "fa fa-user";
	}
	$rfc_sat = $row["RFC_SAT"];
	
    $html_text .= "<a href=\"#\">";
	$html_text .= "<div class=\"item_customer\" id=\"$idgral\">";
    $html_text .= "<div class=\"animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12\">";
	$html_text .= "<div class=\"tile-stats\">";
    $html_text .= "<div class=\"icon\"><i class=\"$icono_cliente\"></i></div>";	
    $html_text .= "<p style=\"font-size:17px\"><b class=\"grey\">$nombre_cliente</b></p>";
	$html_text .= "<p style=\"font-size:16px\"><strong class=\"blue\">RFC $rfc_sat</strong></p>";
	$html_text .= "<p>Persona $tipo_persona</p>";
    $html_text .= "</div>";
    $html_text .= "</div>";
	$html_text .= "</div>";
	$html_text .= "</a>";
	
}
    
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

echo $html_text;
?>
