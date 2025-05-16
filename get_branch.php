<?php 
include('config.php');

$zone = $_POST['zone_id'];

// $state = mysqli_query($con,"select * from state_copy where zone='".$zone."'  ");
// $statesql = mysqli_fetch_assoc($state);
// $stateid= $statesql['state_id'];

$stateid=  $_POST['state_id'];

$sql = mysqli_query($con,"select * from mis_city  where state_id = '".$stateid."' and zone_id='".$zone."' ");
$option = "<option value=''>".'Select'."</option>";

while($sql_result = mysqli_fetch_assoc($sql)){

    $option=$option."<option value='".$sql_result['id']."'>".$sql_result['city']."</option>";

    
}

echo $option;

?>