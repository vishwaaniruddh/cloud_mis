<?php 
    
    include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
    header('Access-Control-Allow-Origin: *');
    //header('Content-Type: application/json');
    
   
    
    date_default_timezone_set('Asia/Kolkata');
    $datetime = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    
    $data = $_POST;
// var_dump($_POST);

$cashier_id = $data['user_id'];

$fundreq_id = 0;
if(isset($data['fund_id'])){
  $fundreq_id = $data['fund_id'];
}
$eng_id = 0;
if(isset($data['eng_id'])){
  $eng_id = $data['eng_id'];
}
$approved_amount = 0;
if(isset($data['approved_amount'])){
  $approved_amount = $data['approved_amount'];
}
$txn_id = "";
if(isset($data['order_id'])){
  $txn_id = $data['order_id'];
}
$transfer_id = "";
if(isset($data['transfer_id'])){
  $transfer_id = $data['transfer_id'];
}
$order_status = "";
if(isset($data['order_status'])){
  $order_status = $data['order_status'];
}


$array = array();

$sql = "insert into eng_fundreq_transfer_payment_details(fundreq_id,eng_id,cashier_id,approved_amount,txn_id,transfer_id,txn_date,remark) values('".$fundreq_id."','".$eng_id."','".$cashier_id."','".$approved_amount."','".$txn_id."','".$transfer_id."','".$datetime."','".$order_status."')";
    
    if(mysqli_query($con,$sql)){ 
        $payment_order_id = $con->insert_id;
        
        if($fundreq_id>0){
            
            $msg = "Order Created Successfully";
            $array = array(['Code'=>200,'msg'=>$msg,'payment_id'=>$payment_order_id]);
            
        }else{
            $array = array(['Code'=>202]);
        }
    }else{
        $array = array(['Code'=>201]);
    }  	


            
    echo json_encode($array);		
  