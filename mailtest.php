<?php
// Database connection settings
include('config.php');

require('PHPExcel.php');
include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

// require_once 'Classes/PHPExcel.php';
// require_once "Classes/PHPExcel/IOFactory.php";
// include_once 'Classes/PHPExcel/Writer/Excel5.php';

require 'mail/PHPMailer/src/PHPMailer.php';
require 'mail/PHPMailer/src/SMTP.php';
require 'mail/PHPMailer/src/Exception.php';

// Fetch data from the database
$query = "SELECT Customer,Bank,ATMID FROM sites where Customer='hitachi' and Bank='icici'";
$result = mysqli_query($con,$query);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}

// echo mysqli_num_rows($result); die; 



if (mysqli_num_rows($result) > 0) {
    // Create a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    $objSheet = $objPHPExcel->getActiveSheet();

    // Fetch column names from the database result 
    // $columns = array_keys(mysqli_fetch_assoc($result));

    // Set the headers (column names) in the Excel file
    $col = 'A';
    // foreach ($columns as $columnName) {
    //     $objSheet->setCellValue($col . '1', $columnName);
    //     $col++;
    // }

    $row = 2; 
    
    
    
    
    $message = '<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
                         style="border-collapse:collapse;border:none">
                
                <tr style="height:14.5pt">
                    <td width=51 nowrap valign=top style="width:38.0pt;border:solid windowtext 1.0pt;
                          padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><b><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">SN</span></b></p>
                          </td>

                          <td width=329 nowrap valign=top style="width:247.0pt;border:solid windowtext 1.0pt;
                          border-left:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><b><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">ATMID</span></b></p>
                          </td>

                          <td width=168 nowrap valign=top style="width:125.85pt;border:solid windowtext 1.0pt;
                          border-left:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><b><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">Customer</span></b></p>
                          </td>
                          </tr>';
                          
                          $srno=1;
                        // $qry="SELECT Customer,Bank,ATMID FROM sites where Customer='hitachi' and Bank='icici' ";
                        // $result = mysqli_query($con,$qry);
                        while($sql2fetch=mysqli_fetch_assoc($result)){
                          	     $customer = $sql2fetch['Customer'];
                          	     $atmid = $sql2fetch['ATMID'];
                        
                        $message .= '<tr style="height:14.5pt">
                          <td width=51 nowrap valign=top style="width:38.0pt;border:solid windowtext 1.0pt;
                          border-top:none;padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">'.$srno.'</span></p>
                          </td>
                        
                          <td width=329 valign=top style="width:247.0pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">'.$atmid.'</span></p>
                          </td>
                        
                        
                          <td width=168 nowrap valign=top style="width:125.85pt;border-top:none;
                          border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          padding:0in 5.4pt 0in 5.4pt;height:14.5pt">
                          <p class=MsoNormal style="margin-bottom:0in;line-height:normal"><span
                          lang=EN-IN style="font-size:10.5pt;
                          border:none windowtext 1.0pt;padding:0in;background:white">'.$customer.'</span></p>
                          </td>
                        
                         </tr>';
                             $srno++;
                        }
                        
                        $message .= '</table>'; 
    
    

    // mysqli_data_seek($result, 0); 

    // while ($rowdata = mysqli_fetch_assoc($result)) {
    //     $col = 'A';
    //     foreach ($rowdata as $value) {
    //         $objSheet->setCellValue($col . $row, $value);
    //         $col++;
    //     }
    //     $row++;
    // }

    // Save the Excel file
    $excelFileName = 'test/data.xls';
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($excelFileName);

    // Email configuration
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'mail.sarmicrosystems.in';
    $mail->SMTPAuth = true;
    $mail->Username = 'rajeshbiswas@sarmicrosystems.in';
    $mail->Password = 'rajesh.biswas@12345';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('rajeshbiswas@sarmicrosystems.in', 'Tester');
    $mail->addAddress('rajeshrungta719@gmail.com', 'Rajesh');

    // Email subject and body
    $mail->isHTML(true); 
    $mail->Subject = 'Excel Data';
    $mail->Body = $message;

    // Attach the Excel file
    // $mail->addAttachment($excelFileName);

    // Send the email
    if ($mail->send()) {
        echo 'Email sent successfully';
    } else {
        echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
    }
} else {
    echo 'No data found in the database.';
}

// Close the database connection
mysqli_close($con);
?>
