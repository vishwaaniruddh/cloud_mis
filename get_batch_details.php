<?php
// Start session and include configuration
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit;
}

// Check if batch_id is provided
if (!isset($_REQUEST['batch_id']) || empty($_REQUEST['batch_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Batch ID is missing.']);
    exit;
}

$batch_id = intval($_REQUEST['batch_id']);

try {
    // Start transaction
    mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_ONLY);

    // Fetch batch details
      $query = "
        SELECT 
        id, atmid , fund_type, fund_component, approved_amount, created_at
        from eng_fund_request 
        WHERE batch_id = $batch_id";
    
    $result = mysqli_query($con, $query);

    if (!$result) {
        throw new Exception('Error executing query: ' . mysqli_error($con));
    }
    
    

    // Check if batch exists
    if (mysqli_num_rows($result) == 0) {
        mysqli_rollback($con);
        echo json_encode(['status' => 'error', 'message' => 'No batch found with the provided ID.']);
        exit;
    }

    // Fetch batch details
    $batch_details = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $batch_details[] = $row;
    }

    // Commit transaction
    mysqli_commit($con);

    echo json_encode(['status' => 'success', 'data' => $batch_details]);
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($con);
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
