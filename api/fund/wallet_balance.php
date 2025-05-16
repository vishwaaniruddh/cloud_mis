<?php
include('./config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$userid = $_GET['userid'];

            
    $query = "SELECT 
    IFNULL(SUM(approved_amount), 0) AS total_received,
    IFNULL(SUM(finalUtilisedAmount), 0) AS total_utilised,
    IFNULL(SUM(approved_amount) - SUM(finalUtilisedAmount), 0) AS available_funds
    FROM 
    eng_fund_request 
    WHERE 
    fund_requested_by = '$userid'";
    $result = mysqli_query($con, $query);
    $walletData = mysqli_fetch_assoc($result);
    
    $totalReceived = $walletData['total_received'];
    $totalUtilised = $walletData['total_utilised'];
    $availableFunds = $walletData['available_funds'];
    
    
    $data = ['total_receved'=>$totalReceived, 'totalUtilised'=>$totalUtilised,'availableFunds'=>$availableFunds ]; 
    
    echo json_encode($data);