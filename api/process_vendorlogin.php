<?php session_start();

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


$uname = $_POST['username'];
$password =$_POST['password'];
if(isset($_POST['mac_id'])){
$mac_id =$_POST['mac_id'];
}else{
  $mac_id = "";  
}

if($uname!='' && $password!=''){
    $sql = mysqli_query($con,"select * from mis_loginvendors where uname = '".$uname."' and pwd='".$password."'");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
            $id = $sql_result['id'];
            $name = $sql_result['name']; 
            $uname = $sql_result['uname']; 
            if($mac_id!=''){
        		mysqli_query($con,"update mis_loginvendors set mac_id='".$mac_id."' where id = '".$id."'");
        	}
            
            $data=['userid'=>$id,'name'=>$name,'uname'=>$uname,'is_login'=>1];
        }else{
            $data = ['is_login'=>0,'msg'=>'You are inactive'];
        }
        
        echo json_encode($data);
            
    }
    else{
        $data = ['is_login'=>0,'msg'=>'Incorrect Username or password'];
        echo json_encode($data);
    }

}else{
    $data = ['is_login'=>2,'msg'=>'Must Required Username and password'];
    echo json_encode($data);
}
?>