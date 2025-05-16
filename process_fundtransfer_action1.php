<? session_start();
include('config.php');

if($_SESSION['username']){ 
    $reqid = $_POST['reqid'];
    $id = $_POST['id'];
    $checkboxid = $_POST['checkboxid'];
    $action_by = $_SESSION['userid'];
    
    $remarks = $_POST['remarks'];
    
    $status = 8;
    
    $_fundsql = "select fundDetails,account_number,trans_id from mis_fund_transfer where req_id='".$reqid."'";
    $_fundtable=mysqli_query($con,$_fundsql);
    $_fundrow = mysqli_fetch_row($_fundtable);
    $fundDetails = $_fundrow[0];
    $accno = $_fundrow[1];
    $transid = $_fundrow[2];
    
    $_transql="select req_id from mis_fund_transfer where trans_id='".$transid."' and fundDetails='".$fundDetails."' and account_number='".$accno."' order by id desc";
    $trantable=mysqli_query($con,$_transql);
    while($tranrow = mysqli_fetch_array($trantable)){
    $req_id = $tranrow[0];
    $_sql="select * from mis_fund_requests where req_id='".$req_id."' order by id desc limit 1";
    $table=mysqli_query($con,$_sql);
    $row = mysqli_fetch_row($table);
    
    $req_amt = $row[2];
    $approved_amt = $row[3];
    $action = 0;
    $created_date = date('Y-m-d');
    
    $sql = "insert into mis_fund_requests(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
            values('".$req_id."','".$req_amt."','".$approved_amt."','".$action_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
    mysqli_query($con,$sql);  
    
    $updatesql = "update mis_fund_transfer SET remarks = '".$remarks."', current_status= 0, action_by= '".$action_by."', rejected_date= '".$created_date."' WHERE req_id = ".$req_id; 
   
    mysqli_query($con,$updatesql); 
    }
    echo $id."_".$checkboxid;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>