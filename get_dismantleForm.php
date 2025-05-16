<? include('config.php');

$customer = $_REQUEST['customer'];
$bank = $_REQUEST['bank'];


$sql = mysqli_query($con,"select * from dismatleForm where customer='".$customer."' and bank='".$bank."' and status=1 order by id desc");
$sql_result = mysqli_fetch_assoc($sql);

$formId = $sql_result['id'];



$detailSql1 = mysqli_query($con,"select * from dismatleFormDetails where dismatleFormId='".$formId."'");
$detailSql1_result = mysqli_num_rows($detailSql1);

if($detailSql1_result>0){
$detailSql = mysqli_query($con,"select * from dismatleFormDetails where dismatleFormId='".$formId."'");
$counter=1 ; 



echo '<form action="process_dismantle.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="dismatleFormId" value="'.$formId.'">
<input type="hidden" name="siteid" value="'.$siteid.'" />
<input type="hidden" name="customer" value="'.$customer.'" />
<input type="hidden" name="bank" value="'.$bank.'" />


';
while($detailSql_result = mysqli_fetch_assoc($detailSql)){
    
    $detailId = $detailSql_result['id'];
    $question = $detailSql_result['question'];
    $type = $detailSql_result['type'];
    $optionVal = $detailSql_result['optionVal'];
    $optionValAr = explode(',',$optionVal);
    $isImgReq = $detailSql_result['isImgReq'];
    echo '<div class="row">';
    
        echo '<div class="col-sm-12 form-group question">'. $counter. ') ' . $question ; 
        
            echo '<div class="answer_option">';
                
                echo '<input type="hidden" name="questionId'.$counter.'" value="'.$detailId.'">';
                if($type=='text'){
                    echo '<input type="text" class="form-control" name="option'.$counter.'" required />';
                }elseif($type=='radio'){
                    foreach($optionValAr as $optionValAr_key=>$optionValAr_val){
                        echo '<input type="radio" name="option'.$counter.'" value="'.$optionValAr_val.'" required />&nbsp;' . $optionValAr_val . '&nbsp;&nbsp;&nbsp;';
                    }
                }elseif($type=='checkbox'){
                    foreach($optionValAr as $optionValAr_key=>$optionValAr_val){
                        echo '<input type="checkbox" name="option'.$counter.'[]" value="'.$optionValAr_val.'"  />&nbsp;' . $optionValAr_val.'&nbsp;&nbsp;&nbsp;' ;
                    }
                }
                
                 if($isImgReq=="on"){
                     ?>
                     
                <br /><input type="file" name="file'.<? echo $counter; ?>.'" accept=".png, .jpg, .jpeg" class="form-control" required>     
<? } 
                echo '</div>';
        echo '</div>';
    echo '</div>';
    
    $counter++ ; 
}
echo '<input type="hidden" name="total_records" value="'.$counter.'" />';
    echo '<div class="row"><input type="submit" class="btn btn-success" value="Submit"></div>';
echo '</form>';    
}


?>