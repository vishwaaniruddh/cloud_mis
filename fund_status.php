<?php
session_start();
include('config.php');

if ($_SESSION['username']) {
    include('header.php');

    // Fetch fund details based on ID
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $fundDetails = null;

    if ($id > 0) {
        $query = "SELECT atmid, requested_amount, approved_amount, req_status, isPaymentProcessed, img, created_at FROM eng_fund_request WHERE id = $id";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $fundDetails = mysqli_fetch_assoc($result);
        }
        
        
        function getHistory_data($fundId,$statuscode){
            global $con;
            
            $historyQuery = "SELECT status, created_at FROM eng_fund_request_history WHERE fundreq_id = $fundId and status='".$statuscode."' ORDER BY created_at ASC";
            $historyResult = mysqli_query($con, $historyQuery);
                if ($historyResult && mysqli_num_rows($historyResult) > 0) {
                    $row = mysqli_fetch_assoc($historyResult);
                        return $row; 
                }else{
                    return null;
                }
        }
        
        
    }
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<style>
    .timeline {
        position: relative;
        margin: 20px 0;
        padding: 0;
        list-style: none;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 20px;
        width: 2px;
        height: 100%;
        background: #007bff;
    }
    .timeline-item {
        position: relative;
        margin: 20px 0;
        padding: 20px;
        border-radius: 6px;
        background: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        margin-left: 60px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        top: 20px;
        left: -28px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: #007bff;
        border: 3px solid #f8f9fa;
    }
    .timeline-item h4 {
        margin: 0 0 10px;
        font-size: 18px;
        color: #343a40;
    }
    .timeline-item p {
        margin: 0;
        color: #6c757d;
    }
    .fund-details {
        margin: 20px 0;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .fund-details h4 {
        margin-bottom: 15px;
        color: #007bff;
    }
    .fund-details p {
        margin: 5px 0;
        font-size: 16px;
        color: #343a40;
    }
    .timeline-item.active{
        background:green;
    }
    .timeline-item.active p , .timeline-item.active h4{
        color:white;
    }
</style>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if ($fundDetails) { ?>
                                <!-- Display Fund Details -->
                                <div class="fund-details">
                                    <h4>Fund Request Details</h4>
                                    <p><strong>ATM ID:</strong> <?= htmlspecialchars($fundDetails['atmid']); ?></p>
                                    <p><strong>Requested Amount:</strong> ₹<?= number_format($fundDetails['requested_amount'], 2); ?></p>
                                    <p><strong>Approved Amount:</strong> ₹<?= number_format($fundDetails['approved_amount'], 2); ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($fundDetails['req_status']); ?></p>
                                    <p><strong>Requested On:</strong> <?= date('d-M-Y', strtotime($fundDetails['created_at'])); ?></p>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger">
                                    <p>Invalid Fund Request ID or data not found.</p>
                                </div>
                            <?php } ?>
                        </div>
                        
                        <div class="col-sm-6">
                            
                            <?php 
                            $fundId = $_GET['id'];
                            
                            ?>
                            <!-- Timeline -->
                            <ul class="timeline">
                                <li class="timeline-item active">
                                    <h4>Fund Initiated</h4>
                                    <p>The fund has been successfully initiated.</p>
                                </li>
                                <li class="timeline-item <?= (getHistory_data($fundId,2)['status'] == 2) ? 'active' : ''; ?>">
                                    <h4>Level 1 <?= (getHistory_data($fundId,1)['status'] == 1) ? 'Approved' : 'Pending'; ?> </h4>
                                </li>
                                <li class="timeline-item <?= (getHistory_data($fundId,4)['status'] == 4) ? 'active' : ''; ?>">
                                    <h4>Level 2 <?= (getHistory_data($fundId,2)['status'] == 2) ? 'Approved' : 'Pending'; ?> </h4>
                                </li>
                                <li class="timeline-item <?= (getHistory_data($fundId,4)['status'] == 4) ? 'active' : ''; ?>">
                                    <h4>Payment <?= (getHistory_data($fundId,4)['status'] == 4) ? 'Initiated' : 'Initiation Pending'; ?>  </h4>
                                </li>
                                <li class="timeline-item <?= (getHistory_data($fundId,5)['status'] == 5 && $fundDetails['isPaymentProcessed'] == 1) ? 'active' : ''; ?>">
                                    <h4>Payment <?= (getHistory_data($fundId,5)['status'] == 5 && $fundDetails['isPaymentProcessed'] == 1 ) ? 'Done' : 'Pending'; ?> </h4>
                                </li>
                                <li class="timeline-item <?= (getHistory_data($fundId,6)['status'] == 6 && !empty($fundDetails['img'])) ? 'active' : ''; ?>">
                                    <h4>Invoice <?= (getHistory_data($fundId,6)['status'] == 6 && !empty($fundDetails['img'])) ? 'Uploaded' : 'Upload Pending'; ?></h4>
 <?php  
if (getHistory_data($fundId, 6)['status'] == 6 && !empty($fundDetails['img'])) {
    $imgPath = $fundDetails['img'];

    // Check if the img path is already a full URL
    if (strpos($imgPath, 'http') === 0) {
        $finalUrl = $imgPath; // Use as is if it's a complete URL
    } else {
        $finalUrl = './' . $imgPath; // Prepend './' for relative paths
    }
    ?>
    <a class="btn btn-primary" href="<?php echo $finalUrl; ?>" target="_blank">View</a>
    <?php 
}
?>

                                </li>
                                <li class="timeline-item <?= (isset(getHistory_data($fundId,0)['status']) && getHistory_data($fundId,0)['status'] == 0) ? 'active' : ''; ?>">
                                    <h4>Account Clearance</h4>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
} else {
    echo "<script>window.location.href = 'login.php';</script>";
}
?>
