<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$visitid = $_POST['visit_id'];
$videodataArray = array();
$imgdataArray = array();
  
$imgsql = mysqli_query($con,"select * from newcheckquality_images_app where visitid = '".$visitid."' order by id DESC");
if(mysqli_num_rows($imgsql)>0){
   while($img_sql_data = mysqli_fetch_assoc($imgsql)){
        $img_data = array();
        $img_data['key_name'] = $img_sql_data['key_name'];
        $img_data['link'] = $img_sql_data['link'];
        array_push($imgdataArray,$img_data); 
   }
}

$videosql = mysqli_query($con,"select * from newcheckquality_videos_app where visitid = '".$visitid."' order by id DESC");
if(mysqli_num_rows($videosql)>0){
   while($video_sql_data = mysqli_fetch_assoc($videosql)){
        $video_data = array();
        $video_data['key_name'] = $video_sql_data['filename'];
        $video_data['link'] = $video_sql_data['link'];
        array_push($videodataArray,$video_data); 
   }
}

if(count($imgdataArray)>0){
	$array = array(['Code'=>200,'res_imgdata'=>$imgdataArray,'res_videodata'=>$videodataArray]);
}else{
	$array = array(['Code'=>500,'res_data' => "Something Wrong"]);
}

echo json_encode($array);