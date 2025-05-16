<?php 

        include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
        header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        
        date_default_timezone_set('Asia/Kolkata');
        $created_at = date('Y-m-d H:i:s');
        $datetime = $created_at;
        
        $atmid = $_POST['atm_id'];
        $eng_id = $_POST['eng_id'];
        $_imagefilename = $_POST['image_name'][0];
        
        $target_filedir =  "../pmcreportuploadimageapp/".$atmid.'/'; 
        $target_dir = "pmcreportuploadimageapp/".$atmid.'/';
            if (!file_exists($target_filedir)) {
                mkdir($target_filedir, 0777, true);
            }
        $path = $_FILES["image"]["name"];
        $img_ext = explode(".",$path[0]);
        $ext = $img_ext[1];
        
        $name = 0;
        
        
        
      //  $ext = pathinfo($path, PATHINFO_EXTENSION);
      //  $filename = time()."_".$name.".".$ext; 
      
        
        $new_imagefilename = str_replace(' ', '_', $_imagefilename);
        
        $filename = $new_imagefilename."_".$name.".".$ext;
        $noerr = 0;$err = 0;
        
        $target_file = $target_filedir . $filename;
        if (move_uploaded_file($_FILES["image"]["tmp_name"][0], $target_file)) {
            $noerr = $noerr + 1;
            
            $select_qry = "SELECT * from pmcreport_upload_images_app WHERE img_name='".$_imagefilename."' AND atmid='".$atmid."'";
            $query_result = mysqli_query($con,$select_qry);
            if(mysqli_num_rows($query_result)>0){
                $del_qry = "DELETE FROM pmcreport_upload_images_app WHERE img_name='".$_imagefilename."' AND atmid='".$atmid."'";
                mysqli_query($con,$del_qry);
            }
            
            $link = 'https://sarsspl.com/css/dash/esir/'.$target_dir. $filename ; 
            $_ins_sql = "insert into pmcreport_upload_images_app(img,img_name,eng_id,atmid,created_at) values('".$link."','".$_imagefilename."','".$eng_id."','".$atmid."','".$datetime."')" ; 
            mysqli_query($con,$_ins_sql);
        }else {
            $err = $err + 1;
        }
        
        if($noerr>0){
            $msg = $noerr." Files uploaded successfully."; 
            $array = array(['Code'=>200,'msg'=>$msg]);
        }else{
            $msg = "Sorry, there was an error uploading ".$err." file."; 
            $array = array(['Code'=>201,'msg'=>$msg]);
        }
        
        echo json_encode($array);
        
       // echo json_encode(['path'=>$path,'ext'=>$ext]);

?>