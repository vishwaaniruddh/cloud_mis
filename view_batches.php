<?php
session_start();
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
                            <div class="card-header">
                                <h5>View Batches</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="batchesTable">
                                        <thead>
                                            <tr>
                                                <th>Batch ID</th>
                                                <th>Batch Name</th>
                                                <th>Total Amount</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM eng_fund_batches ORDER BY created_at DESC";
                                            $result = mysqli_query($con, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>
                                                        <td>{$row['id']}</td>
                                                        <td>{$row['batch_name']}</td>
                                                        <td>{$row['total_amount']}</td>
                                                        <td>{$row['created_by']}</td>
                                                        <td>{$row['created_at']}</td>
                                                        <td>
                                                            <a href='view_batch_details.php?batch_id={$row['id']}' class='btn btn-primary btn-sm'>View Details</a>
                                                        </td>
                                                      </tr>";
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

    <script src="../datatable/jquery.dataTables.min.js"></script>
    <script src="../datatable/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#batchesTable').DataTable();
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
