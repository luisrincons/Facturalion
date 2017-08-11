<?php
date_default_timezone_set('America/Mexico_City');
require("_configuration.php");

// Inicialización de variables SESSION -------------------------------------
$_SESSION['session_autorized'] = "";
$_SESSION['idgral_user'] = "";
$_SESSION['login_user'] = "";
$_SESSION['passw_user'] = "";
$_SESSION['name_user'] = "";
$_SESSION['path_icon_user'] = "";
$_SESSION['idgral'] = "";
$_SESSION['category_user'] = "";
$_SESSION['prefix_table_user'] = "";
$_SESSION['nombre_SAT'] = "";
$_SESSION['tipo_regimen'] = "";
$_SESSION['tipo_persona'] = "";
$_SESSION['calle_DomicilioFiscal'] = "";
$_SESSION['noExterior_DomicilioFiscal'] = "";
$_SESSION['noInterior_DomicilioFiscal'] = "";
$_SESSION['localidad_DomicilioFiscal'] = "";
$_SESSION['colonia_DomicilioFiscal'] = "";
$_SESSION['municipio_DomicilioFiscal'] = "";
$_SESSION['estado_DomicilioFiscal'] = "";
$_SESSION['ciudad_DomicilioFiscal'] = "";
$_SESSION['pais_DomicilioFiscal'] = "";
$_SESSION['codigoPostal_DomicilioFiscal'] = "";
$_SESSION['telefono1_DomicilioFiscal'] = "";
$_SESSION['telefono2_DomicilioFiscal'] = "";
$_SESSION['email_DomicilioFiscal'] = "";
$_SESSION['num_Certificado'] = "";
$_SESSION['RFC_SAT'] = "";
$_SESSION['RegistroPatronal'] = "";
$_SESSION['domicilio_SAT'] = "";

$_SESSION['itemdata_selected_year'] = "";
$_SESSION['itemdata_selected_month'] = "";
$_SESSION['itemdata_selected_customer'] = "";
$_SESSION['itemdata_selected_name_customer'] = "";
$_SESSION['itemdata_selected_invoice'] = "";
$_SESSION['itemdata_selected_number_invoice'] = "";

//Validación ----------------------------------------------------------------

$type_access = $_POST['type_access'];

$login_id = $_POST['login'];
$passw_id = $_POST['passw'];
$pattern_data = $_POST['pattern_data'];
$pattern_draw = $_POST['pattern_draw'];

$_SESSION['session_type_access'] = $type_access;
$_SESSION['session_autorized'] = "No";

$goPage = "";
$get_error = "empty";
switch ($type_access) {
	case "login":
	     $sql = "SELECT * FROM $Tabla_Cuentas_Acceso WHERE login = '$login_id' AND password = '$passw_id'";
	     break;
	case "pattern":
	     $sql = "SELECT * FROM $Tabla_Cuentas_Acceso WHERE idgral = '$pattern_data' AND login_pattern = '$pattern_draw'";
		 break;
    default:
	     $goPage = "index.html";
}

