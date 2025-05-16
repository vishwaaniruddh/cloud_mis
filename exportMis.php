<?php include('config.php');
require 'vendor/autoload.php';


error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


function getColumnLabel($index) {
    $base26 = '';
    
    // Calculate the first part of the label (A, B, C, ...)
    if ($index >= 26) {
        $base26 .= chr(65 + ($index / 26) - 1);
    }
    
    // Calculate the second part of the label (A, B, C, ...)
    $base26 .= chr(65 + ($index % 26));
    
    return $base26;
}




if (!function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
}
if (!function_exists('clean')) {
    function clean($string)
    {
        $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }
}
if (!function_exists('remove_special')) {

    function remove_special($site_remark2)
    {
        $site_remark2_arr = explode(" ", $site_remark2);

        foreach ($site_remark2_arr as $k => $v) {
            $a[] = preg_split('/\n/', $v);
        }

        $site_remark = '';
        foreach ($a as $key => $value) {
            foreach ($value as $ke => $va) {
                $site_remark .= $va . " ";
            }
        }

        return clean($site_remark);
    }
}

 $sql_query = $_REQUEST['exportSql'] ;


$sql_app = mysqli_query($con, $sql_query);




// Set Header Styles
$headerStyle = [
     'font' => [
        'bold' => true, // Make the text bold
        'color' => ['rgb' => 'FFFFFF'], // Font color (white)
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '0070C0'], // Background color (blue)
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'], // Border color (black)
        ],
    ],
];





$date = date('Y-m-d');
$date1 = date_create($date);

$headers = array(
    'SR',
    'TicketId',
    'Customer',
    'Bank',
    'Atmid',
    'Atm Address',
    'City',
    'State',
    'Branch',
    'Call Type',
    'Call Receive From',
    'Component',
    'Sub Component',
    'Current Status',
    'Current Status Remarks',
    'Schedule Date',
    'Schedule Remark',
    'Material Condition',
    'Required Material Name',
    'Material Remark',
    'Courier Agency (Material Dispatch)',
    'POD (Material Dispatch)',
    'Serial Number',
    'Material dispatch date ',
    'Material Dispatch Remark',
    'DOCKET NO',
    'Footage Status',
    'REQUEST FOOTAGE DATE',
    'Time From',
    'Time To',
    'Close Type',
    'Close Remark',
    'Last Action By',
    'Last Action Date',
    'Call Log Date',
    'Call Log By',
    'BM',
    'Aging',
    'Call Log Remark',
    'Engineer Name',
    'Engineer Contact Number',
    'Call Receive from',
    'Footage Format',
    'Footage TXN Time'
);


// Apply Header Styles
foreach ($headers as $index => $header) {
    $column = getColumnLabel($index);
    $sheet->setCellValue($column . '1', $header);
    $sheet->getStyle($column . '1')->applyFromArray($headerStyle);
    //   $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);

}



$i = 2; // Start from row 2 for data

