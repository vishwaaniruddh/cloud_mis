<?php 
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');

$fundreq_id = $_POST['id'];
$action_by = $_POST['user_id'];
$payment_id = $_POST['payment_id'];
$paid_status = 4;

$order_final_status = $_POST['order_status'];

$query_result = mysqli_query($con,"update eng_fundreq_transfer_payment_details SET  `remark`='".$order_final_status."' where id='".$payment_id."'");

if($order_final_status=='Success'){

    $query_result = mysqli_query($con,"update eng_fund_request SET  `req_status`='".$paid_status."' where id='".$fundreq_id."'");
    
    $fund_sql = mysqli_query($con,"select * from eng_fund_request_history where fundreq_id='".$fundreq_id."' order by id desc limit 1");
    $fund_data = mysqli_fetch_assoc($fund_sql);
    $requested_amt = $fund_data['requested_amount'];
    $approved_amt = $fund_data['approved_amount'];
                      
    $insertfundsql = "insert into eng_fund_request_history(fundreq_id, requested_amount,approved_amount,action_by,status,created_at,updated_at) values('".$fundreq_id."','".$requested_amt."','".$approved_amt."','".$action_by."',4,'".$created_at."','".$created_at."')" ; 
    mysqli_query($con,$insertfundsql);
    
    $array = array(['Code'=>200,'msg'=>'Payment Done']);
}
else{
   $array = array(['Code'=>200,'msg'=>'Payment cancelled']); 
}

 
echo json_encode($array);	

?>
