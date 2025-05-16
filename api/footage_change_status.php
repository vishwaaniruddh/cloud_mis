<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    date_default_timezone_set("Asia/Calcutta");   
    $date = date('Y-m-d H:i:s');
    $id = $_POST['footage_id'];
    $userid = $_POST['user_id'];
    $set_status = $_POST['status'];
    $status = $_POST['status'] ;
    $update = 0;$is_insert = 0;
    $finalstatus = 'Pending';

    if($_POST['status']=='Available'){
       $finalstatus = 'Close';
       $is_insert = 1;
    }
    if($_POST['status']=='ReSchedule'){
        $details = $_POST['details'];
        mysqli_query($con,"update eng_footage_request_history set created_by = '".$userid."',update_details='".$details."',created_at='".$date."' where id = '".$id."' AND update_status='Schedule'");
        $array = array(['Code'=>200,'msg'=>'Re-Scheduled Successfully']);
    }
    if($_POST['status']=='Schedule'){
        $footage_sql = mysqli_query($con,"select * from eng_footage_request_history where footage_id ='".$id."' AND update_status='Schedule'");
        if(mysqli_num_rows($footage_sql)==0){
            $is_insert = 1;
        }else{
            $array = array(['Code'=>203,'msg'=>'Already Scheduled']);
        }
    }
    if($_POST['status']=='Not Available'){
        $is_insert = 1;
    }
    
    if($is_insert==1){
        $details = $_POST['details'];
        if($status!='' && $id!=''){
            $update = 1;
            $statement = "insert into eng_footage_request_history(footage_id,update_status,update_details,created_by,created_at) values('".$id."','".$status."','".$details."','".$userid."','".$date."')" ;
        }
    }
    
    if($update==1){
        if(mysqli_query($con,$statement)){
            if(mysqli_query($con,"update footage_bulk_request set status = '".$finalstatus."' where id = '".$id."'")){
                	$array = array(['Code'=>200,'msg'=>'Status Updated Successfully.']);
            }else{
                	$array = array(['Code'=>201,'msg'=>'Unable to update status.']);
            } 
        }else{
            $array = array(['Code'=>202,'msg'=>'Something Went wrong try again.']);
        }
    }
    
    echo json_encode($array);		