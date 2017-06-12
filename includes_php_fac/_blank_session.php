<?php
session_name('area_customer');
session_start();
$_SESSION = array();
session_destroy();
exit;
?>