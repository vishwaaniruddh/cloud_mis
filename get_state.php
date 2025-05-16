<?php 
include('config.php');

$zone = $_POST['zone_id'];


$sql = mysqli_query($con,"select * from state_copy  where zone = '".$zone."' ");
$option = "<option value=''>".'Select'."</option>";

while($sql_result = mysqli_fetch_assoc($sql)){
    
    
    $option=$option."<option value='".$sql_result['state_id']."'>".$sql_result['state']."</option>";

    
}

echo $option;

?>