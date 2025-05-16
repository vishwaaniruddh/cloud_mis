<?php
header('Content-Type: application/json');
require_once 'config.php'; // Include your database connection file

// Get input data
$atmid = isset($_REQUEST['atmid']) ? trim($_REQUEST['atmid']) : '';
$spares_component = isset($_REQUEST['spares_component']) ? trim($_REQUEST['spares_component']) : '';
$spares_subcomponent = isset($_REQUEST['spares_subcomponent']) ? trim($_REQUEST['spares_subcomponent']) : '';



// $atmid = 'P3ENDL07';
// $spares_component ='AI';
// $spares_subcomponent = 'RASPBERRY PI';


// Check if required parameters are provided
if (empty($atmid) || empty($spares_component) || empty($spares_subcomponent)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
    exit;
}


$mis_ids = [];

// Fetch mis_id from mis_details where status is not 'close'
$sql = $con->prepare("SELECT id FROM mis_details WHERE atmid = ? AND status <> 'close'");
$sql->bind_param('s', $atmid);
$sql->execute();
$result = $sql->get_result();
while ($row = $result->fetch_assoc()) {
    $mis_ids[] = $row['id'];
}


$sql->close();

if (count($mis_ids)==0) {
    echo json_encode(['status' => 'success', 'message' => 'Fresh call, allow to generate spare fund request.']);
    exit;
}

$spares_fund_request_ids = [];


foreach ($mis_ids as $mis_id) {
    $fund_sql = $con->prepare("SELECT id FROM eng_fund_request WHERE mis_id = ? AND fund_component LIKE '%Spares%'");
    $fund_sql->bind_param('i', $mis_id);
    $fund_sql->execute();
    $fund_result = $fund_sql->get_result();
    while ($fund_row = $fund_result->fetch_assoc()) {
        $spares_fund_request_ids[] = $fund_row['id'];
    }
    $fund_sql->close();
}




if (!empty($spares_fund_request_ids)) {
    foreach ($spares_fund_request_ids as $fund_id) {
        
        // echo $query =  "SELECT s.id FROM spare_funds s
        // INNER JOIN raisedFund r on r.id = s.raisedFundId 
        // WHERE s.spares_component = '$spares_component' AND s.spares_subcomponent = '$spares_subcomponent' AND s.status = 1
        // and r.eng_fund_req_id = '$fund_id'
        // " ; 
        
        $spare_sql = $con->prepare("SELECT s.id FROM spare_funds s
        INNER JOIN raisedFund r on r.id = s.raisedFundId 
        WHERE s.spares_component = ? AND s.spares_subcomponent = ? AND s.status = 1
        and r.eng_fund_req_id = ? ");
        
        $spare_sql->bind_param('ssi', $spares_component, $spares_subcomponent, $fund_id);
        $spare_sql->execute();
        $spare_result = $spare_sql->get_result();
        if ($spare_result->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Spare request already exists. Cannot regenerate.']);
            exit;
        }
        $spare_sql->close();
    }
}

// If no existing fund request is found, allow generating a new request
echo json_encode(['status' => 'success', 'message' => 'Spare request not found. Allow generating a new request.']);
exit;
?>
