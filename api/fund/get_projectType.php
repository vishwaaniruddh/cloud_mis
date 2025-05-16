<?php
header('Content-Type: application/json');

// Database connection
include('config.php'); // Assuming you have a separate file for database connection
if (!$con) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

try {
    // Query to fetch only id, name, and status
    $query = "SELECT id, name, status FROM projectType";
    $result = mysqli_query($con, $query);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($con));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; // Fetch only selected columns
    }

    echo json_encode(["status" => "success", "data" => $data]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

// Close the database connection
mysqli_close($con);
?>
