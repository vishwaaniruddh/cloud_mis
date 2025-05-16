<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

    $userid = $_POST['user_id'];

    $usersql = mysqli_query($con,"select branch,zone from mis_loginusers where id='".$userid."'");
	$userdata = mysqli_fetch_assoc($usersql);
	$_bank_ids = $userdata['branch'];
    $banks = explode(",",$_bank_ids);
	$_bank_name = [];
	for($i=0;$i<count($banks);$i++){
	    $branch_city = $banks[$i];
    	$citysql = mysqli_query($con,"select city from mis_city where id='".$branch_city."'");
    	$citydata = mysqli_fetch_assoc($citysql);
	    array_push($_bank_name,$citydata['city']);
	} 
	   
    $_bank_name=json_encode($_bank_name);
	$_bank_name=str_replace( array('[',']','"') , ''  , $_bank_name);
	$bankarr=explode(',',$_bank_name);
	$_bank_name = "'" . implode ( "', '", $bankarr )."'";
	
$activity = $_POST['activity'];
$statement = "select * from mis_newsite where activity = '".$activity."' and engineer_user_id='".$userid."' order by id desc";
//$statement = "select * from mis_newsite where activity = '".$activity."' and branch IN (".$_bank_name.") and engineer_user_id='".$userid."' order by id desc";
//$statement = "select a.id as ID,a.created_at as Created_AT,a.* from mis_newvisit a inner join mis_newsite b on a.atmid=b.atmid where b.activity='".$activity."' AND engineer='".$userid."' ";
//$statement.= " order by a.id desc" ; 

$dataArray = array();
$sql = mysqli_query($con,$statement);
if(mysqli_num_rows($sql)>0){
    while($sql_result = mysqli_fetch_assoc($sql)){
            $_atm_id = $sql_result['atmid'];
            $check_statement = "select * from mis_newvisit_app where atmid = '".$_atm_id."'";
            $check_sql = mysqli_query($con,$check_statement);
            if(mysqli_num_rows($check_sql)>0){
                $is_hdd_hide = 1;
            }else{
                $is_hdd_hide = 0;
            }
            $_newdata = array();
            $_newdata['site_id'] = $sql_result['id'];
            $_newdata['atmid'] = $sql_result['atmid'];
            $_newdata['bank'] = $sql_result['bank'];
            $_newdata['customer'] = $sql_result['customer'];
            $_newdata['zone'] = $sql_result['zone'];
            $_newdata['city'] = $sql_result['city'];
            $_newdata['state'] = $sql_result['state'];
            $_newdata['location'] = htmlspecialchars($sql_result['address']);
            $_newdata['status'] = $sql_result['status'];
            $_newdata['is_hdd_hide'] = $is_hdd_hide;
            array_push($dataArray,$_newdata); 
        
     }
}
 
if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>201,'bn'=>$_bank_name]);
}

echo json_encode($array);	

?>
							 
   