<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set("Asia/Calcutta");   
$date = date('Y-m-d H:i:s');
$id = $_POST['mis_detail_id'];
$userid = $_POST['user_id'];

//$array = array(['Code'=>200,'msg'=>$_POST]);echo json_encode($array);	

$update = 0;
        if($_POST['status']=='dispatch' || $_POST['status']=='MRS' || $_POST['status'] =='permission_require' || $_POST['status']=='broadband' || $_POST['status']=='material_not_available' || $_POST['status'] =='material_available_in_branch'){
            
            $remark = $_POST['remark'];
            $status = $_POST['status'] ;
            if($remark!='' && $id!=''){
                $update = 1;
               $statement = "insert into mis_history(mis_id,type,remark,status,created_at,created_by) values('".$id."','".$status."','".$remark."','1','".$date."','".$userid."')" ;
            }
        }elseif($_POST['status']=='schedule'){
            $status = $_POST['status'] ;
            $engineer = $_POST['engineer'];
            $remark = $_POST['remark'];
            $schedule_date = $_POST['schedule_date']; 
            if($engineer!='' && $schedule_date!='' && $remark!='' && $id!=''){
            $update = 1;
            $statement = "insert into mis_history(mis_id,type,engineer,remark,schedule_date,status,created_at,created_by) values('".$id."','".$status."','".$engineer."','".$remark."','".$schedule_date."','1','".$date."','".$userid."')" ;
            }
        }elseif($_POST['status']=='material_requirement'){
            $address = $_POST['address'];
            $status = $_POST['status'] ;
            $material = $_POST['material'];
            $material_condition = $_POST['material_condition'];
            $remark = $_POST['remark'];
            if($address!='' && $material!='' && $material_condition!='' && $remark!=''){
            $statement = "insert into mis_history(mis_id,type,material,material_condition,remark,status,created_at,created_by,delivery_address) values('".$id."','".$status."','".$material."','".$material_condition."','".$remark."','1','".$date."','".$userid."','".$address."')" ;
            $update = 1;
            mysqli_query($con,"insert into material_inventory(mis_id,material,material_condition,remark,status,created_at,created_by,delivery_address) values('".$id."','".$material."','".$material_condition."','".$remark."','1','".$date."','".$userid."','".$address."')");
            }
        }elseif($_POST['status']=='material_dispatch'){
            $status = $_POST['status'] ;
            $courier = $_POST['courier'];
            $pod = $_POST['pod'];
            $dispatch_date = $_POST['dispatch_date'];
            $remark = $_POST['remark'];
            if($courier!='' && $pod!='' && $remark!='' && $id!='' && $dispatch_date!=''){
                $update = 1;
                $statement = "insert into mis_history(mis_id,type,courier_agency,pod,dispatch_date,remark,status,created_at,created_by) values('".$id."','".$status."','".$courier."','".$pod."','".$dispatch_date."','".$remark."','1','".$date."','".$userid."')" ;
            }
        }elseif($_POST['status']=='material_delivered'){
            $status = $_POST['status'] ;
            $delivery_date = $_POST['delivery_date'];
             if($id!='' && $delivery_date!=''){
                $update = 1;
                $statement = "insert into mis_history(mis_id,type,status,created_at,created_by,delivery_date) values('".$id."','".$status."','1','".$date."','".$userid."','".$delivery_date."')" ;
             }
        }elseif($_POST['status']=='paste_control'){
            $status = $_POST['status'] ;
            
            if(!is_dir('../close_uploads/'.$year .'/'. $month.'/'.$atmid)){
                mkdir('../close_uploads/'.$year .'/'. $month .'/'.$atmid , 0777 , true) ; 
            }
            $target_dir = '../close_uploads/'.$year .'/'. $month.'/'. $atmid ;

            $image = $_FILES['image']['name'];
             if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .'/' .$image )) {
                $link  = $target_dir . '/' .$image ;
                $remark = $_POST['remark'];
                $statement = "insert into mis_history(mis_id,type,status,created_at,created_by,attachment) values('".$id."','".$status."','1','".$date."','".$userid."','".$link."')" ;
             }   
        }elseif($_POST['status']=='close'){
            $status = $_POST['status'] ;
            $atmid = $_POST['atmid'];
            $year = date('Y');
            $month = date('m');
            $close_date = date('Y-m-d');
            $close_type = $_POST['close_type'];
            if(!is_dir('../close_uploads/'.$year .'/'. $month.'/'.$atmid)){
                mkdir('../close_uploads/'.$year .'/'. $month .'/'.$atmid , 0777 , true) ; 
            }
            $target_dir = '../close_uploads/'.$year .'/'. $month.'/'. $atmid ;
            $link_target_dir = 'close_uploads/'.$year .'/'. $month.'/'. $atmid ;
            $link = "";
            $time = strtotime(date("Y-m-d H:i:s"));
            $image = $time."_".$_FILES['image']['name'];
             if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .'/' .$image )) {
                $link  = $link_target_dir . '/' .$image ;
                
             }
             
             $remark = $_POST['remark'];
              if($atmid!='' && $close_type!='' && $remark!='' && $id!=''){
                $update = 1;
                $statement = "insert into mis_history(mis_id,type,attachment,remark,status,created_at,created_by,close_type) values('".$id."','".$status."','".$link."','".$remark."','1','".$date."','".$userid."','".$close_type."')" ;
                 mysqli_query($con,"update mis_details set close_date = '".$close_date."' where id = '".$id."'");
              }
        }
        if($update==1){
            if(mysqli_query($con,$statement)){
                if(mysqli_query($con,"update mis_details set status = '".$status."' where id = '".$id."'")){
                    	$array = array(['Code'=>200,'msg'=>'Status Updated Successfully.']);
                }else{
                    	$array = array(['Code'=>201,'msg'=>'Unable to update status.']);
                }
            }else{
                $array = array(['Code'=>202,'msg'=>'Something Went wrong try again.']);
            }
        }else{
                $array = array(['Code'=>204,'msg'=>'Something Went wrong try again.']);
            }
        
        echo json_encode($array);		