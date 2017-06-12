<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$year        = $_SESSION['itemdata_selected_year'];
$month       = $_SESSION['itemdata_selected_month'];
$day_finish  = calcular_dias_del_mes($month, $year);
$date_start  = $year."-".$month."-01";
$date_finish = $year."-".$month."-".$day_finish;
 
$prefijo_tabla = $_SESSION['prefix_table_user'];
$tabla = $prefijo_tabla."_facturacion_invoice";

$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");
//SELECT * FROM 005_facturacion_invoice WHERE date_invoice BETWEEN '2014-01-01' AND '2014-01-31' GROUP BY name_receiver ORDER BY name_receiver ASC
//generamos la consulta
$sql  = "SELECT * FROM ".$tabla." ";
$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
$sql .= "GROUP BY name_receiver ORDER BY name_receiver ASC";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($link, $sql)) die();
$html_text = "";
$item = 0;
while($row = mysqli_fetch_array($result)) { 
	$item = $item + 1;
	$idgral = $row["idgral_customer"];
	$nombre_cliente = $row["name_receiver"];
	$rfc_sat = $row["rfc_receiver"];
	$icono_cliente = "fa fa-list-alt";
	
	$total_facturas_emitidas = TotalInvoices($date_start, $date_finish, $idgral, $tabla, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_facturas = number_format($total_facturas_emitidas);
	
	$total_facturas_vigentes = TotalInvoices_Valid($date_start, $date_finish, $idgral, $tabla, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_vigentes = number_format($total_facturas_vigentes);
	
	$total_facturas_cancelados = TotalInvoices_Cancel($date_start, $date_finish, $idgral, $tabla, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_cancelados = number_format($total_facturas_cancelados);	
	
    $html_text .= "<a href=\"#\">";
	$html_text .= "<div class=\"item_customer\" id=\"$idgral\">";
    $html_text .= "<div class=\"animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12\">";
	$html_text .= "<div class=\"tile-stats\">";
    $html_text .= "<div class=\"icon\"><i class=\"$icono_cliente\"></i></div>";	
    $html_text .= "<p style=\"font-size:17px\"><b class=\"grey\">$nombre_cliente</b></p>";
	$html_text .= "<p style=\"font-size:16px\"><strong class=\"blue\">RFC $rfc_sat</strong></p>";
	if($total_vigentes > 0){
	  if($total_vigentes > 1){
		 $text_vigente = "VIGENTES";
	  } else {
		 $text_vigente = "VIGENTE";
	  }	
	  $html_text .= "<p style=\"font-size:16px\"><strong class=\"green\">$total_vigentes $text_vigente</strong></p>";
	}
	if($total_cancelados > 0){
	  if($total_cancelados > 1){
		 $text_cancelado = "CANCELADOS";
	  } else {
		 $text_cancelado = "CANCELADO";
	  }	
	  $html_text .= "<p style=\"font-size:16px\"><strong class=\"grey\">$total_cancelados $text_cancelado</strong></p>";	
	}
	if($total_facturas > 1){
	  $text_timbrado = "TIMBRADOS";
	} else {
	  $text_timbrado = "TIMBRADO";
	}
	$html_text .= "<p style=\"font-size:16px\"><strong class=\"blue\">$total_facturas $text_timbrado</strong></p>";
	
    $html_text .= "</div>";
    $html_text .= "</div>";
	$html_text .= "</div>";
	$html_text .= "</a>";
	
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

echo $html_text;

function TotalInvoices($date_start, $date_finish, $idgral, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $sql  = "SELECT COUNT(*) AS TOTAL FROM ".$tabla." ";
	$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
	$sql .= "AND idgral_customer = '$idgral'";
    //echo $sql;
    //mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
	$total = 0;
	if(!$result = mysqli_query($link, $sql)) die();
	if($row = mysqli_fetch_array($result)) { 
       $total = $row['TOTAL'];
	}
    $close = mysqli_close($link) 
    or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	return $total;
}

function TotalInvoices_Valid($date_start, $date_finish, $idgral, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $sql  = "SELECT COUNT(*) AS TOTAL FROM ".$tabla." ";
	$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
	$sql .= "AND idgral_customer = '$idgral' AND status_cfdi = 'vigente'";
    //echo $sql;
    //mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
	$total = 0;
	if(!$result = mysqli_query($link, $sql)) die();
	if($row = mysqli_fetch_array($result)) { 
       $total = $row['TOTAL'];
	}
    $close = mysqli_close($link) 
    or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	return $total;
}

function TotalInvoices_Cancel($date_start, $date_finish, $idgral, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $sql  = "SELECT COUNT(*) AS TOTAL FROM ".$tabla." ";
	$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
	$sql .= "AND idgral_customer = '$idgral' AND status_cfdi <> 'vigente'";
    //echo $sql;
    //mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
	$total = 0;
	if(!$result = mysqli_query($link, $sql)) die();
	if($row = mysqli_fetch_array($result)) { 
       $total = $row['TOTAL'];
	}
    $close = mysqli_close($link) 
    or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	return $total;
}

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

