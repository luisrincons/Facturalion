<?php
session_name('area_customer');
session_start();
// Dominio
$SiteNameDomain = "/facturalion2/";

// Base de datos
$NameDatabase	= "virtualadmindatabase";
$LoginDatabase	= "virtualmaster";
$PassDatabase	= "lars1118";

// Tabla para validar cuentas de acceso
$Tabla_Cuentas_Acceso = "facturacion_cuentas_acceso";

// Correo principal de envío/recepción
$MailServer		= "mail.virtualadmin.com.mx";
$MailAccount 	= "evalion@virtualadmin.com.mx";
$MailPassword	= "lars1118";

// Correo de atención
$MailAttention	= "ventas@cdcom.dynalias.com";

// Confirmación registro
$Confirmation_Subject = "Confirmación de registro.";
$Confirmation_Body 	  = "&#8226; Para aclaración, duda o información al respecto puedes comunicarte ";
$Confirmation_Body   .= "con nosotros a nuestro correo $MailAttention";




//* GUID
function genChar()
{
 $vals = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
 $char = substr($vals, mt_rand(0, strlen($vals)-1), 1);
 return $char;
}

//create our guid
function GUID()
{
 $guid = genChar().genChar().genChar().genChar().genChar().genChar().genChar().genChar();
 //$guid  .= genChar().genChar().genChar().genChar()."-";
 //$guid  .= genChar().genChar().genChar().genChar()."-"; 
 //$guid  .= genChar().genChar().genChar().genChar()."-";
 //$guid  .= genChar().genChar().genChar().genChar().genChar().genChar().genChar().genChar().genChar().genChar().genChar().genChar();
 return $guid;
}

function exist_file($ruta) 
{
	if(is_file(dirname(__FILE__).$ruta)) {	return "Verdadero"; } return "Falso";
}

//*
?>