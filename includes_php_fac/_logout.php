<?php
session_name('area_customer');
session_start();
require("_configuration.php");
if ($_SESSION['acceso_facturalion'] == "frame_login"){
   $acceso_facturalion = "frame_login";
} else {
   $acceso_facturalion = "form_login";
}
$_SESSION = array();
session_destroy();
if ($acceso_facturalion == "form_login"){
    header("Location: ".$SiteNameDomain."index.html");
} else {
	header("Location: ".$SiteNameDomain."index.html");
}
exit;
?>