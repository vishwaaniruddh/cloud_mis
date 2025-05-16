<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$branch_id = $_POST['branch_id'];

$usersql = mysqli_query($con,"select id,name from mis_loginusers where branch IN ('".$branch_id."')");
$dataarray = array();
if(mysqli_num_rows($usersql)>0){
   while($userdata = mysqli_fetch_assoc($usersql)){
       $_newdata = array();
       $_newdata['id'] = $userdata['id'];
       $_newdata['name'] = $userdata['name'];
       array_push($dataarray,$_newdata);
   }
}

echo json_encode($dataarray);	