$counter=1; 
while ($sql_result = mysqli_fetch_assoc($sql_app)) {



    $id = '';
    $createdBy = '';
    $site_eng_contact = '';
    $mis_id = '';
    $closed_date = '';
    $date2 = '';
    $atmid = '';
    $bm_name = '';
    $status = '';
    $created_by = '';
    $customer = '';
    $ticket_id = '';
    $createdBy = '';
    $mis_id = '';
    $closed_date = '';
    $date2 = '';
    $bank = '';
    $atmid = '';
    $bm_name = '';
    $status = '';
    $created_by = '';
    $site_eng_contact = '';
    $city = '';
    $call_type = '';
    $case_type = '';
    $component = '';
    $subcomponent = '';
    $footage_date = '';
    $fromtime = '';
    $totime = '';
    $created_at = '';
    $remarks = '';
    $site_engineer = '';
    $site_engineer_contact = '';
    $serial_number  = '';
    $status_remark = '';
    $schedule_date = '';
    $material_condition = '';
    $material = '';
    $material_req_remark = '';
    $courier_agency = '';

    $pod = '';
    $serial_number = '';
    $dispatch_date  = '';
    $material_dispatch_remark = '';
    $docket_no = '';
    $footage_date = '';
    $fromtime = '';
    $totime = '';
    $close_type = '';
    $close_remark = '';
    $last_action_by = '';
    $created_date = '';
    $created_at = '';
    $createdBy = '';
    $bm_name = '';
    $remarks = '';
    $site_engineer = '';
    $site_engineer_contact = '';
    $schedule_remark = '';
    $footage_status = '';


    $id = $sql_result['id'];
    $createdBy = $sql_result['createdBy'];
    $site_eng_contact = $sql_result['eng_name_contact'];
    if ($site_eng_contact == '') {
        $site_engineer = "";
        $site_engineer_contact = "";
    } else {
        $site_engcontact = explode("_", $site_eng_contact);
        $site_engineer = $site_engcontact[0];
        $site_engineer_contact = $site_engcontact[1];
    }

    $mis_id = $sql_result['mis_id'];

    $historydate = mysqli_query($con, "select created_at from mis_history where mis_id='" . $id . "' order by id desc limit 1");
    $created_date_result = mysqli_fetch_row($historydate);
    

    
    $created_date = $created_date_result[0];

    $closed_date = $sql_result['close_date'];

    if ($closed_date != '0000-00-00') {
        $date1 = date_create($closed_date);
    }

    $date2 = $sql_result['created_at'];
    $cust_date2 = date('Y-m-d', strtotime($date2));

    $cust_date2 = date_create($cust_date2);
    $diff = date_diff($date1, $cust_date2);
    $atmid = $sql_result['atmid'];

    $bm_name = $sql_result['bm'];
    $docket_no = $sql_result['docket_no'];
    $status = $sql_result['status'];
    $created_by = $sql_result['created_by'];
    $aging_day = $diff->format("%a");

    $mis_his_key = 0;

    $lastactionsql = mysqli_query($con, "select type,created_by,remark,schedule_date,material,material_condition,courier_agency,pod,serial_number,dispatch_date,(SELECT name FROM mis_loginusers WHERE id=mis_history.created_by) AS last_action_by from mis_history where mis_id='" . $id . "' order by id desc");
    if ($lastactionsql_result = mysqli_fetch_assoc($lastactionsql)) {

        $his_type = $lastactionsql_result['type'];


        $lastactionuserid = $lastactionsql_result['created_by'];
        $status_remark = $lastactionsql_result['remark'];

        if ($mis_his_key == 0) {
            $last_action_by = $lastactionsql_result['last_action_by'];
        }
        $mis_his_key = $mis_his_key + 1;
        $schedule_date = "";
        if ($his_type == 'schedule') {
            $schedule_date = $lastactionsql_result['schedule_date'];
            $schedule_remark = $lastactionsql_result['remark'];
        }


        $material = "";
        $material_req_remark = "";
        if ($his_type == 'material_requirement' || $his_type=='material_dispatch' || $his_type=='Material Request Approved' ) {
            $material = $lastactionsql_result['material'];
            $material_req_remark = $lastactionsql_result['remark'];
            $material_condition = $lastactionsql_result['material_condition'];
        }
        
        $courier_agency = "";
        $pod = "";
        $serial_number = "";
        $dispatch_date = "";
        $material_dispatch_remark = "";
        // if($his_type=='material_dispatch'){
        $courier_agency = $lastactionsql_result['courier_agency'];
        $pod = $lastactionsql_result['pod'];
        $serial_number = $lastactionsql_result['serial_number'];
        $dispatch_date = $lastactionsql_result['dispatch_date'];
        $material_dispatch_remark = $lastactionsql_result['remark'];
        // }
        $close_type = "";
        $close_remark = "";
        $close_created_at = "";
        $attachment = "";
        if ($his_type == 'close') {
            $close_type = $lastactionsql_result['close_type'];
            $close_remark = $lastactionsql_result['remark'];
            $close_created_at = $lastactionsql_result['created_at'];
            $attachment = $lastactionsql_result['attachment'];
        }
         if($his_type=='material_dispatch'){
            $courier_agency = $lastactionsql_result['courier_agency'];
            $pod = $lastactionsql_result['pod'];
            $serial_number = $lastactionsql_result['serial_number'];
            $dispatch_date = $lastactionsql_result['dispatch_date'];
            $material_dispatch_remark = $lastactionsql_result['remark'];
        }
    }
    
$matCondition = mysqli_query($con,"select * from mis_history where mis_id='".$id."' ORDER BY `mis_history`.`material_condition` DESC");
    $matConditionResult = mysqli_fetch_assoc($matCondition); 

    $material_condition = $matConditionResult['material_condition'];
    
    


    $customer = $sql_result['customer'];
    $ticket_id = $sql_result['ticket_id'];
    $createdBy = $sql_result['createdBy'];
    $mis_id = $sql_result['mis_id'];
    $closed_date = $sql_result['close_date'];
    $date2 = $sql_result['created_at'];
    $bank = $sql_result['bank'];
    $atmid = $sql_result['atmid'];
    $bm_name = $sql_result['bm'];
    $status = $sql_result['status'];
    $created_by = $sql_result['created_by'];
    $site_eng_contact = $sql_result['eng_name_contact'];
    $city = $sql_result['city'];
    $state = $sql_result['state'];
    $branch = $sql_result['branch'];
    $call_type = $sql_result['call_type'];
    $case_type = $sql_result['case_type'];
    $component = $sql_result['component'];
    $subcomponent = $sql_result['subcomponent'];

    $footage_date = $sql_result['footage_date'];
    $fromtime = $sql_result['fromtime'];
    $totime = $sql_result['totime'];
    $close_type = "";

    $created_at = $sql_result['created_at'];
    $remarks = $sql_result['remarks'];
    $site_engineer = $sql_result['eng_name'];
    $site_engineer_contact = $sql_result['eng_contact'];
    $serial_number = $sql_result['serial_number'];
$footage_status = $sql_result['footage_status'];


    $sheet->getStyle('A' . $i . ':AN' . $i)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'], // Border color (black)
            ],
        ],
    ]);





    $sheet->setCellValue('A' . $i, $counter);
    $sheet->setCellValue('B' . $i, ($ticket_id ? $ticket_id : '-'));
    $sheet->setCellValue('C' . $i, ($customer ? $customer : '-'));
    $sheet->setCellValue('D' . $i, ($bank ? $bank : '-'));
    $sheet->setCellValue('E' . $i, ($atmid ? $atmid : '-'));
    // $sheet->setCellValue('F' . $i, ($sql_result['location'] ? $sql_result['location'] : '-'));
    $sheet->setCellValue('F' . $i, mb_convert_encoding($sql_result['location'], 'UTF-8', 'ISO-8859-1'));

    $sheet->setCellValue('G' . $i, ($city ? $city : '-'));
    $sheet->setCellValue('H' . $i, ($state ? $state : '-'));
    $sheet->setCellValue('I' . $i, ($branch ? $branch : '-'));
    $sheet->setCellValue('J' . $i, ($call_type ? $call_type : '-'));
    $sheet->setCellValue('K' . $i, ($case_type ? $case_type : '-'));
    $sheet->setCellValue('L' . $i, ($component ? $component : '-'));
    $sheet->setCellValue('M' . $i, ($subcomponent ? $subcomponent : '-'));
    $sheet->setCellValue('N' . $i, ($status ? $status : '-'));
    $sheet->setCellValue('O' . $i, (strtolower($status)=='open' ? '-' :  ($status_remark ? $status_remark : '-')  ));
    $sheet->setCellValue('P' . $i, ($schedule_date ? $schedule_date : '-'));
    $sheet->setCellValue('Q' . $i, ($schedule_remark ? $schedule_remark : '-'));
    $sheet->setCellValue('R' . $i, ($material_condition ? $material_condition : '-'));
    $sheet->setCellValue('S' . $i, ($material ? $material : '-'));
    $sheet->setCellValue('T' . $i, ($material_req_remark ? $material_req_remark : '-'));
    $sheet->setCellValue('U' . $i, (trim($courier_agency) ? trim($courier_agency) : '-'));
    $sheet->setCellValue('V' . $i, ($pod ? $pod : '-'));
    $sheet->setCellValue('W' . $i, ($serial_number ? $serial_number : '-'));
    $sheet->setCellValue('X' . $i, ($dispatch_date ? $dispatch_date : '-'));
    $sheet->setCellValue('Y' . $i, ($material_dispatch_remark ? $material_dispatch_remark : '-'));
    $sheet->setCellValue('Z' . $i, ($docket_no ? $docket_no : '-'));
    $sheet->setCellValue('AA' . $i, ($footage_status ? $footage_status : '-'));
    
    $sheet->setCellValue('AB' . $i, ($footage_date ? $footage_date : '-'));
    $sheet->setCellValue('AC' . $i, ($fromtime ? $fromtime : '-'));
    $sheet->setCellValue('AD' . $i, ($totime ? $totime : '-'));
    $sheet->setCellValue('AE' . $i, ($close_type ? $close_type : '-'));
    $sheet->setCellValue('AF' . $i, ($close_remark ? $close_remark : '-'));
    $sheet->setCellValue('AG' . $i, ($last_action_by ? $last_action_by : '-'));
    $sheet->setCellValue('AH' . $i, ($created_date ? $created_date : '-'));
    $sheet->setCellValue('AI' . $i, ($created_at ? $created_at : '-'));
    $sheet->setCellValue('AJ' . $i, ($createdBy ? $createdBy : '-'));
    $sheet->setCellValue('AK' . $i, ($bm_name ? $bm_name : '-'));
    $sheet->setCellValue('AL' . $i, ($diff->format("%a days") ? $diff->format("%a days") : '-'));
    $sheet->setCellValue('AM' . $i, ($remarks ? $remarks : '-'));
    $sheet->setCellValue('AN' . $i, ($site_engineer ? $site_engineer : '-'));
    $sheet->setCellValue('AO' . $i, ($site_engineer_contact ? $site_engineer_contact : '-'));
    
    $sheet->setCellValue('AP' . $i, ($sql_result['footage_requestBy'] ? $sql_result['footage_requestBy'] : '-'));
    $sheet->setCellValue('AQ' . $i, ($sql_result['footage_format'] ? $sql_result['footage_format'] : '-'));
    $sheet->setCellValue('AR' . $i, ($sql_result['footage_txn_time'] != '05:30:00' ? $sql_result['footage_txn_time'] : '-'));
    


    $i++;
$counter++ ; 
}

 
// Create a writer to save the Excel file
$writer = new Xlsx($spreadsheet);

// Save the Excel file to a temporary location
$tempFile = tempnam(sys_get_temp_dir(), 'Inventory');
$writer->save($tempFile);

// Provide the file as a download to the user
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Exported MIS.xlsx"');
header('Cache-Control: max-age=0');
readfile($tempFile);

// Close the database connection
mysqli_close($con);

// Clean up and delete the temporary file
unlink($tempFile);
