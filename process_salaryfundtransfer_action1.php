<? session_start();
include('config.php');

if($_SESSION['username']){ 
    $reqid = $_POST['reqid'];
    $id = $_POST['id'];
    $checkboxid = $_POST['checkboxid'];
    $action_by = $_SESSION['userid'];
    
    $remarks = $_POST['remarks'];
    
    $status = 8;
    
    $_fundsql = "select fundDetails,account_number,amount from mis_salary_fund_transfer where req_id='".$reqid."'";
    $_fundtable=mysqli_query($con,$_fundsql);
    $_fundrow = mysqli_fetch_row($_fundtable);
    $fundDetails = $_fundrow[0];
    $accno = $_fundrow[1];
   
    
    $amount = $_fundrow[2];
    $action = 0;
    $created_date = date('Y-m-d');
    
    $sql = "insert into mis_salary_fund_requests(req_id,amount,created_by,action,remarks,created_date,status) 
            values('".$reqid."','".$amount."','".$action_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
    mysqli_query($con,$sql);  
    
    $updatesql = "update mis_salary_fund_transfer SET remarks = '".$remarks."', current_status= 0, action_by= '".$action_by."', rejected_date= '".$created_date."' WHERE req_id = '".$reqid."'"; 
   
    mysqli_query($con,$updatesql); 
  
    echo $id."_".$checkboxid;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>