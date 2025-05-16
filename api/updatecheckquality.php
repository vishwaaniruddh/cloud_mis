<?php 
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');

function compress_image($source_url, $destination_url, $quality)
{
    $info = getimagesize($source_url);
    if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
    elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
    elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
    $_return = imagejpeg($image, $destination_url, $quality);
   // echo "Image uploaded successfully.";
   // return $destination;
   $return = false;
   if($_return ==1){
       $return = true;
   }
   echo $return;
}

function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }

$wizard_no = $_POST['wizard_no'];
$visit_id = $_POST['visit_id'];
$eng_id = $_POST['eng_id'];


$files = '';
$status = 0;

$data = $_POST;
// var_dump($_POST);

$testarray = array();

foreach($data as $key=>$value)
{
    // if($key!='Atm_id' && $key!='bank') {
    $_newdata = array();
    $_newdata['key'] = $key;
    $_newdata['value'] = $value;
    array_push($testarray,$_newdata);
    // }
}

$testarray = json_encode($testarray);

$is_qry = 0;
$updat = "";
$is_qry = 1;
if($wizard_no==2){
    $is_qry = 1;
   // $updat = "update newcheckquality SET  `question_list_2`='".$testarray."', `wizard_number`='".$wizard_no."', `updated_at`='".$created_at."' where visit_id='".$visit_id."'";
    $query_result = mysqli_query($con,"update newcheckquality SET  `question_list_2`='".$testarray."', `updated_at`='".$created_at."' where visit_id='".$visit_id."'");

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
            rrmdir($target_filedir);
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
          
           
            if (move_uploaded_file($_FILES["Sim_No"]["tmp_name"][$name], $target_file)) {
                $noerr = $noerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
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
            rrmdir($target_filedir);
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
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $hdderr = $hdderr + 1;
        
            }
        }
    }
    
    $sql = "insert into newcheckquality_history(visit_id, wizard_number, updated_by, updated_at) values('".$visit_id."','".$wizard_no."','".$eng_id."','".$created_at."')" ; 
    mysqli_query($con,$sql);
}
if($wizard_no==3){
    $is_qry = 1;
    $query_result = mysqli_query($con,"update newcheckquality SET  `question_list_3`='".$testarray."', `updated_at`='".$created_at."' where visit_id='".$visit_id."'");

    $cnt_r = count($_FILES["Relay"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_r = 0;$err_r = 0;$noerr_r = 0;
    if($cnt_r>0){
        $key_name = 'Relay';
        for($k=0;$k<$cnt_r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_r = $totalfiles_r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Relay"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Relay"]["tmp_name"][$name], $target_file)) {
                $noerr_r = $noerr_r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_r = $err_r + 1;
        
            }
        }
    }
    
    $cnt_el = count($_FILES["EM_Lock"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_el = 0;$hdderr_el = 0;$err_el=0;
    if($cnt_el>0){
        $key_name = 'EM_Lock';
        for($k=0;$k<$cnt_el;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_el = $totalfiles_el + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["EM_Lock"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["EM_Lock"]["tmp_name"][$name], $target_file)) {
                $noerr_el = $noerr_el + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_el = $err_el + 1;
        
            }
        }
    }
    
    $cnt_kp = count($_FILES["Key_pad"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_kp = 0;$err_kp = 0;$noerr_kp = 0;
    if($cnt_kp>0){
        $key_name = 'Key_pad';
        for($k=0;$k<$cnt_kp;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_kp = $totalfiles_kp + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Key_pad"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Key_pad"]["tmp_name"][$name], $target_file)) {
                $noerr_kp = $noerr_kp + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_kp = $err_kp + 1;
        
            }
        }
    }
    
    $cnt_ts = count($_FILES["Thermal_Sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ts = 0;$err_ts = 0;$noerr_ts=0;
    if($cnt_ts>0){
        $key_name = 'Thermal_Sensor';
        for($k=0;$k<$cnt_ts;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ts = $totalfiles_ts + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Thermal_Sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Thermal_Sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_ts = $noerr_ts + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ts = $err_ts + 1;
        
            }
        }
    }

    $cnt_ac_c_w_r = count($_FILES["ac_connected_with_relay"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ac_c_w_r = 0;$err_ac_c_w_r = 0;$noerr_ac_c_w_r=0;
    if($cnt_ac_c_w_r>0){
        $key_name = 'ac_connected_with_relay';
        for($k=0;$k<$cnt_ac_c_w_r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ac_c_w_r = $totalfiles_ac_c_w_r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["ac_connected_with_relay"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["ac_connected_with_relay"]["tmp_name"][$name], $target_file)) {
                $noerr_ac_c_w_r = $noerr_ac_c_w_r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ac_c_w_r = $err_ac_c_w_r + 1;
        
            }
        }
    }
    
    $cnt_s_c_r = count($_FILES["signage_connected_to_relay_timing"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_s_c_r = 0;$err_s_c_r = 0;$noerr_s_c_r=0;
    if($cnt_s_c_r>0){
        $key_name = 'signage_connected_to_relay_timing';
        for($k=0;$k<$cnt_s_c_r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_s_c_r = $totalfiles_s_c_r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["signage_connected_to_relay_timing"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["signage_connected_to_relay_timing"]["tmp_name"][$name], $target_file)) {
                $noerr_s_c_r = $noerr_s_c_r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
             //   $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_s_c_r = $err_s_c_r + 1;
        
            }
        }
    }
    
    $cnt_l_l_c_r = count($_FILES["lolipop_or_lobby_light_connected_to_relay_timing"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_l_l_c_r = 0;$err_l_l_c_r = 0;$noerr_l_l_c_r=0;
    if($cnt_l_l_c_r>0){
        $key_name = 'lolipop_or_lobby_light_connected_to_relay_timing';
        for($k=0;$k<$cnt_l_l_c_r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_l_l_c_r = $totalfiles_l_l_c_r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["lolipop_or_lobby_light_connected_to_relay_timing"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["lolipop_or_lobby_light_connected_to_relay_timing"]["tmp_name"][$name], $target_file)) {
                $noerr_l_l_c_r = $noerr_l_l_c_r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_l_l_c_r = $err_l_l_c_r + 1;
        
            }
        }
    }
    
    $sql = "insert into newcheckquality_history(visit_id, wizard_number, updated_by, updated_at) values('".$visit_id."','".$wizard_no."','".$eng_id."','".$created_at."')" ; 
    mysqli_query($con,$sql);
}
if($wizard_no==4){
    $is_qry = 1;
    $query_result = mysqli_query($con,"update newcheckquality SET  `question_list_4`='".$testarray."', `updated_at`='".$created_at."' where visit_id='".$visit_id."'");

    $cnt_vs = count($_FILES["Vibration_Sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_vs = 0;$err_vs = 0;$noerr_vs = 0;
    if($cnt_vs>0){
        $key_name = 'Vibration_Sensor';
        for($k=0;$k<$cnt_vs;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_vs = $totalfiles_vs + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Vibration_Sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Vibration_Sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_vs = $noerr_vs + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_vs = $err_vs + 1;
        
            }
        }
    }
    
    $cnt_ar = count($_FILES["Atm_Removal"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ar = 0;$noerr_ar = 0;$err_ar=0;
    if($cnt_ar>0){
        $key_name = 'Atm_Removal';
        for($k=0;$k<$cnt_ar;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ar = $totalfiles_ar + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Atm_Removal"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Atm_Removal"]["tmp_name"][$name], $target_file)) {
                $noerr_ar = $noerr_ar + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ;
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ar = $err_ar + 1;
        
            }
        }
    }
    
    $cnt_hd = count($_FILES["Hood_door"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_hd = 0;$err_hd = 0;$noerr_hd = 0;
    if($cnt_hd>0){
        $key_name = 'Hood_door';
        for($k=0;$k<$cnt_hd;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_hd = $totalfiles_hd + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Hood_door"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Hood_door"]["tmp_name"][$name], $target_file)) {
                $noerr_hd = $noerr_hd + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_hd = $err_hd + 1;
        
            }
        }
    }
    
    $cnt_cd = count($_FILES["Chest_door"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_cd = 0;$noerr_cd = 0;$err_cd=0;
    if($cnt_cd>0){
        $key_name = 'Chest_door';
        for($k=0;$k<$cnt_cd;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_cd = $totalfiles_cd + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Chest_door"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Chest_door"]["tmp_name"][$name], $target_file)) {
                $noerr_cd = $noerr_cd + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_cd = $err_cd + 1;
        
            }
        }
    }
    
    $cnt_cdsi = count($_FILES["Chest_door_Sensor_Install"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_cdsi = 0;$err_cdsi = 0;$noerr_cdsi = 0;
    if($cnt_cdsi>0){
        $key_name = 'Chest_door_Sensor_Install';
        for($k=0;$k<$cnt_cdsi;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_cdsi = $totalfiles_cdsi + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Chest_door_Sensor_Install"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Chest_door_Sensor_Install"]["tmp_name"][$name], $target_file)) {
                $noerr_cdsi = $noerr_cdsi + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_cdsi = $err_cdsi + 1;
        
            }
        }
    }
    
    $cnt_pb = count($_FILES["Panic_button"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_pb = 0;$noerr_pb = 0;$err_pb=0;
    if($cnt_pb>0){
        $key_name = 'Panic_button';
        for($k=0;$k<$cnt_pb;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_pb = $totalfiles_pb + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Panic_button"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Panic_button"]["tmp_name"][$name], $target_file)) {
                $noerr_pb = $noerr_pb + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_pb = $err_pb + 1;
        
            }
        }
    }
    
    $cnt_ac1r = count($_FILES["AC1_Removal"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ac1r = 0;$err_ac1r = 0;$noerr_ac1r = 0;
    if($cnt_ac1r>0){
        $key_name = 'AC1_Removal';
        for($k=0;$k<$cnt_ac1r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ac1r = $totalfiles_ac1r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["AC1_Removal"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["AC1_Removal"]["tmp_name"][$name], $target_file)) {
                $noerr_ac1r = $noerr_ac1r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ac1r = $err_ac1r + 1;
        
            }
        }
    }
    
    $cnt_ac2r = count($_FILES["AC2_Removal"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ac2r = 0;$noerr_ac2r = 0;$err_ac2r=0;
    if($cnt_ac2r>0){
        $key_name = 'AC2_Removal';
        for($k=0;$k<$cnt_ac2r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ac2r = $totalfiles_ac2r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["AC2_Removal"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["AC2_Removal"]["tmp_name"][$name], $target_file)) {
                $noerr_ac2r = $noerr_ac2r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ac2r = $err_ac2r + 1;
        
            }
        }
    }
    
    $cnt_sm = count($_FILES["Speaker_and_mic_Removal_Sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_sm = 0;$err_sm = 0;$noerr_sm = 0;
    if($cnt_sm>0){
        $key_name = 'Speaker_and_mic_Removal_Sensor';
        for($k=0;$k<$cnt_sm;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_sm = $totalfiles_sm + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Speaker_and_mic_Removal_Sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Speaker_and_mic_Removal_Sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_sm = $noerr_sm + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ;
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_sm = $err_sm + 1;
        
            }
        }
    }
    
    $cnt_cdbs = count($_FILES["Check_Drop_Box_Sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_cdbs = 0;$noerr_cdbs = 0;$err_cdbs=0;
    if($cnt_cdbs>0){
        $key_name = 'Check_Drop_Box_Sensor';
        for($k=0;$k<$cnt_cdbs;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_cdbs = $totalfiles_cdbs + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Check_Drop_Box_Sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Check_Drop_Box_Sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_cdbs = $noerr_cdbs + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_cdbs = $err_cdbs + 1;
        
            }
        }
    }
    
    $sql = "insert into newcheckquality_history(visit_id, wizard_number, updated_by, updated_at) values('".$visit_id."','".$wizard_no."','".$eng_id."','".$created_at."')" ; 
    mysqli_query($con,$sql);
}
if($wizard_no==5){
    $is_qry = 1;
    $query_result = mysqli_query($con,"update newcheckquality SET  `question_list_5`='".$testarray."', `updated_at`='".$created_at."' where visit_id='".$visit_id."'");

    $cnt_vs = count($_FILES["CCTV_removal_Sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_vs = 0;$err_vs = 0;$noerr_vs = 0;
    if($cnt_vs>0){
        $key_name = 'CCTV_removal_Sensor';
        for($k=0;$k<$cnt_vs;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_vs = $totalfiles_vs + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["CCTV_removal_Sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["CCTV_removal_Sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_vs = $noerr_vs + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_vs = $err_vs + 1;
        
            }
        }
    }
    
    $cnt_ar = count($_FILES["Lobby_camera"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ar = 0;$noerr_ar = 0;$err_ar=0;
    if($cnt_ar>0){
        $key_name = 'Lobby_camera';
        for($k=0;$k<$cnt_ar;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ar = $totalfiles_ar + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Lobby_camera"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Lobby_camera"]["tmp_name"][$name], $target_file)) {
                $noerr_ar = $noerr_ar + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ar = $err_ar + 1;
        
            }
        }
    }
    
    $cnt_hd = count($_FILES["Backroom_camera"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_hd = 0;$err_hd = 0;$noerr_hd = 0;
    if($cnt_hd>0){
        $key_name = 'Backroom_camera';
        for($k=0;$k<$cnt_hd;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_hd = $totalfiles_hd + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Backroom_camera"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Backroom_camera"]["tmp_name"][$name], $target_file)) {
                $noerr_hd = $noerr_hd + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_hd = $err_hd + 1;
        
            }
        }
    }
    
    $cnt_cd = count($_FILES["Out_door_camera"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_cd = 0;$noerr_cd = 0;$err_cd=0;
    if($cnt_cd>0){
        $key_name = 'Out_door_camera';
        for($k=0;$k<$cnt_cd;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_cd = $totalfiles_cd + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Out_door_camera"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Out_door_camera"]["tmp_name"][$name], $target_file)) {
                $noerr_cd = $noerr_cd + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_cd = $err_cd + 1;
        
            }
        }
    }
    
    $cnt_cdsi = count($_FILES["Pinhole_Camera"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_cdsi = 0;$err_cdsi = 0;$noerr_cdsi = 0;
    if($cnt_cdsi>0){
        $key_name = 'Pinhole_Camera';
        for($k=0;$k<$cnt_cdsi;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_cdsi = $totalfiles_cdsi + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Pinhole_Camera"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Pinhole_Camera"]["tmp_name"][$name], $target_file)) {
                $noerr_cdsi = $noerr_cdsi + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_cdsi = $err_cdsi + 1;
        
            }
        }
    }
    
    $cnt_pb = count($_FILES["Glass_break_sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_pb = 0;$noerr_pb = 0;$err_pb=0;
    if($cnt_pb>0){
        $key_name = 'Glass_break_sensor';
        for($k=0;$k<$cnt_pb;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_pb = $totalfiles_pb + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Glass_break_sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Glass_break_sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_pb = $noerr_pb + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_pb = $err_pb + 1;
        
            }
        }
    }
    
    $sql = "insert into newcheckquality_history(visit_id, wizard_number, updated_by, updated_at) values('".$visit_id."','".$wizard_no."','".$eng_id."','".$created_at."')" ; 
    mysqli_query($con,$sql);
}
if($wizard_no==6){
    $is_qry = 1;
    $query_result = mysqli_query($con,"update newcheckquality SET  `question_list_6`='".$testarray."', `updated_at`='".$created_at."' where visit_id='".$visit_id."'");

    $cnt_vs = count($_FILES["PIR_sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_vs = 0;$err_vs = 0;$noerr_vs = 0;
    if($cnt_vs>0){
        $key_name = 'PIR_sensor';
        for($k=0;$k<$cnt_vs;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_vs = $totalfiles_vs + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
          //  $path = "images";
            
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["PIR_sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["PIR_sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_vs = $noerr_vs + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_vs = $err_vs + 1;
        
            }
        }
    }
    
    $cnt_ar = count($_FILES["Smoke_sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ar = 0;$noerr_ar = 0;$err_ar=0;
    if($cnt_ar>0){
        $key_name = 'Smoke_sensor';
        for($k=0;$k<$cnt_ar;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ar = $totalfiles_ar + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Smoke_sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Smoke_sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_ar = $noerr_ar + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ar = $err_ar + 1;
        
            }
        }
    }
    
    $cnt_hd = count($_FILES["Shutter_Sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_hd = 0;$err_hd = 0;$noerr_hd = 0;
    if($cnt_hd>0){
        $key_name = 'Shutter_Sensor';
        for($k=0;$k<$cnt_hd;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_hd = $totalfiles_hd + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Shutter_Sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Shutter_Sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_hd = $noerr_hd + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_hd = $err_hd + 1;
        
            }
        }
    }
    
    $cnt_cd = count($_FILES["Backroom_sensor"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_cd = 0;$noerr_cd = 0;$err_cd=0;
    if($cnt_cd>0){
        $key_name = 'Backroom_sensor';
        for($k=0;$k<$cnt_cd;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_cd = $totalfiles_cd + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Backroom_sensor"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Backroom_sensor"]["tmp_name"][$name], $target_file)) {
                $noerr_cd = $noerr_cd + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_cd = $err_cd + 1;
        
            }
        }
    }
    
    $cnt_cdsi = count($_FILES["Lobby_Temperature"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_cdsi = 0;$err_cdsi = 0;$noerr_cdsi = 0;
    if($cnt_cdsi>0){
        $key_name = 'Lobby_Temperature';
        for($k=0;$k<$cnt_cdsi;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_cdsi = $totalfiles_cdsi + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Lobby_Temperature"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Lobby_Temperature"]["tmp_name"][$name], $target_file)) {
                $noerr_cdsi = $noerr_cdsi + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_cdsi = $err_cdsi + 1;
        
            }
        }
    }
    
    $cnt_pb = count($_FILES["Siren"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_pb = 0;$noerr_pb = 0;$err_pb=0;
    if($cnt_pb>0){
        $key_name = 'Siren';
        for($k=0;$k<$cnt_pb;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_pb = $totalfiles_pb + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Siren"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Siren"]["tmp_name"][$name], $target_file)) {
                $noerr_pb = $noerr_pb + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_pb = $err_pb + 1;
        
            }
        }
    }
    
    $cnt_ac1r = count($_FILES["Hooter"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ac1r = 0;$err_ac1r = 0;$noerr_ac1r = 0;
    if($cnt_ac1r>0){
        $key_name = 'Hooter';
        for($k=0;$k<$cnt_ac1r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ac1r = $totalfiles_ac1r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Hooter"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Hooter"]["tmp_name"][$name], $target_file)) {
                $noerr_ac1r = $noerr_ac1r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ac1r = $err_ac1r + 1;
        
            }
        }
    }
    
    $cnt_ac2r = count($_FILES["Battery_12v_and_12Ah"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_ac2r = 0;$noerr_ac2r = 0;$err_ac2r=0;
    if($cnt_ac2r>0){
        $key_name = 'Battery_12v_and_12Ah';
        for($k=0;$k<$cnt_ac2r;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_ac2r = $totalfiles_ac2r + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Battery_12v_and_12Ah"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Battery_12v_and_12Ah"]["tmp_name"][$name], $target_file)) {
                $noerr_ac2r = $noerr_ac2r + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_ac2r = $err_ac2r + 1;
        
            }
        }
    }
    
    $cnt_sm = count($_FILES["UPS_Battery"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles_sm = 0;$err_sm = 0;$noerr_sm = 0;
    if($cnt_sm>0){
        $key_name = 'UPS_Battery';
        for($k=0;$k<$cnt_sm;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles_sm = $totalfiles_sm + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["UPS_Battery"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["UPS_Battery"]["tmp_name"][$name], $target_file)) {
                $noerr_sm = $noerr_sm + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err_sm = $err_sm + 1;
        
            }
        }
    }
    
    $sql = "insert into newcheckquality_history(visit_id, wizard_number, updated_by, updated_at) values('".$visit_id."','".$wizard_no."','".$eng_id."','".$created_at."')" ; 
    mysqli_query($con,$sql);
}
if($wizard_no==7){
    
    $cnt = count($_FILES["Panel_Temper"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalfiles = 0;$err = 0;$noerr = 0;
    if($cnt>0){
        $key_name = 'Panel_Temper';
        for($k=0;$k<$cnt;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles = $totalfiles + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["Panel_Temper"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["Panel_Temper"]["tmp_name"][$name], $target_file)) {
                $noerr = $noerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
              //  $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err = $err + 1;
        
            }
        }
    }
    
    $hddcnt = count($_FILES["All_Wire_Cover_With"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalhddfiles = 0;$hdderr = 0;$hddnoerr = 0;
    if($hddcnt>0){
        $key_name = 'All_Wire_Cover_With';
        for($k=0;$k<$hddcnt;$k++){
        // foreach($_FILES as $k => $v){
            $totalhddfiles = $totalhddfiles + 1;
            $name = $k ;
            $target_filedir =  "../newcheckqualityapp/".$visit_id.'/'.$key_name.'/'; 
            rrmdir($target_filedir);
            $target_dir = "newcheckqualityapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["All_Wire_Cover_With"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["All_Wire_Cover_With"]["tmp_name"][$name], $target_file)) {
                $hddnoerr = $hddnoerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "update newcheckquality_images_app SET link='".$link."' where visitid='".$visit_id."' AND key_name='".$key_name."'" ; 
               // $sql = "insert into newcheckquality_images_app(visitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$created_at."')" ; 
                mysqli_query($con,$sql);
            } else {
                $hdderr = $hdderr + 1;
        
            }
        }
    }
    
    $errv = 0;$noerrv = 0;
    $_videofilename = $_POST['videos_name'];
    
    $cntv = count($_FILES["videos"]["name"]);
    // echo $cntv;
    $maxsize = 15728640; // 15MB
    
    for ($k = 0; $k < $cntv; $k++) {
        $totalfilesv = $totalfilesv + 1;
        $name = $k;
        $video_name = $_videofilename[$k];
        
        $target_filedir =  "../newcheckqualityapp/" . $visit_id .'/'.$video_name.'/';
        rrmdir($target_filedir);
        $target_dir = "newcheckqualityapp/" . $visit_id .'/'.$video_name.'/';
        if (!file_exists($target_filedir)) {
            mkdir($target_filedir, 0777, true);
        }
        $path = $_FILES["videos"]["name"][$name];
      //  var_dump($path);
        
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    
        // Valid file extensions
        $extensions_arr = array("mp4", "mpeg");
    
        $filename = time() . "_" . $name . "." . $ext;
    
        $target_file = $target_filedir . $filename;
    
        if (in_array($ext, $extensions_arr)) {
    
            $size = $_FILES['videos']['size'][$name];
            // var_dump($size);
    
             
            if(move_uploaded_file($_FILES["videos"]["tmp_name"][$name], $target_file)) {
                $noerrv = $noerrv + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/' . $target_dir . $filename;
                
                $count_visit_vid_query = mysqli_query($con,"select id from newcheckquality_videos_app where visitid='".$visit_id."' AND filename='".$video_name."'");
                $count_visit_vid = mysqli_num_rows($count_visit_vid_query);
                
                if($count_visit_vid==0){
                   $sql = "insert into newcheckquality_videos_app(visitid, name,filename,link,status,created_at) values('" . $visit_id . "','" . $name . "','".$video_name."','" . $link . "','1','" . $created_at . "')";   
                }else{
                   $sql = "update newcheckquality_videos_app SET link='".$link."' where visitid='".$visit_id."' AND filename='".$video_name."'" ; 
                }
               
                mysqli_query($con, $sql);
            }  else if (($size >= $maxsize) || ($size == 0)) {
                $errmsg = "File too large. File must be less than 15MB.";
                $errv = $errv + 1;
            }
        }
    
        
        
    }

  //  $is_qry = 1;
  //  $query_result = mysqli_query($con,"update newcheckquality SET  `question_list_7`='".$testarray."', `wizard_number`='".$wizard_no."', `updated_at`='".$created_at."',`status`='1' where visit_id='".$visit_id."'");

   
    if($totalfiles==$noerr){
        if($totalhddfiles==$hddnoerr){
            if($noerrv==$cntv){
                $is_qry = 1;
                $query_result = mysqli_query($con,"update newcheckquality SET  `question_list_7`='".$testarray."', `updated_at`='".$created_at."' where visit_id='".$visit_id."'");
                $sql = "insert into newcheckquality_history(visit_id, wizard_number, updated_by, updated_at) values('".$visit_id."','".$wizard_no."','".$eng_id."','".$created_at."')" ; 
                mysqli_query($con,$sql);
            }
        }
    } 
    
}

if($is_qry == 1){
    $array = array('Code'=>200,'wizard_no'=>$wizard_no,'check'=>$_POST);
}else{
    $array = array(['Code'=>202]);
}

echo json_encode($array);


?>