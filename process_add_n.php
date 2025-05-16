<? session_start();
include('config.php');
date_default_timezone_set('Asia/Kolkata');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if($_SESSION['username']){ 

include('header.php');

function compressImage($source,$destination,$quality){
    // getimagesize
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];
    
    //Create new image from file
    switch($mime){
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default :
            $image = imagecreatefromjpeg($source);
           
    }
    // save image
    imagejpeg($image,$destination,$quality);
    
    return $destination;
}
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <?  
$atmid = $_POST['atmid'];
$bank = $_POST['bank'];
$customer = $_POST['customer'];
$zone = $_POST['zone'];
$city = $_POST['city'];
$state = $_POST['state'];
$location = $_POST['location'];
$engineer = $_POST['engineer'];
$eng_contact = $_POST['eng_contact'];





$userid = $_SESSION['userid'];
$datetime = date('Y-m-d H:i:s');




$tabselect = $_POST['tabselect'];
$status = $_POST['status'];
$cam1 = $_POST['cam1'];
$cam2 = $_POST['cam2'];
$cam3 = $_POST['cam3'];
$cam4 = $_POST['cam4'];
$hdd_status = $_POST['hdd_status'];
$routername = $_POST['routername'];
$routerid = $_POST['routerid'];
$other_status = $_POST['other_statuss'];
$ip_cam = $_POST['ip_cam'];
$sd_card_status = $_POST['sd_card_status'];


if($tabselect=='rms'){

    $eml = $_POST['eml'];
    $panic = $_POST['panic'];
    $twoway = $_POST['twoway'];
    $hooder = $_POST['hooder'];
    $machine_sensor = $_POST['machine_sensor'];
    $shutter = $_POST['shutter'];
    $glass_break_sensor = $_POST['glass_break_sensor'];
    $pir = $_POST['pir'];
    $acCon = $_POST['acCon'];
    $relayCon = $_POST['relayCon'];
    $panel_battery = $_POST['panel_battery'];
    $panel_name = $_POST['panel_name'];
    $router_name = $_POST['router_name'];
    $router_id = $_POST['router_id'];
    $remark = $_POST['remark'];
    $count_panel_battery = $_POST['count_panel_battery'];
    
}else{
    
$eml = '-';
$panic = '-';
$twoway = '-';
$hooder = '-';
$machine_sensor = '-';
$shutter = '-';
$glass_break_sensor = '-';
$pir = '-';
$acCon = '-';
$relayCon = '-';
$panel_battery = '-';
$panel_name = '-';
$router_name = '-';
$router_id = '-';
$remark = '-';
$count_panel_battery = '-';

}






 $sql = "insert into mis_newvisit(atmid,bank,customer,zone,city,state,location,engineer,eng_contact,eml,panic,twoway,hooder,machine_sensor,shutter,glass_break_sensor,pir,acCon,relayCon,panel_battery,panel_name,router_name,router_id,remark,status,created_at,created_by,count_panel_battery) values('".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$engineer."','".$eng_contact."','".$eml."','".$panic."','".$twoway."','".$hooder."','".$machine_sensor."','".$shutter."','".$glass_break_sensor."','".$pir."','".$acCon."','".$relayCon."','".$panel_battery."','".$panel_name."','".$router_name."','".$router_id."','".$remark."','1','".$datetime."','".$userid."','".$count_panel_battery."')";

if(mysqli_query($con,$sql)){ 
    $insert_id = $con->insert_id;
    mysqli_query($con,"insert into visitsite_details(visit_id,type,status,cam1,cam2,cam3,cam4,hdd_status,router_name,routerid,other_status,visitstatus,created_at,ip_cam,sd_card_status) values('".$insert_id."','".$tabselect."','".$status."','".$cam1."','".$cam2."','".$cam3."','".$cam4."','".$hdd_status."','".$routername."','".$routerid."','".$other_status."','1','".$datetime."','".$ip_cam."','".$sd_card_status."')");


foreach($_FILES as $k => $v){
    $name = $k ;
    $target_dir = "visitupload/".$insert_id.'/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    $target_file = $target_dir . basename($_FILES[$name]["name"]);    
    $imageTmp = $_FILES[$name]["tmp_name"];
    $compressedImage = compressImage($imageTmp,$target_file,60);
    if($compressedImage){
        $compressedImageSize = filesize($compressedImage);
    //} 
   //  if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
    if ($compressedImageSize) {
    echo "The file  has been uploaded.";
    $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. htmlspecialchars( basename( $_FILES[$name]["name"])) ; 
    $sql = "insert into misvisit_images(misvisitid, name,link,status,created_at) values('".$insert_id."','".$name."','".$link."','1','".$date."')" ; 
    mysqli_query($con,$sql);
    } else {
    echo "Sorry, there was an error uploading your file.";
    }
    echo '<br>';
    }
}
?>



   <script>
       alert('Successfully Created');
      window.location.href="add_n.php";
   </script> 
<? }else{ ?>
       <script>
       alert('Error');
      window.history.back();
   </script>
<? }

                                        ?>
                                        
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>
    


</body>

</html>