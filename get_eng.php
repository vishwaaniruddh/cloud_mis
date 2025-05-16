<?php

include('config.php');

$bid=$_GET['branch_id'];
$zid=$_GET['zone_id'];
// console.log($id);

$qry1=mysqli_query($con,"select location from cssbranch where zone_id='".$zid."'");
$qry1f=mysqli_fetch_row($qry1);
// $qry1r=mysqli_fetch_result();


$qry=mysqli_query($con,"select id,name from mis_loginusers where branch='".$qryf[0]."'");
$option = "<option value=''>".'Select'."</option>";

while($sql_result = mysqli_fetch_assoc($qry)){
    
    $id = $sql_result['id'];
    $name = $sql_result['name'];
    
    
    $option=$option."<option value='".$sql_result['id']."'>".$sql_result['name']."</option>";

    
}





?>