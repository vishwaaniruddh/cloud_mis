<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');

$visitid = $_POST['visit_id'];

$images = $_POST['image_url'];
$testarray = array();
if(count($images)>0){
    for($i=0;$i<count($images);$i++){
        $key_name = $images[$i];
        $actualkey_name = $key_name;
        if($key_name=='AC_Connected_with_Relay'){
            $key_name = "ac_connected_with_relay";
            $actualkey_name = 'AC_Connected_with_Relay';
        }
        if($key_name=='Sinage_or_lolipop_Connected_to_Relay_Timing'){
            $key_name = "signage_connected_to_relay_timing";
            $actualkey_name = 'Sinage_or_lolipop_Connected_to_Relay_Timing';
        }
        if($key_name=="Lobby_light_Connected_to_Relay_Timing"){
            $key_name = "lolipop_or_lobby_light_connected_to_relay_timing";
            $actualkey_name = 'Lobby_light_Connected_to_Relay_Timing';
        }
        $url_link = "";
        $count_visit_query = mysqli_query($con,"select link from newcheckquality_videos_app where visitid='".$visitid."' AND filename='".$key_name."' order by id DESC LIMIT 1");
        if(mysqli_num_rows($count_visit_query)>0){
           $count_visit = mysqli_fetch_assoc($count_visit_query);
           $url_link = $count_visit['link'];
        }
        $_newdata = array();
        $_newdata['key'] = $actualkey_name;
        $_newdata['value'] = $url_link;
        array_push($testarray,$_newdata);
    }
}

$array = array('Code'=>200,'res_data'=>$testarray,'visit_id'=>$visitid);
echo json_encode($array);

?>