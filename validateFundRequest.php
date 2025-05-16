<?php include('./config.php');

$con;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$atmid = $_REQUEST['atmid'];
$fund_type = $_REQUEST['fund_type'];

if ($fund_type == 'Travelling') {

	$sql = mysqli_query($con, "select * from mis_details where atmid='" . $atmid . "' and status<>'close'");
	while ($sql_result = mysqli_fetch_assoc($sql)) {
		$mis_ids[] = $sql_result['id'];
	}

	$travelFundRequestFound = 0;
	foreach ($mis_ids as $mis_ids_key => $mis_ids_val) {


		$travelfundRequestsql = mysqli_query($con, "Select * from eng_fund_request where mis_id='" . $mis_ids_val . "' and fund_component like '%Travelling%' ");
		if ($travelfundRequestsql_result = mysqli_fetch_assoc($travelfundRequestsql)) {
			$travelFundRequestFound = 1;
		}
	}


	if ($travelFundRequestFound == 0) {
		$data = ['status' => '1', 'message' => 'Eligible to generate Fund Request'];
	} else {
		$data = ['status' => '0', 'message' => 'Not Eligible to generate Fund Request'];
	}

	echo json_encode($data);
}
