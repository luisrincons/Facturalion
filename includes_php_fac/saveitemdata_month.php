<?php
session_name('area_customer');
session_start();

$_SESSION['itemdata_selected_month'] = $_POST['id'];

$data_cache = array(
'result'=>'Ok!'
);
header('Content-type: application/json');
echo json_encode($data_cache);

?>