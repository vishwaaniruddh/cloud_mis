<?php
session_start();
include('config.php');
require 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SESSION['username']) {
    include('header.php');
?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>Upload Excel File</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="file" class="form-control" name="excel_file" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100" name="upload_excel">Upload</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-block" style="overflow:auto;">
                            
                            <?php
                            $limit = 10;
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;
                            $filter_atm_id = isset($_GET['atm_id']) ? $_GET['atm_id'] : '';
                            
                            $where_clause = "";
                            if (!empty($filter_atm_id)) {
                                $where_clause = " WHERE atm_id LIKE '%" . $con->real_escape_string($filter_atm_id) . "%'";
                            }
                            
                            $total_query = "SELECT COUNT(*) as total FROM fund_distance_master" . $where_clause;
                            $total_result = $con->query($total_query);
                            $total_row = $total_result->fetch_assoc();
                            $total_pages = ceil($total_row['total'] / $limit);
                            
                            $query = "SELECT * FROM fund_distance_master" . $where_clause . " LIMIT $offset, $limit";
                            $result = $con->query($query);
                            ?>
                            
                            <form method="get" class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="atm_id" class="form-control" placeholder="Filter by ATM ID" value="<?php echo htmlspecialchars($filter_atm_id); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Comfort ID</th>
                                        <th>ATM ID</th>
                                        <th>ATM-ID-II</th>
                                        <th>ATM-ID-III</th>
                                        <th>Old ATM ID</th>
                                        <th>Tracker No</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zone</th>
                                        <th>CSS Branch</th>
                                        <th>Engineer Name</th>
                                        <th>KM</th>
                                        <th>Engg Payment</th>
                                        <th>Fund Require</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['comfort_id']; ?></td>
                                            <td><?php echo $row['atm_id']; ?></td>
                                            <td><?php echo $row['atm_id_ii']; ?></td>
                                            <td><?php echo $row['atm_id_iii']; ?></td>
                                            <td><?php echo $row['old_atm_id']; ?></td>
                                            <td><?php echo $row['tracker_no']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['city']; ?></td>
                                            <td><?php echo $row['state']; ?></td>
                                            <td><?php echo $row['zone']; ?></td>
                                            <td><?php echo $row['css_branch']; ?></td>
                                            <td><?php echo $row['engineer_name']; ?></td>
                                            <td><?php echo $row['km']; ?></td>
                                            <td><?php echo $row['engg_payment']; ?></td>
                                            <td><?php echo $row['fund_require']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                        <a class="page-link" href="?page=1&atm_id=<?php echo $filter_atm_id; ?>">First</a>
                                    </li>
                                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                        <a class="page-link" href="?page=<?php echo ($page - 1); ?>&atm_id=<?php echo $filter_atm_id; ?>">Previous</a>
                                    </li>
                                    <?php for ($i = max(1, $page - 3); $i <= min($total_pages, $page + 3); $i++) { ?>
                                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&atm_id=<?php echo $filter_atm_id; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php } ?>
                                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                        <a class="page-link" href="?page=<?php echo ($page + 1); ?>&atm_id=<?php echo $filter_atm_id; ?>">Next</a>
                                    </li>
                                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                        <a class="page-link" href="?page=<?php echo $total_pages; ?>&atm_id=<?php echo $filter_atm_id; ?>">Last</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php include('footer.php'); } else { ?>
<script>window.location.href="login.php";</script>
<?php } ?>
