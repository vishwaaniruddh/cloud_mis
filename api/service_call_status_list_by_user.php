<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

$today = date('Y-m-d');
$date = date('Y-m-d');
$date1 = date_create($date);

function get_mis_history($parameter, $type, $id,$con)
    {
        $sql = mysqli_query($con, "select $parameter from mis_history where type='" . $type . "' and mis_id='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);

        return $sql_result[$parameter];
    }

$userid = $_POST['user_id'];
$mis_status = $_POST['mis_status'];

$service_callsql = mysqli_query($con,"select m.atmid,m.bank,m.customer,m.zone,m.city,m.state,m.location,md.status,md.id,md.subcomponent,md.created_at,m.created_by,m.call_receive_from from mis m,mis_details md where m.id = md.mis_id AND md.status='".$mis_status."' AND md.atmid IN (select atmid FROM mis_newsite WHERE engineer_user_id='".$userid."')");
	$dataArray = array();
//$service_callsql = mysqli_query($con,"SELECT COUNT(id) AS count,status FROM `mis_details` WHERE status IN ('material_dispatch','material_in_process','material_requirement','Open','schedule','close') AND atmid IN (select atmid FROM mis_newsite WHERE engineer_user_id='".$userid."') GROUP BY status");

$totalservice_call = mysqli_num_rows($service_callsql);
if($totalservice_call>0){
    while($sql_result = mysqli_fetch_assoc($service_callsql)){
        $_newdata = array();
                   $id = $sql_result['id'];
    	            $_newdata['mis_detail_id'] = $sql_result['id'];
    			   $_newdata['atmid'] = $sql_result['atmid'];
    			    $_newdata['bank'] = $sql_result['bank'];
    			     $_newdata['customer'] = $sql_result['customer'];
    			      $_newdata['zone'] = $sql_result['zone'];
    			       $_newdata['city'] = $sql_result['city'];
    			        $_newdata['state'] = $sql_result['state'];
    			         $_newdata['location'] = htmlspecialchars($sql_result['location']);
    			      //   $_newdata['status'] = $sql_result['status'];
    			      //   $_newdata['branch_id'] = $call_branch_id;
    			         $_newdata['subcomponent'] = $sql_result['subcomponent'];
    			         
    			         $date2=date_create($sql_result['created_at']);
                         $diff=date_diff($date1,$date2);
                         $_newdata['down_time'] = $diff->format("%a days");
                         $_newdata['aging'] = $diff->format("%a");
                         $_id = $sql_result['created_by'];
                         $user_sql = mysqli_query($con,"select * from mis_loginusers where id ='".$_id."'");
                         $created_by_name = "";
                         if(mysqli_num_rows($user_sql)>0){
                           $user_sql_result = mysqli_fetch_assoc($user_sql);
                           $created_by_name = $user_sql_result['name'];
                         }
                         $_newdata['created_by'] = $created_by_name;
                         $_newdata['call_receive_from'] = $sql_result['call_receive_from'];
                         $material = "";
                         if($mis_status=='material_requirement' || $mis_status=='material_dispatch' || $mis_status=='material_in_process'){
                             /*if($mis_status=='material_in_process'){
                                 $mis_status = "material_requirement";
                             }*/
                            $mis_status = "material_requirement";
                            $material = get_mis_history('material', $mis_status, $id, $con); 
                         }
                         $_newdata['material'] = $material;
    			         array_push($dataArray,$_newdata);  
    }
}

if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);
