<?php

ini_set('max_execution_time', 0);
    set_time_limit(0) ;

include("config.php");

$activity = $_POST['activity'];
$_atmid=$_POST['atmid'];
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];
// var_dump($_POST); die;


require_once 'Classes/PHPExcel.php';

require_once "Classes/PHPExcel/IOFactory.php";

include_once 'Classes/PHPExcel/Writer/Excel5.php';

// create new PHPExcel object
$objPHPExcel = new PHPExcel();



 
ini_set('memory_limit', '-1');
//Prevent your script from timing out

// This increases the excution time from 30 secs to 3000 secs.
//set_time_limit ( 3000 ); 

$styleArray = array(
    'font'  => array(
        //'bold'  => true,
        'color' => array('rgb' => 'FF0000'),
       // 'size'  => 15,
       // 'name'  => 'Verdana'
    ));
    
// writer already created the first sheet for us, let's get it
$objSheet = $objPHPExcel->getActiveSheet();

// rename the sheet
$objSheet->setTitle('Visit Report');


$objSheet->setCellValue('A1', 'SNo');
$objSheet->getColumnDimension('A1')->setWidth(10);
$objSheet->setCellValue('B1', 'Status');
$objSheet->setCellValue('C1', 'Activity');
$objSheet->getColumnDimension('C1')->setWidth(10);
$objSheet->setCellValue('D1', 'AtmID');
$objSheet->setCellValue('E1', 'City');
$objSheet->setCellValue('F1', 'State');
$objSheet->setCellValue('G1', 'BM Name');
$objSheet->setCellValue('H1', 'Call Type');
$objSheet->setCellValue('I1', 'Remark');
$objSheet->setCellValue('J1', 'Visit Created Time');
$objSheet->setCellValue('K1', 'Created By ');



$rowNumber = 1; 
$col = 'L'; 
$key_cnt = 0; 
$kh=array();
$sqllist = "select * from mis_newvisit_app where activity_type in('RMS','Cloud') order by id desc ";
// print_r($sqllist);
$sqlreslist = mysqli_query($con,$sqllist);
/*
while($sql_result_app_head = mysqli_fetch_assoc($sqlreslist)){
    $list_head= $sql_result_app_head['checklist_json'];
    $data_heading =json_decode($list_head);
    $count_h = count($data_heading);
    if($key_cnt==0){
        foreach($data_heading as $newdatahead => $key ){
            $keyhead = $key->k;
            if($key->k !='call_type' ){
                array_push($kh,$keyhead);
                $keyh = str_replace("_", " ", $key->k);
                $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$keyh); 
                $col++;
            } 
        }
    }
    $key_cnt++;
}
*/
$khwith = array('Router_Status','Dvr_Status','Camera_1','Camera_2','Camera_3','Camera_4','IP_Camera','HDD_Status_or_SD','HDD_Serial_Number','Sim_Card_Number',
            'Recording_from','Recording_to','Panel_Status','Backroom_Lock_Status','Panic','Two_Way','Hooter','Machine_Sensor','Shutter','Glass_Break_Sensor',
            'PIR','AC_Mains Connected','Relay_Status','Relay_Connection_to_light_or_AC','Count_Panel_Battery','Panel_Battery_Status');
$kh = array('Router Status','Dvr Status','Camera 1','Camera 2','Camera 3','Camera 4','IP Camera','HDD Status or SD','HDD Serial Number','Sim Card Number',
            'Recording from','Recording to','Panel Status','Backroom Lock Status','Panic','Two Way','Hooter','Machine Sensor','Shutter','Glass Break Sensor',
            'PIR','AC Mains Connected','Relay Status','Relay Connection to light or AC','Count Panel Battery','Panel Battery Status');
for($i=0;$i<count($kh);$i++){
    $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$kh[$i]); 
    $col++;
}
//echo '<pre>'; print_r($kh);echo '</pre>';

