<?php 
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');

$user_id = $_POST['user_id'];
$mac_id = $_POST['mac_id'];
$location = $_POST['location'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$created_time = $_POST['created_time'];

    $statement = "select created_time from eng_locations where user_id='".$user_id."' order by id desc limit 1";
                                             
    $sqle = mysqli_query($con,$statement);
    $sql_result = mysqli_fetch_assoc($sqle);
   
    $usercreated_time = $sql_result['created_time'];
    $created_date = date("Y-m-d", strtotime($usercreated_time)); 
    
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $start_date = new DateTime($datetime);  //var_dump( $start_date)."<br>";
    $since_start = $start_date->diff(new DateTime($usercreated_time));
   
    $hr = $since_start->h;
     $insert = 0; 
    if($date == $created_date) {
        if($hr>=1)
        {
           $insert = 1;     
            	
        }
    }else{
         $insert = 1;  
    }
    
    if($insert==1){
        $sql = "insert into eng_locations(user_id,mac_id,location,latitude,longitude,created_time) values('".$user_id."','".$mac_id."','".$location."','".$latitude."','".$longitude."','".$created_time."')";
            
        if(mysqli_query($con,$sql)){ 
                $array = array(['Code'=>200]);
        }else{
            	$array = array(['Code'=>201]);
        }  
    }else{
        $array = array(['Code'=>201,'time' => $since_start]);
    }
echo json_encode($array);		