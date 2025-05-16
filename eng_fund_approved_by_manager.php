<? session_start();
include('config.php');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');

if($_SESSION['username']){ 
    $action_by = $_SESSION['userid'];
    $fund_id = $_POST['fund_req_id'];
    $approved_amt = $_POST['approved_amt'];
    $fund_remarks = $_POST['fund_remarks'];
    
    $remarks = $_POST['remarks'];
    
    $updatesql = "update eng_fund_request SET approved_amount = '".$approved_amt."',req_status= 3 WHERE id='".$fund_id."'"; 
   
    mysqli_query($con,$updatesql); 
    
    $fund_sql = mysqli_query($con,"select * from eng_fund_request_history where fundreq_id='".$fund_id."' order by id desc limit 1");
    $fund_data = mysqli_fetch_assoc($fund_sql);
    $requested_amt = $fund_data['requested_amount'];
  //  $approved_amt = $approved_amt;
                      
    $insertfundsql = "insert into eng_fund_request_history(fundreq_id, requested_amount,approved_amount,action_by,status,created_at,updated_at) values('".$fund_id."','".$requested_amt."','".$approved_amt."','".$action_by."',3,'".$created_at."','".$created_at."')" ; 
    mysqli_query($con,$insertfundsql);
    echo $fund_id;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>