$filename = "newvisit_app";
$srn=1;
$row = 2;

    $sqlapp = "select * from mis_newvisit_app where 1 ";
    
    if(isset($activity) && $activity!=''){
       $sqlapp .= " and activity_type in('RMS','Cloud')";
   }
					       
   if(isset($_atmid) && $_atmid!=''){
       //$sqlapp .= " and atmid like '%".$_atmid."%'";
       $sqlapp .= " and atmid = '".$_atmid."'";
   }
   
   if(isset($date1) && $date1!='' && isset($date2) && $date2!='')
    {
        // $date1 = $_POST['date1'];
        // $date2 = $_POST['date2'];   
        $sqlapp .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
    }

$sqlapp .=" order by id desc";
//echo $sqlapp;die;
// print_r($sqlapp);die;

$sql_app = mysqli_query($con,$sqlapp);

while($sql_result_app = mysqli_fetch_assoc($sql_app)){
    $id = $sql_result_app['id'];
    $atmid = $sql_result_app['atmid'];
    
    $activity_type = $sql_result_app['activity_type'];
    
    
    $created_by = $sql_result_app['created_by'];
    $remark = $sql_result_app['remark'];
    if($remark!=''){
        $remark = htmlspecialchars($remark);
        $remark = str_replace("_", " ", $remark);
    }
    
    
    $status = $sql_result_app['status'];
    
    if($status == 0){
        $validity = "In-Valid";
    }else {
        $validity = "Valid";
    }
    
    
    
    $user_sql = mysqli_query($con,"select name from mis_loginusers where id='".$created_by."'");
    $created_name = "";
    if(mysqli_num_rows($user_sql)>0){
        $user_name_row = mysqli_fetch_row($user_sql);
        $created_name = $user_name_row[0];
    }
    
    
    $newsite = mysqli_query($con,"select bm_name,city,state from mis_newsite where atmid = '".$atmid."'");
    $newsite_res = mysqli_fetch_assoc($newsite);
                                    
                                    

    $bl="";
    $objSheet->setCellValueExplicitByColumnAndRow(0, $row, $srn);
    $objSheet->setCellValueByColumnAndRow(1, $row, $validity);
    $objSheet->setCellValueByColumnAndRow(2, $row, $activity_type);
    $objSheet->setCellValueByColumnAndRow(3, $row, $atmid);
    $objSheet->setCellValueByColumnAndRow(4, $row,$newsite_res['city']);
    $objSheet->setCellValueByColumnAndRow(5, $row,$newsite_res['state']);
    $objSheet->setCellValueByColumnAndRow(6, $row,$newsite_res['bm_name']);
    $objSheet->setCellValueByColumnAndRow(7, $row,$sql_result_app['call_type']);
    $objSheet->setCellValueByColumnAndRow(8, $row,$remark);
    $objSheet->setCellValueByColumnAndRow(9, $row,$sql_result_app['created_at']);
    $objSheet->setCellValueByColumnAndRow(10, $row,$created_name);

    $list = $sql_result_app['checklist_json'];
    $data=json_decode($list);
   // echo '<pre>';print_r($data);echo '</pre>';die;
    $r1 = 11;
    for($i=0;$i<count($khwith);$i++){
        $routerstatus  = "";
        for($j = 0; $j<count($data);$j++){
            if($data[$j]->k==$khwith[$i] || $data[$j]->k==strtolower($khwith[$i])){
               /* if($data[$j]->k != $kh[$j]){
                        $data[$j]->v = '';
                }*/
                if($data[$j]->k !='call_type' ){
                
                  $routerstatus =  str_replace("_", " ", $data[$j]->v);
                  
                }
            }
        }
        $objSheet->setCellValueByColumnAndRow($r1, $row,$routerstatus);
        $r1++;
    }

    $row++;
    $srn++;
}
// }
// }

/*
$objSheet->getProtection()->setPassword('pass_to_remove_protection');
$objSheet->getProtection()->setSheet(true);
$objSheet->getStyle('B2:J5')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
*/

 header("Content-Disposition: attachment; filename=".$filename.".xlsx");
// header("Content-Type: application/vnd.ms-excel");
 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
$objWriter->save("php://output",'r');

?>