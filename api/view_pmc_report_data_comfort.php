<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$id = $_POST['site_id'];
$dataArray = array();
$videodataArray = array();
$imgdataArray = array();
$sql = mysqli_query($con,"select * from pmc_report_test where id = '".$id."' order by id DESC");
if(mysqli_num_rows($sql)>0){
        $sql_data = mysqli_fetch_assoc($sql);
        $data = array();
        $data['atmid'] = $sql_data['atmid'];
        $visitid = $sql_data['visit_id'];
        $data['visit_id']   = $visitid;
        $data['form_start_time']   = $sql_data['form_start_time'];
        $data['form_end_time']   = $sql_data['form_end_time'];
        $data['status']   = $sql_data['status'];
        $data['created_at']   = $sql_data['created_at'];
        $data['question_list'] = $sql_data['question_list'];
        
        array_push($dataArray,$data); 
         
        $imgsql = mysqli_query($con,"select * from pmcreport_images_app_test where visitid = '".$visitid."' order by id DESC");
        if(mysqli_num_rows($imgsql)>0){
           while($img_sql_data = mysqli_fetch_assoc($imgsql)){
                $img_data = array();
                $img_data['key_name'] = $img_sql_data['filename'];
                $img_data['link'] = $img_sql_data['link'];
                array_push($imgdataArray,$img_data); 
           }
        }
        
        $videosql = mysqli_query($con,"select * from pmcreport_videos_app where visitid = '".$visitid."' order by id DESC");
        if(mysqli_num_rows($videosql)>0){
           while($video_sql_data = mysqli_fetch_assoc($videosql)){
                $video_data = array();
                $video_data['key_name'] = $video_sql_data['filename'];
                $video_data['link'] = $video_sql_data['link'];
                array_push($videodataArray,$video_data); 
           }
        }
   
}


if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray,'res_imgdata'=>$imgdataArray,'res_videodata'=>$videodataArray]);
}else{
	$array = array(['Code'=>500,'res_data' => "Something Wrong"]);
}

echo json_encode($array);	

?>