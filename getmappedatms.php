<?php
// Include the configuration file for database connection
include('./config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the response content type to JSON
header('Content-Type: application/json');

// Check if the engineer_user_id is provided
if (!isset($_REQUEST['engineer_user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing parameter: engineer_user_id"
    ]);
    exit;
}



if($_user_designation==1){
    
    $sql = "SELECT id, atmid FROM mis_newsite where status=1 order by atmid limit 500 ";
    $result = $con->query($sql);
    
}else{
    
    $engineer_user_id = intval($_REQUEST['engineer_user_id']); 
    $sql = "SELECT id, atmid FROM mis_newsite WHERE status=1 and engineer_user_id = $engineer_user_id order by atmid";
    $result = $con->query($sql);    
    
}


// Check for database errors
if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => "Database query failed: " . $con->error
    ]);
    exit;
}

// Fetch results
$data = [];

$data[] = ['id'=>'home','atmid'=>'Resident'];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the database connection
$con->close();

// Return the response as JSON
if (empty($data)) {
    echo json_encode([
        "status" => "error",
        "message" => "No records found"
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
}
