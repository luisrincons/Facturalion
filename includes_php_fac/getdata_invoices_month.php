<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$prefijo_tabla = $_SESSION['prefix_table_user'];
$Table_Invoice = $prefijo_tabla."_facturacion_invoice";

$year_selected = $_SESSION['itemdata_selected_year'];
$year_now	   = date("Y");

$html_text = "";
if($year_selected == $year_now){
  $mes_inicial = intval(date("m"));	
} else {
  $mes_inicial = 12;	
}

for($item=$mes_inicial; $item > 0; $item--){
	if($item < 10){
	   $idgral = "0$item";
	} else {
	   $idgral = "$item";	
	}
	switch($item){
		case 1:
			$mes = "Enero";
			break;
		case 2:
			$mes = "Febrero";
			break;
		case 3:
			$mes = "Marzo";
			break;
		case 4:
			$mes = "Abril";
			break;
		case 5:
			$mes = "Mayo";
			break;
		case 6:
			$mes = "Junio";
			break;
		case 7:
			$mes = "Julio";
			break;
		case 8:
			$mes = "Agosto";
			break;
		case 9:
			$mes = "Septiembre";
			break;
		case 10:
			$mes = "Octubre";
			break;
		case 11:
			$mes = "Noviembre";
			break;
		case 12:
			$mes = "Diciembre";
			break;			
	}
	
	$dia_final = calcular_dias_del_mes($idgral, $year_selected);
	$total_facturas_emitidas = TotalInvoices($year_selected, $idgral, $dia_final, $Table_Invoice, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_facturas = number_format($total_facturas_emitidas);	

	$total_facturas_vigentes = TotalInvoices_Valid($year_selected, $idgral, $dia_final, $Table_Invoice, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_vigentes = number_format($total_facturas_vigentes);

	$total_facturas_canceladas = TotalInvoices_Cancel($year_selected, $idgral, $dia_final, $Table_Invoice, $LoginDatabase, $PassDatabase, $NameDatabase);
	$total_canceladas = number_format($total_facturas_canceladas);
	
    $html_text .= "<a href=\"#\">";
	$html_text .= "<div class=\"item_month\" id=\"$idgral\">";
    $html_text .= "<div class=\"animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12\">";
	$html_text .= "<div class=\"tile-stats\">";
    $html_text .= "<div class=\"icon\"><i class=\"fa fa-calendar\"></i></div>";	
    $html_text .= "<div class=\"count\">$mes</div>";
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
	  $html_text .= "<p style=\"font-size:16px\"><strong class=\"orange\">$total_canceladas $text_cancelado</strong></p>";
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
    

echo $html_text;

function TotalInvoices($year, $month, $day_finish, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $date_start  = $year."-".$month."-01";
    $date_finish = $year."-".$month."-".$day_finish;	
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

function TotalInvoices_Valid($year, $month, $day_finish, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $date_start  = $year."-".$month."-01";
    $date_finish = $year."-".$month."-".$day_finish;	
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

function TotalInvoices_Cancel($year, $month, $day_finish, $tabla, $login, $passw, $database){
    $link = mysqli_connect("localhost", $login, $passw, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    //generamos la consulta
    $date_start  = $year."-".$month."-01";
    $date_finish = $year."-".$month."-".$day_finish;	
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

