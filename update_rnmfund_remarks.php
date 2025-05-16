<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
    $req_acc_no = $_POST['req_acc_no'];
    $checkboxid = $_POST['checkboxid'];
    $fund_details = $_POST['fund_details'];
    
    $remarks = $_POST['remarks'];
    
    $updatesql = "update rnm_fund SET fundDetails = '".$remarks."' WHERE status=6 and account_number = '".$req_acc_no."' and fundDetails='".$fund_details."'"; 
   
    mysqli_query($con,$updatesql); 
    
    $update_sql = "update mis_fund_transfer SET fundDetails = '".$remarks."' WHERE status=2 and account_number = '".$req_acc_no."' and fundDetails='".$fund_details."'"; 
   
    mysqli_query($con,$update_sql); 
    echo $remarks."_".$checkboxid;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>