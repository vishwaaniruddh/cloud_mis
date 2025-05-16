<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');

$count_visit_query = mysqli_query($con,"select id from checkquality order by id DESC LIMIT 1");
$count_visit = mysqli_fetch_assoc($count_visit_query);
if($count_visit['id']){
    $_next_visit_id = $count_visit['id'] + 1;
}else{
    $_next_visit_id = 1;
}

$customer = $_POST['customer'];
$atmid = $_POST['atm_id'];
$visit_id = $_next_visit_id;
$bank = $_POST['bank'];
$eng_id = $_POST['eng_id'];
$files = '';

$status = 0;

$data = $_POST;
// var_dump($_POST);

$testarray = array();

foreach($data as $key=>$value)
{
    // if($key!='Atm_id' && $key!='bank') {
    $_newdata = array();
    $_newdata['key'] = $key;
    $_newdata['value'] = $value;
    array_push($testarray,$_newdata);
    // }
}

$testarray = json_encode($testarray);

$query_result = mysqli_query($con,"insert into checkquality (`customer`,`atmid`, `visit_id`, `bank`,  `question_list`, `files`, `status`, `created_at`, `created_by`) values ('".$customer."','".$atmid."','".$visit_id."','".$bank."','".$testarray."','".$files."','".$status."','".$created_at."','".$eng_id."') ");

if($query_result)
	{
	    $insert_id = $con->insert_id;
   	    $array = array('Code'=>200,'res_data'=>$testarray,'new_visit_id'=>$insert_id);
	
	}       
else
    {
        $array = array(['Code'=>201]);
    }

    echo json_encode($array);


?>