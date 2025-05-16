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


$visit_id = 12055;
$atmid = "B1494700";
$target_filedir =  "../pmcreportapp/".$visit_id.'/'; 
        $target_dir = "pmcreportapp/".$visit_id.'/';
        if (!file_exists($target_filedir)) {
            mkdir($target_filedir, 0777, true);
        }
        
        $count_visit_video_query = mysqli_query($con,"select * from pmcreport_upload_videos_app WHERE atmid='".$atmid."'");
        $file_cpy = 0;
        $_name = 0;
        $file_cnt = mysqli_num_rows($count_visit_video_query);
        while($count_visit_video = mysqli_fetch_assoc($count_visit_video_query)) {
        
            $video_name = $count_visit_video['img_name']; 
            $img_file = $count_visit_video['img']; 
            $explode_img_url = explode("esir",$img_file);
            
            $filename_explode = explode("/",$explode_img_url[1]);
            
            $filename = $filename_explode[count($filename_explode) - 1];
            
          //  $source_file =  __DIR__ .$explode_img_url[1];
        //    $destination_file =  __DIR__ .$target_filedir . $filename;
           // $filename = "_Lobby_Temperature_0.jpg";
           $source_file = "..".$explode_img_url[1];
           $destination_file = $target_filedir . $filename;
            
        /*    
           if (file_exists($source_file)) {
                echo "Source exists<br>";
            } else {
                echo "Source does NOT exist<br>";
            }
            
            if (is_writable(dirname($destination_file))) {
                echo "Destination folder is writable<br>";
            } else {
                echo "Destination folder is NOT writable<br>";
            }
          
           $check_cpy = copy($source_file, $destination_file);
           echo $check_cpy;die;
            
            $in  = fopen($source_file, 'rb');
            $out = fopen($destination_file, 'wb');
            
            $video_uploaded = 0;
            
            if ($in && $out) {
                while (!feof($in)) {
                    fwrite($out, fread($in, 8192));
                }
                fclose($in);
                fclose($out);
                $video_uploaded = 1;
            } 
            
            echo $video_uploaded;die;  */
            
            if (copy($source_file, $destination_file)) {
                $noerr = $noerr + 1;
                $file_cpy = $file_cpy + 1;
                
                $link = 'https://sarsspl.com/css/dash/esir/'.$target_dir. $filename ; 
                
                $sql = "insert into pmcreport_videos_app(visitid, name,filename,link,status,created_at) values('" . $visit_id . "','" . $_name . "','".$video_name."','" . $link . "','1','" . $datetime . "')";
                mysqli_query($con, $sql);
                $_name = $_name + 1;
            } else {
                $err = $err + 1;
            }
        
        }
        
        if($file_cpy==$file_cnt){
           $path = "../pmcreportuploadvideoapp/".$atmid;
          delfolder($path);
        }
        
        die;
        
        
        ?>