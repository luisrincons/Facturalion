<?php
session_name('area_customer');
session_start();
$_SESSION = array();
session_destroy();
$data_cache = array(
'result'=>'Ok!'
);
header('Content-type: application/json');
echo json_encode($data_cache);
?>