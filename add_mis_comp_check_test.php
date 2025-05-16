<?php session_start();
include('config.php');

if($_SESSION['username']){ 
    $atm_id = $_POST['atmid'];
    $component = $_POST['component'];
    $subcomponent = $_POST['subcomponent'];
    $status = 0;
    $_sql="select status from mis_details where atmid='".$atm_id."' and component='".$component."' and subcomponent='".$subcomponent."' and status!='close' order by id desc";
    $table=mysqli_query($con,$_sql);
    if(mysqli_num_rows($table)){
        while($row = mysqli_fetch_assoc($table)){
            // if($row['status']!='close' || $row['status']!='Close'){
                $status = 1;
                // $status .= " and ".$_sql; 
            // }
            
        }
    
    }
    
    echo $status;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>