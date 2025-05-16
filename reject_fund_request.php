<?php 
include('./config.php');
header('Content-Type: application/json');

$response = array();

// Check if required parameters are set
if (!isset($_REQUEST['fundid'], $_REQUEST['level'], $_REQUEST['remarks'])) {
    echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
    exit;
}

$fundid = mysqli_real_escape_string($con, $_REQUEST['fundid']);
$level = mysqli_real_escape_string($con, $_REQUEST['level']);
$remarks = mysqli_real_escape_string($con, $_REQUEST['remarks']);
$action_by = isset($userid) ? $userid : "System"; // Ensure action_by has a valid value

// Fetch fund details
$sql = mysqli_query($con, "SELECT * FROM raisedFund WHERE eng_fund_req_id='$fundid'");

if ($sql_result = mysqli_fetch_assoc($sql)) {
    $eng_fund_req_id = $sql_result['eng_fund_req_id'];
    $mis_id = $sql_result['mis_id'];

    // Fetch details from eng_fund_request_history
    $history_sql = mysqli_query($con, "SELECT * FROM eng_fund_request_history WHERE fundreq_id='$eng_fund_req_id'");
    $history_result = mysqli_fetch_assoc($history_sql);

    if ($history_result) {
        $requested_amount = $history_result['requested_amount'];
        $approved_amount = $history_result['approved_amount'];
        $action_by = $history_result['action_by'];
        $status = $history_result['status'];
        $updated_at = $created_at = date("Y-m-d H:i:s"); // Set timestamp

        // Define status based on level
        $status_code = ($level == 1) ? 7 : (($level == 2) ? 8 : (($level == 4) ? 9 : null));

        if ($status_code) {
            // Update eng_fund_request table
            $update_query = "UPDATE eng_fund_request SET req_status='$status_code' WHERE id='$fundid'";
            if (!mysqli_query($con, $update_query)) {
                echo json_encode(["status" => "error", "message" => "Failed to update fund request."]);
                exit;
            }

            // Insert record into eng_fund_request_history
            $insert_query = "INSERT INTO eng_fund_request_history 
                (fundreq_id, requested_amount, approved_amount, action_by, status, remarks, created_at, updated_at) 
                VALUES 
                ('$eng_fund_req_id', '$requested_amount', '$approved_amount', '$action_by', '$status_code', '$remarks', '$created_at', '$updated_at')";

            if (!mysqli_query($con, $insert_query)) {


                echo json_encode(["status" => "error", "message" => "Failed to insert into history table."]);
                exit;
            }

            mysqli_query($con,"update mis_details set status = 'fund_request_rejected' where id='".$mis_id."' ");

                $statement = "INSERT INTO mis_history (mis_id, type, remark, created_at, created_by,raisedFundId) 
                      VALUES ('$mis_id', 'fund_request_rejected', '{$remarks}', '$datetime', '$userid','$fundid')";

                mysqli_query($con,$statement);
                
            echo json_encode(["status" => "success", "message" => "Fund request rejected successfully."]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid level provided."]);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No history record found for this fund request."]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Fund request not found."]);
    exit;
}
?>
