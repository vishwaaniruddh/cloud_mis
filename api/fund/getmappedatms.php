<?php include('./config.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');


if (!isset($_REQUEST['engineer_user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing parameter: engineer_user_id"
    ]);
    exit;
}

$engineer_user_id = intval($_REQUEST['engineer_user_id']); // Ensure the input is an integer

$sql = "SELECT id, atmid FROM mis_newsite WHERE engineer_user_id = $engineer_user_id order by atmid";
$result = $con->query($sql);

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
$dataArray = array();
$_newdata = array();
$_newdata['label'] = 'Resident'; 
$_newdata['value'] = 'Resident';
array_push($dataArray,$_newdata); 

$data[] = ['id'=>'home','atmid'=>'Resident'];
while ($row = $result->fetch_assoc()) {
   // $data[] = $row;
    $_newdata = array();
    $_newdata['label'] = $row['atmid']; 
    $_newdata['value'] = $row['atmid'];
    array_push($dataArray,$_newdata); 
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
        "data" => $dataArray
    ]);
}
