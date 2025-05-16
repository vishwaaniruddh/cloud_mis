<?php

include($_SERVER['DOCUMENT_ROOT'] . '/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$datetime = date('Y-m-d H:i:s');

$visit_id = $_POST['visit_id'];
$_videofilename = $_POST['videos_name'];
$_imagefilename = $_POST['images_name'];
$err = 0;
$noerr = 0;

$errv = 0;
$noerrv = 0;

$totalfiles = 0;
$totalfilesv = 0;
$cnt = count($_FILES["image"]["name"]);

$cntv = count($_FILES["videos"]["name"]);

$array = array(['Code'=>200,'image'=>$cnt,'videos'=>$cntv]);
    
        echo json_encode($array);