<?php 

  // $user_id = $_POST['user_id'];
   $field_no = $_POST['field_number'];
   $url = $_POST['url'];
   if($field_no==1){
       $field_name_1 = $_POST['field_name_1'];
       $field_value_1 = $_POST['field_value_1'];
       $curl_url = $url.'?'.$field_name_1.'='.$field_value_1;
   }
   if($field_no==2){
       $field_name_1 = $_POST['field_name_1'];
       $field_value_1 = $_POST['field_value_1'];
       $field_name_2 = $_POST['field_name_2'];
       $field_value_2 = $_POST['field_value_2'];
       $curl_url = $url.'?'.$field_name_1.'='.$field_value_1.'&'.$field_name_2.'='.$field_value_2;
   }
   if($field_no==3){
       $field_name_1 = $_POST['field_name_1'];
       $field_value_1 = $_POST['field_value_1'];
       $field_name_2 = $_POST['field_name_2'];
       $field_value_2 = $_POST['field_value_2'];
       $field_name_3 = $_POST['field_name_3'];
       $field_value_3 = $_POST['field_value_3'];
       $curl_url = $url.'?'.$field_name_1.'='.$field_value_1.'&'.$field_name_2.'='.$field_value_2.'&'.$field_name_3.'='.$field_value_3;
   }
   
  
   $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $curl_url,
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

/* 

$url = 'https://comfort.ifiber.in:8080/Hitachi/api/get_macid_by_userid.php';
$data = array("user_id" => $user_id );

$postdata = json_encode($data);



$ch = curl_init($url); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
curl_close($ch);
//print_r ($result);
echo $response;die;


*/


?>