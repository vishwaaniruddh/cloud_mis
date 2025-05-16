<? include('config.php');

$id = $_POST['id'];

if($id>0){
    $sql = "update mis_newsite set status=0 where id ='".$id."'";
    if(mysqli_query($con,$sql)){
        echo 1;
    }else{
        echo 0;
    }
}else{
    echo 0;
}

?>