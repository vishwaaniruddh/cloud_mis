<? session_start();
include('config.php');  
date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)

$ip = $_SERVER['REMOTE_ADDR'];
$userid = $_SESSION['userid'];
$datetime = date('Y-m-d H:i:s'); 

if($ip && $userid){
    
    $sql = "insert into mis_logintrack(ip,userid,created_at) values('".$ip."','".$userid."','".$datetime."')";
    if(mysqli_query($con,$sql)){
        echo 1;
    } else{
        echo 0;
    }
}else{
    echo 2;
}
?>
