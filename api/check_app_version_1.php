<?php 

header("Access-Control-Allow-Origin: *");  // Allow all domains, or specify a particular domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");  // If you need to allow cookies/authentication

// Handle preflight request (OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

// header("Access-Control-Allow-Origin: *");  // Allow all origins, replace '*' with your React Native app's URL for security
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
// header("Access-Control-Allow-Credentials: true");

//header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

$usersql = mysqli_query($con,"select * from eng_app_version");
$total = mysqli_fetch_row($usersql);
$version = $total[0];
$array = array(['code'=>200,'version'=>$version]);
echo json_encode($array);