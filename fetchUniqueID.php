<?php
include('./config.php');

ini_set('max_execution_time',0);
$conn = $con ; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$atmid = $_REQUEST['atmid'];


function getUniqueCodeByAtmId($atmid, $conn) {
    // Prepare the SQL query
    $query = "SELECT unique_code FROM unique_atm_codes WHERE atmid = ? ORDER BY id DESC LIMIT 1";
    
    // Initialize the statement
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 's', $atmid);
        
        // Execute the statement
        mysqli_stmt_execute($stmt);
        
        // Store the result
        mysqli_stmt_store_result($stmt);
        
        // Check if a row was returned
        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Bind the result variable
            mysqli_stmt_bind_result($stmt, $unique_code);
            
            // Fetch the result
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
            return $unique_code; // Return the unique_code
        } else {
            mysqli_stmt_close($stmt);
            return null; // No unique code found for the given atmid
        }
    } else {
        // Handle query preparation error
        return null;
    }
}


$uniqueCode = getUniqueCodeByAtmId($atmid, $con);
if ($uniqueCode) {
    echo $uniqueCode;
} else {
    echo 0;;
}

