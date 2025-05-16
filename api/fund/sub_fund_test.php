<?php
// Include the configuration file for database connection
include('./config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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


$_id = $data['id'];
$_fund_type = $data['fund_type'];
$_fund_amt = $data['fund_amount'];
$_fund_remark = $data['remark'];
//$date_created = "2025-01-04 12:12:12";

// Insert into raisedFund
$fundQuery = "INSERT INTO raisedFund (mis_id, fund_type, fund_amount, remark, status, created_at, created_by, raisedFundStatus) 
              VALUES ('".$_id."', '".$_fund_type."', '".$_fund_amt."', '".$_fund_remark."', '1', NOW(), 1, 'active')";

if (!mysqli_query($con, $fundQuery)) {
    echo json_encode(['status' => 'error', 'message' => "Error inserting into raisedFund: " . mysqli_error($con)]);
    exit;
}
$raisedFundId = mysqli_insert_id($con); // Get the last inserted ID


$_fund_comp = json_decode($data['fund_component']);


 

// Insert into raisedFundComponent and related tables
foreach ($_fund_comp as $component) {
    
    $componentQuery = "INSERT INTO raisedFundComponent (mis_id, raisedFundId, component, created_at, created_by, status, fundStatus) 
                       VALUES ('".$_id."', '".$raisedFundId."', '".$component."', NOW(), 1, '1', 'pending')";
                       
                      
                       
    if (!mysqli_query($con, $componentQuery)) {
        echo json_encode(['status' => 'error', 'message' => "Error inserting into raisedFundComponent: " . mysqli_error($con)]);
        exit;
    }
    $allraisedComponent .= $component . ",";

    $raisedFundComponentId = mysqli_insert_id($con); // Get the last inserted ID for this component

    // Insert into travelling_funds if the component is Travelling
    if ($component === "Travelling") {
        $_fund_travel_type = json_decode($data['travel_type']);
        
        $travel_fromsite = json_decode($data['from_site']);
        $travel_tosite = json_decode($data['to_site']);
        $travel_distance = json_decode($data['travel_distance']);
        $travel_calculated_amount = json_decode($data['calculated_amount']);
        $travel_tot_distance = json_decode($data['travel_distance']);
        
        
        foreach ($_fund_travel_type as $travelIndex => $travelType) {
            $traveltypeindex = $_fund_travel_type[$travelIndex];
            $fromsiteindex = $travel_fromsite[$travelIndex];
            $tositeindex = $travel_tosite[$travelIndex];
            $distindex = $travel_distance[$travelIndex];
            $calamtindex = $travel_calculated_amount[$travelIndex];
            $travelQuery = "INSERT INTO travelling_funds (mis_id, raisedFundId, raisedFundComponentId, travel_type, from_site, to_site, travel_distance, calculated_amount, status) 
                            VALUES ('".$_id."', '".$raisedFundId."', '".$raisedFundComponentId."', '".$traveltypeindex."', 
                                    '".$fromsiteindex."', '".$tositeindex."', 
                                    '".$distindex."', '".$calamtindex."', '1')";
            
            if (!mysqli_query($con, $travelQuery)) {
                echo json_encode(['status' => 'error', 'message' => "Error inserting into travelling_funds: " . mysqli_error($con)]);
                exit;
            }

            $totalDistanceTravel += $travel_tot_distance[$travelIndex];
        }
    }

    // Insert into spare_funds if the component is Spares
    if ($component === "Spares") {
        $_fund_spares_comp = json_decode($data['spares_component']);
        $_fund_spares_subcomp = json_decode($data['spares_subcomponent']);
        $_fund_spares_cost = json_decode($data['spares_cost']);
        foreach ($_fund_spares_comp as $spareIndex => $sparesComponent) {
            $sparescomponentindex = $_fund_spares_comp[$spareIndex];
            $spares_subcompindex = $_fund_spares_subcomp[$spareIndex];
            $spares_amt = $_fund_spares_cost[$spareIndex];
            $spareQuery = "INSERT INTO spare_funds (mis_id, raisedFundId, raisedFundComponentId, spares_component, spares_subcomponent, spares_cost, status) 
                           VALUES ('".$_id."', '".$raisedFundId."', '".$raisedFundComponentId."', '".$sparescomponentindex."', 
                                   '".$spares_subcompindex."', '".$spares_amt."', '1')";
                                   
                              
            if (!mysqli_query($con, $spareQuery)) {
                echo json_encode(['status' => 'error', 'message' => "Error inserting into spare_funds: " . mysqli_error($con)]);
                exit;
            }
        }
    }

    // Insert into vendor_funds if the component is Vendor
    if ($component === "Vendor") {
        $vendor_amt = $data['vendor_amount'];
        $vendor_name = $data['vendor_name'];
        $vendorQuery = "INSERT INTO vendor_funds (mis_id, raisedFundId, raisedFundComponentId, vendor_name, vendor_amount, status) 
                        VALUES ('".$_id."', '".$raisedFundId."', '".$raisedFundComponentId."', '".$vendor_name."', '".$vendor_amt."', '1')";
                        
                              
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
$fund_atmid = $data['atmid'];
$userid = $data['userid'];
$fund_remark = $data['remark'];

          

$eng_fund_requestsql = "INSERT INTO eng_fund_request (mis_id, atmid, fund_type, fund_component, requested_amount, req_status, fund_requested_by, created_at) 
                        VALUES ('".$_id."', '".$fund_atmid."', '".$fund_type."', '".$fund_component."', '".$fund_amount."', 1, '".$userid."', NOW())";
if (!mysqli_query($con, $eng_fund_requestsql)) {
    echo json_encode(['status' => 'error', 'message' => "Error inserting into eng_fund_request: " . mysqli_error($con)]);
    exit;
}

$eng_fund_request_insertId = mysqli_insert_id($con); // Get the last inserted ID

// Insert into eng_fund_request_history
$eng_fund_request_history_sql = "INSERT INTO eng_fund_request_history (fundreq_id, requested_amount, approved_amount, action_by, status, remarks, created_at, updated_at) 
                                  VALUES ('".$eng_fund_request_insertId."', '".$fund_amount."', '".$fund_amount."', '".$userid."', 1, '".$fund_remark."', NOW(), NOW())";
if (!mysqli_query($con, $eng_fund_request_history_sql)) {
    echo json_encode(['status' => 'error', 'message' => "Error inserting into eng_fund_request_history: " . mysqli_error($con)]);
    exit;
}

// Insert into mis_history

$status = 'Fund Request Initiated';
$statement = "INSERT INTO mis_history (mis_id, type, remark, created_at, created_by) 
              VALUES ('".$_id."', '".$status."', '".$fund_remark."', NOW(), '".$userid."')";   
              
mysqli_query($con,$statement);  
              

// Return success response
echo json_encode([
    'status' => 'success',
    'message' => 'All data inserted successfully.',
    'raisedFundId' => $raisedFundId,
    'eng_fund_request_insertId' => $eng_fund_request_insertId
]);

?>
