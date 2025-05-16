<?php
include('config.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Update the database
    $query = "UPDATE eng_fund_request SET req_status=5 , isPaymentProcessed = 1 WHERE id = $id";
    if (mysqli_query($con, $query)) {
        echo 'success';
        
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
        // mysqli_query($con,"update eng_fund_request_history set status=5 where id='".$his_id."'");
        
    } else {
        echo 'error';
    }
} else {
    echo 'invalid';
}
?>
