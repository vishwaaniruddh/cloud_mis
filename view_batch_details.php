<?php
session_start();
include('config.php');

if ($_SESSION['username']) {
    include('header.php');

    if (!isset($_GET['batch_id'])) {
        echo "<script>alert('Invalid Batch ID.'); window.location.href = 'view_batches.php';</script>";
        exit;
    }

    $batch_id = intval($_GET['batch_id']);
    $batch_query = "SELECT * FROM eng_fund_batches WHERE id = $batch_id";
    $batch_result = mysqli_query($con, $batch_query);
    $batch = mysqli_fetch_assoc($batch_result);

    if (!$batch) {
        echo "<script>alert('Batch not found.'); window.location.href = 'view_batches.php';</script>";
        exit;
    }
    ?>

<style>
    .table tbody tr td, .table  th{
        text-align:center;
    }
</style>
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-header">
                                <h5>Batch Details: <?= htmlspecialchars($batch['batch_name']) ?></h5>
                                <p>Total Amount: <?= number_format($batch['total_amount'], 2) ?></p>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="batchDetailsTable">
                                        <thead>
                                            <tr>

                                                <th>ATM ID</th>
                                                <th>Fund Requested By</th>
                                                <th width="200px;">Approved Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_approved_amount = 0 ; 
                                            $query = "SELECT * FROM eng_fund_request WHERE batch_id = $batch_id";
                                            $result = mysqli_query($con, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                
                                                $approved_amount = $row['approved_amount'] ;
                                                $fund_request_raiser_name = get_member_name($row['fund_requested_by']) ; 
                                                echo "<tr>
                                                        <td>{$row['atmid']}</td>
                                                        <td>{$fund_request_raiser_name}</td>
                                                        <td >&#8377; {$approved_amount}</td>
                                                        <td>" . ($row['isPaymentProcessed'] ? "Processed" : "Pending") . "</td>
                                                      </tr>";
                                                      $total_approved_amount = $total_approved_amount + $approved_amount ;  
                                                      
                                            }
                                            ?>
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo '&#8377; ' . $total_approved_amount ; ?></th>
                                                <th></th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../datatable/jquery.dataTables.min.js"></script>
    <script src="../datatable/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#batchDetailsTable').DataTable();
        });
    </script>

    <?php
    include('footer.php');
} else {
    ?>
    <script>
        window.location.href = "login.php";
    </script>
    <?php
}
?>
