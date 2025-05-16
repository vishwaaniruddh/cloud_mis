<? include('config.php');


$id = $_REQUEST['id'];
$sql = mysqli_query($con,"select * from mis_eng where id='".$id."'");
$sql_result = mysqli_fetch_assoc($sql);

echo $sql_result['contact'];

?>