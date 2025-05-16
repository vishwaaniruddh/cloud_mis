<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$visit_id = $_POST['visit_id'];
$dataArray = array();
$sql = mysqli_query($con,"select * from newcheckquality_history where visit_id = '".$visit_id."' group by wizard_number");
if(mysqli_num_rows($sql)>0){
   while($sql_data = mysqli_fetch_assoc($sql)){
        $data = array();
        $data['wizard_no']   = $sql_data['wizard_number'];
        $data['updated_at']   = $sql_data['updated_at'];
        $data['visit_id'] = $sql_data['visit_id'];
        $data['id'] = $sql_data['id'];
        array_push($dataArray,$data); 
   }
}

if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>500,'res_data' => "Something Wrong"]);
}

echo json_encode($array);	

?>