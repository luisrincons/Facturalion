<?php
session_name('area_customer');
session_start();

$authorized 		 = $_SESSION['session_autorized'];
$idgral_user		 = $_SESSION['idgral_user'];
$login_user 		 = $_SESSION['login_user'];
$passw_user			 = $_SESSION['passw_user'];
$category_user  	 = $_SESSION['category_user'];
$name_user 			 = $_SESSION['name_user'];
$icon_user 			 = $_SESSION['path_icon_user'];
$prefix_user 		 = $_SESSION['prefix_table_user'];
$nombre_SAT			 = $_SESSION['nombre_SAT'];
$tipo_persona		 = $_SESSION['tipo_persona'];
$tipo_regimen		 = $_SESSION['tipo_regimen'];
$calle_fiscal 		 = $_SESSION['calle_DomicilioFiscal'];
$noExterior_fiscal 	 = $_SESSION['noExterior_DomicilioFiscal'];
$noInterior_fiscal 	 = $_SESSION['noInterior_DomicilioFiscal'];
$localidad_fiscal  	 = $_SESSION['localidad_DomicilioFiscal'];
$colonia_fiscal	   	 = $_SESSION['colonia_DomicilioFiscal'];
$municipio_fiscal  	 = $_SESSION['municipio_DomicilioFiscal'];
$estado_fiscal	   	 = $_SESSION['estado_DomicilioFiscal'];
$ciudad_fiscal		 = $_SESSION['ciudad_DomicilioFiscal'];
$pais_fiscal		 = $_SESSION['pais_DomicilioFiscal'];
$codigoPostal_fiscal = $_SESSION['codigoPostal_DomicilioFiscal'];
$telefono1_fiscal	 = $_SESSION['telefono1_DomicilioFiscal'];
$telefono2_fiscal	 = $_SESSION['telefono2_DomicilioFiscal'];
$email_fiscal		 = $_SESSION['email_DomicilioFiscal'];
$num_Certificado	 = $_SESSION['num_Certificado'];
$RFC_SAT			 = $_SESSION['RFC_SAT'];
$CURP_Emisor		 = $_SESSION['CURP_Emisor'];
$RegistroPatronal 	 = $_SESSION['RegistroPatronal'];
$ruta_logo			 = $_SESSION['path_icon_user'];

$item_year_selected_value  = $_SESSION['itemdata_selected_year'];
$item_month_selected_value  = $_SESSION['itemdata_selected_month'];
$item_customer_selected_value  = $_SESSION['itemdata_selected_customer'];
$item_name_customer_selected_value  = $_SESSION['itemdata_selected_name_customer'];
$item_invoice_selected_value  = $_SESSION['itemdata_selected_invoice'];
$item_number_invoice_selected_value = $_SESSION['itemdata_selected_number_invoice'];

switch($item_month_selected_value){
	case 1:
		$item_month_name_value = "Enero";
		break;
	case 2:
		$item_month_name_value = "Febrero";
		break;
	case 3:
		$item_month_name_value = "Marzo";
		break;
	case 4:
		$item_month_name_value = "Abril";
		break;
	case 5:
		$item_month_name_value = "Mayo";
		break;
	case 6:
		$item_month_name_value = "Junio";
		break;
	case 7:
		$item_month_name_value = "Julio";
		break;
	case 8:
		$item_month_name_value = "Agosto";
		break;
	case 9:
		$item_month_name_value = "Septiembre";
		break;
	case 10:
		$item_month_name_value = "Octubre";
		break;
	case 11:
		$item_month_name_value = "Noviembre";
		break;
	case 12:
		$item_month_name_value = "Diciembre";
		break;			
}

$data_cache = array(
'authorized'=>$authorized,
'idgral_user'=>$idgral_user, 
'login_user'=>$login_user, 
'passw_user'=>$$passw_user, 
'name_user'=>$name_user, 
'icon_user'=>$icon_user, 
'prefix_user'=>$prefix_user, 
'nombre_SAT'=>$nombre_SAT, 
'tipo_regimen'=>$tipo_regimen,
'tipo_persona'=>$tipo_persona,
'calle_fiscal'=>$calle_fiscal, 
'noExterior_fiscal'=>$noExterior_fiscal, 
'noInterior_fiscal'=>$noInterior_fiscal, 
'localidad_fiscal'=>$localidad_fiscal, 
'colonia_fiscal'=>$colonia_fiscal, 
'municipio_fiscal'=>$municipio_fiscal, 
'estado_fiscal'=>$estado_fiscal, 
'ciudad_fiscal'=>$ciudad_fiscal, 
'pais_fiscal'=>$pais_fiscal, 
'codigoPostal_fiscal'=>$codigoPostal_fiscal, 
'telefono1_fiscal'=>$telefono1_fiscal, 
'telefono2_fiscal'=>$telefono2_fiscal, 
'email_fiscal'=>$email_fiscal, 
'num_Certificado'=>$num_Certificado, 
'RFC_SAT'=>$RFC_SAT, 
'CURP_emisor'=>$CURP_Emisor,
'RegistroPatronal'=>$RegistroPatronal,
'correo_fiscal'=>$email_fiscal,
'ruta_logo'=>$ruta_logo,
'item_year_selected_value'=>$item_year_selected_value,
'item_month_selected_value'=>$item_month_selected_value,
'item_month_name_value'=>$item_month_name_value,
'item_customer_selected_value'=>$item_customer_selected_value,
'item_name_customer_selected_value'=>$item_name_customer_selected_value,
'item_invoice_selected_value'=>$item_invoice_selected_value,
'item_number_invoice_selected_value'=>$item_number_invoice_selected_value
);
header('Content-type: application/json');
echo json_encode($data_cache);

?>