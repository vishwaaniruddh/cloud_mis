<?php
session_start();
include('config.php');

if ($_SESSION['username']) {
    include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
    <style>
        .wallet-card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .wallet-card h4 {
            margin-bottom: 15px;
            font-weight: bold;
        }

        .wallet-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .wallet-info div {
            text-align: center;
        }

        .wallet-info div h5 {
            margin-bottom: 5px;
            color: #007bff;
        }

        .wallet-info div span {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-block">
                                <h4>Wallet Overview</h4>
                                <hr>
                                <div class="wallet-card">
                                    <?php
                                    // Query to fetch wallet data
                                    $userid = $_SESSION['userid']; // Assuming user ID is stored in session
                                    $query = "
                                        SELECT 
                                            IFNULL(SUM(approved_amount), 0) AS total_received,
                                            IFNULL(SUM(finalUtilisedAmount), 0) AS total_utilised,
                                            IFNULL(SUM(approved_amount) - SUM(finalUtilisedAmount), 0) AS available_funds
                                        FROM 
                                            eng_fund_request 
                                        WHERE 
                                            fund_requested_by = '$userid' and isPaymentProcessed=1";
                                    $result = mysqli_query($con, $query);
                                    $walletData = mysqli_fetch_assoc($result);

                                    $totalReceived = $walletData['total_received'];
                                    $totalUtilised = $walletData['total_utilised'];
                                    $availableFunds = $walletData['available_funds'];
                                    ?>
                                    <div class="wallet-info">
                                        <div>
                                            <h5>Money Received</h5>
                                            <span>₹<?php echo number_format($totalReceived, 2); ?></span>
                                        </div>
                                        <div>
                                            <h5>Amount Utilized</h5>
                                            <span>₹<?php echo number_format($totalUtilised, 2); ?></span>
                                        </div>
                                        <div>
                                            <h5>Available Funds</h5>
                                            <span>₹<?php echo number_format($availableFunds, 2); ?></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="card">
                            <div class="card-block">
                                <h4>Transaction History</h4>
                                <div class="table-responsive">
                                    <!--<table id="walletTransactions" class="table table-bordered table-striped">-->
                                    <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">

                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Fund ID</th>
                                                <th>ATM ID</th>
                                                <th>Payment Status</th>
                                                <th>Requested Amount</th>
                                                <th>Approved Amount</th>
                                                <th>Utilized Amount</th>
                                                <th>Available Amount</th>
                                                <th>Invoice</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch transaction details
                                            $transactionQuery = "
                                                SELECT 
                                                    id, atmid, requested_amount, approved_amount, finalUtilisedAmount, isPaymentProcessed,
                                                    (approved_amount - finalUtilisedAmount) AS remaining_amount ,img
                                                FROM 
                                                    eng_fund_request 
                                                WHERE 
                                                    fund_requested_by = '$userid' 
                                                ORDER BY id DESC";
                                            $transactionResult = mysqli_query($con, $transactionQuery);
                                            
                                            $counter = 0 ; 
                                            
                                            while ($transaction = mysqli_fetch_assoc($transactionResult)) {
                                                $isPaymentProcessed = $transaction['isPaymentProcessed'];
                                                echo "<tr>";
                                                echo "<td>" . ++$counter . "</td>";
                                                echo "<td>{$transaction['id']}</td>";
                                                echo "<td>{$transaction['atmid']}</td>";
                                                echo "<td>";
                                                if ($isPaymentProcessed == 1) {
                                                    echo "<span class='badge badge-success'>Done</span>";
                                                }
                                                if ($isPaymentProcessed == 0) {
                                                    echo "<span class='badge badge-warning'>Pending</span>";
                                                }
                                                echo "</td>";

                                                echo "<td>₹" . number_format($transaction['requested_amount'], 2) . "</td>";
                                                echo "<td>₹" . number_format($transaction['approved_amount'], 2) . "</td>";
                                                echo "<td>₹" . number_format($transaction['finalUtilisedAmount'], 2) . "</td>";
                                                echo "<td>₹" . number_format($transaction['remaining_amount'], 2) . "</td>";
                                                echo "<td>";
                                                if (!empty($transaction['img'])) {
                                                    echo "<a href='./{$transaction['img']}' target='_blank'>View</a>";
                                                } else {
                                                    echo "No Invoice";
                                                }
                                                echo "</td>";
                                                echo "</tr>";
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
    </div>
    </div>
    </div>

    <?php include('footer.php'); ?>
<?php
} else {
?>
    <script>
        window.location.href = "login.php";
    </script>
<?php
}
?>

    
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
<script>

</script>
</body>

</html>