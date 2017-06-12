<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$prefijo_tabla = $_SESSION['prefix_table_user'];
$Table_Invoice = $prefijo_tabla."_facturacion_invoice";

$html_text = "";
$ano_inicial = date("Y");
for($item=1; $item<=11; $item++){
	$idgral = "$ano_inicial";	
	$total_facturas_emitidas = TotalInvoices($ano_inicial, $Table_Invoice, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_facturas = number_format($total_facturas_emitidas);

	$total_facturas_vigentes = TotalInvoices_Valid($ano_inicial, $Table_Invoice, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_vigentes = number_format($total_facturas_vigentes);

	$total_facturas_canceladas = TotalInvoices_Cancel($ano_inicial, $Table_Invoice, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_canceladas = number_format($total_facturas_canceladas);
	
    $html_text .= "<a href=\"#\">";
	$html_text .= "<div class=\"item_year\" id=\"$idgral\">";
    $html_text .= "<div class=\"animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12\">";
	$html_text .= "<div class=\"tile-stats\">";
    $html_text .= "<div class=\"icon\"><i class=\"fa fa-calendar-o\"></i></div>";	
    $html_text .= "<div class=\"count\">$ano_inicial</div>";
	if($total_vigentes > 0){
	  if($total_vigentes > 1){
		 $text_vigente = "VIGENTES";
	  } else {
		 $text_vigente = "VIGENTE";
	  }	
	  $html_text .= "<p style=\"font-size:16px\"><strong class=\"green\">$total_vigentes $text_vigente</strong></p>";
	}
	if($total_canceladas > 0){
	  if($total_canceladas > 1){
		 $text_cancelado = "CANCELADOS";
	  } else {
		 $text_cancelado = "CANCELADO";
	  }	
	  $html_text .= "<p style=\"font-size:16px\"><strong class=\"grey\">$total_canceladas $text_cancelado</strong></p>";	
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
	
	$ano_inicial = $ano_inicial - 1;
	
}

echo $html_text;


function TotalInvoices($year, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $date_start  = $year."-01-01";
    $date_finish = $year."-12-31";	
    $sql  = "SELECT COUNT(*) AS TOTAL FROM ".$tabla." ";
	$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
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

function TotalInvoices_Valid($year, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $date_start  = $year."-01-01";
    $date_finish = $year."-12-31";	
    $sql  = "SELECT COUNT(*) AS TOTAL FROM ".$tabla." ";
	$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
	$sql .= "AND status_cfdi = 'vigente'";
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

function TotalInvoices_Cancel($year, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $date_start  = $year."-01-01";
    $date_finish = $year."-12-31";	
    $sql  = "SELECT COUNT(*) AS TOTAL FROM ".$tabla." ";
	$sql .= "WHERE date_invoice BETWEEN '$date_start' AND '$date_finish' ";
	$sql .= "AND status_cfdi <> 'vigente'";
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

?>

