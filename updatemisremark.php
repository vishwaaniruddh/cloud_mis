<? include('config.php');

$remark = $_POST['remark'];
$misid = $_POST['misid'];
$created_at = date('Y-m-d h:i:s');

if($remark){
    $sql = "insert into mis_history(mis_id,type,remark,created_at) values('".$misid."','remark','".$remark."','".$created_at."')";
    
    if(mysqli_query($con,$sql)){
        echo 1;
    }else{
        echo 0;
    }    
}else{
    echo 2;
}



?>