if ($goPage == ""){
	
	$link = mysql_connect("localhost", $LoginDatabase, $PassDatabase);
	mysql_select_db($NameDatabase, $link);
	$opentmp = mysql_query($sql, $link);
    $get_error = mysql_error();
	if($get_error == ""){$get_error = "empty";}
	if($get_error == "empty"){

			if ( $field = mysql_fetch_array($opentmp)){ 
				// Acceso permitido;
				$_SESSION['idgral_user'] = $field["idgral"];
				$_SESSION['login_user']  = $field["login"];
				$_SESSION['passw_user']  = $field["password"];
				$_SESSION['name_user']   = trim($field["nombre"]." ".$field["paterno"]." ".$field["materno"]);
				$_SESSION['category_user'] = $field["categoria"];
				$_SESSION['prefix_table_user'] = $field["prefijo_tabla"];
				$_SESSION['path_icon_user'] = "http://cdcom.dynalias.com/facturalion/html2pdf/examples/res/C".$_SESSION['prefix_table_user']."_Expediente/logo_cliente.png";

				$_SESSION['tipo_persona'] = $field["tipo_persona"];
				if($_SESSION['tipo_persona'] == 'Moral'){
				   $_SESSION['nombre_SAT'] = $field["nombre_empresa_moral"];
				   $_SESSION['CURP_Emisor'] = "";
				} else {
				   $_SESSION['nombre_SAT'] = $field["nombre_persona_fisica"]." ".$field["paterno_persona_fisica"]." ".$field["materno_persona_fisica"];
				   $_SESSION['CURP_Emisor'] = $field["curp_persona_fisica"];
				}
				
				$_SESSION['tipo_regimen']                 = $field["tipo_regimen"];
				$_SESSION['calle_DomicilioFiscal']        = $field["calle_fiscal"];
				$_SESSION['noExterior_DomicilioFiscal']   = $field["num_exterior_fiscal"];
				$_SESSION['noInterior_DomicilioFiscal']   = $field["num_interior_fiscal"];
				$_SESSION['localidad_DomicilioFiscal']    = $field["localidad_fiscal"];
				$_SESSION['colonia_DomicilioFiscal']      = $field["colonia_fiscal"];
				$_SESSION['municipio_DomicilioFiscal']    = $field["delegacion_fiscal"];
				$_SESSION['estado_DomicilioFiscal']       = $field["entidad_federativa_fiscal"];
				$_SESSION['ciudad_DomicilioFiscal']       = $field["ciudad_fiscal"];
				$_SESSION['pais_DomicilioFiscal']         = $field["pais_fiscal"];
				$_SESSION['codigoPostal_DomicilioFiscal'] = $field["codigo_postal_fiscal"];
				$_SESSION['telefono1_DomicilioFiscal']    = $field["telefono1_fiscal"];
				$_SESSION['telefono2_DomicilioFiscal']    = $field["telefono2_fiscal"];
				$_SESSION['email_DomicilioFiscal']        = $field["email_fiscal"];
				
				$calle_ExpedidoEn		  = $_SESSION['calle_DomicilioFiscal'];
				$noExterior_ExpedidoEn	  = $_SESSION['noExterior_DomicilioFiscal'];
				$noInterior_ExpedidoEn	  = $_SESSION['noInterior_DomicilioFiscal'];
				$colonia_ExpedidoEn	      = $_SESSION['colonia_DomicilioFiscal'];
				$municipio_ExpedidoEn	  = $_SESSION['municipio_DomicilioFiscal'];
				$estado_ExpedidoEn		  = $_SESSION['estado_DomicilioFiscal'];
				$pais_ExpedidoEn		  = $_SESSION['pais_DomicilioFiscal'];
				$codigoPostal_ExpedidoEn  = $_SESSION['codigoPostal_DomicilioFiscal'];
				
				if(trim($calle_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante = "CALLE ".trim($calle_ExpedidoEn);
				}
				if(trim($noExterior_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante .= " ".$noExterior_ExpedidoEn;
				}
				if(trim($noInterior_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante .= " ".$noInterior_ExpedidoEn;
				}
				if(trim($colonia_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante .= ", COL. ".$colonia_ExpedidoEn;
				}
				if(trim($codigo_postal_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante .= ", C.P.".$codigo_postal_ExpedidoEn;
				}
				if(trim($municipio_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante .= ", DELEG. ".$municipio_ExpedidoEn;
				}
				if(trim($pais_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante .= ", ".$pais_ExpedidoEn;
				}
				if(trim($estado_ExpedidoEn)!=""){
				   $LugarExpedicion_comprobante .= ", ".$estado_ExpedidoEn;
				}

				$LugarExpedicion_comprobante = trim($LugarExpedicion_comprobante);
				if($noInterior_Receptor == ""){ $noInterior_Receptor = "-"; }		
				
				$_SESSION['num_Certificado'] = $field["num_certificado"];
				$_SESSION['RFC_SAT'] = $field["RFC_SAT"];
				$_SESSION['RegistroPatronal'] = $field["RegistroPatronal"];
				$_SESSION['domicilio_SAT'] = $LugarExpedicion_comprobante;
				
				$_SESSION['session_autorized'] = "Yes";
				
				if($_SESSION['prefix_table_user'] == ''){
				   //No existe del prefijo de la tabla del cliente.
				   $_SESSION['session_autorized'] = "No";
				}
				 
				if($_SESSION['session_autorized'] == "Yes"){
				  $goPage = "granted_access.html";
				} else {
				  $goPage = "index.html";
				}

			} else {
				$goPage = "invalid_login.html";
			}	  
	}
	mysql_close($link);
}

$data_cache = array(
'goPage'=>$goPage,
'error'=>$get_error
);
header('Content-type: application/json');
echo json_encode($data_cache);
?>
