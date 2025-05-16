<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
    $id = $_POST['id'];
    $checkboxid = $_POST['checkboxid'];
    $action_by = $_SESSION['userid'];
    
    $remarks = $_POST['remarks'];
    
    $updatesql = "update rnm_fund_test SET remark = '".$remarks."' WHERE id = ".$id; 
   
    mysqli_query($con,$updatesql); 
    echo $remarks."_".$checkboxid;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>