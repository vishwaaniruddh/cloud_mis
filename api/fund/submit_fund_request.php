<?php
// Include the configuration file for database connection
include('./config.php');

// Enable error reporting for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');


// Set the response content type to JSON
header('Content-Type: application/json');

// Get the request data
$data = $_REQUEST;

// Check if required parameters are present in the request
if (!isset($data['id'], $data['fund_type'], $data['fund_amount'], $data['fund_component'], $data['remark'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit;
}

$totalDistanceTravel = 0;
$allraisedComponent = '';

// Insert into raisedFund
$fundQuery = "INSERT INTO raisedFund (mis_id, fund_type, fund_amount, remark, status, created_at, created_by, raisedFundStatus) 
              VALUES ('{$data['id']}', '{$data['fund_type']}', '{$data['fund_amount']}', '{$data['remark']}', '1', NOW(), 1, 'active')";
if (!mysqli_query($con, $fundQuery)) {
    echo json_encode(['status' => 'error', 'message' => "Error inserting into raisedFund: " . mysqli_error($con)]);
    exit;
}
$raisedFundId = mysqli_insert_id($con); // Get the last inserted ID

// Insert into raisedFundComponent and related tables
foreach ($data['fund_component'] as $component) {
    $componentQuery = "INSERT INTO raisedFundComponent (mis_id, raisedFundId, component, created_at, created_by, status, fundStatus) 
                       VALUES ('{$data['id']}', '$raisedFundId', '$component', NOW(), 1, '1', 'pending')";
    if (!mysqli_query($con, $componentQuery)) {
        echo json_encode(['status' => 'error', 'message' => "Error inserting into raisedFundComponent: " . mysqli_error($con)]);
        exit;
    }
    $allraisedComponent .= $component . ",";

    $raisedFundComponentId = mysqli_insert_id($con); // Get the last inserted ID for this component

    // Insert into travelling_funds if the component is Travelling
    if ($component === "Travelling") {
        foreach ($data['travel_type'] as $travelIndex => $travelType) {
            $travelQuery = "INSERT INTO travelling_funds (mis_id, raisedFundId, raisedFundComponentId, travel_type, from_site, to_site, travel_distance, calculated_amount, status) 
                            VALUES ('{$data['id']}', '$raisedFundId', '$raisedFundComponentId', '{$data['travel_type'][$travelIndex]}', 
                                    '{$data['from_site'][$travelIndex]}', '{$data['to_site'][$travelIndex]}', 
                                    '{$data['travel_distance'][$travelIndex]}', '{$data['calculated_amount'][$travelIndex]}', '1')";
            if (!mysqli_query($con, $travelQuery)) {
                echo json_encode(['status' => 'error', 'message' => "Error inserting into travelling_funds: " . mysqli_error($con)]);
                exit;
            }

            $totalDistanceTravel += $data['travel_distance'][$travelIndex];
        }
    }

    // Insert into spare_funds if the component is Spares
    if ($component === "Spares") {
        foreach ($data['spares_component'] as $spareIndex => $sparesComponent) {
            $spareQuery = "INSERT INTO spare_funds (mis_id, raisedFundId, raisedFundComponentId, spares_component, spares_subcomponent, spares_cost, status) 
                           VALUES ('{$data['id']}', '$raisedFundId', '$raisedFundComponentId', '{$data['spares_component'][$spareIndex]}', 
                                   '{$data['spares_subcomponent'][$spareIndex]}', '{$data['spares_cost'][$spareIndex]}', '1')";
            if (!mysqli_query($con, $spareQuery)) {
                echo json_encode(['status' => 'error', 'message' => "Error inserting into spare_funds: " . mysqli_error($con)]);
                exit;
            }
        }
    }

    // Insert into vendor_funds if the component is Vendor
    if ($component === "Vendor") {
        $vendorQuery = "INSERT INTO vendor_funds (mis_id, raisedFundId, raisedFundComponentId, vendor_name, vendor_amount, status) 
                        VALUES ('{$data['id']}', '$raisedFundId', '$raisedFundComponentId', 'Vendor Name', '{$data['vendor_amount']}', '1')";
        if (!mysqli_query($con, $vendorQuery)) {
            echo json_encode(['status' => 'error', 'message' => "Error inserting into vendor_funds: " . mysqli_error($con)]);
            exit;
        }
    }
}

$allraisedComponent = rtrim($allraisedComponent, ',');

// Insert into `eng_fund_request`
$fund_type = $data['fund_type'];
$fund_component = $allraisedComponent;
$fund_amount = $data['fund_amount'];

$eng_fund_requestsql = "INSERT INTO eng_fund_request (mis_id, atmid, fund_type, fund_component, requested_amount, req_status, fund_requested_by, created_at) 
                        VALUES ('{$data['id']}', '{$data['atmid']}', '$fund_type', '$fund_component', '$fund_amount', 1, '{$data['userid']}', NOW())";
if (!mysqli_query($con, $eng_fund_requestsql)) {
    echo json_encode(['status' => 'error', 'message' => "Error inserting into eng_fund_request: " . mysqli_error($con)]);
    exit;
}

$eng_fund_request_insertId = mysqli_insert_id($con); // Get the last inserted ID

// Insert into eng_fund_request_history
$eng_fund_request_history_sql = "INSERT INTO eng_fund_request_history (fundreq_id, requested_amount, approved_amount, action_by, status, remarks, created_at, updated_at) 
                                  VALUES ('$eng_fund_request_insertId', '$fund_amount', '$fund_amount', '{$data['userid']}', 1, '{$data['remark']}', NOW(), NOW())";
if (!mysqli_query($con, $eng_fund_request_history_sql)) {
    echo json_encode(['status' => 'error', 'message' => "Error inserting into eng_fund_request_history: " . mysqli_error($con)]);
    exit;
}

// Insert into mis_history
$status = $data['status'];
$statement = "INSERT INTO mis_history (mis_id, type, remark, created_at, created_by) 
              VALUES ('{$data['id']}', '$status', '{$data['remark']}', NOW(), '{$data['userid']}')";

// Return success response
echo json_encode([
    'status' => 'success',
    'message' => 'All data inserted successfully.',
    'raisedFundId' => $raisedFundId,
    'eng_fund_request_insertId' => $eng_fund_request_insertId
]);

?>
