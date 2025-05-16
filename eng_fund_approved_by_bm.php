<?php
session_start();
include('config.php');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');

$response = array('status' => 400, 'message' => 'Invalid Request');

if (isset($_SESSION['username'])) {
    $action_by = $_SESSION['userid'];
    $fund_id = $_POST['fund_req_id'];
    $approved_amt = $_POST['approved_amt'];
    $fund_remarks = $_POST['fund_remarks'];
    $remarks = $_POST['remarks'];

    // Update eng_fund_request table
    $updatesql = "UPDATE eng_fund_request SET approved_amount = '$approved_amt', req_status = 2 WHERE id = '$fund_id'";

    if (mysqli_query($con, $updatesql)) {
        // Fetch the latest history record
        $fund_sql = mysqli_query($con, "SELECT * FROM eng_fund_request_history WHERE fundreq_id = '$fund_id' ORDER BY id DESC LIMIT 1");
        $fund_data = mysqli_fetch_assoc($fund_sql);
        $requested_amt = $fund_data['requested_amount'];

        // Insert into eng_fund_request_history table
        $insertfundsql = "INSERT INTO eng_fund_request_history (fundreq_id, requested_amount, approved_amount, action_by, status, created_at, updated_at) 
                          VALUES ('$fund_id', '$requested_amt', '$approved_amt', '$action_by', 2, '$created_at', '$created_at')";
        if (mysqli_query($con, $insertfundsql)) {
            $response = array('status' => 200, 'message' => 'Fund request updated successfully.', 'fund_id' => $fund_id);
        } else {
            $response = array('status' => 500, 'message' => 'Failed to update fund request history.');
        }
    } else {
        $response = array('status' => 500, 'message' => 'Failed to update fund request.');
    }
} else {
    $response = array('status' => 401, 'message' => 'Unauthorized access. Please log in.');
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
