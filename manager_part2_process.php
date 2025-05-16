<?php
session_start();
include('config.php');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');

// Initialize response with default values
$response = array('status' => 400, 'message' => 'Invalid request.');

if (isset($_SESSION['username'])) {
    // Get necessary variables from the session and POST data
    $action_by = $_SESSION['userid'];
    $fund_id = $_POST['fund_req_id'];
    $approved_amt = $_POST['approved_amt'];
    $fund_remarks = $_POST['fund_remarks'];
    $remarks = $_POST['remarks'];
    $mis_id = $_POST['misid'];

    // Update the eng_fund_request table
    $updatesql = "
        UPDATE eng_fund_request 
        SET approved_amount = '$approved_amt', req_status = 4 
        WHERE id = '$fund_id'
    ";
    
    if (mysqli_query($con, $updatesql)) {
        // Fetch the latest record from eng_fund_request_history
        $fund_sql = mysqli_query($con, "
            SELECT * 
            FROM eng_fund_request_history 
            WHERE fundreq_id = '$fund_id' 
            ORDER BY id DESC 
            LIMIT 1
        ");
        $fund_data = mysqli_fetch_assoc($fund_sql);

        $requested_amt = $fund_data['requested_amount'];
        $finalapproved_amount = $fund_data['approved_amount'];

        // Insert new record into eng_fund_request_history
        $insertfundsql = "
            INSERT INTO eng_fund_request_history (
                fundreq_id, requested_amount, approved_amount, action_by, 
                status, created_at, updated_at, remarks
            ) VALUES (
                '$fund_id', '$finalapproved_amount', '$approved_amt', '$action_by', 
                4, '$created_at', '$created_at', '$fund_remarks'
            )
        ";
        if (mysqli_query($con, $insertfundsql)) {
            // Additional remarks for mis_history
            $additional = "Ask: $finalapproved_amount & Approved: $approved_amt";

            mysqli_query($con,"update mis_details set status = 'fund_batch_pending' where id='".$mis_id."' ");

            // Insert new record into mis_history
            $statement = "
                INSERT INTO mis_history (
                    mis_id, type, remark, created_at, created_by
                ) VALUES (
                    '$mis_id', 'Level 2 Fund Processed', 
                    '$fund_remarks $additional', '$created_at', '$action_by'
                )
            ";
            mysqli_query($con, $statement);

            // Prepare success response
            $response = array(
                'status' => 200,
                'message' => 'Fund request updated successfully.',
                'fund_id' => $fund_id
            );
        } else {
            $response = array(
                'status' => 500,
                'message' => 'Failed to insert into fund request history.'
            );
        }
    } else {
        $response = array(
            'status' => 500,
            'message' => 'Failed to update fund request.'
        );
    }
} else {
    // Handle unauthorized access
    $response = array(
        'status' => 401,
        'message' => 'Unauthorized access. Please log in.'
    );
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
