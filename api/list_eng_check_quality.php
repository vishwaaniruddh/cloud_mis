<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$userid = $_POST['user_id'];
$dataArray = array();
$sql = mysqli_query($con,"select * from newcheckquality where created_by = '".$userid."' order by id DESC");
if(mysqli_num_rows($sql)>0){
   while($sql_data = mysqli_fetch_assoc($sql)){
        $data = array();
        $data['atmid'] = $sql_data['atmid'];
        $data['customer']   = $sql_data['customer'];
        $data['bank']   = $sql_data['bank'];
        $data['wizard_no']   = $sql_data['wizard_number'];
        $data['status']   = $sql_data['status'];
        $data['created_at']   = $sql_data['created_at'];
        $data['question_list'] = $sql_data['question_list'];
        $data['question_list_2'] = $sql_data['question_list_2'];
        $data['question_list_3'] = $sql_data['question_list_3'];
        $data['question_list_4'] = $sql_data['question_list_4'];
        $data['question_list_5'] = $sql_data['question_list_5'];
        $data['question_list_6'] = $sql_data['question_list_6'];
        $data['question_list_7'] = $sql_data['question_list_7'];
        $data['visit_id'] = $sql_data['visit_id'];
        $data['id'] = $sql_data['id'];
        $data['dissapp_remark'] = $sql_data['dissapp_remark'];
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