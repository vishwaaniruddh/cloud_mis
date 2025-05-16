<? include('config.php');

$address = $_REQUEST['address'];

$sql = mysqli_query($con,"select distinct(delivery_address) as delivery_address from mis_history where delivery_address like '%".$address."%'");
while($sql_result = mysqli_fetch_assoc($sql)){ 
    
    ?>
   <option><? echo $sql_result['delivery_address'];?></option> 
<? }

?>
