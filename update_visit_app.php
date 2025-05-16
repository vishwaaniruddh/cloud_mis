<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $updatesql = "update mis_newvisit_app_test SET status = '".$status."' WHERE id = ".$id; 
   
    mysqli_query($con,$updatesql); 
    echo '1';
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>