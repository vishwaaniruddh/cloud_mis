<?php 
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
function getOnlineOfflineSite($user_id,$con){
	$curl = curl_init();
	$panel_id_arr = array();
	
	
    $userid = $user_id;
    
    $usersql = mysqli_query($con,"select id,atmid from mis_newsite where engineer_user_id ='".$userid."'");
    $dataarray = array();
    $total_site = mysqli_num_rows($usersql);
    $dvr_online_count = 0;
    $dvr_offline_count = 0;
    if($total_site>0){
       while($userdata = mysqli_fetch_assoc($usersql)){
           array_push($dataarray,$userdata['atmid']);
       }
        
    }
	$json = array('atm_id_list' => $dataarray,'purpose' => 'count');
//	echo '<pre>';print_r($json);echo '</pre>';die;
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'http://103.141.218.26:8080/ComfortTechnoNew/api/atmid_get_network_count.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_SSL_VERIFYPEER => false,
	  CURLOPT_SSL_VERIFYHOST => false,
	  CURLOPT_POSTFIELDS => $json,
	/*  CURLOPT_POSTFIELDS =>'{
		"org_id" : 1004,
		"panel_id" : ["091364"]
	  }', */
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));

    curl_exec($curl);
    if (curl_errno($curl)) {
        $response = curl_error($curl);
    }else{

    	$response = curl_exec($curl);
    }

	curl_close($curl);
	return $response;
}
//$user_id = 334;echo $user_id;die;
echo getOnlineOfflineSite($user_id,$con);