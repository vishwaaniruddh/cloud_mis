<?php
include('./config.php');

ini_set('max_execution_time',0);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$statement ="
select * from mis_newsite where atmid not in (select atmid from unique_atm_codes) and status=1
" ;
// $statement = "SELECT * FROM `mis_newsite` WHERE status = 1 and customer='Hitachi' order by id desc"
$sql = mysqli_query($con, $statement);
$i=1;
while ($sql_result = mysqli_fetch_assoc($sql)) {
    
    echo $i ; 
    
    $atmid = mysqli_real_escape_string($con, $sql_result['atmid']);
    $customer = mysqli_real_escape_string($con, $sql_result['customer']);
    $created_at = $sql_result['created_at'];
    
    // // Check if created_at is a valid date, otherwise use the current year
    if ($created_at !== '0000-00-00 00:00:00' && strtotime($created_at) !== false) {
        $givenYear = date('y', strtotime($created_at));
    } else {
        $givenYear = date('y');
    }

    // // API endpoint and parameters
    $api_url = 'https://sarsspl.com/css/dash/esir/createUniqueIDAPI.php';
    $data = array(
        'atmid' => $atmid,
        'customer' => $customer,
        'givenYear' => $givenYear
    );
    
    // // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // // Execute the cURL request
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        echo 'Response: ' . $response;
    }
    echo '<br>';
    
    $i++;
    
    curl_close($ch);
}
?>
