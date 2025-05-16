<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');
$three_month_ago_date =  date("Y-m-d",strtotime("-3 Months"));

//$dataarray = json_decode($_POST['atm_id_list']);
//$dataarray = ["B1026100", "B1156910", "B1157010", "B1364300", "N2364300", "N2026100", "D7311100"];
$dataarray = $_POST['atm_id_list'];

$_data = [];
    if(count($dataarray)>0){
        $dataarray=json_encode($dataarray);
		$dataarray=str_replace( array('[',']','"') , ''  , $dataarray);
		$atmarr=explode(',',$dataarray);
		$dataarray = "'" . implode ( "', '", $atmarr )."'";
	
        $_pmc_sql = "select * from pmc_report_test where atmid IN (".$dataarray.") AND CAST(created_at AS DATE)>='".$three_month_ago_date."'";
        
        $_sql_data = mysqli_query($con,$_pmc_sql);
        if(mysqli_num_rows($_sql_data)>0){
            $_is_done = 1;
            $total_done = $total_done + 1;
            while($sql_pmc_result = mysqli_fetch_assoc($_sql_data)){
                $total = $total + 1;
                $id = $sql_pmc_result['id'];
                $atm_id = $sql_pmc_result['atmid'];
                $_newdata = array();
                $_newdata['site_id'] = $id;
                $_newdata['atmid'] = $atm_id;
                $_newdata['activity'] = 'RMS';
                array_push($_data,$_newdata); 
            }
        }
            
    }



if(count($_data)>0){
	$array = array(['Code'=>200,'res_data'=>$_data]);
}else{
	$array = array(['Code'=>201]);
}

//echo json_encode(count($dataarray));
echo json_encode($array);