<?php

ini_set('max_execution_time', 0);
    set_time_limit(0) ;
error_reporting(0);
include("config.php");

$activity = $_POST['activity'];
$report_type=$_POST['report_type'];
$date1 = $_POST['date1'];
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
$objSheet->setTitle('Daily Report');


$objSheet->setCellValue('A1', 'SNo');
$objSheet->getColumnDimension('A1')->setWidth(10);
$objSheet->setCellValue('B1', 'Report Type');
$objSheet->setCellValue('C1', 'Report Date');
$objSheet->setCellValue('D1', 'Created At');
$objSheet->setCellValue('E1', 'Created By');

$rowNumber = 1; 
$col = 'F'; 
$key_cnt = 0; 
$sqllist = mysqli_query($con,"select * from daily_report_app ");
while($sql_result_app_head = mysqli_fetch_assoc($sqllist)){
   $list_head= $sql_result_app_head['checklist_json'];
    $data_heading =json_decode($list_head);
    $count_h = count($data_heading);
    // print_r($data_heading);
    if($key_cnt==0){
       foreach($data_heading as $newdatahead => $key ){
          
              $keyh = str_replace("_", " ", $key->k);
                  $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$keyh); 
                $col++;
       
      
       }
    }
    $key_cnt++;
}


$filename = "dailyreport";
$srn=1;
$row = 2;


   $sqlapp = "select * from daily_report_app";
					       
   if(isset($date1) && $date1!='')
    {
        $sqlapp .="  where CAST(created_at AS DATE) >= '".$date1."'  ";
    }
   
    if(isset($report_type) && $report_type!=''){
       $sqlapp .= " and report_type = '".$report_type."'";
    }

   $sql_app = mysqli_query($con,$sqlapp);

while($sql_result_app = mysqli_fetch_assoc($sql_app)){
    $id = $sql_result_app['id'];
    $report_typ = $sql_result_app['report_type'];
    $reportdt = $sql_result_app['report_date'];
    $created_at = $sql_result_app['created_at'];
    $created_by= $sql_result_app['created_by'];

    $user_sql = mysqli_query($con,"select name from mis_loginusers where id = '".$created_by."'");
    $name_res = mysqli_fetch_assoc($user_sql);
                                    
                                    

$bl="";
$objSheet->setCellValueExplicitByColumnAndRow(0, $row, $srn);
$objSheet->setCellValueByColumnAndRow(1, $row, $report_typ);
$objSheet->setCellValueByColumnAndRow(2, $row, $reportdt);
$objSheet->setCellValueByColumnAndRow(3, $row, $created_at);
$objSheet->setCellValueByColumnAndRow(4, $row, $name_res['name']);

$list= $sql_result_app['checklist_json'];
$data=json_decode($list);
$r1 = 5;
for($j = 0; $j<count($data);$j++){
    
      $datareport =  str_replace("_", " ", $data[$j]->v);
      $objSheet->setCellValueByColumnAndRow($r1, $row,$datareport);
      $r1++;

}

 $row++;
$srn++;
}
// }
// }

$objSheet->getProtection()->setPassword('pass_to_remove_protection');
$objSheet->getProtection()->setSheet(true);
$objSheet->getStyle('B2:J5')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);

 header("Content-Disposition: attachment; filename=".$filename.".xls");
 header("Content-Type: application/vnd.ms-excel");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save("php://output",'r');

?>