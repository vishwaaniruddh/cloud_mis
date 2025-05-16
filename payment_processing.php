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
                                <h4>Payment Processing</h4>
                            </div>
                            <div class="card-block">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#batchTab" role="tab">Batch Payment</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#singleTab" role="tab">Single Payment</a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <!-- Single Payment Tab -->
                                    <div class="tab-pane fade " id="singleTab" role="tabpanel">
                                        <br />
                                        <h4>Pending Fund Requests (Single)</h4>
                                        <br />
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>ATM ID</th>
                                                        <th>Approved Amount</th>
                                                        <th>Requested Amount</th>
                                                        <th>Payment Processed</th>
                                                        <th>Batch Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = mysqli_query($con, "SELECT a.id, a.approved_amount, a.requested_amount, a.isPaymentProcessed, a.atmid, b.batch_name
                                                FROM `eng_fund_request` a  
                                                LEFT JOIN eng_fund_batches b ON a.batch_id = b.id and b.status=1
                                                
                                                WHERE a.isPaymentProcessed = 0
                                                and a.status=1 
                                                ");
                                                
                                                    while ($row = mysqli_fetch_assoc($sql)) {
                                                        $atmid = ucwords($row['atmid']) ; 
                                                        echo "<tr id='row-{$row['id']}'>";
                                                        echo "<td>{$row['id']}</td>";
                                                        echo "<td>{$atmid}</td>";
                                                        echo "<td>{$row['approved_amount']}</td>";
                                                        echo "<td>{$row['requested_amount']}</td>";
                                                        echo "<td>" . ($row['isPaymentProcessed'] == 0 ? 'No' : 'Yes') . "</td>";
                                                        echo "<td>{$row['batch_name']}</td>";
                                                        echo "<td><button class='btn btn-primary process-payment' data-id='{$row['id']}'>Process Payment</button></td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Batch Payment Tab -->
                                    <div class="tab-pane fade show active" id="batchTab" role="tabpanel">
                                        <br />
                                        <p style="text-align:right;"><a href="./make_fund_batch.php" class="badge badge-success">Make New Batch</a></p>
                                        <h4>Batch Fund Requests</h4>
                                        <br />




                                        <div class="table-responsive">

                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Batch ID</th>
                                                        <th>Batch Name</th>
                                                        <th>Total Amount</th>
                                                        <th>Created By</th>
                                                        <th>Created At</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $batch_sql = mysqli_query($con, "SELECT * FROM eng_fund_batches where status=1");
                                                    while ($batch = mysqli_fetch_assoc($batch_sql)) {
                                                        echo "<tr id='batch-row-{$batch['id']}'>";
                                                        echo "<td>{$batch['id']}</td>";

                                                        // Make batch name clickable
                                                        echo "<td><a href='#' class='batch-name' data-id='{$batch['id']}' data-toggle='modal' data-target='#batchModal' data-name='{$batch['batch_name']}'>{$batch['batch_name']}</a></td>";

                                                        echo "<td>{$batch['total_amount']}</td>";
                                                        echo "<td>{$batch['created_by']}</td>";
                                                        echo "<td>{$batch['created_at']}</td>";

                                                        // Determine status text
                                                        $status_text = $batch['isBatchProcessed'] == 0 ? 'Pending' : ($batch['status'] == 1 ? 'Processed' : 'Rejected');
                                                        echo "<td>{$status_text}</td>";

                                                        if ($batch['isBatchProcessed'] == 0) {
                                                            echo "<td>
                                                            <button class='btn btn-success process-batch' data-id='{$batch['id']}'>Process Payment</button>
                                                            <a href='view_batch_details.php?batch_id={$batch['id']}' class='btn btn-primary'>View</a>
                                                            <button class='btn btn-success process-batch-bot' data-id='{$batch['id']}'>Process Bot And Send Email</button>
                                                        </td>";
                                                        } else {
                                                            echo "<td>Action Completed</td>";
                                                        }
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>



                                    </div>
                                </div> <!-- End Tab Content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade modal-flex" id="batchModal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchModalLabel">Batch Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="batchNameContent"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
document.addEventListener('DOMContentLoaded', function () {
    const batchLinks = document.querySelectorAll('.batch-name');

    batchLinks.forEach(link => {
        link.addEventListener('click', function () {
            const batchId = this.dataset.id;

            if (!batchId) {
                console.error('Batch ID is missing!');
                return;
            }

            // Send AJAX request
            $.ajax({
                url: 'get_batch_details.php', // Endpoint to fetch batch details
                type: 'GET',
                data: { batch_id: batchId },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.status === 'success') {
                        renderBatchTable(result.data);
                    } else {
                        $('#batchNameContent').html(`<p class="text-danger">${result.message}</p>`);
                    }
                },
                error: function () {
                    $('#batchNameContent').text('Failed to load batch details.');
                }
            });
        });
    });

    function renderBatchTable(data) {
        if (!data || data.length === 0) {
            $('#batchNameContent').html('<p>No records found for this batch.</p>');
            return;
        }

        let tableHTML = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Batch ID</th>
                        <th>ATMID</th>
                        <th>Type</th>
                        <th>Components</th>
                        <th>Total Amount</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
        `;

        data.forEach(record => {
            tableHTML += `
                <tr>
                    <td>${record.id}</td>
                    <td>${record.atmid}</td>
                    <td>${record.fund_type}</td>
                    <td>${record.fund_component}</td>
                    <td>${record.approved_amount}</td>
                    <td>${record.created_at}</td>

                </tr>
            `;
        });

        tableHTML += `
                </tbody>
            </table>
        `;

        $('#batchNameContent').html(tableHTML);
    }
});


        
    </script>



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

<script src="../jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Single Payment Processing
        $('.process-payment').on('click', function() {
            const id = $(this).data('id');
            const button = $(this);

            if (confirm('Are you sure you want to process this payment?')) {
                $.ajax({
                    url: 'process_payment.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response === 'success') {
                            alert('Payment processed successfully!');
                            $('#row-' + id).find('td:nth-child(5)').text('Yes');
                            button.prop('disabled', true);
                            window.location.reload();
                        } else {
                            alert('Failed to process payment. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while processing the payment.');
                    }
                });
            }
        });

        // Batch Payment Processing
$('.process-batch').on('click', function() {
    const batchId = $(this).data('id');
    const button = $(this);

    if (confirm('Are you sure you want to process this batch?')) {
        $.ajax({
            url: 'process_batch_payment.php',
            type: 'POST',
            dataType: 'json', // Expecting JSON response
            data: {
                batch_id: batchId
            },
            success: function(response) {
                if (response.total) { // Check if response contains the counters
                    alert(
                        `Batch processed successfully!\n` +
                        `Total Requests: ${response.total}\n` +
                        `Successful: ${response.successcounter}\n` +
                        `Failed: ${response.errorcounter}`
                    );
                    button.prop('disabled', true); // Disable button after processing
                } else {
                    alert('Failed to process batch. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while processing the batch.');
            }
        });
    }
});

        // Batch Payment Processing
$('.process-batch-bot').on('click', function() {
    const batchId = $(this).data('id');
    const button = $(this);

    if (confirm('Are you sure you want to process this batch?')) {
        $.ajax({
            url: 'process_batch_payment_odooo.php',
            type: 'POST',
            dataType: 'json', // Expecting JSON response
            data: {
                batch_id: batchId
            },
            success: function(response) {
                if (response==1) { // Check if response contains the counters
                    alert(
                        `Batch processed successfully!\n`
                    );
                } else {
                    alert('Failed to process batch. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while processing the batch.');
            }
        });
    }
});




    });
</script>
