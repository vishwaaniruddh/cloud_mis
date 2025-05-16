<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include('./config.php');
// Sample data
$data = array(
    "id" => "71057",
    "fund_component" => array("Travelling", "Spares", "Vendor"),
    "status" => "fund_required",
    "travel_type" => array("Resident to Site", "Site to Site"),
    "from_site" => array("Resident", "BPCN177111"),
    "to_site" => array("P3ENDE50", "P3ENDI13"),
    "travel_distance" => array("32", "43"),
    "calculated_amount" => array("96", "129"),
    "spares_component" => array("HDD", "DVR"),
    "spares_subcomponent" => array("HDD MISSING", "DVR Not Working"),
    "spares_cost" => array("1200", "3200"),
    "vendor_amount" => "5000",
    "fund_amount" => "9625",
    "remark" => "someting remark"
);

// Database connection (assuming $con is already initialized)
// Insert into raisedFund
$fundQuery = "INSERT INTO raisedFund (mis_id, fund_amount, remark, status, created_at, created_by, raisedFundStatus) 
              VALUES ('{$data['id']}', '{$data['fund_amount']}', '{$data['remark']}', '1', NOW(), 1, 'active')";
if (!mysqli_query($con, $fundQuery)) {
    die("Error inserting into raisedFund: " . mysqli_error($con));
}
$raisedFundId = mysqli_insert_id($con); // Get the last inserted ID

// Insert into raisedFundComponent and related tables
foreach ($data['fund_component'] as $index => $component) {
    $componentQuery = "INSERT INTO raisedFundComponent (mis_id, raisedFundId, component, created_at, created_by, status, fundStatus) 
                       VALUES ('{$data['id']}', '$raisedFundId', '$component', NOW(), 1, '1', 'pending')";
    if (!mysqli_query($con, $componentQuery)) {
        die("Error inserting into raisedFundComponent: " . mysqli_error($con));
    }
    $raisedFundComponentId = mysqli_insert_id($con); // Get the last inserted ID for this component

    // Insert into travelling_funds if the component is Travelling
    if ($component === "Travelling") {
        foreach ($data['travel_type'] as $travelIndex => $travelType) {
            $travelQuery = "INSERT INTO travelling_funds (mis_id, raisedFundId,raisedFundComponentId, travel_type, from_site, to_site, travel_distance, calculated_amount, status) 
                            VALUES ('{$data['id']}', '$raisedFundId','$raisedFundComponentId', '{$data['travel_type'][$travelIndex]}', 
                                    '{$data['from_site'][$travelIndex]}', '{$data['to_site'][$travelIndex]}', 
                                    '{$data['travel_distance'][$travelIndex]}', '{$data['calculated_amount'][$travelIndex]}', '1')";
            if (!mysqli_query($con, $travelQuery)) {
                die("Error inserting into travelling_funds: " . mysqli_error($con));
            }
        }
    }

    // Insert into spare_funds if the component is Spares
    if ($component === "Spares") {
        foreach ($data['spares_component'] as $spareIndex => $sparesComponent) {
            $spareQuery = "INSERT INTO spare_funds (mis_id, raisedFundId,raisedFundComponentId, spares_component, spares_subcomponent, spares_cost, status) 
                           VALUES ('{$data['id']}',  '$raisedFundId','$raisedFundComponentId', '{$data['spares_component'][$spareIndex]}', 
                                   '{$data['spares_subcomponent'][$spareIndex]}', '{$data['spares_cost'][$spareIndex]}', '1')";
            if (!mysqli_query($con, $spareQuery)) {
                die("Error inserting into spare_funds: " . mysqli_error($con));
            }
        }
    }

    // Insert into vendor_funds if the component is Vendor
    if ($component === "Vendor") {
        $vendorQuery = "INSERT INTO vendor_funds (mis_id, raisedFundId,raisedFundComponentId, vendor_name, vendor_amount, status) 
                        VALUES ('{$data['id']}', '$raisedFundId', '$raisedFundComponentId', 'Vendor Name', '{$data['vendor_amount']}', '1')";
        if (!mysqli_query($con, $vendorQuery)) {
            die("Error inserting into vendor_funds: " . mysqli_error($con));
        }
    }
}
echo "Data inserted successfully.";
?>
