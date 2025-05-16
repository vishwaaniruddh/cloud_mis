<?php

ini_set('max_execution_time', 0);
    set_time_limit(0) ;

include("config_test.php");

// var_dump($_POST); die;
$qry=$_POST['qry'];

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
$objSheet->setTitle('Quiztest Report');


$objSheet->setCellValue('A1', 'SNo');
$objSheet->setCellValue('B1', 'std');
$objSheet->setCellValue('C1', 'subject');
$objSheet->setCellValue('D1', 'topic');
$objSheet->setCellValue('E1', 'sub topic');
$objSheet->setCellValue('F1', 'mcq');
// $objSheet->getColumnDimension('F1')->setTextWrap(true);
$objSheet->getStyle('F1')->getAlignment()->setWrapText(true);
$objSheet->setCellValue('G1', 'a');
$objSheet->setCellValue('H1', 'b');
$objSheet->setCellValue('I1', 'c');
$objSheet->setCellValue('J1', 'd');
$objSheet->setCellValue('K1', 'final ans ');
$objSheet->setCellValue('L1', 'status');


$filename = "quiztest";
$srn=1;
$row = 2;

    $qrys = "select * from quiztest where subject =6 ";
   $sql_app = mysqli_query($contest,$qrys);

while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                  
                                    

$bl="";
$objSheet->setCellValueExplicitByColumnAndRow(0, $row, $srn);
$objSheet->setCellValueByColumnAndRow(1, $row, $sql_result_app['std']);
$objSheet->setCellValueByColumnAndRow(2, $row, $sql_result_app['subject']);
$objSheet->setCellValueByColumnAndRow(3, $row, $sql_result_app['topic']);
$objSheet->setCellValueByColumnAndRow(4, $row, $sql_result_app['sub_topic']);
$objSheet->setCellValueByColumnAndRow(5, $row,$sql_result_app['mcq']);
$objSheet->setCellValueByColumnAndRow(6, $row,$sql_result_app['a']);
$objSheet->setCellValueByColumnAndRow(7, $row,$sql_result_app['b']);
$objSheet->setCellValueByColumnAndRow(8, $row, $sql_result_app['c']);
$objSheet->setCellValueByColumnAndRow(9, $row, $sql_result_app['d']);
$objSheet->setCellValueByColumnAndRow(10, $row,$sql_result_app['final_ans']);
$objSheet->setCellValueByColumnAndRow(11, $row,$sql_result_app['status']);



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