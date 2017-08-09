<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

$prefijo_tabla = $_SESSION['prefix_table_user'];
$tabla = $prefijo_tabla."_facturacion_invoice";
$tabla_d = $prefijo_tabla."_facturacion_invoice_details";
$idgral = $_SESSION['itemdata_selected_invoice'];

$link = mysqli_connect("localhost", $LoginDatabase, $PassDatabase, $NameDatabase) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
$sql  = "SELECT * FROM ".$tabla." ";
$sql .= "WHERE idgral = '$idgral' ";
//echo $sql;

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$html_text = "";
if(!$data = mysqli_query($link, $sql)) die();
$exist_row = "false";
if ($row = mysqli_fetch_array($data)) {
    $exist_row = "true";
	$html_details_invoice = getdata_details_invoice($idgral, $tabla_d, $LoginDatabase, $PassDatabase, $NameDatabase);
	//------------------------------------------------
	$date_invoice = $row["date_invoice"];
	$date_cancellation = $row["date_cancellation"];
	$uuid_stamp = $row["UUID_stamp"];
	$rfc_emisor = $row["rfc_transmitter"];
	$rfc_receptor = $row["rfc_receiver"];
	$file_cfdi = $row["file_cfdi"];
	$subtotal_invoice = $row["subtotal_invoice"];
	$monto_subtotal = number_format($subtotal_invoice, 2, ".", ",");
	$tax_IVA_invoice = $row["tax_IVA_invoice"];
	$monto_IVA = number_format($tax_IVA_invoice, 2, ".", ",");
	$porcen_impuesto = number_format($row["rate_traslation"]);
	$total_invoice = $row["total_invoice"];
	$monto_total = number_format($total_invoice, 2, ".", ",");
	$path_cfdi = "http://cdcom.dynalias.com/facturalion/clientes/C".$prefijo_tabla."_Expediente/facturas/cfdi/$file_cfdi";
	$file_pdf = $row["file_pdf"];
	$path_pdf = "http://cdcom.dynalias.com/facturalion/clientes/C".$prefijo_tabla."_Expediente/facturas/pdf/$file_pdf";
	list($year, $month, $day) = explode('-', $date_invoice);
	$nameMonth = getNameMonth($month);
	$day = substr($day, 0, 2);
	$status_cfdi = strtoupper($row["status_cfdi"]);
	$html_text .= "<li>";
    $html_text .= "<img src=\"images/cfdi.jpg\" class=\"avatar\" alt=\"Avatar\">";
    $html_text .= "<div class=\"message_date\">";
	$html_text .= "<h3 class=\"date text-info\">$day</h3>";
	$html_text .= "<p class=\"month\">$nameMonth</p>";
    $html_text .= "</div>";
    $html_text .= "<div class=\"message_wrapper\">";
	$html_text .= "<h4 class=\"heading\">$status_cfdi</h4>";
	if($status_cfdi == "CANCELADO"){
	  $html_text .= "<strong style=\"font-size:16px\">FECHA DE CANCELACIÓN $date_cancellation</strong>";
	}
	$html_text .= "<h5 class=\"heading\">FOLIO FISCAL FECHA $date_invoice</h5>";
	$html_text .= "<strong style=\"font-size:16px\">$uuid_stamp</strong>";
	$html_text .= "<h5 class=\"heading\">RFC EMISOR $rfc_emisor</h5>";
	$html_text .= "<h5 class=\"heading\">RFC RECEPTOR $rfc_receptor</h5>";
	$html_text .= "<blockquote class=\"message\">";
	
	$html_text .= $html_details_invoice;

	$html_text .= "<strong class=\"dark\">SUBTOTAL</strong> $ $monto_subtotal </br>";
	$html_text .= "<strong class=\"dark\">IVA $porcen_impuesto%</strong> $ $monto_IVA </br>";
	$html_text .= "<strong class=\"dark\">TOTAL</strong> $ $monto_total </br>";
	$html_text .= "</blockquote>";
	$html_text .= "<br />";
	$html_text .= "<p class=\"url\">";
	$html_text .= "  <span class=\"fs1 text-info\" aria-hidden=\"true\" data-icon=\"\"></span>";
	$html_text .= "  <a href=\"$path_cfdi\"><img src=\"images/xml-ico.jpg\"> DESCARGAR XML </a>";
	$html_text .= "</p>";
	$html_text .= "<p class=\"url\">";
	$html_text .= "  <span class=\"fs1 text-info\" aria-hidden=\"true\" data-icon=\"\"></span>";
	$html_text .= "  <a href=\"$path_pdf\"><img src=\"images/pdf-ico.jpg\"> DESCARGAR PDF </a>";
	$html_text .= "</p>";
    $html_text .= "</div>";
    $html_text .= "</li>";
	//------------------------------------------------
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

function getdata_details_invoice($id, $table_d, $login, $pass, $database){
	$link_g = mysqli_connect("localhost", $login, $pass, $database) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");

	$sql_g  = "SELECT * FROM ".$table_d." ";
    $sql_g .= "WHERE idgral_invoice = '$id' ";

	if(!$result = mysqli_query($link_g, $sql_g)) die();
	$html_text = "";
	while($row = mysqli_fetch_array($result)) { 
		$cantidad = number_format($row["amount_article"]);
		$unidad_articulo = $row["unit_article"];
		$nombre_articulo = $row["name_article"];
		$descripcion_articulo = $row["description_article"];
		$precio_unitario = number_format($row["price_article"], 2, ".", ",");
		$subtotal_producto = number_format($row["subtotal_article"], 2, ".", ",");
		$html_text  = "<strong class=\"dark\">CANTIDAD</strong> $cantidad </br>";
		$html_text .= "<strong class=\"dark\">P.U.</strong> $ $precio_unitario </br>";	
		$html_text .= "<strong class=\dark\">ARTICULO</strong> $nombre_articulo </br>";
		$html_text .= "<strong class=\"dark\">UNIDAD</strong> $unidad_articulo </br>";
		$html_text .= "<strong class=\"dark\">DESCRIPCIÓN</strong> </br>";
		$html_text .= "$descripcion_articulo </br>";
		$html_text .= "<strong class=\"dark\">SUBTOTAL</strong> $ $subtotal_producto </br>";
        $html_text .= "</br>";		
	}
	$close = mysqli_close($link_g) 
    or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	return $html_text;
}

function getNameMonth($item){
	switch($item){
		case "01":
			$mes = "Ene";
			break;
		case "02":
			$mes = "Feb";
			break;
		case "03":
			$mes = "Mar";
			break;
		case "04":
			$mes = "Abr";
			break;
		case "05":
			$mes = "May";
			break;
		case "06":
			$mes = "Jun";
			break;
		case "07":
			$mes = "Jul";
			break;
		case "08":
			$mes = "Ago";
			break;
		case "09":
			$mes = "Sep";
			break;
		case "10":
			$mes = "Oct";
			break;
		case "11":
			$mes = "Nov";
			break;
		case "12":
			$mes = "Dic";
			break;			
	}
	return $mes;
}

/*
<li>
  <img src="images/cfdi.jpg" class="avatar" alt="Avatar">
  <div class="message_date">
	<h3 class="date text-info">24</h3>
	<p class="month">Mar</p>
  </div>
  <div class="message_wrapper">
	<h4 class="heading">VIGENTE</h4>
	<blockquote class="message">
	<strong class="dark">CANTIDAD</strong> 1 </br>
	<strong class="dark">ARTICULO</strong> VARIOS </br>
	<strong class="dark">UNIDAD</strong> PIEZA </br>
	<strong class="dark">DESCRIPCIÓN</strong> </br>
	REGULADOR PARA KYOCERA </br>
	<strong class="dark">P.U.</strong> $ 1,000.00 </br>
	<strong class="dark">SUBTOTAL</strong> $ 1,000.00 </br>
	<strong class="dark">IVA 16%</strong> $ 180.00 </br>
	<strong class="dark">TOTAL</strong> $ 1,180.00 </br>
	</blockquote>
	<br />
	<p class="url">
	  <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
	  <a href="#"><img src="images/xml-ico.jpg"> DESCARGAR XML </a>
	</p>
	<p class="url">
	  <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
	  <a href="#"><img src="images/pdf-ico.jpg"> DESCARGAR PDF </a>
	</p>
  </div>
</li>
 */
/*
$html_text = "";
$item = 0;
if(!$result = mysqli_query($link, $sql)) die();
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
	
    $html_text .= "";

	
}
$close = mysqli_close($link) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
*/

echo $html_text;

?>

