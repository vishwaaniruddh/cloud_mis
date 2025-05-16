<?php 

        include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
        header('Access-Control-Allow-Origin: *');
        
        date_default_timezone_set('Asia/Kolkata');
        $created_at = date('Y-m-d H:i:s');
        $datetime = $created_at;
        $data = $_POST;
  
        $_videofilename = $data['videos_name'];
        $atmid = $_POST['atm_id'];
        $eng_id = $_POST['eng_id'];
        
        $name = 0;
        
        $target_filedir =  "../pmcreportuploadvideoapp/".$atmid.'/'; 
        $target_dir = "pmcreportuploadvideoapp/".$atmid.'/';
            if (!file_exists($target_filedir)) {
                mkdir($target_filedir, 0777, true);
            }
        $path = $_FILES["videos"]["name"][$name];
          //  var_dump($path);
            $video_name = $_videofilename[$name];
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        $noerrv = 0;$errv = 0;
        
       $extensions_arr = array("mp4", "mpeg");
        
            $filename = time() . "_" . $name . "." . $ext;
        
            $target_file = $target_filedir . $filename;
            
          
            
        $visit_id = 1;
        
        if (in_array($ext, $extensions_arr)) {
    
            $size = $_FILES['videos']['size'][$name];
            
            if(move_uploaded_file($_FILES["videos"]["tmp_name"][$name], $target_file)) {
                $noerrv = $noerrv + 1;
               
                $select_qry = "SELECT * from pmcreport_upload_videos_app WHERE img_name='".$video_name."' AND atmid='".$atmid."'";
                $query_result = mysqli_query($con,$select_qry);
                if(mysqli_num_rows($query_result)>0){
                    $del_qry = "DELETE FROM pmcreport_upload_videos_app WHERE img_name='".$video_name."' AND atmid='".$atmid."'";
                    mysqli_query($con,$del_qry);
                }
                
                $link = 'https://sarsspl.com/css/dash/esir/'.$target_dir. $filename ; 
                $_ins_sql = "insert into pmcreport_upload_videos_app(img,img_name,eng_id,atmid,created_at) values('".$link."','".$video_name."','".$eng_id."','".$atmid."','".$datetime."')" ; 
                mysqli_query($con,$_ins_sql);
                
            }  else if (($size >= $maxsize) || ($size == 0)) {
                $errmsg = "File too large. File must be less than 15MB.";
                $errv = $errv + 1;
            } else {
                $errmsg = "Something went wrong.";
                $errv = $errv + 1;
            }
        }
        
        if($noerrv>0){
            $msg = $noerrv." Files uploaded successfully."; 
            $array = array(['Code'=>200,'msg'=>$msg]);
        }else{
            $msg = "Sorry, there was an error uploading ".$errv." file."; 
            $array = array(['Code'=>201,'msg'=>$msg]);
        }
        
        echo json_encode($array);
        
        
        
      
?>