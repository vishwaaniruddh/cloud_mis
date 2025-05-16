<?php

ini_set('max_execution_time', 0);
    set_time_limit(0) ;
error_reporting(0);
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
$objSheet->setTitle('PMC Report');


$objSheet->setCellValue('A1', 'SNo');
$objSheet->setCellValue('B1', 'ATMID');
$objSheet->setCellValue('C1', 'Customer');
$objSheet->setCellValue('D1', 'Bank');
$objSheet->setCellValue('E1', 'Address');
$objSheet->setCellValue('F1', 'City');
$objSheet->setCellValue('G1', 'State');
$objSheet->setCellValue('H1', 'Zone');
$objSheet->setCellValue('I1', 'Branch');
$objSheet->setCellValue('J1', 'BM Name');
$objSheet->setCellValue('K1', 'Engineer ');
$objSheet->setCellValue('L1', 'Form Start Time ');
$objSheet->setCellValue('M1', 'Form End Time ');


$rowNumber = 1; 
$col = 'O'; 
$key_cnt = 0; 
$sqllist = mysqli_query($con,"select * from pmc_report_test");
while($sql_result_app_head = mysqli_fetch_assoc($sqllist)){
   $list_head= $sql_result_app_head['question_list'];
    $data_heading =json_decode($list_head);
    $count_h = count($data_heading);
    // print_r($data_heading);
    if($key_cnt==0){
       foreach($data_heading as $newdatahead => $key ){
          if($key->key !='atm_id'  && $key->key !='eng_id' && $key->key !='form_start_time' ){
              $keyh = str_replace("_", " ", $key->key);
                  $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$keyh); 
                $col++;
      } 
      
       }
    }
    $key_cnt++;
}

$filename = "pmcreport";
$srn=1;
$row = 2;
/*
   $sqlapp = "select * from pmc_report where status = 0  ";
   if(isset($_atmid) && $_atmid!=''){
       $sqlapp .= " and atmid like '%".$_atmid."%'";
   }
   if(isset($date1) && $date1!='' && isset($date2) && $date2!='')
    {
        $sqlapp .=" and CAST(form_start_time AS DATE) >= '".$date1."' and CAST(form_end_time AS DATE) <= '".$date2."' ";
    }
*/

   $sqlapp = "select * from pmc_report_test";
					       
   if(isset($date1) && $date1!='' && isset($date2) && $date2!='')
    {
        $sqlapp .="  where CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' ";
    }
   
    if(isset($_atmid) && $_atmid!=''){
      // $sqlapp .= " and atmid like '%".$_POST['atmid']."%'";
       $sqlapp .= " and atmid = '".$_atmid."'";
    }

   $sql_app = mysqli_query($con,$sqlapp);

while($sql_result_app = mysqli_fetch_assoc($sql_app)){
    $id = $sql_result_app['id'];
    $atmid = $sql_result_app['atmid'];
    // echo $atmid."<br>";
    $fromdt = $sql_result_app['form_start_time'];
    $enddt = $sql_result_app['form_end_time'];
    
    $details_sql = mysqli_query($con,"select * from mis_newsite where atmid='".$atmid."'");
    $detail_sql_res = mysqli_fetch_assoc($details_sql);
    $engid = $detail_sql_res['engineer_user_id'];
    
    $user_sql = mysqli_query($con,"select name from mis_loginusers where id = '".$engid."'");
    $name_res = mysqli_fetch_assoc($user_sql);
                                    
                                    

$bl="";
//$objSheet->setCellValueByColumnAndRow(0, $row, 'image');
$objSheet->setCellValueExplicitByColumnAndRow(0, $row, $srn);
$objSheet->setCellValueByColumnAndRow(1, $row, $atmid);
$objSheet->setCellValueByColumnAndRow(2, $row, $detail_sql_res['customer']);
$objSheet->setCellValueByColumnAndRow(3, $row, $detail_sql_res['bank']);
$objSheet->setCellValueByColumnAndRow(4, $row, $detail_sql_res['address']);
$objSheet->setCellValueByColumnAndRow(5, $row,$detail_sql_res['city']);
$objSheet->setCellValueByColumnAndRow(6, $row,$detail_sql_res['state']);
$objSheet->setCellValueByColumnAndRow(7, $row,$detail_sql_res['zone']);
$objSheet->setCellValueByColumnAndRow(8, $row, $detail_sql_res['branch']);
$objSheet->setCellValueByColumnAndRow(9, $row, $detail_sql_res['bm_name']);
$objSheet->setCellValueByColumnAndRow(10, $row,$name_res['name']);
$objSheet->setCellValueByColumnAndRow(11, $row,$fromdt);
$objSheet->setCellValueByColumnAndRow(12, $row,$enddt);

$list= $sql_result_app['question_list'];
$data=json_decode($list);
$r1 = 14;
for($j = 0; $j<count($data);$j++){
    if($data[$j]->key !='atm_id'  && $data[$j]->key !='eng_id' && $data[$j]->key !='form_start_time' && $data[$j]->key !='location'  && $data[$j]->key !='mac_id' && $data[$j]->key !='latitude' && $data[$j]->key !='longitude' ){
    
      $routerstatus =  str_replace("_", " ", $data[$j]->value);
      
      if($data[$j]->key == 'SIM_Number'){
         // $objSheet->setCellValueExplicitByColumnAndRow($r1, $row,$routerstatus, DataType::TYPE_STRING);
        //  $objSheet->setCellValueExplicit('S'.$r1,$routerstatus, DataType::TYPE_STRING);
          $_cell_name = 'S'.$row;
          $objSheet->setCellValueExplicit($_cell_name, $routerstatus, PHPExcel_Cell_DataType::TYPE_STRING);
        //  $objSheet->getStyleByColumnAndRow($r1, $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        // $objSheet->getStyle('A1')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
      }else{
          $objSheet->setCellValueByColumnAndRow($r1, $row,$routerstatus);
      }
      $r1++;
}

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