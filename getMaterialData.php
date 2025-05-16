<? include('config.php');


$misid = $_REQUEST['misid'];

$sql = mysqli_query($con,"select * from mis_history where mis_id='".$misid."' and type='material_requirement'");
$sqlResult = mysqli_fetch_assoc($sql);

$material = $sqlResult['material'];
$remark = $sqlResult['remark'];

$data = ['material'=>$material,'oldRemark'=>$remark] ;
echo json_encode($data);



?>