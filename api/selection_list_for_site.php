<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$data = [];
$case = $_POST['request_type'];
if($case=='material_request'){
    $mat_sql =mysqli_query($con,"select * from material where status=1 "); 
    if(mysqli_num_rows($mat_sql)>0){
        while($mat_sql_result = mysqli_fetch_assoc($mat_sql)){
            $newdata = [];
            $newdata['label'] = $mat_sql_result['material'];
            $newdata['value'] = $mat_sql_result['material'];
            array_push($data,$newdata);
        }
    }
}
$array = array(['Code'=>200,'data'=>$data]);
 echo json_encode($array);
 