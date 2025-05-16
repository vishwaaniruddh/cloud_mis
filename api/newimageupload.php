<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');
$visit_id = '83';

    $cnt = count($_FILES["Sim_No"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles = 0;$err = 0;$noerr = 0;
    if($cnt>0){
        $key_name = 'Sim_No';
        for($k=0;$k<$cnt;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles = $totalfiles + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Sim_No"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            $source_file = $_FILES["Sim_No"]["tmp_name"][$name];
           // if(compress_image($source_file, $target_file,20)){
            $info = getimagesize($source_url);
            if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
            else $image = imagecreatefromjpeg($source_url);
            $_return = imagejpeg($image, $target_file, 20);
            if($_return==1){
           // if (move_uploaded_file($_FILES["Sim_No"]["tmp_name"][$name], $target_file)) {
                $noerr = $noerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err = $err + 1;
        
            }
        }
    }
    
    $hddcnt = count($_FILES["HDD_Status"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalhddfiles = 0;$hdderr = 0;$hddnoerr = 0;
    if($hddcnt>0){
        $key_name = 'HDD_Status';
        for($k=0;$k<$hddcnt;$k++){
        // foreach($_FILES as $k => $v){
            $totalhddfiles = $totalhddfiles + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
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
                $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $hdderr = $hdderr + 1;
        
            }
        }
    }
    
     $array = array('Code'=>200);
     
      echo json_encode($array);