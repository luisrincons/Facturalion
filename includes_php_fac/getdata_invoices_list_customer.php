<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$year        = $_SESSION['itemdata_selected_year'];
$month       = $_SESSION['itemdata_selected_month'];
$customer    = $_SESSION['itemdata_selected_customer'];
$day_finish  = calcular_dias_del_mes($month, $year);
$date_start  = $year."-".$month."-01";
$date_finish = $year."-".$month."-".$day_finish;
 
$prefijo_tabla = $_SESSION['prefix_table_user'];
$tabla = $prefijo_tabla."_facturacion_invoice";

$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
$sql  = "SELECT * FROM ".$tabla." ";
$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
$sql .= "AND idgral_customer = '$customer' ";
$sql .= "ORDER BY number_invoice DESC";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
$html_text = "";
$item = 0;
while($row = mysqli_fetch_array($result)) { 
	$item = $item + 1;
	$idgral = $row["idgral"];
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
	$fecha_cancelacion = $row["date_cancellation"];
	if($fecha_cancelacion == ""){$fecha_cancelacion = "&nbsp;";}
	$monto = number_format($row["total_invoice"], 2, ".", ",");
	$icono_factura = "fa fa-certificate";
	
    $html_text .= "<a href=\"#\">";
	$html_text .= "<div class=\"item_invoice\" id=\"$idgral\">";
    $html_text .= "<div class=\"animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12\">";
	$html_text .= "<div class=\"tile-stats\">";
    $html_text .= "<div class=\"icon\"><strong class=\"$color_icono\"><i class=\"$icono_factura\"></i></strong></div>";	
    $html_text .= "<p style=\"font-size:22px\"><b class=\"$color_cfdi\">$numero_cfdi</b></p>";
	$html_text .= "<p style=\"font-size:14px\"><strong class=\"$color_fecha\">$fecha_factura</strong></p>";
	$html_text .= "<p style=\"font-size:14px\"><strong class=\"$color_monto\">$ $monto</strong></p>";
	$html_text .= "<p style=\"font-size:14px\"><strong class=\"$color_status\">".strtoupper($status_cfdi)."</strong></p>";
	$html_text .= "<p style=\"font-size:12px\"><strong class=\"$color_status\">$fecha_cancelacion</strong></p>";
    $html_text .= "</div>";
    $html_text .= "</div>";
	$html_text .= "</div>";
	$html_text .= "</a>";
	
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

echo $html_text;

function calcular_dias_del_mes($nMes, $nAno){  
  $nDiasMes = "30";  
  switch ($nMes) {
  case '01':
       //Enero
       $nDiasMes = "31";
	   break;
  case '02':
       //Febrero
	   if ($nAno=='2016' || $nAno=='2020' || $nAno=='2024' || $nAno=='2028' || $nAno=='2030')
	   {
		   $nDiasMes = "29";   
	   } else {
		   $nDiasMes = "28";
	   }
	   break;
  case '03':
       //Marzo
       $nDiasMes = "31";
	   break;
  case '04':
       //Abril
       $nDiasMes = "30";
	   break;
  case '05':
       //Mayo
       $nDiasMes = "31";
	   break;	   
  case '06':
       //Junio
       $nDiasMes = "30";
	   break;	   
  case '07':
       //Julio
       $nDiasMes = "31";
	   break;	   
  case '08':
       //Agosto
       $nDiasMes = "31";
	   break;	   
  case '09':
       //Septiembre
       $nDiasMes = "30";
	   break;	   
  case '10':
       //Octubre
       $nDiasMes = "31";
	   break;	   
  case '11':
       //Noviembre
       $nDiasMes = "30";
	   break;	   
  case '12':
       //Diciembre
       $nDiasMes = "31";
	   break;	   
  }
  return $nDiasMes;
} 
?>

