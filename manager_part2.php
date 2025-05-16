<?php 
include('config.php');
if ($_SESSION['username']) {
    include('header.php');

    $designation = $_SESSION['designation'];
    $bm_id = $_SESSION['bm_id'];

    // error_reporting(1);

    function get_mis_history($parameter, $type, $id){
        global $con;
        $sql = mysqli_query($con, "select $parameter from mis_history where type='" . $type . "' and mis_id='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result[$parameter];
    }
    
    // $userid = 275;
    $username = $_SESSION['username'];
    
    
    $usersql = mysqli_query($con,"select cust_id,zone from mis_loginusers where name='".$username."'");
	$userdata = mysqli_fetch_assoc($usersql);
	$_cust_ids = $userdata['cust_id'];
    $assigned_customers = explode(",",$_cust_ids);
    
    $bankPermission = $_SESSION['bankPermission'];
    $bankPermission_AR = explode(',',$bankPermission);



?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <style>
        
    html{
        /*text-transform: inherit !important;*/
    }
    
    td a { color: #01a9ac;text-decoration: none;}
    td a:focus, td a:hover { text-decoration: none;color: chartreuse;}
    a:not([href]) { padding: 5px;}
    .btn-group { border: 1px solid #cccccc; }
    ul.dropdown-menu { transform: translate3d(0px, 2%, 0px) !important;overflow: scroll !important;max-height: 250px;}
    label { font-weight: 900;font-size: 16px; }
    </style>

    <?php

        $userid  = $_SESSION['userid'];
        // echo $userid;
        $fund_type = $_REQUEST['fund_type'];
      //  $call_receive = $_REQUEST['call_receive'];
    //    $ticket_id = $_REQUEST['ticket_id'];
        $engineer = $_REQUEST['engineer'];
        $sql = mysqli_query($con, "select * from mis_loginusers where id='" . $userid . "' and branch!='null' and zone!='null' ");
        $sql_result = mysqli_fetch_assoc($sql);

        $branch_result = $sql_result['branch'];
        $branch = explode(',', $branch_result);
        
        // var_dump($branch);
        echo '<br>';
        
        foreach($branch as $branchkey => $branchvalue){
            $miscitysql = mysqli_query($con,"select * from mis_city where id='".$branchvalue."'");
            $miscitysql_result = mysqli_fetch_assoc($miscitysql);
            
            $miscity[] = $miscitysql_result['city'];
            
        }


        
        
        
        $branch = json_encode($miscity);
        $branch = str_replace(array('[', ']', '"'), '', $branch);
        $branch = explode(',', $branch);
        $branch = "'" . implode("', '", $branch) . "'";
        
        if ($branch_result) {
            $branch_query = " and b.branch in($branch)";
        } else {
            $branch_query = " ";
        }
        
        $zone_result = $sql_result['zone'];
        $zone = explode(',',$zone_result);
        
        $zone=json_encode($zone);
        $zone=str_replace( array('[',']','"') , ''  , $zone);
        $zone=explode(',',$zone);
        $zone = "'" . implode ( "', '", $zone )."'";
        
        if($zone_result){
            $zone_query = " and b.zone in($zone)";
        }else{
            $zone_query =" ";
        }

      // echo $branch_query;die;


        $callTypePermission = $_SESSION['callTypePermission'];
        $callTypePermission_AR = explode(',',$callTypePermission) ;
        
        foreach($callTypePermission_AR as $callTypePermission_key=>$callTypePermission_val){
            $calltypesql = mysqli_query($con,"select * from callType where id='".$callTypePermission_val."'");    
            if($calltypesql_result = mysqli_fetch_assoc($calltypesql)){
                $callPermission[] = $calltypesql_result['call_type'];
            }
        }
        
        
        
        
        $callPermission=json_encode($callPermission);
        $callPermission=str_replace( array('[',']','"') , ''  , $callPermission);
        $callPermission=explode(',',$callPermission);
        $callPermission = "'" . implode ( "', '", $callPermission )."'";
        
        if($callTypePermission){
                    $callTypeQuery = " and b.call_type in($callPermission)";
                }else{
                    $callTypeQuery =" ";
                }
        
        $bankPermission = $_SESSION['bankPermission'];
        $bankPermission_AR = explode(',',$bankPermission);
        $bankStrPermission=json_encode($bankPermission_AR);
        $bankStrPermission=str_replace( array('[',']','"') , ''  , $bankStrPermission);
        $bankStrPermission=explode(',',$bankStrPermission);
        $bankStrPermission = "'" . implode ( "', '", $bankStrPermission )."'";
        
        if($callTypePermission){
            $bankQuery = " and a.bank in($bankStrPermission)";
        }else{
            $bankQuery =" ";
        }


        // print_r($branch);

    if (isset($_REQUEST['submit']) || isset($_GET['page'])) { 
                
    $statement = "SELECT a.*, 
                    b.customer, b.bank, b.address, b.city, b.state, b.zone, b.branch,
                    (SELECT name FROM mis_loginusers WHERE id = b.engineer_user_id) AS eng_name,
                    (SELECT contact FROM mis_loginusers WHERE id = b.engineer_user_id) AS eng_contact,
                    MAX(r.id) AS raisfundid
                FROM eng_fund_request a
                INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                INNER JOIN raisedFund r ON a.id = r.eng_fund_req_id
                WHERE a.status = 1
                AND a.requested_amount > 0
                AND a.approved_amount > 0";

    if ($userRole != 'admin') {
        $statement .= " AND b.Surveillance_Head IN ('$userid')";
    }

    $sqlappCount = "SELECT COUNT(DISTINCT a.id) AS total 
                    FROM eng_fund_request a
                    INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                    INNER JOIN raisedFund r ON a.id = r.eng_fund_req_id
                    WHERE a.status = 1
                    AND a.requested_amount > 0
                    AND a.approved_amount > 0";

    if ($userRole != 'admin') {
        $sqlappCount .= " AND b.Surveillance_Head IN ('$userid')";
    }

    // ATM ID filter
    if (!empty($_REQUEST['atmid'])) {
        $statement .= " AND b.atmid = '" . $_REQUEST['atmid'] . "'";
        $sqlappCount .= " AND b.atmid = '" . $_REQUEST['atmid'] . "'";
    }

    // Engineer filter
    if (!empty($_REQUEST['engineer'])) {
        $statement .= " AND b.engineer_user_id = '" . $_REQUEST['engineer'] . "'";
        $sqlappCount .= " AND b.engineer_user_id = '" . $_REQUEST['engineer'] . "'";
    }

    // Branch filter
    if (!empty($_REQUEST['local_branch'])) {
        $statement .= " AND a.branch = '" . $_REQUEST['local_branch'] . "'";
        $sqlappCount .= " AND a.branch = '" . $_REQUEST['local_branch'] . "'";
    }

    // Date range filter
    if (!empty($_REQUEST['fromdt']) && !empty($_REQUEST['todt'])) {
        $date1 = $_REQUEST['fromdt'];
        $date2 = $_REQUEST['todt'];
        $statement .= " AND CAST(a.created_at AS DATE) BETWEEN '$date1' AND '$date2'";
        $sqlappCount .= " AND CAST(a.created_at AS DATE) BETWEEN '$date1' AND '$date2'";
    }

    // Customer filter
    if (!empty($_REQUEST['customer'])) {
        $cust = implode("', '", $_REQUEST['customer']);
        $statement .= " AND a.customer IN ('$cust')";
        $sqlappCount .= " AND a.customer IN ('$cust')";
    }

    // Status filter
    if (!empty($_REQUEST['status'])) {
        switch ($_REQUEST['status']) {
            case 'Pending':
                $_status = 2;
                break;
            case 'Approved':
                $_status = '3,4,5,6';
                break;
            case 'Rejected':
                $_status = 8;
                break;
            default:
                $_status = '0,2,3,4,5,6,8,9';
        }
        $statement .= " AND a.req_status IN ($_status)";
        $sqlappCount .= " AND a.req_status IN ($_status)";
    } else {
        $statement .= " AND a.req_status IN (0,2,3,4,5,6,8,9)";
        $sqlappCount .= " AND a.req_status IN (0,2,3,4,5,6,8,9)";
    }

    // Fund type filter
    if (!empty($_REQUEST['fund_type'])) {
        $statement .= " AND a.fund_type = '" . $_REQUEST['fund_type'] . "'";
        $sqlappCount .= " AND a.fund_type = '" . $_REQUEST['fund_type'] . "'";
    }

    // Call receive filter
    if (!empty($_REQUEST['call_receive'])) {
        $statement .= " AND b.case_type = '" . $_REQUEST['call_receive'] . "'";
        $sqlappCount .= " AND b.case_type = '" . $_REQUEST['call_receive'] . "'";
    }

    // Grouping to remove duplicates
    $statement .= " GROUP BY a.id ORDER BY a.id DESC";
    $sql_query = $statement;
    
} else { 
    $statement = "SELECT a.*, 
                    b.customer, b.bank, b.address, b.city, b.state, b.zone, b.branch,
                    (SELECT name FROM mis_loginusers WHERE id = b.engineer_user_id) AS eng_name,
                    (SELECT contact FROM mis_loginusers WHERE id = b.engineer_user_id) AS eng_contact,
                    MAX(r.id) AS raisfundid
                FROM eng_fund_request a
                INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                INNER JOIN raisedFund r ON a.id = r.eng_fund_req_id
                WHERE a.status = 1
                AND a.requested_amount > 0
                AND a.approved_amount > 0";

    if ($userRole != 'admin') {
        $statement .= " AND b.Surveillance_Head IN ('$userid')";
    }

    $sqlappCount = "SELECT COUNT(DISTINCT a.id) AS total 
                    FROM eng_fund_request a
                    INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                    INNER JOIN raisedFund r ON a.id = r.eng_fund_req_id
                    WHERE a.status = 1
                    AND a.requested_amount > 0
                    AND a.approved_amount > 0";

    if ($userRole != 'admin') {
        $sqlappCount .= " AND b.Surveillance_Head IN ('$userid')";
    }

    // Default status is 'Pending'
    $statement .= " AND a.req_status IN (2)";
    $sqlappCount .= " AND a.req_status IN (2)";

    // Grouping to remove duplicates
    $statement .= " GROUP BY a.id ORDER BY a.id DESC";

    $sql_query = $statement;
}

    echo $sql_query ; 
            
            // return ; 
            
    ?>

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        
                        
                        <div class="card" id="filter">
                            <div class="card-block">
                                
                                <?
                                
                        // echo $statement;                                
                        // echo  $sql_query ; 
                                                
                                ?>
<?php
echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';

echo '<div class="row">';

// ATMID Field
echo '<div class="col-md-3">
        <label>ATMID</label>
        <input type="text" name="atmid" class="form-control" value="' . (isset($_REQUEST['atmid']) ? $_REQUEST['atmid'] : '') . '">
      </div>';

// Engineer Dropdown
echo '<div class="col-md-3">
        <label> Engineer </label>
        <select name="engineer" class="form-control">
            <option value=""> -- Select -- </option>';

$eng_sql = mysqli_query($con, "SELECT * FROM mis_loginusers WHERE designation=4 AND user_status=1");
while ($eng_sql_result = mysqli_fetch_assoc($eng_sql)) {
    $selected = (isset($_REQUEST['engineer']) && $_REQUEST['engineer'] == $eng_sql_result['id']) ? 'selected' : '';
    echo '<option value="' . $eng_sql_result['id'] . '" ' . $selected . '>' . $eng_sql_result['name'] . '</option>';
}

echo '</select></div>';

// From Date Field
echo '<div class="col-md-3">
        <label>From Fund Requested Date</label>
        <input type="date" name="fromdt" class="form-control" value="' . (isset($_REQUEST['fromdt']) ? $_REQUEST['fromdt'] : '2024-01-01') . '">
      </div>';

// To Date Field
echo '<div class="col-md-3">
        <label>To Fund Requested Date</label>
        <input type="date" name="todt" class="form-control" value="' . (isset($_REQUEST['todt']) ? $_REQUEST['todt'] : date('Y-m-d')) . '">
      </div>';

// Fund Type Dropdown
echo '<div class="col-sm-3">
        <label>Fund Type</label>
        <select name="fund_type" id="fund_type" class="form-control">
            <option value="">-- Select --</option>';

$callTypesql = mysqli_query($con, "SELECT * FROM engfundType WHERE status=1");
while ($callTypesql_result = mysqli_fetch_assoc($callTypesql)) {
    $fundTypeId = $callTypesql_result['id'];
    $fund_type_val = $callTypesql_result['fund_type'];
    $selected = (isset($_REQUEST['fund_type']) && $_REQUEST['fund_type'] == $fund_type_val) ? 'selected' : '';
    echo '<option value="' . $fund_type_val . '" ' . $selected . '>' . $fund_type_val . '</option>';
}

echo '</select></div>';

// Status Dropdown
$current_status = $_REQUEST['status'] ?? ''; 

echo '<div class="col-sm-3">
        <label>Status</label>
        <select name="status" id="status" class="form-control">
            <option value="">-- Select --</option>
            <option value="Pending" ' . ($current_status == 'Pending' ? 'selected' : '') . '>Pending</option>
            <option value="Approved" ' . ($current_status == 'Approved' ? 'selected' : '') . '>Approved</option>
            <option value="Rejected" ' . ($current_status == 'Rejected' ? 'selected' : '') . '>Rejected</option>
        </select>
      </div>';

// JavaScript for call_type change
echo '<script>
        $(document).on("change", "#call_type", function() {
            var call_type = $(this).val();
            var option = "";

            if (call_type == "Project") {
                option = `<option value="">Select</option>`; 
            } else if (call_type == "Service") {
                option = `
                    <option value="">Select</option>
                    <option value="Customer / Bank">Customer / Bank</option>
                    <option value="Internal">Internal</option>`;
            } else if (call_type == "Footage") {
                option = `
                    <option value=""> -- Select --</option>
                    <option>Transaction</option>
                    <option>Audit Case</option>
                    <option>BO Case</option>
                    <option>Chargeback</option>
                    <option>Fraud / Skimming / CRM Case</option>
                    <option>Cyber Crime</option>
                    <option>Dispute</option>
                    <option>Customer Request</option>
                    <option>Police Case</option>
                    <option>Shutter Assembly / Pre Arbitration</option>`;
            }
            $("#call_receive").html(option);
        });
      </script>';

echo '</div><br><br>';

// Submit and Reset Buttons
echo '<div class="col" style="display:flex;justify-content:center;">
        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
        <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
      </div>';

echo '</form>';

// echo $sql_query ; 
?>


                                <hr>

                            </div>
                        </div>

                        <style>
                            .indication {
                                display: flex;
                                background: #404e67;
                            }

                            .indication span {
                                width: 15px;
                                height: 15px;
                                border: 1px solid white;
                                border-radius: 25px;
                                margin: 10px;
                            }

                            .open, .Pending {
                                background: white;
                            }

                            .close {
                                background: #e29a9a;
                            }

                            .schedule {
                                background: #d09f45;
                            }

                            th.address,
                            td.address {
                                white-space: inherit;
                            }
                        </style>


                        <?php 
                        // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {   
                        if($sql_query){
                            

                        ?>

                            <div class="card">
                                <div class="card-block">
                                    <div style="display:flex;justify-content:space-around;">
                                        <h5 style="text-align:center;">Fund Requested Detailed Report </p></h5>
                                        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    </div>
                                        
                                        
                                    <h5 style="text-align:right;" id="row_count"></h5>
                                    <div class="custom_table_content">
                                        
                                        
                                        <span id="totalRecords"></span>
                                        
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" id="example">
    <thead>
        <tr>
            <th>SR</th>
            <th>Action</th>
            <th>Fund Component</th>
            <th>ATM ID</th>
            <th>Customer</th>
            <th>Bank</th>
            <th>Requested Amount</th>
            <th>Approved Amount</th>
            <th>Aging</th>
            <th>Request Raised By</th>
            <th>ATM Address</th>
            <th>City</th>
            <th>State</th>
            <th>Branch</th>
            <th>Fund Type</th>
            
            <th>Fund Requested Date</th>
            <th>Current Status</th>
            <th>Engineer Name</th>
            <th>Engineer Contact</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $date = date('Y-m-d');
            $date1 = date_create($date);
            $counter = ($current_page - 1) * $page_size + 1;
            
            // echo $sql_query ; 
            
            $sql_app = mysqli_query($con, $sql_query);

            $status_labels = [
                0 => 'Close',
                1 => 'Eng_Request',
                2 => 'Manager_Approved',
                3 => 'Cashier_Paid',
                4 => 'Invoice_Uploaded',
                5 => 'Account_Verified',
                7 => 'Rejected by Branch Manager',
                8 => 'Rejected by Service Manager',
                9 => 'Rejected by Account Manager'
            ];

            while ($sql_result = mysqli_fetch_assoc($sql_app)) {
                $id = $sql_result['id'];
                $createdBy = $sql_result['fund_requested_by'];
                $mis_id = $sql_result['mis_id'];
                $raisfundid = $sql_result['raisfundid'];
                $eng_fund_request_id = $sql_result['id'];
                $customer = $sql_result['customer'];
                $bank = $sql_result['bank'];
                
                $date2 = date_create(date('Y-m-d', strtotime($sql_result['created_at'])));
                $aging_day = date_diff($date1, $date2)->format("%a");

                $status = $sql_result['req_status'];
                $current_status = $status_labels[$status] ?? '-';

                // Row background color logic
                if ($status == 0) {
                    $row_color = '#0ac282'; // Green for closed
                } elseif ($aging_day > 3 && $status != 0) {
                    $row_color = '#fe5d70c2'; // Red for aging > 3 days and not closed
                } elseif ($status > 1) {
                    $row_color = '#6c757d'; // Grey for approved stages
                } else {
                    $row_color = 'yellow'; // Pending cases
                }

                // Text color
                $text_color = ($status == 1) ? 'black' : 'white';
                ?>
                <tr 
                
                >
                    <td><?= $counter++; ?></td>
                    <td>
                        <?php 
                                                $atmid = $sql_result['atmid'] ; 
                        if ($status == 2) { // Pending
                            echo "<a data-toggle='modal' data-id='$id' data-atmid='$atmid'  data-raisedfund-id='$raisfundid' 
                                data-misid='$mis_id' data-reqamt='{$sql_result['requested_amount']}' data-approvedamt='{$sql_result['approved_amount']}' 
                                class='open-AddBookDialog btn btn-primary' href='#myModal'>Actions</a> | 
                                <button class='btn btn-danger btn-sm rejectFundRequest' 
                                data-id='{$eng_fund_request_id}'>Reject</button>";
                        } elseif ($status == 8) { // Rejected
                            echo "<span class='badge badge-danger'>Rejected</span> | ";
                             ?>
                             <a target="_blank" href="mis_details.php?id=<?= htmlspecialchars($mis_id); ?>">View Rivision</a>
                             <?php 
                             
                             
                        }elseif ($status == 4) { // Rejected
                            echo "<span class='badge badge-success'>Approved</span> | ";
                            ?>
                            <a target="_blank" class="badge badge-info" href="mis_details.php?id=<?= htmlspecialchars($mis_id); ?>">View Rivision</a>
                            <?
                        }  

                        ?>
                    </td>

                    <td><?= htmlspecialchars($sql_result['fund_component'] ?: '-'); ?></td>
                    <td><a target="_blank" href="mis_details.php?id=<?= htmlspecialchars($mis_id); ?>"><strong style="font-size:18px;"><?= htmlspecialchars(strtoupper($sql_result['atmid']) ?: '-'); ?></strong></a></td>
                    <td><?= htmlspecialchars($customer ?: '-'); ?></td>
                    <td><?= htmlspecialchars($bank ?: '-'); ?></td>
                    <td><?= htmlspecialchars($sql_result['requested_amount'] ?: '-'); ?></td>
                    <td><?= htmlspecialchars($sql_result['approved_amount'] ?: '-'); ?></td>
                    <td><?= $aging_day . ' days'; ?></td>
                    <td><?= htmlspecialchars(get_member_name($createdBy)); ?></td>
                    <td><?= htmlspecialchars($sql_result['address'] ?: '-'); ?></td>
                    <td><?= htmlspecialchars($sql_result['city'] ?: '-'); ?></td>
                    <td><?= htmlspecialchars($sql_result['state'] ?: '-'); ?></td>
                    <td><?= htmlspecialchars($sql_result['branch'] ?: '-'); ?></td>
                    <td><?= htmlspecialchars($sql_result['fund_type'] ?: '-'); ?></td>

                    <td><?= htmlspecialchars($sql_result['created_at'] ?: '-'); ?></td>
                    <td><span class="badge badge-info"><?= $current_status; ?></span></td>
                    <td><?= htmlspecialchars($sql_result['eng_name'] ?: '-'); ?></td>
                    <td><?= htmlspecialchars($sql_result['eng_contact'] ?: '-'); ?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


                                        
                                        
                                        


                                    </div>




                                        <? 





$customer = $_REQUEST['customer'] ; 
$customer = http_build_query(array('customer' => $customer));

$status = $_REQUEST['status'] ; 
$status = http_build_query(array('status' => $status));



$atmid = $_REQUEST['atmid'];
$fromdt = $_REQUEST['fromdt'];
$todt = $_REQUEST['todt'];
$local_branch = $_REQUEST['local_branch'];
										
										
										
										
										?>



										
										
<style>
.dt-buttons{
    margin:15px 0;
}
.dataTables_paginate.paging_simple_numbers{
    width:100%;
}
									</style>	




                                </div>
                            </div>

                        <? } ?>



                        <script>
                            
$(document).on("click", ".rejectFundRequest", function() {
    let fundid = $(this).data("id"); // Get fund ID from button attribute

    // Create an input box dynamically
    let remarks = prompt("Please enter remarks for rejection:");

    // If user enters remarks
    if (remarks !== null && remarks.trim() !== "") {
        if (confirm("Are you sure you want to reject this request?")) {
            $.ajax({
                url: "reject_fund_request.php",
                type: "POST",
                data: { fundid: fundid, level: '1', remarks: remarks },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("An error occurred while rejecting the fund request.");
                }
            });
        }
    } else {
        alert("Remarks are required for rejection.");
    }
});





                            $('.update_remark').on('submit', function(e) {
                                e.preventDefault();
                                var remark = $(this).find("[name='update_remark']").val();
                                var misid = $(this).find("[name='misid']").val();
                                $.ajax({
                                    type: 'post',
                                    url: 'updatemisremark.php',
                                    data: 'remark=' + remark + '&&misid=' + misid,
                                    success: function(msg) {
                                        if (msg == 1) {
                                            swal('Updated !');
                                            setTimeout(function() {
                                                window.location.reload();
                                            }, 3000);


                                        } else if (msg == 0) {
                                            swal('Error in updated !');
                                        } else if (msg == 2) {
                                            swal('Remark should not be empty !');
                                        }
                                    }
                                });


                            });
                        </script>








                    </div>
                </div>


            </div>
        </div>
    </div>
    
    
    <!-- large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          
        <div class="header-inner" style="display: flex;justify-content: space-between;width: 100%;">
            <h4 class="modal-title" id="myModalLabel">Update - <span id="atmid_fund"></span> </h4>
            <h4 class="modal-title" id="historyModal"></h4>    
        </div>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
          <div class="col-sm-12">
              <div id="fundHistoryContent_mis_id" class="p-3 d-none" style="overflow: scroll;"></div> <!-- Initially Hidden -->                   
          </div>
          <div class="col-sm-12">
              <form>
                    <div class="row">
                        <input type="hidden" id="fund_req_id" name="fund_req_id">
                        <input type="hidden" id="misid" name="misid">
                        
                        <div class="col-sm-12">
                            <label>Requested Amount</label>
                            <input type="text" readonly id="requested_amt" class="form-control">
                        </div>
                        
                        <div class="col-sm-12">
                            <label>Branch Manager Approved Amount</label>
                            <input type="text" readonly id="bm_approved_amount" class="form-control">
                        </div>
                        
                        
                        <div class="col-sm-12">
                            <label>Approved Amount</label>
                            <input type="number" id="approved_amt" name="approved_amt" class="form-control">
                        </div>
                        
                        <div class="col-sm-12">
                            <br>
                            <label>Remarks</label>
                            <input type="text" name="fund_remarks" class="form-control" id="fund_remarks">
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <input type="submit" name="submit" value="Approve" class="btn btn-success">

                        </div>
                    </div>
                </form>
                
          </div>

              
          </div>
                
              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const requestedAmtInput = document.getElementById("requested_amt");
        const approvedAmtInput = document.getElementById("approved_amt");
        // const fillFullAmountCheckbox = document.getElementById("fill_full_amount");

        // Fill approved amount with requested amount when checkbox is checked
        // fillFullAmountCheckbox.addEventListener("change", function() {
        //     if (this.checked) {
        //         approvedAmtInput.value = requestedAmtInput.value;
        //         approvedAmtInput.setAttribute("readonly", true);
        //     } else {
        //         approvedAmtInput.value = "";
        //         approvedAmtInput.removeAttribute("readonly");
        //     }
        // });

        // Validate that approved amount does not exceed requested amount
        approvedAmtInput.addEventListener("input", function() {
            const requestedAmt = parseFloat(requestedAmtInput.value) || 0;
            const approvedAmt = parseFloat(this.value) || 0;

            if (approvedAmt > requestedAmt) {
                alert("Approved amount cannot be greater than requested amount.");
                this.value = requestedAmt;
            }
        });
    });

    $(document).on("click", ".open-AddBookDialog", function() {
        var approveamt = $(this).data('approveamt');
        
        var reqAmt = $(this).data('reqamt');
        var reqAmt = $(this).data('reqamt');
        var approvedamt = $(this).data('approvedamt');
        
        
        var misid = $(this).data('misid');
        

        var fund_id = $(this).data('id');
        $(".modal-body #fund_req_id").val(fund_id);

        $(".modal-body .rejectFundRequest").attr("data-id", fund_id);

        $(".modal-body #requested_amt").val(reqAmt);
        $(".modal-body #misid").val(misid);
        $(".modal-body #bm_approved_amount").val(approvedamt);
        

        $("#approved_amt").attr({
            "max": reqAmt,
            "min": 1
        });
    });


    $('#myModal form').on('submit', function(e) {
        var req_amt = $(".modal-body #requested_amt").val();
        var app_amt = $(".modal-body #approved_amt").val();
        var fund_remarks = $(".modal-body #fund_remarks").val();
        
        var bm_approved_amount = $(".modal-body #bm_approved_amount").val();
        var err = 0;

        if (fund_remarks === '') {
            err = 1;
            alert("Remarks must be required!");
            return false;
        }

        if (parseInt(app_amt) > parseInt(bm_approved_amount)) {
            err = 1;
            alert("Approved Amount must be less than or equal to Branch Manager Approved Amount!");
            return false;
        }

        if (err === 0) {
            e.preventDefault();
            $("#myModal .btn-success").hide();
            $.ajax({
                type: 'post',
                url: 'manager_part2_process.php',
                data: $('#myModal form').serialize(),
                
                success: function(response) {
    $("#myModal .btn-success").show();
    if (response.status === 200) {
        $('#myModal').modal('toggle');
        swal("Good job!", response.message, "success");
        setTimeout(function() {
            window.location.href = "manager_part2.php";
        }, 3000);
    } else {
        swal("Oops!", response.message, "error");
    }
},
            });
        }
    });

    $(document).on('change', '#amount_utilised', function() {
        var amount_utilised = parseFloat($(this).val()); // Get the utilized amount
        var requested_amt = parseFloat($("#requested_amt").val()); // Get the requested amount
        var bm_approved_amount = $(".modal-body #bm_approved_amount").val();
        // Check if the utilized amount is greater than the requested amount
        if (amount_utilised > bm_approved_amount) {
            alert("Utilized amount cannot be greater than the Branch Manager Approved Amount.");
            $(this).val(''); // Clear the utilized amount field
        }
    });
    
    
     $(document).on('change', '#approved_amt', function() {
        
        var req_amt = $(".modal-body #requested_amt").val();
        var app_amt = $(".modal-body #approved_amt").val();
        var bm_approved_amount = $(".modal-body #bm_approved_amount").val();
        
        if (parseInt(app_amt) > parseInt(bm_approved_amount)) {
            err = 1;
            alert("Approved Amount must be less than or equal to Branch Manager Approved Amount!");
            $(this).val('');
            $(this).focus();
            return false;
        }
        
    });
    
    
    
    
    
    
    $(document).on("click", ".open-AddBookDialog", function() {
        let raisedFundId = $(this).data("raisedfund-id"); // Get raisedFundId from clicked button
        let atmid = $(this).data("atmid"); 

        $("#fundHistoryLoader").removeClass("d-none"); // Show Spinner
        $("#fundHistoryContent_mis_id").addClass("d-none"); // Hide Data Section

        $.ajax({
            url: 'get_mis_FundHistory.php',
            type: 'POST',
            data: {
                atmid: atmid,
                raisedFundId: raisedFundId // Pass raisedFundId in AJAX request
            },
            success: function(response) {
                $("#fundHistoryContent_mis_id").html(response).removeClass("d-none"); // Show Data
                $("#fundHistoryLoader").addClass("d-none"); // Hide Spinner
                $("#atmid_fund").html(atmid);
                $("#historyModal").html('<a href="./view_fund_distribution_history.php?atmid='+atmid+'" target="_blank">View History</a>')
                
            },
            error: function() {
                $("#fundHistoryLoader").html("<p class='text-danger'>❌ Failed to fetch data. Try again.</p>");
            }
        });
    });
    
    
    
</script>



<? include('footer.php');
} else { ?>

    <script>
        window.location.href = "login.php";
    </script>
<? }
?>

<script>
    $(document).ready(function() {
        $('#multiselect').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

        $('#multiselect_bm').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });



        $('#multiselect_banks').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
        
        $('#multiselect_status').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });




    });


    $("#show_filter").css('display', 'none');

    $("#hide_filter").on('click', function() {
        $("#filter").css('display', 'none');
        $("#show_filter").css('display', 'block');
    });
    $("#show_filter").on('click', function() {
        $("#filter").css('display', 'block');
        $("#show_filter").css('display', 'none');
    });
    
    
    




</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>-->




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

    $(document).ready(function(){
        var table = $('#example').DataTable();

        // Wait for DataTable to fully initialize
        setTimeout(function(){
            var totalRecords = table.page.info().recordsTotal;
            $('#totalRecords').text("Total Records: " + totalRecords);
        }, 500); // Small delay to ensure DataTable is ready

        // Update total records on table redraw
        table.on('draw', function () {
            var totalRecords = table.page.info().recordsTotal;
            $('#totalRecords').text("Total Records: " + totalRecords);
        });
    });

</script>

</body>

</html>