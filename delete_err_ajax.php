<? include('config.php');

if(mysqli_query($con,"truncate table mis_newsitetest_err")){
    echo 1 ;
}else{
    echo 0;
}

?>