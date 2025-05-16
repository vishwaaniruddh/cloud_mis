<?php include('./config.php');

$con;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$atmid = $_REQUEST['atmid'];
$fund_type = $_REQUEST['fund_type'];

if ($fund_type == 'Travelling') {

	$sql = mysqli_query($con, "select * from fund_distance_master where atm_id = '" . $atmid . "'");
	if ($sql_result = mysqli_fetch_assoc($sql)) {
	    $isEligibleToRequest = $sql_result['fund_require'];
	    $km = $sql_result['km'];
	    $amount = $km * 3 ;  
	    if($isEligibleToRequest=='Yes'){
        	$data = ['isEligible'=>1,'distance'=>$km,'amount'=>$amount];

	    }else{
    		$data = ['isEligible'=>0,'distance'=>$km,'amount'=>0];
	    }

	}else{
	    	$data = ['isEligible'=>2,'distance'=>0,'amount'=>0];
	}

	echo json_encode($data);
}
