<?php
include('../config.php');
$id = $_GET['id'];
$sqlapp = "select * from mis_newvisit_app where id = '".$id."'  ";
$sqlapp2 = "select * from mis_newvisit_app where id = '".$id."'  ";

$sql_app = mysqli_query($con, $sqlapp);
$sql_app2 = mysqli_query($con, $sqlapp2);

$sql_app_result = mysqli_fetch_assoc($sql_app2);
$atmid = $sql_app_result['atmid'];

$customer = $sql_app_result['customer'];
$bank = $sql_app_result['bank'];
$location = $sql_app_result['location'] ; 
$engineer = $sql_app_result['engineer'];
$created_at = $sql_app_result['created_at'];



require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator('Comfort');
$pdf->SetAuthor('Comfort');
$pdf->SetTitle('Quarterly Maintenance Report');
$pdf->SetSubject('Quarterly Maintenance Report');
$pdf->SetKeywords('Quarterly Maintenance Report');

// Add a page
$pdf->AddPage();

// Set font for the rest of the document
$pdf->SetFont('helvetica', '', 10);

// Add content as an HTML table
$html = '
<table border="1" cellpadding="4">
    <tr style="background-color:#bebebe;">
        <td colspan="3">Quarterly Maintenance Report</td>
    </tr>
    <tr>
        <td><b>ATM Site ID:</b> '.$atmid.'</td>

        <td><b>Date & Time:</b> '.$created_at.'</td>
        <td><b>Panel ID:</b></td>        
    </tr>

    <tr>
        <td><b>Client/Bank Name:</b> </td>
        <td colspan="2">'.$customer.'/'.$bank.'</td>
    </tr>
    <tr>
        <td><b>Address:</b></td>
        <td colspan="2">'.$location.'</td>
    </tr>
    <tr>
        <td><b>Inspection Engineer Name:</b></td>
        <td>'.$engineer.'</td>
        <td><b>Area Manager:</b></td>
    </tr>

    <tr style="background-color:#bebebe;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><b>PM Details</b></td>
    </tr>
    <tr style="background-color:#f1f1f1;text-align:center;">
        <td><b>SN</b></td>
        <td><b>Equipment installed</b></td>
        <td><b>Working/ Not Working</b></td>
    </tr>';

if ($sql_result_app = mysqli_fetch_assoc($sql_app)) {
    $list_head = $sql_result_app["checklist_json"];
    $datajson = json_decode($list_head);
    if ($list_head != '') {
        $counter = 1;
        for ($i = 0; $i < count($datajson); $i++) {
            $key = str_replace("_", " ", $datajson[$i]->k);
            $value = str_replace("_", " ", $datajson[$i]->v);
            $html .= '
                <tr style="text-align:center;">
                    <td>' . $counter . '</td>
                    <td>' . $key . '</td>
                    <td>' . $value . '</td>
                </tr>';
        $counter++ ;
            
        }
    }
}

$html .= '
    <tr style="background-color:#f1f1f1;">
        <td>Testing Done By:</td>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>';

$pdf->writeHTML($html);

// Output the PDF
$pdf->Output('equipment_installation_report.pdf', 'I');
?>
