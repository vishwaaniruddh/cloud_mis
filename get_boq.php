<? include('config.php');

$bank = $_REQUEST['bank'];



$i=1;
$sql = mysqli_query($con,"select * from boq where bank = '".$bank."' and status=1");
$sql1 = mysqli_query($con,"select * from boq where bank = '".$bank."' and status=1");
if($sql_result1 = mysqli_fetch_assoc($sql1)){
    while($sql_result = mysqli_fetch_assoc($sql)){
        $id = $sql_result['id'];
        $boq = $sql_result['boq'];
        $qty = $sql_result['qty'];
        
    ?>
    
    <div class="col-sm-12 boq_node">
    <div class="col-sm-8"><input type="text" name="boq[]" class="form-control" placeholder="Enter Material Name" value="<? echo $boq ; ?>"></div>
    <div class="col-sm-3"><input type="text" name="qty[]" class="form-control" placeholder="Enter Quantity" value="<? echo $qty ; ?>"></div>
    <div class="col-sm-1" style="text-align: center;"><i class="ion-plus-circled add_boq"></i> <i class="ion-minus-circled remove_boq" onclick="remove_boqid('<? echo $id; ?>')"></i></div>
    </div>
    
    <?
    $i++ ; 
    
    }
    
    
}else{ ?>
   <div class="col-sm-12 boq_node">
    <div class="col-sm-8"><input type="text" name="boq[]" class="form-control" placeholder="Enter Material Name"></div>
    <div class="col-sm-3"><input type="text" name="qty[]" class="form-control" placeholder="Enter Quantity"></div>
    <div class="col-sm-1" style="text-align: center;"><i class="ion-plus-circled add_boq"></i> <i class="ion-minus-circled remove_boq"></i></div>
    </div>
     
<? }

?>