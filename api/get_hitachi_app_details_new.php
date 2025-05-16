<?php 

   $url = $_POST['url'];
   $data = [];
   $field_no = $_POST['field_number'];
   for($i=1;$i<=$field_no;$i++){
       $postfield_name = 'field_name_'.$i;
       $postfield_value = 'field_value_'.$i;
       $field_name = $_POST[$postfield_name];
       $field_value = $_POST[$postfield_value];
       $data[$field_name] = $field_value;
   }
   
    
   //$array = array(['Code'=>202,'msg'=>'Ticket Raised Already','tot'=>$data,'url'=>$url]);


   //echo json_encode($array);
   
//   $params = [
//     'user_id' => 123,
//     'type' => 'summary'
//     ];
    
    $baseUrl = $url;
    // Build query string and append to base URL
    $url = $baseUrl . '?' . http_build_query($data);

   // echo $url;
   
   $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => 'GET',
     // CURLOPT_POSTFIELDS => http_build_query($data),
      CURLOPT_HTTPHEADER => array(
        //'Content-Type: application/json'
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;die;


?>