<?php
session_start();

include('config.php');

$valid_extensions = array('jpeg', 'jpg'); // valid extensions

date_default_timezone_set("Asia/Calcutta");   
$date = date('Y-m-d H:i:s');



$userid = $_SESSION['userid'];

$name = $_POST['fname'];
$address = $_POST['address'];
$contact = $_POST['cnumber'];
$email = $_POST['cemail'];
$pincode = $_POST['pincode'];
$occupation = $_POST['occupaction'];



if(!is_dir('profile_uploads/'.$call_id)){
    mkdir('profile_uploads/'.$call_id , 0777 , true) ; 
}

$path = 'profile_uploads/'.$call_id; // upload directory


if(!empty($_POST['call_id']) || $_FILES['image'])
{
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    
    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    
    // can upload same image using rand function
    $final_image = $img;
    
    // check's valid format
    if(in_array($ext, $valid_extensions)) 
    { 
    $path = $path.'/'.strtolower($final_image); 
    
    if(move_uploaded_file($tmp,$path)) 
        {
        echo "<img src='$path' />";
        include 'config.php';
        // $con = OpenCon();
        
        $insert = mysqli_query($con,"insert into profile_details(name,address,contact,email,location,dob,occupation,created_by,created_at)  ");
        
        if($insert)
        {
            echo "<script> alert('Data Inserted Successfully'); </script>  ";
             echo "<script> window.location.href='profile_new.php'; </script>  ";
        }
        }
    } 
    else 
    {
         echo "<script> window.location.href='profile_new.php'; </script>  ";
    }
}





?>