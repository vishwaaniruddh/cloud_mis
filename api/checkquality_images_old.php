<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$visit_id = $_POST['visit_id'];
$err = 0;
$noerr = 0;
$totalfiles = 0;
$cnt = count($_FILES["image"]["name"]);
//$filename = strtotime("now").".jpg";

for($k=0;$k<$cnt;$k++){
//foreach($_FILES as $k => $v){
    $totalfiles = $totalfiles + 1;
    $name = $k ;
    $target_filedir =  "../checkqualityapp/".$visit_id.'/'; 
    $target_dir = "checkqualityapp/".$visit_id.'/';
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
        $sql = "insert into checkquality_images_app(visitid, name,link,status,created_at) values('".$visit_id."','".$name."','".$link."','1','".$date."')" ; 
        mysqli_query($con,$sql);
    } else {
        $err = $err + 1;
    
    }
    
}

if($noerr>0){
    if($totalfiles==$noerr){
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