<?php
include('config.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Generate the spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers
$headers = [
    "Vetical", "Sub Categories", "Payee Type", "BENEFICIARY NAME", "BANK NAME",
    "BENE ACCOUNT NUMBER", "IFSC CODE", "AMOUNT", "DESCRIPTION", "CSS LOCAL BRANCH",
    "STATE", "SUP. NAME", "CUSTOMER", "BANK", "ATM ID", "MONTH", "REMARK"
];
$columnIndex = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue("{$columnIndex}1", $header);
    $columnIndex++;
}

// Fetch data from the database
$sql = mysqli_query($con, "SELECT * FROM eng_fund_request WHERE isPaymentProcessed = 0");
$data = [];
while ($sql_result = mysqli_fetch_assoc($sql)) {
    $mis_id = $sql_result['mis_id'];
    $atmid = $sql_result['atmid'];
    $fund_requested_by = $sql_result['fund_requested_by'];
    $approved_amount = $sql_result['approved_amount'];

    $getmis_datasql = mysqli_query($con, "SELECT customer, branch, state, bm_name FROM mis_newsite WHERE atmid = '".$atmid."'");
    $getmis_datasql_result = mysqli_fetch_assoc($getmis_datasql);

    $customer = $getmis_datasql_result['customer'];
    $branch = $getmis_datasql_result['branch'];
    $state = $getmis_datasql_result['state'];
    $bm_name = $getmis_datasql_result['bm_name'];

    $user_sql = mysqli_query($con, "SELECT * FROM mis_loginusers WHERE id='".$fund_requested_by."'");
    $user_sql_result = mysqli_fetch_assoc($user_sql);

    $personName = $user_sql_result['name'];
    $bank = $user_sql_result['bankname'];
    $account = $user_sql_result['accountNumber'];
    $ifsc = $user_sql_result['ifsc'];
    $contact = $user_sql_result['contact'];

    $currentMonth = date('M');
    $currentYear = date('y');

    $data[] = [
        "SERVICE",
        "$customer - HSK",
        "NA", 
        "$personName - $contact", 
        "$bank", 
        "$account", 
        "$ifsc", 
        "$approved_amount", 
        "Need Amount $approved_amount for service call", 
        "$branch", 
        "$state", 
        "$bm_name", 
        "$customer", 
        "-", 
        "-", 
        "$currentMonth-$currentYear", 
        "other"
    ];
}

// Populate the spreadsheet with data
$rowIndex = 2;
foreach ($data as $row) {
    $columnIndex = 'A';
    foreach ($row as $cell) {
        $sheet->setCellValue("{$columnIndex}{$rowIndex}", $cell);
        $columnIndex++;
    }
    $rowIndex++;
}

// Style the header row
$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
$sheet->getStyle('A1:Q1')->applyFromArray($styleArray);

// Save the file locally
$filename = 'odoo file mis.xlsx';
$filepath = __DIR__ . '/' . $filename;

$writer = new Xlsx($spreadsheet);
$writer->save($filepath);

// Send the email with PHPMailer
$mail = new PHPMailer(true);

try {

        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.hostinger.com';                   
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'tickets@sarsspl.com';               
        $mail->Password   = 'AVav@@2020';                        
        $mail->SMTPSecure = 'tls';        
        $mail->Port       = 587;                                   


    // Email settings
    $mail->setFrom('tickets@sarsspl.com', 'Ticketing System');
    $mail->addAddress('vishwaaniruddh@gmail.com'); // Recipient email
    $mail->Subject = 'Process Payment MIS Service calls';
    $mail->Body = "Hi,\n\nPlease Process Payment MIS Service calls with this Excel attachment.\n\nThanks";

    // Attach the file
    $mail->addAttachment($filepath);

    // Send the email
    $mail->send();
    echo "Email sent successfully.";
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

// Remove the local file after sending the email
unlink($filepath);
?>
