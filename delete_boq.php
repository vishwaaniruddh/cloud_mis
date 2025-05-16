<? include('config.php');

$id = $_REQUEST['id'];

$sql = "update boq set status=0 where id='".$id."'";  

if(mysqli_query($con,$sql)){
    echo 1;
}else{
    echo 0;
}

?>