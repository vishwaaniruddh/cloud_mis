<? include('config.php');

$bank = $_REQUEST['bank'];
$boq = $_REQUEST['boq'];
$qty = $_REQUEST['qty'];

mysqli_query($con,"update boq set status=0 ,updated_at='".$datetime."' where bank='".$bank."'");

$i = 0 ;
foreach($boq as $b_k => $b_v){
    $sql = "insert into boq(bank,boq,qty,status,created_at,created_by) values('".$bank."','".$b_v."','".$qty[$i]."','1','".$datetime."','".$userid."')";
    mysqli_query($con,$sql);
    $i++;
}
?>
<script>
    alert('BOQ Added Successfully !');
    window.location.href="boq.php?bank=<? echo $bank; ?>";
</script>