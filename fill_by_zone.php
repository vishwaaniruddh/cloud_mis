<?php 
 include('config.php');

// $zone = $_POST['zone'];


// if($zone=="North"){
//     $zone=3;
// }
// else if($zone=="South")
// {
//     $zone=1;
    
// }
// else if($zone=="East"){
//     $zone=4;
// }
// elseif($zone=="West")
// {
//     $zone=2;
// }

// echo $zone;


$branch = $_POST["branch"];

$zone_sql = mysqli_query($con,"select * from cssbranch where location= '".$branch."' and status = 1 ");
$zone_sql_result = mysqli_fetch_assoc($zone_sql);

$zone = $zone_sql_result['id'];

$data = ['zone'=>$zone,'branch'=>$branch];

echo json_encode($data);
?>