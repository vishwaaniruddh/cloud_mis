<?php

$con;
if(isset($_REQUEST['atmid'])){
include('./config.php');

    $atmid = $_REQUEST['atmid'];
    
}

$sql = mysqli_query($con, "SELECT * FROM fund_distribution WHERE atmid='" . mysqli_real_escape_string($con, $atmid) . "' ORDER BY created_at DESC");

$totalAmount = 0;
$totalTransactions = 0;
$payeeType = "";
$requester = "";
$lastFundTransferDate = "-";
$fundHistory = "";

if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        $totalAmount += $row['AMOUNT'];
        $totalTransactions++;
        $payeeType = $row['Payee_Type'];
        $requester = $row['Requester'];
        $lastFundTransferDate = $row['Fund_Transfer_Date'] ? date('d-M-Y', strtotime($row['Fund_Transfer_Date'])) : "-";

        $fundHistory .= "<tr class='hover-row'>
            <td><b>" . date('d-M-Y', strtotime($row['created_at'])) . "</b></td>
            <td><span class='badge badge-success'>₹" . number_format($row['AMOUNT'], 2) . "</span></td>
            <td>" . ucfirst($row['Requester']) . "</td>
            <td>" . date('d-M-Y', strtotime($row['Request_Date'])) . "</td>
            <td>" . date('d-M-Y', strtotime($row['Fund_Transfer_Date'])) . "</td>
            <td><span class='badge badge-primary'>" . ucfirst($row['Work_Type']) . "</span></td>
            <td>" . ucfirst($row['DESCRIPTION']) . "</td>
            <td>" . ucfirst($row['REMARK']) . "</td>
            <td><span class='badge badge-" . ($row['Fund_Transfer_Status'] == 'Completed' ? 'success' : 'warning') . "'>" . ucfirst($row['Fund_Transfer_Status']) . "</span></td>
            <td>" . ucfirst($row['Work_Status']) . "</td>
        </tr>";
    }

    echo "<div class='card shadow p-3 mb-3'>
        <h5 class='mb-3'>📊 <b>Fund Summary</b></h5>
        <div class='list-group'>
            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Total Amount:</b> <span class='text-success'>₹" . number_format($totalAmount, 2) . "</span>
            </div>

            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Total Transactions:</b> <span class='text-dark'>" . $totalTransactions . "</span>
            </div>
            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Last Fund Transfer Date:</b> <span class='text-danger'>" . $lastFundTransferDate . "</span>
            </div>
        </div>
    </div>";

    echo "<h5 class='mb-3'>📋 <b>Detailed Fund Transfer History</b></h5>
    <div class='historyFundData' style='overflow:scroll;'>
    <table class='table table-hover table-bordered'>
        <thead class='thead-dark'>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Requester</th>
                <th>Request Date</th>
                <th>Fund Transfer Date</th>
                <th>Work Type</th>
                <th>Description</th>
                <th>Remark</th>
                <th>Fund Status</th>
                <th>Work Status</th>
            </tr>
        </thead>
        <tbody>$fundHistory</tbody>
    </table>
    <div>
    ";
} else {
    echo "<p class='text-center text-danger'><b>No fund history available for this ATM.</b></p>";
}
?>
