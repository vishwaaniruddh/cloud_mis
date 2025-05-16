<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
    $trans_id = $_POST['id'];
    
    $missql = "select account_number from mis_salary_fund_transfer where id=".$trans_id;
    $mis_table=mysqli_query($con,$missql);
    $row=mysqli_fetch_row($mis_table);                                        	    
    
    $req_acc_no = $row[0];
   // $fund_details = $row[1];
    
    $remarks = $_POST['fund_remark'];
    
   // $updatesql = "update rnm_fund SET fund_remark = '".$remarks."' WHERE status=6 and account_number = '".$req_acc_no."' and fundDetails='".$fund_details."'"; 
   
  //  mysqli_query($con,$updatesql); 
    
   // $update_sql = "update mis_salary_fund_transfer SET fund_remark = '".$remarks."' WHERE status=2 and account_number = '".$req_acc_no."' and fundDetails='".$fund_details."'";
    $update_sql = "update mis_salary_fund_transfer SET fund_remark = '".$remarks."' WHERE status=2 and account_number = '".$req_acc_no."'";
   
    mysqli_query($con,$update_sql); 
    echo 1;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>