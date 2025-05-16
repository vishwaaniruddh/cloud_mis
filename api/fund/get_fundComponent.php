<?php
header('Content-Type: application/json');

// Database connection
include('config.php'); // Include your database connection file
if (!$con) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

try {
    // Query to fetch data where status = 1
    $query = "SELECT id, name, status FROM fundComponent WHERE status = 1";
    $result = mysqli_query($con, $query);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($con));
    }

    $data = [];
    $dataArray = array();
    while ($row = mysqli_fetch_assoc($result)) {
        //$data[] = $row;
            $_newdata = array();
            $_newdata['label'] = $row['name']; 
            $_newdata['value'] = $row['name'];
            array_push($dataArray,$_newdata); 
    }

    echo json_encode(["status" => "success", "data" => $dataArray]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

// Close the database connection
mysqli_close($con);
?>
