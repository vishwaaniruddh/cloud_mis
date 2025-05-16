<?php session_start();
return ;              
include('../config.php');


$result = mysqli_query($con, "SELECT * FROM trigger_log WHERE processed = 0");

while ($row = mysqli_fetch_assoc($result)) {
    
    $visit_id = $row['mis_newvisit_id'];
    
$sql = mysqli_query($con, "SELECT * FROM mis_newvisit_app_test where id='".$visit_id."'");
if ($sql_result = mysqli_fetch_assoc($sql)) {
    
    $status ='Pending';   
    $amount = 'NULL';


    $atmid = $sql_result['atmid'];
 $checklist_json = $sql_result['checklist_json'];
    $checklist_array = json_decode($checklist_json, true);
 

$json_data = [];
foreach ($checklist_array as $item) {
    $json_data[$item['k']] = $item['v'];
}


foreach (array_keys($json_data) as $key) {
    $component_check = mysqli_query($con, "SELECT master_component FROM visit_component WHERE app_component = '$key'");

    if (mysqli_num_rows($component_check) > 0) {
        $master_component = mysqli_fetch_assoc($component_check)['master_component'];
        $value = $json_data[$key];


        if (stripos($value, 'NOT_WORKING') !== false) {
           
          
        
            
            $get_atmsql = mysqli_query($con,"select * from mis_newsite where atmid like '".$atmid."'");
if($get_atmsql_result = mysqli_fetch_assoc($get_atmsql)){
    
    $call_type = 'Service';
    $call_receive = 'Internal';
        
    $bank = $get_atmsql_result['bank'];
    $customer = $get_atmsql_result['customer'];
    $zone = $get_atmsql_result['zone'];
    $city = $get_atmsql_result['city'];
    $state = $get_atmsql_result['state'];
    $location = $get_atmsql_result['address'];
    $location = mysqli_real_escape_string($con, $location);
    $branch = $get_atmsql_result['branch'];
    $bm = $get_atmsql_result['bm_name'];
    $remarks = 'Not Working' ;
    $created_at = date('Y-m-d h:i:s');
}



$engineer_sql = mysqli_query($con,"select * from mis_newsite where atmid like '%".$atmid."%'");
$engineer_user_id = "";
if(mysqli_num_rows($engineer_sql)>0){
    if($engsql_result = mysqli_fetch_assoc($engineer_sql)){
       $engineer_user_id = $engsql_result['engineer_user_id'];   
    }
}


$mis_city_sql = mysqli_query($con,"select * from mis_city where city ='".$city."'");
if($mis_city_sql_result  = mysqli_fetch_assoc($mis_city_sql)){
    $mis_city = $mis_city_sql_result['id'];    
}else{
    mysqli_query($con,"insert into mis_city(city) values('".$city."')");
    $mis_city = $con->insert_id ; 
}




$statement = "insert into mis(atmid,bank,customer,zone,city,state,location,call_receive_from,remarks,status,created_by,created_at,branch,bm,call_type,serviceExecutive) 
values('".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$call_receive."','".$remarks."','Pending','24','".$created_at."','".$branch."','".$bm."','".$call_type."','".$serviceExecutive."')";


if(mysqli_query($con,$statement)){
    
    $mis_id = $con->insert_id ;
    

            $last_sql = mysqli_query($con,"select id from mis_details order by id desc");
            $last_sql_result = mysqli_fetch_assoc($last_sql);
            $last = $last_sql_result['id'];
            
            if(!$last){
                $last=0;
            }
            $ticket_id =  mb_substr(date('M'), 0, 1).date('Y') .date('m')  . date('d') . sprintf('%04u', $last) ;
            
         
            
            $subcomp_sql=mysqli_query($con,"select * from mis_subcomponent where name='".$master_component."'");
            $subcomp_sql_result= mysqli_fetch_assoc($subcomp_sql);
            $com = $subcomp_sql_result['component_id'];
            $subcom = $master_component ; 
            
            $docket_no = '-';
           echo  $detai_statement = "insert into mis_details(mis_id,atmid,component,subcomponent,engineer,docket_no,status,created_at,ticket_id,amount,mis_city,zone,call_type,case_type,branch) 
             values('".$mis_id."','".$atmid."','".$com."','".$subcom."','".$engineer_user_id."','".$docket_no."','".$status."','".$created_at."','".$ticket_id."','".$amount."','".$mis_city."','".$zone."','Service','".$call_receive."','".$branch."')" ;
            mysqli_query($con,$detai_statement);
        }
    }
}
}
}



  mysqli_query($con, "UPDATE trigger_log SET processed = 1 WHERE id = " . $row['id']);
}
?>
