<?php

ini_set('max_execution_time', 0);
    set_time_limit(0) ;

include("config.php");

$app=$_POST['apps'];

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
$objSheet->setTitle('MIS Fund Transfer Excel');


$objSheet->setCellValue('A1', 'DebitAccountNo');

$objSheet->getStyle('A1')->applyFromArray($styleArray);
$objSheet->setCellValue('B1', 'BeneAccountNumber');
$objSheet->getStyle('B1')->applyFromArray($styleArray);
$objSheet->setCellValue('C1', 'BeneficiaryName');
$objSheet->getStyle('C1')->applyFromArray($styleArray);
$objSheet->setCellValue('D1', 'Amt');
$objSheet->getStyle('D1')->applyFromArray($styleArray);
$objSheet->setCellValue('E1', 'PayMode');
$objSheet->getStyle('E1')->applyFromArray($styleArray);
$objSheet->setCellValue('F1', 'Date');
$objSheet->getStyle('F1')->applyFromArray($styleArray);


$objSheet->setCellValue('G1', 'IFSC');
$objSheet->getStyle('G1')->applyFromArray($styleArray);
$objSheet->setCellValue('H1', 'PayableLocation');
$objSheet->setCellValue('I1', 'PrintLocation');
$objSheet->setCellValue('J1', 'BeneficiaryMobile');
$objSheet->setCellValue('K1', 'BeneficiaryEmailId');


$objSheet->setCellValue('L1', 'Beneadd1');
$objSheet->setCellValue('M1', 'Beneadd2');
$objSheet->setCellValue('N1', 'Beneadd3');
$objSheet->setCellValue('O1', 'Beneadd4');

$objSheet->setCellValue('P1', 'Add_Details1');
$objSheet->setCellValue('Q1', 'Add_Details2');
$objSheet->setCellValue('R1', 'Add_Details3');
$objSheet->setCellValue('S1', 'Add_Details4');
$objSheet->setCellValue('T1', 'Add_Details5');
$objSheet->setCellValue('U1', 'Remarks');
$objSheet->getStyle('U1')->applyFromArray($styleArray);

$excelsql="select id from mis_fund_transfer_excel order by id desc";
$exceltable=mysqli_query($con,$excelsql); 
if(mysqli_num_rows($exceltable)>0){
  $excelrowdata=mysqli_fetch_row($exceltable);
  $n = $excelrowdata[0];
}else{
  $n = 1;
}


$joindate = date('dmY');
$filename = "C".$n.$joindate;

$insertexcelsql = "insert into mis_fund_transfer_excel(filename) 
            values('".$filename."')";
    mysqli_query($con,$insertexcelsql);

$srn=1;
$row = 2;
$dt=date('d-m-Y');
$condt = strtotime($dt);
$today = date('d-M-Y');
$mnth=date('M-Y');

                                                    $req_ids = array();
                                                    $accountno_array = array();
                                                    $total=0;$i = 0 ; 
                                                	for($x=0;$x<count($app);$x++){  
                                                	    array_push($req_ids,$app[$x]);
                                                	    $_customer_total_amt = 0;
                                                    	$sql="select * from rnm_fund where id='".$app[$x]."'";
                                                	    $view = 0; 
                                                        $table=mysqli_query($con,$sql);    
                                                        $rowdata=mysqli_fetch_row($table);
                                                        if(!in_array($rowdata[20],$accountno_array)){
                                                           $accs=mysqli_query($con,"select * from rnm_fund where account_number=".$rowdata[20]); 
                                                           while($accr=mysqli_fetch_array($accs)){
                                                               if(in_array($accr[0],$app)){
                                                                   $req_amt_data=mysqli_query($con,"select approved_amt from mis_fund_requests where req_id=".$accr[0]." order by id desc");
                                                                   $req_row_amt = mysqli_fetch_row($req_amt_data);
                                                                     $_customer_total_amt = $_customer_total_amt + $req_row_amt[0];
                                                             //  $_customer_total_amt = $_customer_total_amt + $accr[19];
                                                               }
                                                           }
                                                           array_push($accountno_array,$rowdata[20]);
                                                           $view = 1;
                                                        }
                                                        $total = $total + $_customer_total_amt;
                                                       if($view==1){ $i++;
                                    $string_n = $rowdata[22];       
                                    if(substr( $string_n, 0, 4 )==="ICIC") {
                                        $paymode = 'I';
                                    }else{
                                        if($_customer_total_amt<200000){
                                            $paymode = 'N';
                                        }else{
                                            $paymode = 'R';
                                        }
                                    }                  

$bl="";
$objSheet->setCellValueExplicitByColumnAndRow(0, $row, '345005000122',PHPExcel_Cell_DataType::TYPE_STRING);
$objSheet->setCellValueExplicitByColumnAndRow(1, $row, $rowdata[20],PHPExcel_Cell_DataType::TYPE_STRING);
$objSheet->setCellValueByColumnAndRow(2, $row, $rowdata[21]);
$objSheet->setCellValueByColumnAndRow(3, $row, $_customer_total_amt);
$objSheet->setCellValueExplicitByColumnAndRow(4, $row, $paymode);
$objSheet->setCellValueByColumnAndRow(5, $row,$today);
$objSheet->setCellValueByColumnAndRow(6, $row,$string_n);
$objSheet->setCellValueExplicitByColumnAndRow(7, $row,$bl);
$objSheet->setCellValueByColumnAndRow(8, $row, $bl);
$objSheet->setCellValueByColumnAndRow(9, $row, $bl);
$objSheet->setCellValueByColumnAndRow(10, $row,$bl);
$objSheet->setCellValueByColumnAndRow(11, $row, $bl);
$objSheet->setCellValueByColumnAndRow(12, $row, $bl);
$objSheet->setCellValueByColumnAndRow(13, $row,$bl);
$objSheet->setCellValueByColumnAndRow(14, $row, $bl);
$objSheet->setCellValueByColumnAndRow(15, $row, $bl);
$objSheet->setCellValueByColumnAndRow(16, $row,$bl);
$objSheet->setCellValueByColumnAndRow(17, $row, $bl);
$objSheet->setCellValueByColumnAndRow(18, $row, $bl);
$objSheet->setCellValueByColumnAndRow(19, $row,$bl);
$objSheet->setCellValueByColumnAndRow(20, $row, $rowdata[17]);
 $row++;
$srn++;
}
}

$objSheet->getProtection()->setPassword('pass_to_remove_protection');
$objSheet->getProtection()->setSheet(true);
$objSheet->getStyle('B2:J5')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);

 header("Content-Disposition: attachment; filename=".$filename.".xls");
 header("Content-Type: application/vnd.ms-excel");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save("php://output",'r');

?>