<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
    $req_id = $_POST['req_id'];
    $req_amt = $_POST['req_amt'];
    $approved_amt = $_POST['approved_amt'];
    $created_by = $_SESSION['userid'];
    $action = $_POST['action'];
    $remarks = $_POST['remarks'];
    $created_date = date('Y-m-d');
    $status = $_POST['status'];
    if($action==1){
        if($status==3){
            if($req_amt<=500){
                $status = 4;
            }
        }
        if($status==4){
            if($req_amt<=2000){
                $status = 4;
            }
        }
    }
    $sql = "insert into mis_fund_requests_test(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
            values('".$req_id."','".$req_amt."','".$approved_amt."','".$created_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
    mysqli_query($con,$sql);
    
    $updatesql = "update rnm_fund_test SET required_amount = '".$req_amt."', status= '".$status."' WHERE id = ".$req_id; 
   
    mysqli_query($con,$updatesql); 
    echo $req_id."_".$action;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>