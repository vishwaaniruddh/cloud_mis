<?php session_start();
include('config.php');

if ($_SESSION['username']) {
    include('header.php');
?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-block" style="overflow:auto;">
                                <h5>Footage Records</h5>
                                

                                <?php 
                                $query = "SELECT 
    a.id, 
    a.atmid, 
    a.ticketid, 
    a.batch, 
    a.callReciveDate, 
    a.callreceiveMonth, 
    a.disputeId, 
    a.transaction_type, 
    a.transaction_no, 
    a.m_docket_ticket_id, 
    a.request_by, 
    a.footage_format, 
    a.requested_date, 
    a.start_time, 
    a.end_time, 
    a.txn_time, 
    a.call_attend_by, 
    a.remarks, 
    a.created_by, 
    b.bank, 
    b.address, 
    b.city, 
    b.state, 
    b.zone, 
    b.customer, 
    b.engineer_user_id, 
    b.ip, 
    b.bm_name, 
    c.status,
    CASE 
        WHEN c.status = 'close' THEN c.created_at
        ELSE '-'
    END AS closure_date, 
    c.remark,
    b.dvrname,
    c.lastupdatedBy,
    CASE 
        WHEN c.status = 'close' 
            AND a.callReciveDate IS NOT NULL THEN DATEDIFF(c.created_at, a.callReciveDate)
        WHEN a.callReciveDate IS NOT NULL THEN DATEDIFF(CURDATE(), a.callReciveDate)
        ELSE NULL
    END AS aging_in_days

FROM 
    mis_footage a
INNER JOIN 
    mis_newsite b ON a.atmid = b.atmid
LEFT JOIN 
    (SELECT 
        h.misid, 
        h.status, 
        h.created_at, 
        h.remark,
        h.created_by as lastupdatedBy
     FROM 
        footage_mis_history h
     WHERE 
        h.created_at = (SELECT MAX(h2.created_at) 
                        FROM footage_mis_history h2 
                        WHERE h.misid = h2.misid)) c 
    ON a.id = c.misid

ORDER BY 
    a.id DESC
";
$result = mysqli_query($con, $query);

                                    $result = mysqli_query($con, $query);
                                    
                                    
                                    
                                        
                                        ?>
                                <hr>
                                
                                <form method="post" action="./exportFootageCall.php">
                                    <input type="hidden" name="exportSql" value="<?php echo $query; ?>" />
                                    <!--<input type="submit" name="export" value="Export" class="btn btn-danger" />-->
                                </form>
                                
                                                                           <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                <!--<table id="example" class="table table-striped table-bordered">-->
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Ticket ID</th>
                                            <th>Batch</th>
                                            
                                            <th>Call Receive Date</th>
                                            
                                            <th>Month</th>
                                            <th>Aging</th>
                                            <th>Dispute ID</th>
                                            
                                            <th>M-Docket</th>
                                            <th>Transaction Type</th>
                                            <th>Transaction Number</th>

                                            <th>Client</th>
                                            <th>Bank</th>
                                            
                                            <th>ATM ID</th>
                                            <th>Engg Name</th>
                                            
                                            <th>NVR / DVR IP</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            
                                            <th>Zone</th>
                                            <th>BM</th>
                                            <th>Request By</th>
                                            
                                            <th>Footage Format</th>
                                            <th>Requested Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>TXN Time</th>
                                            <th>Call Attend by</th>
                                            
                                            <th>Remarks</th>
                                            
                                            <th>Status</th>
                                            <th>Closer Date</th>
                                            <th>Remarks</th>
                                            <th>DVR Make</th>
                                            <th>Created By</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch data from mis_footage table


                                        if (mysqli_num_rows($result) > 0) {
                                            
                                            
                                            
                                            
                                            
                                            $count=1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                
                                                
                                                // print_r($row); 
                                                
                                                    
                                                
                                                
                                                $footageid = $row['id'];
                                                echo "<tr>";
                                                echo "<td>" . $count . "</td>" ;
                                                echo "<td><a href='./viewfootagemisdetail.php?id=" . $footageid . "'>" . $row['ticketid'].$footageid . "</a></td>";
                                                echo "<td>" . $row['batch'] . "</td>";
                                                echo "<td>" . $row['callReciveDate'] . "</td>";
                                                echo "<td>" . $row['callreceiveMonth'] . "</td>";
                                                echo "<td>" . $row['aging_in_days'] . "</td>";
                                                
                                                echo "<td>" . $row['disputeId'] . "</td>";
                                                echo "<td>" . $row['m_docket_ticket_id'] . "</td>";
                                                
                                                echo "<td>" . $row['transaction_type'] . "</td>";
                                                echo "<td>" . $row['transaction_no'] . "</td>";
                                                
                                                
                                                echo "<td>" . $row['customer'] . "</td>";
                                                echo "<td>" . $row['bank'] . "</td>";
                                                echo "<td>" . $row['atmid'] . "</td>";
                                                echo "<td>" . get_member_name($row['engineer_user_id']) . "</td>";
                                                
                                                

                                                echo "<td>" . $row['ip'] . "</td>";
                                                echo "<td>" . $row['address'] . "</td>";
                                                echo "<td>" . $row['city'] . "</td>";
                                                echo "<td>" . $row['state'] . "</td>";
                                                echo "<td>" . $row['zone'] . "</td>";
                                                echo "<td>" . $row['bm_name'] . "</td>";
                                                echo "<td>" . $row['request_by'] . "</td>";
                                                
                                                
                                                
                                                
                                                
                                                echo "<td>" . $row['footage_format'] . "</td>";
                                                echo "<td>" . $row['requested_date'] . "</td>";
                                                echo "<td>" . $row['start_time'] . "</td>";
                                                echo "<td>" . $row['end_time'] . "</td>";
                                                echo "<td>" . $row['txn_time'] . "</td>";
                                                echo "<td>" . get_member_name($row['lastupdatedBy']) . "</td>";
                                                echo "<td>" . $row['remark'] . "</td>";
                                                
                                                
                                                echo "<td>" . $row['status'] . "</td>";
                                                echo "<td>" . $row['created_at'] . "</td>";
                                                echo "<td>" . $row['remark'] . "</td>";
                                                echo "<td>" . $row['dvrname'] . "</td>";
                                                
                                                
                                                
                                                echo "<td>" . get_member_name($row['created_by']) . "</td>";
                                                
                                                echo "</tr>";
                                                $count++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='12'>No records found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
<?php
} else { ?>
    <script>
        window.location.href = "login.php";
    </script>
<?php
}
?>

<script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function() {
        $('#footageTable').DataTable();
    });
</script>


        <script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>




<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>



</body>
</html>

