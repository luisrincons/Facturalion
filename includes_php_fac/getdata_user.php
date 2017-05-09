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
'RegistroPatronal'=>$RegistroPatronal
);
header('Content-type: application/json');
echo json_encode($data_cache);

?>