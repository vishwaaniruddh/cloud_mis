<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
$path = 'fsr_uploads/'.$today; // upload directory

if(!empty($_POST['atmid']) || $_FILES['image'])
{
    $_atmid = $_POST['atmid'];
    $target_filedir =  "../fsr_uploads/".$today.'/'.$_atmid.'/'; 
    $target_dir = "fsr_uploads/".$today.'/'.$_atmid.'/';
    if (!file_exists($target_filedir)) {
        mkdir($target_filedir, 0777, true);
    }
    
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    
    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    
    // can upload same image using rand function
    $final_image = rand(1000,1000000).$img;
    $name = 0;
    $filename = time()."_".$name.".".$ext; 
    
    // check's valid format
    if(in_array($ext, $valid_extensions)) 
    { 
       // $path = $path.strtolower($final_image); 
        $target_file = $target_filedir . $filename;
        if(move_uploaded_file($tmp,$target_file)) 
        {
            $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
           
            
            $_bank = 'PNB';
            $_ins_sql = "insert into view_pmc_report_fsr_image(atmid,bank,link,created_at) values('".$_atmid."','".$_bank."','".$link."','".$datetime."')" ; 
            mysqli_query($con,$_ins_sql);
            $array = array(['Code' => 200]);
        }
    } 
    else 
    {
        $array = array(['Code' => 201]);
    }
}

echo json_encode($array);
?>