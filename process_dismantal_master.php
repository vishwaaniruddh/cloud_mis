<? include('config.php');


$totalRecords = $_REQUEST['totalRecords'];
$customer = $_REQUEST['customer'];
$bank = $_REQUEST['bank'];

$sql = "insert into dismatleForm(customer,bank,created_at,status) 
values('".$customer."','".$bank."','".$datetime."',1)";

if(mysqli_query($con,$sql)){

$dismatleFormId = $con->insert_id;
    for($i=1;$i<=$totalRecords;$i++){
        
           $questionNum = $_REQUEST['questionNum'.$i];
           $questionType = $_REQUEST['questionType'.$i];
           $option = $_REQUEST['option'.$i];
           $isImgReq = $_REQUEST['isImgReq'.$i];
           
             $detailsSql = "insert into dismatleFormDetails(dismatleFormId,question,type,optionVal,status,isImgReq) 
            values('".$dismatleFormId."','".$questionNum."','".$questionType."','".$option."',1,'".$isImgReq."')";
            mysqli_query($con,$detailsSql);
    }
    
}




?>