<?php
include('./config.php');

$conn = $con;

// Get request parameters
$atmid = mysqli_real_escape_string($conn, $_REQUEST['atmid']);
$customer = mysqli_real_escape_string($conn, $_REQUEST['customer']);
$givenYear = mysqli_real_escape_string($conn, $_REQUEST['givenYear']);

// Check if the record exists with the provided atmid and status = 1
$query = "SELECT * FROM `unique_atm_codes` WHERE `atmid` = '$atmid' AND `status` = 1";
$result = mysqli_query($conn, $query);

// If the record doesn't exist
if (mysqli_num_rows($result) == 0) {

    // Fetch customer code from customer_codes table where status is 1
    $customerQuery = "SELECT * FROM `customer_codes` WHERE `customer` = '$customer' AND `status` = 1";
    $customerResult = mysqli_query($conn, $customerQuery);

    // Check if customer code exists
    if (mysqli_num_rows($customerResult) > 0) {
        $customerRow = mysqli_fetch_assoc($customerResult);
        $customerCode = $customerRow['customer_code'];

        // Find the next available 5-digit increment for the unique code
        $incrementQuery = "SELECT MAX(id) as max_code FROM `unique_atm_codes`";
        $incrementResult = mysqli_query($conn, $incrementQuery);
        $incrementRow = mysqli_fetch_assoc($incrementResult);
        $nextIncrement = (int)$incrementRow['max_code'] + 1;

        // Ensure the increment number is 5 digits (e.g., 00001)
        $incrementCode = str_pad($nextIncrement, 5, '0', STR_PAD_LEFT);

        // Generate the unique code
        $uniqueCode = "CTS{$customerCode}{$givenYear}{$incrementCode}";

        // Insert the new record into the unique_atm_codes table
        $insertQuery = "INSERT INTO `unique_atm_codes` (`atmid`, `unique_code`, `customer`, `customer_code`, `status`) 
                        VALUES ('$atmid', '$uniqueCode', '$customer', '$customerCode', 1)";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo json_encode(['status' => 'success', 'message' => 'Record inserted', 'unique_code' => $uniqueCode]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert record']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Customer not found or inactive']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ATMID already exists with status 1']);
}

?>
