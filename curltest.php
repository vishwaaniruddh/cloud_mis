<?php

include('config.php');

$sql = mysqli_query($con,"select atmid from mis_newsite where status=1");
$atmid_list=array();
if(mysqli_num_rows($sql)){
    while($result = mysqli_fetch_array($sql))
    {
        $_newdata['value'] = $result['atmid'];
        array_push($atmid_list,$_newdata);
    }
    
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://103.141.218.26:8080/ComfortTechnoNew/api/atmid_get_network_count.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('atm_id_list' => '$atmid_list','purpose' => 'count'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>