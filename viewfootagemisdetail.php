<? session_start();
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
                                <?php

                                $footage_id = $misid = $_REQUEST['id'];

                                $sql = mysqli_query($con, "Select a.ticketid,a.m_docket_ticket_id,a.atmid,b.bank,b.address,b.city,b.state,b.zone,
                                a.transaction_type,a.transaction_no
                                
                                from mis_footage a INNER JOIN mis_newsite b 
                                ON a.atmid = b.atmid
                                where a.id ='" . $footage_id . "'");
                                if ($sql_result = mysqli_fetch_assoc($sql)) {
                                    
                                    $transaction_no = $sql_result['transaction_no'];
                                    $transaction_type = $sql_result['transaction_type'];
                                ?>
                                
                                                        <div class="card">
                            <div class="card-block">
                                
                                
                                <h4>Site Information</h4>
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-6">
                                            <div class="table-responsive">
                                                <table class="table m-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Ticket ID </th>
                                                            <td><?php echo $sql_result['ticketid']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">M-Docket & Ticket ID</th>
                                                            <td>
                                                                <span><?php echo $sql_result['m_docket_ticket_id']; ?></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">ATM ID</th>
                                                            <td>
                                                                <span><?php echo $sql_result['atmid']; ?></span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Location</th>
                                                            <td><?php echo $sql_result['address']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- end of table col-lg-6 -->
                                        <div class="col-lg-12 col-xl-6">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Bank</th>
                                                            <td><?php echo $sql_result['bank']; ?></td>
                                                        </tr>
                                                        <tr>
                                                        <tr>
                                                            <th scope="row">City</th>
                                                            <td><?php echo $sql_result['city']; ?></td>
                                                        </tr>

                                                        <th scope="row">State</th>
                                                        <td><?php echo $sql_result['state']; ?></td>
                                                        </tr>
                                                        <tr>    
                                                            <th scope="row">Zone</th>
                                                            <td><?php echo $sql_result['zone']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Status</th>
                                                            <td><?php echo $sql_result['status']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- end of table col-lg-6 -->
                                    </div>



                            </div>
                        </div>
                        
                                    <div class="card">
                            <div class="card-block">
                                
                        
                        
                                            <form action="footageMISSubmission.php" method="POST">
                        
                        <div class="row">
                            
                            <div class="col-sm-6">
                                <label>Trans Type</label>
                                <select class="form-control" name="transaction_type">
                                    <option value="">Select</option>
                                    <option <?php  if($transaction_type=='24 Hrs'){ echo 'selected'; } ?>>24 Hrs</option>
                                    <option <?php  if($transaction_type=='Rejected'){ echo 'selected'; } ?>>Rejected</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>TransactIon No</label>
                                <input type="text" name="transaction_no" value="<?php echo $transaction_no ; ?>" class="form-control" /> 
                            </div>
                            
                            
                            
                            
                            
                            
                        <div class="col-sm-12">
                            <hr>
                                <h4>Actions</h4>
                        <hr>
                        
                        
                        
                        </div>
                            <div class="col-sm-12">
                                <label>Select Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="available">Available</option>
                                    <option>Not Available</option>
                                    <option>Customer Issue</option>
                                    <option>Schedule</option>
                                    <option>Close</option>
                                </select>
                            </div>
                            
                            <div class="col-sm-12">
                                

<input type="hidden" name="misid" value="<?php echo $misid; ?>" />
                                
                                <div class="resultdiv">
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                        
                        
                                </form>
                        
                            </div>
                        </div>



<div class="card">
    <div class="card-body">
        <h4>History</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Link/Details</th>
                        <th>Remark</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $historysql = mysqli_query($con, "SELECT * FROM footage_mis_history WHERE misid='".$misid."' ORDER BY created_at DESC");
                    
                    // Loop through the history records
                    while ($historysqlresult = mysqli_fetch_assoc($historysql)) { 
                        ?>
                        <tr>
                            <td><?php echo date('d-M-Y H:i', strtotime($historysqlresult['created_at'])); ?></td>
                            <td><?php echo $historysqlresult['status']; ?></td>
                            <td>
                                <?php 
                                // Show relevant details based on the status
                                if ($historysqlresult['status'] == 'available') {
                                    echo "Link: " . $historysqlresult['link'];
                                } elseif ($historysqlresult['status'] == 'Not Available') {
                                    echo "Reason: " . $historysqlresult['reason'];
                                } elseif ($historysqlresult['status'] == 'Customer Issue') {
                                    echo "Issue: " . $historysqlresult['issue'];
                                    if ($historysqlresult['issue'] == 'other') {
                                        echo "<br>Other Issue: " . $historysqlresult['other_issue'];
                                    }
                                } elseif ($historysqlresult['status'] == 'Schedule') {
                                    echo "Scheduled Date: " . $historysqlresult['schedule_date'];
                                } elseif ($historysqlresult['status'] == 'Close') {
                                    echo "Closed";
                                }
                                ?>
                            </td>
                            <td><?php echo $historysqlresult['remark']; ?></td>
                            <td><?php echo get_member_name($historysqlresult['created_by']); ?></td>
                        </tr>
                        <?php 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




                        
                        

    <script>
// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", function() {
    const statusSelect = document.querySelector('select[name="status"]');
    const resultDiv = document.querySelector('.resultdiv');

    // Listen for changes in the select dropdown
    statusSelect.addEventListener('change', function() {
        let selectedValue = this.value;
        let resultHTML = '';

        switch (selectedValue) {
            case 'available':
                resultHTML = `
                    <div>
                                            <input type="hidden" name="status" value="available">

                        <label for="link">Enter Link:</label>
                        <input type="text" name="link" id="link" class="form-control" placeholder="Enter link">
                    </div>
                    <div>
                        <label for="remark">Remark:</label>
                        <textarea name="remark" id="remark" class="form-control" placeholder="Enter remark"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>`;
                break;

            case 'Not Available':
                resultHTML = `
                    <div>
                                            <input type="hidden" name="status" value="Not Available">

                        <label for="reason">Reason:</label>
                        <select name="reason" id="reason" class="form-control">
                            <option value="maintenance">Maintenance</option>
                            <option value="network">Network Issue</option>
                            <option value="power">Power Failure</option>
                        </select>
                    </div>
                    <div>
                        <label for="remark">Remark:</label>
                        <textarea name="remark" id="remark" class="form-control" placeholder="Enter remark"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>`;
                break;

            case 'Customer Issue':
                resultHTML = `
                    <div>
                                            <input type="hidden" name="status" value="Customer Issue">

                        <label for="issue">Issue:</label>
                        <select name="issue" id="issue" class="form-control">
                            <option value="software">Software Issue</option>
                            <option value="hardware">Hardware Issue</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div id="otherIssueDiv" style="display:none;">
                        <label for="other_issue">Other Issue:</label>
                        <input type="text" name="other_issue" id="other_issue" class="form-control" placeholder="Describe other issue">
                    </div>
                    <div>
                        <label for="remark">Remark:</label>
                        <textarea name="remark" id="remark" class="form-control" placeholder="Enter remark"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>`;

                // Listen for 'Other' option
                setTimeout(function() {
                    const issueSelect = document.querySelector('#issue');
                    const otherIssueDiv = document.querySelector('#otherIssueDiv');
                    
                    issueSelect.addEventListener('change', function() {
                        if (this.value === 'other') {
                            otherIssueDiv.style.display = 'block';
                        } else {
                            otherIssueDiv.style.display = 'none';
                        }
                    });
                }, 100); // Ensures that the event listener is added after the HTML is rendered
                break;

            case 'Schedule':
                resultHTML = `
                    <div>
                                            <input type="hidden" name="status" value="Schedule">

                        <label for="schedule_date">Schedule Date:</label>
                        <input type="date" name="schedule_date" id="schedule_date" class="form-control" value="<?php echo date('Y-m-d', strtotime($date)); ?>">
                    </div>
                    <div>
                        <label for="remark">Remark:</label>
                        <textarea name="remark" id="remark" class="form-control" placeholder="Enter remark"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>`;
                break;

            case 'CLose':
                resultHTML = `
                    <div>
                                            <input type="hidden" name="status" value="Close">

                        <label for="remark">Remark:</label>
                        <textarea name="remark" id="remark" class="form-control" placeholder="Enter remark"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>`;
                break;

            default:
                resultHTML = ''; // Clear the result div if no valid selection is made
                break;
        }

        resultDiv.innerHTML = resultHTML;
    });
});
</script>








                                <?php
                                }



                                ?>


                    </div>
                </div>


            </div>
        </div>
    </div>


<? include('footer.php');
} else { ?>

    <script>
        window.location.href = "login.php";
    </script>
<? }
?>
</body>

</html>