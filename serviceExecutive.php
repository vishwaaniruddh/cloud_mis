<? include('config.php');

$userid = $_REQUEST['userid'];
$type = $_REQUEST['type'];

mysqli_query($con,"update mis_loginusers set serviceExecutive='".$type."' where id='".$userid."'");

echo "update mis_loginusers set serviceExecutive='".$type."' where id='".$userid."'"; 

?>