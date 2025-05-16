<? include('config.php');

$id = $_POST['id'];

if($id>0){
    $call_status_sql = mysqli_query($con,"select status from mis_status where id ='".$id."'"); 
    $call_status_data = mysqli_fetch_assoc($call_status_sql);
    $current_call_status = $call_status_data['status'];
    if($current_call_status==0){
        $status = 1;
    }else{
       $status = 0; 
    }
    $sql = "update mis_status set status='".$status."' where id ='".$id."'";
    if(mysqli_query($con,$sql)){
        echo 1;
    }else{
        echo 0;
    }
}else{
    echo 0;
}

?>