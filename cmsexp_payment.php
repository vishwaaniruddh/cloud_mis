<?php

ini_set('max_execution_time', 0);
    set_time_limit(0) ;

include("config.php");

$fromdt=$_POST['fromdt'];
$todt=$_POST['todt'];

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
$objSheet->setTitle('Payment Excel');


$objSheet->setCellValue('A1', 'E-Surveillance Payment');

$objSheet->getStyle('A1')->applyFromArray($styleArray);
$objSheet->setCellValue('A2', 'Name');
$objSheet->getStyle('A2')->applyFromArray($styleArray);
$objSheet->setCellValue('B2', 'Amount');
$objSheet->getStyle('B2')->applyFromArray($styleArray);

$srn=1;
$row = 3;
$dt=date('d-m-Y');
$condt = strtotime($dt);
$today = date('d-M-Y');
$today = strtoupper($today);
$mnth=date('M-Y');

 $vendorstatement1 = "SELECT SUM(approved_amt),fund_remark FROM `mis_fund_transfer` WHERE status='3' AND current_status='4' " ; 
    if(isset($_POST['submit'])){
        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
        {
        
        $date1 = $_POST['fromdt'] ; 
        $date2 = $_POST['todt'] ;
        $vendorstatement .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
        $vendorstatement1 .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
        }
    }
   // $vendorsql = mysqli_query($con,$vendorstatement);
  //  $vendorsql_result = mysqli_fetch_row($vendorsql);
  //  $totalvendoramt = $vendorsql_result[0]; 
    $vendorstatement1 .=" group by fund_remark";
    
    $vendorsql1 = mysqli_query($con,$vendorstatement1);
    
    $salarystatement = "SELECT SUM(amount),fund_remark FROM `mis_salary_fund_transfer` WHERE status='3' AND current_status='4' " ;  
    if(isset($_POST['submit'])){
        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
        {
        
        $date1 = $_POST['fromdt'] ; 
        $date2 = $_POST['todt'] ;
        $salarystatement .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
        }
    }
    $salarystatement .=" group by fund_remark";
    $salarysql = mysqli_query($con,$salarystatement);

            $total_vendor = 0;
            while($vendorsql_result = mysqli_fetch_array($vendorsql1)){ 
                $total_vendor = $total_vendor + $vendorsql_result[0];             
                $bl="";
                $objSheet->setCellValueExplicitByColumnAndRow(0, $row, $vendorsql_result[1],PHPExcel_Cell_DataType::TYPE_STRING);
                $objSheet->setCellValueByColumnAndRow(1, $row, $vendorsql_result[0]);
                $row++;
                $srn++;
            }
            
     

$objSheet->setCellValueExplicitByColumnAndRow(0,$row, 'Total E-Surveillance Payment',PHPExcel_Cell_DataType::TYPE_STRING);
$objSheet->setCellValueByColumnAndRow(1, $row, $total_vendor);
$row++;  
$row++; 
$objSheet->setCellValue('A'.$row, 'Salary Payment');
$objSheet->getStyle('A'.$row)->applyFromArray($styleArray);
$row++;  

$objSheet->setCellValue('A'.$row, 'Name');
$objSheet->getStyle('A'.$row)->applyFromArray($styleArray);
$objSheet->setCellValue('B'.$row, 'Amount');
$objSheet->getStyle('B'.$row)->applyFromArray($styleArray);
$row++;  
                $total_salary = 0;
                    	            
	            while($salarysql_result = mysqli_fetch_array($salarysql)){ 
	              
	              $total_salary = $total_salary + $salarysql_result[0];
	              $bl="";
                $objSheet->setCellValueExplicitByColumnAndRow(0, $row, $salarysql_result[1],PHPExcel_Cell_DataType::TYPE_STRING);
                $objSheet->setCellValueByColumnAndRow(1, $row, $salarysql_result[0]);
                $row++;
                $srn++;
            }
            
$objSheet->setCellValueExplicitByColumnAndRow(0,$row, 'Total Salary Payment',PHPExcel_Cell_DataType::TYPE_STRING);
$objSheet->setCellValueByColumnAndRow(1, $row, $total_salary);
$row++;              

$row++;  

$objSheet->setCellValue('A'.$row, 'Total Payment');
$objSheet->getStyle('A'.$row)->applyFromArray($styleArray);
$row++; 
$total_amount = $total_salary + $total_vendor;
$objSheet->setCellValueExplicitByColumnAndRow(0,$row, 'Total Amount',PHPExcel_Cell_DataType::TYPE_STRING);
$objSheet->setCellValueByColumnAndRow(1, $row, $total_amount);
$row++;              

$objSheet->getProtection()->setPassword('pass_to_remove_protection');
$objSheet->getProtection()->setSheet(true);
$objSheet->getStyle('A2:B2')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);

 header("Content-Disposition: attachment; filename=check.xls");
 header("Content-Type: application/vnd.ms-excel");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save("php://output",'r');

?>