<? include('config.php');

$id = $_POST['id'];

if($id>0){
    $user_sql = mysqli_query($con,"select status from newcheckquality where id ='".$id."'"); 
    $user_data = mysqli_fetch_assoc($user_sql);
    $current_user_status = $user_data['status'];
    // if($current_user_status==0){
    //     $status = 1;
    // }
    if($current_user_status==1){
        $status = 2;
    }

    $sql = "update newcheckquality set status='".$status."' where id ='".$id."'";
    if(mysqli_query($con,$sql)){
        echo 1;
    }else{
        echo 0;
    }
}else{
    echo 0;
}

?>