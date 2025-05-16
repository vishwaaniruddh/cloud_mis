<?php 
    
    include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
    header('Access-Control-Allow-Origin: *');
    //header('Content-Type: application/json');
    
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    
    $visit_id = $_POST['new_visit_id'];
    $err = 0;
    $noerr = 0;
    $totalfiles = 0;
    $cnt = count($_FILES["image"]["name"]);
    //$filename = strtotime("now").".jpg";
   // if(is_int($visit_id)){
    
            for($k=0;$k<$cnt;$k++){
            //foreach($_FILES as $k => $v){
                $totalfiles = $totalfiles + 1;
                $name = $k ;
                $target_filedir =  "../visituploadapptest/".$visit_id.'/'; 
                $target_dir = "visituploadapptest/".$visit_id.'/';
                    if (!file_exists($target_filedir)) {
                        mkdir($target_filedir, 0777, true);
                    }
                $path = $_FILES["image"]["name"][$name];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $filename = time()."_".$name.".".$ext; 
                //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
                $target_file = $target_filedir . $filename;
                if (move_uploaded_file($_FILES["image"]["tmp_name"][$name], $target_file)) {
                    $noerr = $noerr + 1;
                    $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                    //$sql = "insert into misvisit_images_app_test(misvisitid, name,link,status,created_at) values('".$visit_id."','".$name."','".$link."','1','".$date."')" ; 
                    $sql = "insert into misvisit_images_app(misvisitid, name,link,status,created_at) values('".$visit_id."','".$name."','".$link."','1','".$date."')" ; 
                    mysqli_query($con,$sql);
                } else {
                    $err = $err + 1;
                
                }
                
            }
         
   // }       
   
    
    $hddcnt = count($_FILES["HDD_Status"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalhddfiles = 0;$hdderr = 0;$hddnoerr = 0;
    if($hddcnt>0){
        $key_name = 'HDD_Status';
        for($k=0;$k<$hddcnt;$k++){
        // foreach($_FILES as $k => $v){
            $totalhddfiles = $totalhddfiles + 1;
            $name = $k ;
            $target_filedir =  "../visituploadapptest/".$visit_id.'/'.$key_name.'/'; 
            $target_dir = "visituploadapptest/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["HDD_Status"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            $source_file = $_FILES["HDD_Status"]["tmp_name"][$name];
           // if(compress_image($source_file, $target_file,20)){
            if (move_uploaded_file($_FILES["HDD_Status"]["tmp_name"][$name], $target_file)) {
                $hddnoerr = $hddnoerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
             //   mysqli_query($con,$sql);
                $sql = "insert into misvisit_images_app_test(misvisitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$date."')" ; 
                mysqli_query($con,$sql);
            } else {
                $hdderr = $hdderr + 1;
        
            }
        }
    }
         
   
    if($noerr>0){
        if($totalfiles==$noerr){
            $update = mysqli_query($con,"update mis_newvisit_app set status='1' where id = '".$visit_id."' ");

            $msg = $noerr." Files uploaded successfully."; 
        }else{
           $msg = $noerr." Files uploaded successfully and ".$err." Files not uploaded" ;  
        }
        $array = array(['Code'=>200,'msg'=>$msg,'files'=>$cnt]);
    }else{
        $msg = "Sorry, there was an error uploading ".$err." file."; 
       $array = array(['Code'=>201,'msg'=>$msg,'files'=>$cnt]);
    }
            
    echo json_encode($array);		