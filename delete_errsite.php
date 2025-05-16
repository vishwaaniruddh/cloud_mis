<? include('config.php');

if(mysqli_query($con,"truncate table site_status_error")){
    echo 1 ;
}else{
    echo 0;
}

?>