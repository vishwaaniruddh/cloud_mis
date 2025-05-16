<?php 

   $atmid = $_POST['atmid'];
  // $atmid = 'P3ENSK04';
      
		
		$post_data = [
                        "atmid"=> $atmid,
                     ];
//$post_data = json_encode($post_data);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://comfort.ifiber.in:8080/ComfortTechnoNew/api/live_view_ajax_engapp.php?atmid='.$atmid,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS => $post_data,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;die;