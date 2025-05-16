<? include('config.php');


$sql = mysqli_query($con,"select * from mis_subcomponent");

while($sql_result = mysqli_fetch_assoc($sql)){
    
    $id = $sql_result['id'];
    $component_id = $sql_result['component_id'];
    
    $csql = mysqli_query($con,"select * from mis_component where name='".$component_id."'");
    $csql_result = mysqli_fetch_assoc($csql);
    $cid = $csql_result['id'];
    
    mysqli_query($con,"update mis_subcomponent set cid='".$cid."' where id='".$id."'");
    
}

?>