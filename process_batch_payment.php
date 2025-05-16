<?php
include('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batch_id = intval($_POST['batch_id']);
    
    
    
    function getBatchName($batch_id){
        global $con ; 
    
        $sql = mysqli_query($con,"select * from eng_fund_batches where id = '".$batch_id."'") ; 
        $sql_result = mysqli_fetch_assoc($sql);
        
        return $sql_result['batch_name'];
        
    }
    
    $counter = 0 ; 
    $successcounter = 0 ; 
    $errorcounter = 0; 
    $sql = mysqli_query($con,"select * from eng_fund_request where batch_id='".$batch_id."'");
    while($sql_result = mysqli_fetch_assoc($sql)){
     $approved_amt = $sql_result['approved_amount'];
     $mis_id = $sql_result['mis_id'] ; 
     $id = $sql_result['id'];
     
     
     
     
     $selectsql = mysqli_query($con,"Select * from eng_fund_request_history where fundreq_id='".$id."' order by id desc limit 1");
        $selectsqlresult = mysqli_fetch_assoc($selectsql);
        
        $his_id = $selectsqlresult['id'];
        $fundreq_id = $selectsqlresult['fundreq_id'];
        $requested_amount= $selectsqlresult['requested_amount'];
        $approved_amount= $selectsqlresult['approved_amount'];
        $action_by= $userid ;
        $status= 5;
        $statememnt = "insert into eng_fund_request_history(fundreq_id,requested_amount,approved_amount,action_by,status,remarks,created_at,updated_at) 
        values('".$fundreq_id."','".$requested_amount."','".$approved_amount."','".$action_by."','".$status."','Payment Done','".$datetime."','".$datetime."')" ; 
        
        mysqli_query($con,$statememnt);
        
        
        
        
         mysqli_query($con,"update mis_details set status = 'fund_transfered' where id='".$mis_id."' ");
        $query = "UPDATE eng_fund_request SET req_status=5, finalUtilisedAmount='0', isPaymentProcessed = 1 WHERE batch_id = $batch_id";
        
        if (mysqli_query($con, $query)) {
            if(mysqli_query($con,"update eng_fund_batches set status=1 , isBatchProcessed = 1 where id='".$batch_id."'")){
            
            
                $statement = "INSERT INTO mis_history (mis_id, type, remark, created_at, created_by) 
                VALUES ('$mis_id', 'Fund Transferred ',  'Fund Transferred : ".$approved_amt."' , '$datetime', '$userid')";
                
                mysqli_query($con,$statement);
                $successcounter++ ; 
                
            }else{
                $errorcounter++ ; 
            }
            
        }
        $counter++ ; 
    }
    
    
    $data = ['total'=>$counter,'successcounter'=>$successcounter,'errorcounter'=>$errorcounter];
    
    echo json_encode($data);
    
    
}
?>
