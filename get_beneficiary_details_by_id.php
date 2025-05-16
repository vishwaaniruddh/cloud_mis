<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
    $id = $_POST['id'];
    
    $fetchData = mysqli_query($con,"select id,beneficiary_name, account_number,ifsc_code from mis_fund_accounts where id = '".$id."'");
    
    $sql_result = mysqli_fetch_row($fetchData);
    $beneficiary_name = $sql_result[1];
    $acc_no = $sql_result[2];
    $ifsc = $sql_result[3];
    echo $beneficiary_name."_".$acc_no."_".$ifsc;
   
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>