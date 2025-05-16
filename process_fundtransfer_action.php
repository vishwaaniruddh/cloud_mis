<? session_start();
include('config.php');

if($_SESSION['username']){ 
    $req_id = $_POST['reqid'];
    $id = $_POST['id'];
    $checkboxid = $_POST['checkboxid'];
    $action_by = $_SESSION['userid'];
    
    $remarks = $_POST['remarks'];
    
    $status = 10;
    
    $_sql="select * from mis_fund_requests where req_id=".$req_id." order by id desc";
    $table=mysqli_query($con,$_sql);
    $row = mysqli_fetch_row($table);
    
    $req_amt = $row[2];
    $approved_amt = $row[3];
    $action = 0;
    $created_date = date('Y-m-d');
    
    $sql = "insert into mis_fund_requests(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
            values('".$req_id."','".$req_amt."','".$approved_amt."','".$action_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
    mysqli_query($con,$sql);  
    
    $updatesql = "update mis_fund_transfer SET remarks = '".$remarks."', status= '".$status."', action_by= '".$action_by."' WHERE id = ".$id; 
   
    mysqli_query($con,$updatesql); 
    echo $id."_".$checkboxid;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>