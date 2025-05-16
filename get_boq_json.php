<? include('config.php');
$bank = $_REQUEST['bank'];

$sql = mysqli_query($con,"select * from boq where bank = '".$bank."' and status=1");
    while($sql_result = mysqli_fetch_assoc($sql)){
        $id = $sql_result['id'];
        $boq = $sql_result['boq'];
        $qty = $sql_result['qty'];
        
        $data[] = ['id'=>$id,'boq'=>$boq,'qty'=>$qty];
    }
    echo json_encode($data);
?>