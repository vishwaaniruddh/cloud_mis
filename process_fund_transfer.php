<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
    $chq_no = $_POST['chq_no'];
    $transferred_date = $_POST['transferred_date'];
    $trans_id = $_POST['trans_id'];
    
    $updatesql = "update mis_fund_transfer SET chq_no = '".$chq_no."', transferred_date= '".$transferred_date."' WHERE trans_id = ".$trans_id; 
   
    mysqli_query($con,$updatesql); 
    echo 1;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>