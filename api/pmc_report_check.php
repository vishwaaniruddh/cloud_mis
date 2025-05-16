<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');
$datetime = $created_at;

function delfolder($path) {
   $files = array_diff(scandir($path), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$path/$file")) ? delfolder("$path/$file") : unlink("$path/$file");
    }
    return rmdir($path);
} 

//$path = "../pmcreportappchecknow/123";


$visit_id = 123;

$count_visit_image_query = mysqli_query($con,"select * from pmcreport_upload_images_app WHERE atmid='5656'");
//echo mysqli_num_rows($count_visit_image_query);

$target_filedir =  "../pmcreportappchecknow/".$visit_id.'/'; 
$target_dir = "pmcreportappchecknow/".$visit_id.'/';
if (!file_exists($target_filedir)) {
    mkdir($target_filedir, 0777, true);
}

$file_cpy = 0;
$file_cnt = mysqli_num_rows($count_visit_image_query);
if($file_cnt>0){
    while($count_visit_image = mysqli_fetch_assoc($count_visit_image_query)){
        $image_name = $count_visit_image['img_name']; 
        $img_file = $count_visit_image['img']; 
        $explode_img_url = explode("esir",$img_file);
        
        $filename_explode = explode("/",$explode_img_url[1]);
        
        $filename = $filename_explode[count($filename_explode) - 1];
        
       // $filename = "_Lobby_Temperature_0.jpg";
        $source_file = "..".$explode_img_url[1];
        $destination_file = $target_filedir . $filename;
        //$ch = move_uploaded_file($source, $target_file);
        if (copy($source_file, $destination_file)) {
            
            $file_cpy = $file_cpy + 1;
            
            $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
            if($image_name=='FSR Copy'){
                $_get_detail = "SELECT bank,atmid FROM mis_newsite WHERE atmid = (SELECT atmid FROM `pmc_report` WHERE visit_id='".$visit_id."')";
                $_getsql = mysqli_query($con,$_get_detail);
                if(mysqli_num_rows($_getsql)>0){
                   $getsql_result = mysqli_fetch_assoc($_getsql);
                   $_atmid = $getsql_result['atmid'];
                   $_bank = $getsql_result['bank'];
                   $_ins_sql = "insert into view_pmc_report_fsr_image(atmid, visit_id,bank,link,created_at) values('".$_atmid."','".$visit_id."','".$_bank."','".$link."','".$datetime."')" ; 
                   mysqli_query($con,$_ins_sql);
                }
                
            }  
            $sql = "insert into pmcreport_images_app(visitid, name,filename,link,status,created_at) values('".$visit_id."','".$name."','".$image_name."','".$link."','1','".$datetime."')" ; 
            mysqli_query($con,$sql);
            
        }else{
            
        }
    }
    
    if($file_cpy==$file_cnt){
      delfolder($path);
    }
}
/*
while($count_visit_image = mysqli_fetch_assoc($count_visit_image_query)){
    
}
*/