<?php include('config.php');

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

$id = $_POST['id'];
// echo $id;

if($id>0){
    // $user_sql = mysqli_query($con,"select id from mis_newvisit_app where id ='".$id."'"); 
    // $user_data = mysqli_fetch_assoc($user_sql);
    // $_userid = $user_data['id'];
    
    $deldata = mysqli_query($con,"delete from mis_newvisit_app where id = '".$id."'");
    if($deldata) {
        $check_image = mysqli_query($con,"select * from misvisit_images_app where misvisitid = '".$id."' ");
        if(mysqli_num_rows($check_image)>0){
            $imagedel = mysqli_query($con,"delete from misvisit_images_app where misvisitid = '".$id."' ");
            if($imagedel){
               
                $path = $_SERVER['DOCUMENT_ROOT']."/css/dash/esir/visituploadapp/". $id;
                deleteDir($path);
    		  // unlink($path);
    		     echo 1;
    		  
            }
            else{
                echo 0;
            }
        }else{
            echo 1;
        }
    } 
}else{
    echo 0;
}

?>