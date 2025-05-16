<?php
session_start();
include('config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SESSION['username']) {
    include('header.php');
?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        
                        
                        
                        <div class="card">
                            <div class="card-block">
                                
<?php 

// Fetch distinct values for filters
$customers = mysqli_query($con, "SELECT DISTINCT customer FROM mis where customer<>''");
$zones = mysqli_query($con, "SELECT DISTINCT zone FROM mis where zone<>''");
$states = mysqli_query($con, "SELECT DISTINCT state FROM mis where state<>''");
$banks = mysqli_query($con, "SELECT DISTINCT bank FROM mis where bank<>''");
$calTypes = mysqli_query($con, "SELECT DISTINCT call_type FROM mis where call_type<>''");
// Get selected filters
$selected_customer = $_REQUEST['customer'] ?? '';
$selected_zone = $_REQUEST['zone'] ?? '';
$selected_state = $_REQUEST['state'] ?? '';
$selected_bank = $_REQUEST['bank'] ?? '';
$atmid = $_REQUEST['atmid'] ?? '';
$selected_call_type = $_REQUEST['call_type'] ?? '';

?>      
<!-- Filter Form -->
<form method="POST" id="filterForm">
    <div class="row">
        <div class="col-sm-3">
            <label>Customer</label>
            <select name="customer" class="form-control">
                <option value="">All</option>
                <?php while ($row = mysqli_fetch_assoc($customers)) { ?>
                    <option value="<?= $row['customer'] ?>" <?= ($row['customer'] == $selected_customer) ? 'selected' : '' ?>><?= $row['customer'] ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="col-sm-3">
            <label>Zone</label>
            <select name="zone" class="form-control">
                <option value="">All</option>
                <?php while ($row = mysqli_fetch_assoc($zones)) { ?>
                    <option value="<?= $row['zone'] ?>" <?= ($row['zone'] == $selected_zone) ? 'selected' : '' ?>><?= $row['zone'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-sm-2">
            <label>State</label>
            <select name="state" class="form-control">
                <option value="">All</option>
                <?php while ($row = mysqli_fetch_assoc($states)) { ?>
                    <option value="<?= $row['state'] ?>" <?= ($row['state'] == $selected_state) ? 'selected' : '' ?>><?= $row['state'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-sm-2">
            <label>Bank</label>
            <select name="bank" class="form-control">
                <option value="">All</option>
                <?php while ($row = mysqli_fetch_assoc($banks)) { ?>
                    <option value="<?= $row['bank'] ?>" <?= ($row['bank'] == $selected_bank) ? 'selected' : '' ?>><?= $row['bank'] ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="col-sm-2">
            <label>Call Types</label>
            <select name="call_type" class="form-control">
                <option value="">All</option>
                <?php while ($row = mysqli_fetch_assoc($calTypes)) { ?>
                    <option value="<?= $row['call_type'] ?>" <?= ($row['call_type'] == $selected_call_type) ? 'selected' : '' ?>><?= $row['call_type'] ?></option>
                <?php } ?>
            </select>
        </div>
        
        

  <div class="col-sm-10">
      <br/>
        <label>ATM ID <span>(Separate multiple entries with spaces)</span></label>
        <input type="text" name="atmid" class="form-control" value="<?= htmlspecialchars($atmid) ?>" placeholder="ATM1 ATM2 ATM3">
    </div>
        <div class="col-sm-2">
                  <br/>
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </div>
</form>


                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="card">
                            <div class="card-header">
                                <h3>Create Batch</h3>
                            </div>
                           
                           
                            
                            
                            
                            
                            
                            <div class="card-block" style="overflow: scroll;">
                                
                                <form method="POST" action="create_batch.php">
                                    <div class="form-group">
                                        <label for="batch_name">Batch Name</label>
                                        <input type="text" id="batch_name" name="batch_name" class="form-control" placeholder="Enter Batch Name" required>
                                    </div>

<?php


// Build query conditions
$conditions = [];
if (!empty($selected_customer)) $conditions[] = "m.customer = '$selected_customer'";
if (!empty($selected_zone)) $conditions[] = "m.zone = '$selected_zone'";
if (!empty($selected_state)) $conditions[] = "m.state = '$selected_state'";
if (!empty($selected_bank)) $conditions[] = "m.bank = '$selected_bank'";
if (!empty($selected_call_type)) $conditions[] = "m.call_type = '$selected_call_type'";

if (!empty($atmid)) {
    $atmidArray = explode(' ', trim($atmid)); // Split by space
    $atmidConditions = array_map(fn($id) => "e.atmid LIKE '%" . mysqli_real_escape_string($con, $id) . "%'", $atmidArray);
    $conditions[] = '(' . implode(' OR ', $atmidConditions) . ')';
}



$query_conditions = count($conditions) > 0 ? "AND " . implode(" AND ", $conditions) : "";

// Final query with filters
$sql = "SELECT e.*, m.customer, m.zone, m.state, m.bank 
        FROM eng_fund_request e
        INNER JOIN mis_details md ON e.mis_id = md.id
        INNER JOIN mis m ON md.mis_id = m.id
        WHERE e.batch_id IS NULL AND e.isPaymentProcessed=0 
        AND (e.req_status >= 4 AND e.req_status < 7) $query_conditions";

// echo $sql ; 
$result = mysqli_query($con, $sql);
?>

<!-- Table -->
<table id="fundTable" class="table table-striped table-bordered" >
    <thead>
        <tr>
            <th>Select</th>
            <th>Sr No</th>
            <th>Fund Request ID</th>
            <th>Requested By</th>
            <th>ATM ID</th>
            <th>Customer</th>
            <th>Bank</th>
            <th>Zone</th>
            <th>State</th>
            <th>Approved Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $membername = get_member_name($row['fund_requested_by']);
            echo "<tr>";
                echo "<td>
                <input type='hidden' name='mis_id[]' value='{$row['mis_id']}'> 
                <input type='checkbox' class='record-check' name='selected_records[]' value='{$row['id']}' data-amount='{$row['approved_amount']}'></td>";
                echo "<td>{$count}</td>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$membername}</td>";
                echo "<td>{$row['atmid']}</td>";
                echo "<td>{$row['customer']}</td>";
                echo "<td>{$row['bank']}</td>";
                echo "<td>{$row['zone']}</td>";
                echo "<td>{$row['state']}</td>";
                echo "<td>{$row['approved_amount']}</td>";
                echo "<td>{$row['req_status']}</td>";
            echo "</tr>";
            $count++;
        }
        ?>
    </tbody>
</table>

                                    <div class="form-group">
                                        <label for="total_amount">Total Amount</label>
                                        <input type="text" id="total_amount" name="total_amount" class="form-control" readonly>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Create Batch</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            // Calculate total amount
            $('.record-check').on('change', function () {
                let total = 0;
                $('.record-check:checked').each(function () {
                    total += parseFloat($(this).data('amount'));
                });
                $('#total_amount').val(total.toFixed(2));
            });
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

</body>
</html>
