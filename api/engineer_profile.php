<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');



date_default_timezone_set('Asia/Kolkata');
$datetime = date('Y-m-d H:i:s');

$userid = $_POST['userid'];
$name = $_POST['name'];
$qualification = $_POST['qualification'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$mob = $_POST['mobile'];
$created_by = $_POST['created_by'];


$checksql = mysqli_query($con,"select id from profile_details where user_id = '".$userid."' ");
$count = mysqli_num_rows($checksql);
// echo $count;

if($count==1)
{
    $update = mysqli_query($con,"update profile_details set name='".$name."', qualification='".$qualification."', dob='".$dob."', email='".$email."', contact='".$mob."', updated_by = '".$created_by."', updated_at = '".$datetime."' where user_id = '".$userid."' ");

    if($update)
    {
        $msg = ['msg' => 'Data Updated', 'code' => 200];
        echo json_encode($msg);
    }
    else
    {
        $msg = ['msg' => 'Something Wrong', 'code' => 500];
        echo json_encode($msg);
    }
}
else if($count==0)
{
    $insert = mysqli_query($con,"insert into profile_details(user_id,name,qualification,email,dob,contact,created_at,created_by) values ('".$userid."', '".$name."', '".$qualification."','".$email."', '".$dob."', '".$mob."', '".$datetime."', '".$created_by."') ");
    if($insert)
    {
        $msg = ['msg' => 'Data Inserted', 'code' => 200];
        echo json_encode($msg);
    }
    else
    {
        $msg = ['msg' => 'Something Wrong', 'code' => 500];
        echo json_encode($msg);
    }
    
}









