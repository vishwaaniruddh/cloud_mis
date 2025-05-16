<? session_start();
include('config.php');

if($_SESSION['username']){ 
    $reqid = $_POST['reqid'];
    $id = $_POST['id'];
    $checkboxid = $_POST['checkboxid'];
    $action_by = $_SESSION['userid'];
    
    $transferred_date = $_POST['transferred_date'];
    $transferred_date = date('Y-m-d',strtotime($transferred_date));
   
    $updatesql = "update mis_salary_fund_transfer SET transferred_date = '".$transferred_date."' WHERE req_id = ".$reqid; 
   
    mysqli_query($con,$updatesql); 
   
    echo $id."_".$checkboxid;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>