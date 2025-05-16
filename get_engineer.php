<?php
include('config.php');

$zoneid = $_POST['zone_id'];
$stateid = $_POST['state_id'];
$branchid = $_POST['branch_id'];

$sql = mysqli_query($con,"select * from mis_loginusers where branch IN ('$branchid')");

$option = "<option value=''>".'Select'."</option>";

while($sql_result = mysqli_fetch_assoc($sql)){

    $option=$option."<option value='".$sql_result['id']."'>".$sql_result['name']."</option>";
}

echo $option;
?>