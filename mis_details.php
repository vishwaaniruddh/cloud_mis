<?php session_start();
include('config.php');
date_default_timezone_set("Asia/Calcutta");



if ($_SESSION['username']) {

    include('header.php');

//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">-->
    <style>
        html {
            text-transform: inherit !important;
        }

        button {
            max-width: 250px;
        }

        #travel_type_section,
        #spares_section,
        #vendors_section {
            /*box-shadow: 10px 10px 5px gray;*/
            background: #f3f3f3;
            margin: 30px auto;
            padding: 15px;
        }

        /*#Contactperson_name{display:none;}*/
        /*#Contactperson_mob{display:none;}*/
    </style>
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-block">
                                <h5>SITE INFORMATION</h5>
                                <hr>
                                <?php
                                $id = $_GET['id'];
                                $sql = mysqli_query($con, "select * from mis_details  where id= '" . $id . "'");
                                $sql_result = mysqli_fetch_assoc($sql);

                                $mis_id = $sql_result['mis_id'];


                                $atmid = $sql_result['atmid'];
                                $date = date('Y-m-d');
                                $userid = $_SESSION['userid'];

                                $ide = $sql_result['id'];

                                // echo "select * from mis_history  where mis_id = '".$ide."' " ; 
                                $detail_history = mysqli_query($con, "select * from mis_history  where mis_id = '" . $ide . "' ");
                                $fetch_detail_history = mysqli_fetch_assoc($detail_history);

                                $address_history = $fetch_detail_history['delivery_address'];
                                $mobile = $fetch_detail_history['contact_person_mob'];
                                $name = $fetch_detail_history['contact_person_name'];
                                // echo "<script> alert($name); </script>";
                            
                                $sql1 = mysqli_query($con, "select * from mis where id = '" . $mis_id . "'");
                                $sql1_result = mysqli_fetch_assoc($sql1);
                                $branch = $sql1_result['branch'];


                                ?>
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="general-info">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="table-responsive">
                                                            <table class="table m-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Ticket ID </th>
                                                                        <td><?php echo $sql_result['ticket_id']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">ATM ID</th>
                                                                        <td>
                                                                            <span><?php echo $sql_result['atmid']; ?></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Bank</th>
                                                                        <td><?php echo $sql1_result['bank']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Location</th>
                                                                        <td><?php echo $sql1_result['location']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">City</th>
                                                                        <td><?php echo $sql1_result['city']; ?></td>
                                                                    </tr>

                                                                    <th scope="row">State</th>
                                                                    <td><?php echo $sql1_result['state']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Zone</th>
                                                                        <td><?php echo $sql1_result['zone']; ?></td>
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
                                                    <div class="col-lg-12 col-xl-6">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        
                                                                        <?
                                                                        
                                                                                                        $id = $_GET['id'];
                                $sql = mysqli_query($con, "select * from mis_details  where id= '" . $id . "'");
                                $sql_result = mysqli_fetch_assoc($sql);

                                $mis_id = $sql_result['mis_id'];

                                $mis_status = $sql_result['status'];
                                // echo $mis_status;
                                $status_view = 0;
                                if ($mis_status == 'material_in_process') {
                                    $status_view = 1;
                                }

                                $sql1 = mysqli_query($con, "select * from mis where id = '" . $mis_id . "'");
                                $sql1_result = mysqli_fetch_assoc($sql1);

                                $date = date('Y-m-d H:i:s');
                                $date1 = date('Y-m-d');
                                $date1 = date_create($date1);
                                $date2 = date_create($sql_result['created_at']);
                                $diff = date_diff($date1, $date2);
                                $branch = $sql1_result['branch'];



                                $branch_sql = mysqli_query($con, "Select * from mis_city where city like '%" . $branch . "%'");
                                $branch_sql_result = mysqli_fetch_assoc($branch_sql);

                                $branch_id = $branch_sql_result['id'];




                                                                        ?>
                                                                        
                                                                         

                                                                    <tr>
                                                                        <th scope="row">Current Status</th>
                                                                        <td><?php echo $sql_result['status']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Component</th>
                                                                        <td><?php echo $sql_result['component']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Sub Component</th>
                                                                        <td><?php echo $sql_result['subcomponent']; ?></td>
                                                                    </tr>
                                                                    
                                                                     <tr>
                                                                        <th scope="row">Created On</th>
                                                                        <td>
                                                                            <span><?php echo $sql_result['created_at']; ?></span>
                                                                        </td>
                                                                    </tr>

                                                                    <th scope="row">Created By</th>
                                                                    <td><?php echo get_member_name($sql1_result['created_by']); ?>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Down Time </th>
                                                                        <td><?php echo $diff->format("%a days"); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Remark</th>
                                                                        <td><?php echo $sql1_result['remarks']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Branch</th>
                                                                        <td><?php echo $branch; ?></td>
                                                                    </tr>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- end of table col-lg-6 -->
                                                </div>
                                                <!-- end of row -->
                                            </div>
                                            <!-- end of general info -->
                                        </div>
                                        <!-- end of col-lg-12 -->
                                    </div>

                                    <!-- end of row -->
                                </div>
                            </div>
                        </div>




                        <span style="display:none;" id="atmid_fund"><?php echo $atmid; ?></span>
                        
                        





                        <div class="card">
                            <div class="card-block">
                                <h5>Change Status</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <select class="form-control" name="status" id="status">

                                            <?php if ($mis_status == 'open' || $mis_status == 'Open' || $mis_status == 'Pending') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                                
                                            <?php }

                                            if ($mis_status == 'schedule' || $mis_status == 'schedule ' || $mis_status == 'acknowledge_fund'  || $mis_status == 'fund_request_rejected' || $mis_status == 'fund_transfered' || $mis_status == 'fund_level_1_pending' || $mis_status == 'fund_level_2_pending' || $mis_status == 'material_request_rej' || $mis_status == 'pending_fund') { ?>
                                                <option value="">Select</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'material_requirement') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <!--<option value="material_dispatch">Material Dispatch</option>-->
                                                <!--<option value="material_in_process">Material in Process</option>-->
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }



                                            if ($mis_status == 'fund_required') { ?>
                                                <option value="">Select</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="schedule">Schedule</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'material_dispatch') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'close') { ?>
                                                <option value="">Select</option>
                                                <option value="reopen">Reopen</option>
                                            <?php }


                                            if ($mis_status == 'material_request_approved') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }


                                            if ($mis_status == 'material_request_rejected') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }



                                            if ($mis_status == 'permission_require') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'available') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <!--<option value="material_dispatch">Material Dispatch</option> -->
                                                <option value="permission_require">Permission Required</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'cancelled') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'MRS') { ?>
                                                <option value="">Select</option>
                                                <!--<option value="material_dispatch">Material Dispatch</option> -->
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'material_in_process') { ?>
                                                <option value="">Select</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="close">Close</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'material_delivered') { ?>
                                                <option value="">Select</option>
                                                <option value="close">Close</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'customer_issue') { ?>
                                                <option value="">Select</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'submitted') { ?>
                                                <option value="">Select</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }

                                            if ($mis_status == 'not_submitted') { ?>
                                                <option value="">Select</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>
                                            <?php }
                                            
                                             if ($mis_status == 'material_in_transit') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_delivered">Material Delivered</option>
                                                <option value="pending_fund">Pending Fund</option>

                                            <?php } 
                                            
                                            if ($mis_status == 'material_delivered') { ?>
                                                <option value="">Select</option>
                                                <option value="schedule"> Schedule</option>
                                                <option value="fund_required"> Fund Requirement</option>
                                                <option value="material_requirement">Material Requirement</option>
                                                <option value="permission_require">Permission Required</option>
                                                <option value="MRS">Material Pending</option>
                                                <option value="close">close</option>
                                                <option value="customer_issue">Customer Issue</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="not_submitted">Not Submitted</option>
                                                <option value="acknowledge_fund">Acknowledge Fund</option>
                                                <option value="material_in_transit">Material In Transit</option>
                                                <option value="pending_fund">Pending Fund</option>

                                            <?php } ?>

                                            <!--<option value="update">Update</option>-->

                                        </select>
                                    </div>
                                </div>

                                <hr>





                                <?php


                                $year = date('Y');
                                $month = date('m');

                                if (isset($_POST['status'])) {

                                    if ($_POST['status'] == 'dispatch' || $_POST['status'] == 'MRS' || $_POST['status'] == 'permission_require' || $_POST['status'] == 'broadband' || $_POST['status'] == 'material_not_available' || $_POST['status'] == 'material_available_in_branch') {
                                        $remark = $_POST['remark'];
                                        $status = $_POST['status'];
                                        echo $statement = "insert into mis_history (mis_id,type,remark,status,created_at,created_by) values('" . $id . "','" . $status . "','" . $remark . "','1','" . $date . "','" . $userid . "')";
                                    } elseif ($_POST['status'] == 'schedule') {
                                        $status = $_POST['status'];
                                        $engineer = $_POST['engineer'];
                                        $remark = $_POST['remark'];
                                        $schedule_date = $_POST['schedule_date'];
                                        $statement = "insert into mis_history (mis_id,type,engineer,remark,schedule_date,status,created_at,created_by,atmid) 
                                                values('" . $id . "','" . $status . "','" . $engineer . "','" . $remark . "','" . $schedule_date . "','1','" . $date . "','" . $userid . "','" . $atmid . "')";
                                        mysqli_query($con, "update mis_details  set engineer = '" . $engineer . "' where id = '" . $id . "'");

                                    } 
                                    elseif ($_POST['status'] == 'material_requirement') {

    echo '<pre>';
    print_r($_REQUEST);
    echo '</pre>';

    // return;

    $address = $_POST['address'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];
    $contact_name = $_POST['Contactperson_name'];
    $contact_mob = $_POST['Contactperson_mob'];
    $year = date('Y');
    $month = date('m');
    $datetime = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    
    if (!is_dir("MaterialRequirement/$year/$month/$atmid")) {
        mkdir("MaterialRequirement/$year/$month/$atmid", 0777, true);
    }
    $MR_target_dir = "MaterialRequirement/$year/$month/$atmid";

    // Handle Email Attachment
    $emailAttachment_MaterialRequirementLink = '';
    if (!empty($_FILES['emailAttachment_MaterialRequirement']['name'])) {
        $emailFile = $_FILES["emailAttachment_MaterialRequirement"];
        $emailFileName = $emailFile['name'];
        if (move_uploaded_file($emailFile["tmp_name"], "$MR_target_dir/$emailFileName")) {
            $emailAttachment_MaterialRequirementLink = "$MR_target_dir/$emailFileName";
        }
    }

    // Initialize final arrays
    $materialsArray = [];
    $conditionsArray = [];
    $allImagePaths = [];

    if (!empty($_POST['materials']) && is_array($_POST['materials'])) {
        foreach ($_POST['materials'] as $index => $materialData) {
            $material = $materialData['material'] ?? '';
            $condition = $materialData['condition'] ?? '';

            $materialsArray[] = $material;
            $conditionsArray[] = $condition;

            // Handle Images
            $images = $_FILES['materials']['name'][$index]['images'] ?? [];
            $tmp_images = $_FILES['materials']['tmp_name'][$index]['images'] ?? [];

            foreach ($images as $i => $imageName) {
                $tmpName = $tmp_images[$i];
                $destination = "$MR_target_dir/$imageName";
                if (move_uploaded_file($tmpName, $destination)) {
                    $allImagePaths[] = $destination;
                }
            }
        }
    }

    // Final comma-separated values
    $materialsCSV = implode(',', $materialsArray);
    $conditionsCSV = implode(',', $conditionsArray);
    $imagesCSV = implode(',', $allImagePaths);

    // Insert into mis_history
    $statement = "INSERT INTO mis_history 
        (mis_id, type, material, material_condition, remark, status, created_at, created_by, delivery_address, contact_person_name, contact_person_mob, emailAttachment_MaterialRequirement, images_MaterialRequirement)
        VALUES ('$id', '$status', '$materialsCSV', '$conditionsCSV', '$remark', '1', '$date', '$userid', '$address', '$contact_name', '$contact_mob', '$emailAttachment_MaterialRequirementLink', '$imagesCSV')";

    mysqli_query($con, $statement);

    // Insert into pre_material_inventory for each material separately
    foreach ($materialsArray as $i => $mat) {
        $cond = $conditionsArray[$i] ?? '';
        mysqli_query($con, "INSERT INTO pre_material_inventory 
            (mis_id, material, material_condition, remark, status, created_at, created_by, delivery_address) 
            VALUES ('$id', '$mat', '$cond', '$remark', '1', '$datetime', '$userid', '$address')");
    }
}

                                    elseif ($_POST['status'] == 'material_dispatch') {
                                        $status = $_POST['status'];
                                        $courier = $_POST['courier'];
                                        $pod = $_POST['pod'];
                                        $dispatch_date = $_POST['dispatch_date'];
                                        $remark = $_POST['remark'];
                                        $statement = "insert into mis_history (mis_id,type,courier_agency,pod,dispatch_date,remark,status,created_at,created_by) values('" . $id . "','" . $status . "','" . $courier . "','" . $pod . "','" . $dispatch_date . "','" . $remark . "','1','" . $date . "','" . $userid . "')";
                                    } elseif ($_POST['status'] == 'update') {
                                        $status = $_POST['status'];
                                        $remark = $_POST['remark'];
                                        $statement = "insert into mis_history (mis_id,type,remark,status,created_at,created_by) 
                                                values('" . $id . "','" . $status . "','" . $remark . "','1','" . $date . "','" . $userid . "')";
                                    } elseif ($_POST['status'] == 'material_in_transit') {
                                        
                                        $status = $_POST['status'];
                                        $courier = $_POST['courier'];
                                        $pod = $_POST['pod'];
                                        $delivery_date = $_POST['delivery_date'];
                                        $serialNumber = $_POST['serialNumber'];
                                        
                                        $statement = "INSERT INTO mis_history (mis_id, type, status, created_at, created_by, dispatch_date , courier_agency, pod, serial_number) 
                                          VALUES ('$id', '$status', '1', '$date', '$userid', '$delivery_date', '$courier', '$pod', '$serialNumber')";


                                    } 
                                    elseif ($_POST['status'] == 'material_delivered') {
                                        
                                        $status = $_POST['status'];
                                        $courier = $_POST['courier'];
                                        $pod = $_POST['pod'];
                                        $delivery_date = $_POST['delivery_date'];
                                        $serialNumber = $_POST['serialNumber'];
                                        
                                        $statement = "INSERT INTO mis_history (mis_id, type, status, created_at, created_by, delivery_date , courier_agency, pod, serial_number) 
                                          VALUES ('$id', '$status', '1', '$date', '$userid', '$delivery_date', '$courier', '$pod', '$serialNumber')";


                                    } 
                                    
                                    elseif ($_POST['status'] == 'paste_control') {
                                        $status = $_POST['status'];

                                        if (!is_dir('close_uploads/' . $year . '/' . $month . '/' . $atmid)) {
                                            mkdir('close_uploads/' . $year . '/' . $month . '/' . $atmid, 0777, true);
                                        }
                                        $target_dir = 'close_uploads/' . $year . '/' . $month . '/' . $atmid;

                                        $image = $_FILES['image']['name'];
                                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . '/' . $image)) {
                                            $link = $target_dir . '/' . $image;
                                            $remark = $_POST['remark'];
                                            $statement = "insert into mis_history (mis_id,type,status,created_at,created_by,attachment) values('" . $id . "','" . $status . "','1','" . $date . "','" . $userid . "','" . $link . "')";
                                        }
                                    } elseif ($_POST['status'] == 'close') {
                                        $status = $_POST['status'];
                                        $year = date('Y');
                                        $month = date('m');
                                        $close_type = $_POST['close_type'];
                                        $serial_no = $_POST['sno'];
                                        if (!is_dir('close_uploads/' . $year . '/' . $month . '/' . $atmid)) {
                                            mkdir('close_uploads/' . $year . '/' . $month . '/' . $atmid, 0777, true);
                                        }
                                        $target_dir = 'close_uploads/' . $year . '/' . $month . '/' . $atmid;
                                        $link = "";
                                        $link2 = "";
                                        $image = $_FILES['image']['name'];
                                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . '/' . $image)) {
                                            $link = $target_dir . '/' . $image;
                                        }

                                        $image2 = $_FILES['image2']['name'];
                                        if (move_uploaded_file($_FILES["image2"]["tmp_name"], $target_dir . '/' . $image2)) {
                                            $link2 = $target_dir . '/' . $image2;
                                        }

                                        $engineer = $_POST['engineer'];
                                        $remark = $_POST['remark'];
                                        $oldMaterialDetails = $_POST['oldMaterialDetails'];
                                        $statement = "insert into mis_history (mis_id,type,attachment,attachment2,remark,status,created_at,created_by,close_type,serial_number,oldMaterialDetails) values('" . $id . "','" . $status . "','" . $link . "','" . $link2 . "','" . $remark . "','1','" . $date . "','" . $userid . "','" . $close_type . "','" . $sno . "','" . $oldMaterialDetails . "')";
                                        mysqli_query($con, "update mis_details  set close_date = '" . $date . "' where id = '" . $id . "'");
                                    } elseif ($_POST['status'] == 'fund_required') {


$username = get_member_name($userid);




// var_dump($_FILES);

// echo '<br />';

// var_dump($_REQUEST);



                                        $totalDistanceTravel = 0;
                                        $allraisedComponent = '';


                                        $data = $_REQUEST;
                                        // Insert into raisedFund
                                        $fundQuery = "INSERT INTO raisedFund (mis_id, fund_type, fund_amount, remark, status, created_at, created_by, raisedFundStatus,travel_mode) 
              VALUES ('{$data['id']}', '{$data['fund_type']}', '{$data['fund_amount']}', '{$data['remark']}', '1', '" . $datetime . "', 1, 'active','{$data['travel_mode']}')";
                                        if (!mysqli_query($con, $fundQuery)) {
                                            die("Error inserting into raisedFund: " . mysqli_error($con));
                                        }
                                        $raisedFundId = mysqli_insert_id($con); // Get the last inserted ID
                            
                                        // Insert into raisedFundComponent and related tables
                                        foreach ($data['fund_component'] as $index => $component) {
                                            $componentQuery = "INSERT INTO raisedFundComponent (mis_id, raisedFundId, component, created_at, created_by, status, fundStatus) 
                       VALUES ('{$data['id']}', '$raisedFundId', '$component', NOW(), 1, '1', 'pending')";
                                            if (!mysqli_query($con, $componentQuery)) {
                                                die("Error inserting into raisedFundComponent: " . mysqli_error($con));
                                            }
                                            $allraisedComponent .= $component . ",";

                                            $raisedFundComponentId = mysqli_insert_id($con); // Get the last inserted ID for this component
                            
                                            // Insert into travelling_funds if the component is Travelling
                                            if ($component === "Travelling") {
                                                foreach ($data['travel_type'] as $travelIndex => $travelType) {
                                                    $travelQuery = "INSERT INTO travelling_funds (mis_id, raisedFundId, raisedFundComponentId, travel_type, from_site, to_site, travel_distance, calculated_amount, status) 
                            VALUES ('{$data['id']}', '$raisedFundId', '$raisedFundComponentId', '{$data['travel_type'][$travelIndex]}', 
                                    '{$data['from_site'][$travelIndex]}', '{$data['to_site'][$travelIndex]}', 
                                    '{$data['travel_distance'][$travelIndex]}', '{$data['calculated_amount'][$travelIndex]}', '1')";
                                                    if (!mysqli_query($con, $travelQuery)) {
                                                        die("Error inserting into travelling_funds: " . mysqli_error($con));
                                                    }

                                                    $totalDistanceTravel += $data['travel_distance'][$travelIndex];
                                                    $travelDataRecorded = 1;
                                                }
                                            }

if ($component === "Spares") {
    $allrequestedspares = []; // Use an array instead of a string

    // Define upload directory structure
    $currentYear = date('Y'); // e.g., 2025
    $currentMonth = date('m'); // e.g., 03
    $currentDate = date('d'); // e.g., 26
    $fund_id = $raisedFundId; // Assuming raisedFundId is the fund ID
    $uploadDir = "uploads/{$currentYear}/{$currentMonth}/{$currentDate}/fund/{$fund_id}/";

    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        chmod($uploadDir, 0777); // Ensure directory is writable
    }

    foreach ($data['spares_component'] as $spareIndex => $sparesComponent) {
        // Escape form data
        $spare_required_reason = mysqli_real_escape_string($con, $data['spare_required_reason'][$spareIndex]);
        $spares_component = mysqli_real_escape_string($con, $data['spares_component'][$spareIndex]);
        $spares_subcomponent = mysqli_real_escape_string($con, $data['spares_subcomponent'][$spareIndex]);
        $spares_cost = mysqli_real_escape_string($con, $data['spares_cost'][$spareIndex]);

        // Insert into spare_funds table
        $spareQuery = "INSERT INTO spare_funds (mis_id, raisedFundId, raisedFundComponentId, spares_component, spares_subcomponent, spares_cost, status, spare_required_reason,atmid) 
                       VALUES ('{$data['id']}', '$raisedFundId', '$raisedFundComponentId', '$spares_component', '$spares_subcomponent', '$spares_cost', '1', '$spare_required_reason','$atmid')";

        if (!mysqli_query($con, $spareQuery)) {
            die("Error inserting into spare_funds: " . mysqli_error($con));
        }

        // Get the last inserted spare_fund_id
        $spare_fund_id = mysqli_insert_id($con);

        // Store subcomponents in array
        $allrequestedspares[] = $spares_subcomponent;

        // Handle multiple image uploads (not tied to $spareIndex)
        if (isset($_FILES['spares_image']['name']) && !empty($_FILES['spares_image']['name'])) {
            $imageCount = count($_FILES['spares_image']['name']); // Total number of images
            for ($i = 0; $i < $imageCount; $i++) {
                if (!empty($_FILES['spares_image']['name'][$i]) && $_FILES['spares_image']['error'][$i] == 0) {
                    $imageName = $_FILES['spares_image']['name'][$i];
                    $imageTmpName = $_FILES['spares_image']['tmp_name'][$i];
                    $imagePath = $uploadDir . time() . '_' . basename($imageName); // Add timestamp to avoid overwriting

                    if (move_uploaded_file($imageTmpName, $imagePath)) {
                        // Insert image path into spare_funds_attachments
                        $attachmentQuery = "INSERT INTO spare_funds_attachments (spare_fund_id, type, path, status, created_at, created_by, created_by_name) 
                                            VALUES ('$spare_fund_id', 'image', '$imagePath', '1', NOW(), '{$userid}', '{$username}')";
                        if (!mysqli_query($con, $attachmentQuery)) {
                            die("Error inserting image into spare_funds_attachments: " . mysqli_error($con));
                        }
                    } else {
                        echo "Error uploading image '$imageName': " . error_get_last()['message'] . "<br>";
                    }
                }
            }
        }

        // Handle multiple video uploads (not tied to $spareIndex)
        if (isset($_FILES['spares_video']['name']) && !empty($_FILES['spares_video']['name'])) {
            $videoCount = count($_FILES['spares_video']['name']); // Total number of videos
            for ($i = 0; $i < $videoCount; $i++) {
                if (!empty($_FILES['spares_video']['name'][$i]) && $_FILES['spares_video']['error'][$i] == 0) {
                    $videoName = $_FILES['spares_video']['name'][$i];
                    $videoTmpName = $_FILES['spares_video']['tmp_name'][$i];
                    $videoPath = $uploadDir . time() . '_' . basename($videoName); // Add timestamp to avoid overwriting

                    if (move_uploaded_file($videoTmpName, $videoPath)) {
                        // Insert video path into spare_funds_attachments
                        $attachmentQuery = "INSERT INTO spare_funds_attachments (spare_fund_id, type, path, status, created_at, created_by, created_by_name) 
                                            VALUES ('$spare_fund_id', 'video', '$videoPath', '1', NOW(), '$userid', '{$username}')";
                        if (!mysqli_query($con, $attachmentQuery)) {
                            die("Error inserting video into spare_funds_attachments: " . mysqli_error($con));
                        }
                    } else {
                        echo "Error uploading video '$videoName': " . error_get_last()['message'] . "<br>";
                    }
                }
            }
        }
    }

    // Convert array to a comma-separated string
    $allrequestedspares = implode(", ", $allrequestedspares);
}

                                            // Insert into vendor_funds if the component is Vendor
                                            if ($component === "Vendor") {
                                                $vendor_name = $_REQUEST['vendor_name'];
                                                $vendorQuery = "INSERT INTO vendor_funds (mis_id, raisedFundId, raisedFundComponentId, vendor_name, vendor_amount, status) 
                        VALUES ('{$data['id']}', '$raisedFundId', '$raisedFundComponentId', '$vendor_name', '{$data['vendor_amount']}', '1')";
                                                if (!mysqli_query($con, $vendorQuery)) {
                                                    die("Error inserting into vendor_funds: " . mysqli_error($con));
                                                }
                                                $sparesDataRecorded = 1;
                                            }
                                        }

                                        $allraisedComponent = rtrim($allraisedComponent, ',');


                                        // Proceed to insert into `eng_fund_request` only if the previous step is successful
                                        $fund_type = $data['fund_type'];
                                        $fund_component = $allraisedComponent;
                                        $fund_amount = $data['fund_amount'];

                                        $eng_fund_requestsql = "INSERT INTO eng_fund_request (mis_id, atmid, fund_type, fund_component, requested_amount, req_status, fund_requested_by, created_at) 
                        VALUES ('$id', '$atmid', '$fund_type', '$fund_component', '$fund_amount', 1, '$userid', '$datetime')";
                                        if (mysqli_query($con, $eng_fund_requestsql)) {
                                            $eng_fund_request_insertId = mysqli_insert_id($con); // Get the last inserted ID
                            

                                            // echo "update raisedFund set eng_fund_req_id='".$eng_fund_request_insertId."' where id='".$raisedFundId."'" ; 
                                            mysqli_query($con, "update raisedFund set eng_fund_req_id='" . $eng_fund_request_insertId . "' where id='" . $raisedFundId . "'");



                                            // Insert into eng_fund_request_history
                                            $eng_fund_request_history_sql = "INSERT INTO eng_fund_request_history (fundreq_id, requested_amount, approved_amount, action_by, status, remarks, created_at, updated_at) 
                                      VALUES ('$eng_fund_request_insertId', '$fund_amount', '$fund_amount', '$userid', 1, '{$data['remark']}', '$datetime', '$datetime')";
                                            if (!mysqli_query($con, $eng_fund_request_history_sql)) {
                                                die("Error inserting into eng_fund_request_history: " . mysqli_error($con));
                                            }
                                        } else {
                                            die("Error inserting into eng_fund_request: " . mysqli_error($con));
                                        }

                                        // Insert into mis_history
                                        
 

                                        $status = $_POST['status'];
                                        $statement = "INSERT INTO mis_history (mis_id, type, remark, created_at, created_by,raisedFundId) 
              VALUES ('$id', '$status', '{$data['remark']}', '$date', '$userid','$raisedFundId')";

                                        echo "All data inserted successfully.";



                                    } elseif ($_POST['status'] == 'customer_dependency') {
                                        $remark = $_POST['remark'];
                                        $status = $_POST['status'];
                                        $statement = "insert into mis_history (mis_id,type,remark,created_at,created_by) values('" . $id . "','" . $status . "','" . $remark . "','" . $date . "','" . $userid . "')";
                                    } elseif ($_POST['status'] == 'reopen') {
                                        $remark = $_POST['remark'];
                                        $status = $_POST['status'];
                                        $statement = "insert into mis_history (mis_id,type,remark,created_at,created_by) values('" . $id . "','" . $status . "','" . $remark . "','" . $date . "','" . $userid . "')";

                                        mysqli_query($con, "update mis_details set status = 'pending', close_date = '' where id = '" . $id . "' ");
                                    } elseif ($_POST['status'] == 'customer_issue') {
                                        $status = $_POST['status'];
                                        $year = date('Y');
                                        $month = date('m');


                                        if (!is_dir('customer_issue/' . $year . '/' . $month . '/' . $atmid)) {
                                            mkdir('customer_issue/' . $year . '/' . $month . '/' . $atmid, 0777, true);
                                        }
                                        $target_dir = 'customer_issue/' . $year . '/' . $month . '/' . $atmid;
                                        $link = "";

                                        $image = $_FILES['issue_file']['name'];
                                        if (move_uploaded_file($_FILES["issue_file"]["tmp_name"], $target_dir . '/' . $image)) {
                                            $link = $target_dir . '/' . $image;
                                        }


                                        $engineer = $_POST['engineer'];
                                        $remark = $_POST['remark'];

                                        $statement = "insert into mis_history (mis_id,type,engineer,remark,created_at,created_by,customerIssue_Attachment) values('" . $id . "','" . $status . "','" . $engineer . "','" . $remark . "','" . $date . "','" . $userid . "','" . $link . "')";

                                        mysqli_query($con, "update mis_details set status = '" . $status . "'  where id = '" . $id . "'");
                                    } elseif ($_POST['status'] == 'acknowledge_fund') {
                                        $status = $_POST['status'];
                                        $year = date('Y');
                                        $month = date('m');


                                        if (!is_dir('fund_invoice/' . $year . '/' . $month . '/' . $atmid)) {
                                            mkdir('fund_invoice/' . $year . '/' . $month . '/' . $atmid, 0777, true);
                                        }
                                        $target_dir = 'fund_invoice/' . $year . '/' . $month . '/' . $atmid;
                                        $link = "";

                                        $image = $_FILES['fund_invoice']['name'];
                                        if (move_uploaded_file($_FILES["fund_invoice"]["tmp_name"], $target_dir . '/' . $image)) {
                                            $link = $target_dir . '/' . $image;
                                        }


                                        $engineer = '';
                                        $remark = '';

                                        $statement = "insert into mis_history (mis_id,type,engineer,remark,created_at,created_by,customerIssue_Attachment) values('" . $id . "','" . $status . "','" . $engineer . "','" . $remark . "','" . $date . "','" . $userid . "','" . $link . "')";

                                        mysqli_query($con, "update mis_details set status = '" . $status . "'  where id = '" . $id . "'");

                                        // echo "update eng_fund_request set req_status = 6 , img = '".$link."' where mis_id='".$id."'" ;
                            
                                        mysqli_query($con, "update eng_fund_request set req_status=6 , img = '" . $link . "' where mis_id='" . $id . "'");

                                        $gethistorysql = mysqli_query($con, "select * from eng_fund_request where mis_id='" . $id . "' order by id desc");
                                        $gethistorysql_result = mysqli_fetch_assoc($gethistorysql);
                                        $fund_id = $gethistorysql_result['id'];

                                        $selectsql = mysqli_query($con, "Select * from eng_fund_request_history where fundreq_id='" . $fund_id . "' order by id desc limit 1");
                                        $selectsqlresult = mysqli_fetch_assoc($selectsql);

                                        $his_id = $selectsqlresult['id'];
                                        $fundreq_id = $selectsqlresult['fundreq_id'];
                                        $requested_amount = $selectsqlresult['requested_amount'];
                                        $approved_amount = $selectsqlresult['approved_amount'];
                                        $action_by = $userid;
                                        $status = 6;

                                        mysqli_query($con, "insert into eng_fund_request_history(fundreq_id,requested_amount,approved_amount,action_by,status,remarks,created_at,updated_at) 
                                                values('" . $fundreq_id . "','" . $requested_amount . "','" . $approved_amount . "','" . $action_by . "','" . $status . "','Invoice Uploaded','" . $datetime . "','" . $datetime . "')");


                                    } elseif ($_POST['status'] == 'submitted') {
                                        $remark = $_POST['remark'];
                                        $status = $_POST['status'];
                                        $statement = "insert into mis_history (mis_id,type,remark,created_at,created_by) values('" . $id . "','" . $status . "','" . $remark . "','" . $date . "','" . $userid . "')";

                                        mysqli_query($con, "update mis_details set status = 'submitted', close_date = '' where id = '" . $id . "' ");
                                    } elseif ($_POST['status'] == 'pending_fund') {
                                        $remark = $_POST['remark'];
                                        $status = $_POST['status'];
                                        $statement = "insert into mis_history (mis_id,type,remark,created_at,created_by) values('" . $id . "','" . $status . "','" . $remark . "','" . $date . "','" . $userid . "')";

                                        mysqli_query($con, "update mis_details set status = 'submitted', close_date = '' where id = '" . $id . "' ");
                                    } elseif ($_POST['status'] == 'not_submitted') {

                                        $remark = $_POST['remark'];
                                        $status = $_POST['status'];
                                        $issues = $_POST['issue_list'];
                                        $otherIssues = $_POST['otherIssues'];


                                        $statement = "insert into mis_history (mis_id,type,remark,created_at,created_by,notSubmitted_Issues,OtherIssues) values('" . $id . "','Footage Not Submitted','" . $remark . "','" . $date . "','" . $userid . "','" . $issues . "','" . $otherIssues . "')";




                                        mysqli_query($con, "update mis_details set status = 'pending' , footage_status='Not Submitted' where id = '" . $id . "' ");

                                        $getsqlmis = mysqli_query($con, "select * from mis_details where id='" . $id . "'");
                                        $getsqlmis_result = mysqli_fetch_assoc($getsqlmis);

                                        $parentmis_id = $getsqlmis_result['mis_id'];


                                        mysqli_query($con, "update mis set status = 'pending' where id='" . $parentmis_id . "'");


                                    }


                                    // echo $statement;
                                    // die;
                            

                                    if (mysqli_query($con, $statement)) {
                                        $_mis_history_id = $con->mysqli_insert_id;

                                        if ($status == 'fund_required') {


                                            // $travelDataRecorded
                                            $sparesDataRecorded = 1;
                                            if ($sparesDataRecorded) {
                                                mysqli_query($con, "update mis_history set material='" . $allrequestedspares . "' where id='" . $_mis_history_id . "'");
                                            }
                                            
                                        mysqli_query($con, "update mis_details  set status = 'fund_level_1_pending' where id = '" . $id . "'");

                                        echo "update mis_details  set status = 'fund_level_1_pending' where id = '" . $id . "'" ;
                                             

                                        }else if($status == 'not_submitted'){
                                            
                                        }else{
                                            mysqli_query($con, "update mis_details  set status = '" . $status . "' where id = '" . $id . "'");
                                        }

                                        if ($status == 'reopen') {
                                            $status = 'pending';
                                        } else {
                                            $status = $_POST['status'];
                                        }



                                        ?>

                                        <script>
                                            swal("Great !", "Call Updated Successfully !", "success");

                                            setTimeout(function () {
                                                window.location.href = "mis_details.php?id=<?php echo $id; ?>";

                                            }, 2000);

                                        </script>
                                    <?php } else {

                                        echo mysqli_error($con);
                                        ?>

                                        <script>
                                            swal("Oops !", "Call Updated Error !", "error");
                                            setTimeout(function () {
                                                window.location.href = "mis_details.php?id=<?php echo $id; ?>";
                                            }, 2000);

                                        </script>

                                    <?php }
                                }

                                ?>

                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="row" id="status_col">

                                    </div>
                                </form>


                            </div>
                        </div>




                        <div class="card">
                            <div class="card-block" style="overflow:scroll;">
                                <h5>CALL DISPATCH INFORMATION</h5>

                                <hr>
                                <table
                                    class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                    <thead>
                                        <tr>
                                            <th>Sn No</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Date</th>
                                            <th>Schedule Date</th>
                                            <th>Require Material Name </th>
                                            <th>Engineer</th>
                                            <th>POD</th>
                                            <th>Action By</th>
                                            <th>Attchement</th>
                                            <th>Attchement 2</th>
                                            <th>Material Delivered Date</th>
                                            <th>Address (Material Requirement)</th>
                                            <th>Serial Number</th>
                                            <th>Contact Person Name</th>
                                            <th>Contact Person Mobile</th>
                                            <th>Customer Issue Attachment</th>
                                            <th>Not Submitted Reason</th>
                                            <th>Other Issues</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php

                                        $his_sql = mysqli_query($con, "select * from mis_history  where mis_id ='" . $id . "' order by id asc");
                                        $i = 1;
                                        while ($his_sql_result = mysqli_fetch_assoc($his_sql)) {
                                            $is_material_dept = $his_sql_result['is_material_dept'];
                                            $raisedFundId = $his_sql_result['raisedFundId'];
                                            
                                            
                                            $material = $his_sql_result['material'] ; 
                                            $material_condition = $his_sql_result['material_condition'];
                                            
                                            $material_with_conditon = array();
                                            $material_array = explode(',',$material);
                                            $material_condition_ar = explode(',',$material_condition);
                                            
                                            $mat_counter = 0 ; 
                                            foreach ($material_array as $material_array_key=>$material_array_values){
                                                
                                                $material_with_conditon[] = '(' .$material_array_values . '-' . $material_condition_ar[$mat_counter] . ' )';
                                                $mat_counter++ ; 
                                                
                                            }
                                            
                                            $material_with_conditon_string = implode(' / ',$material_with_conditon);
                                            
                                            

                                            $images_MaterialRequirementString = $his_sql_result['images_MaterialRequirement'];

                                            $images_MaterialRequirementAR = explode(',', $images_MaterialRequirementString);

                                            $materialbtns = '';
                                            if ($his_sql_result['type'] == 'material_requirement') {

                                                foreach ($images_MaterialRequirementAR as $images_MaterialRequirementARKey => $images_MaterialRequirementARVal) {

                                                    $materialbtns .= '<a href="' . $images_MaterialRequirementARVal . '" target="_blank">View</a> / ';

                                                }

                                            }


                                            ?>
                                            <tr <?php if ($is_material_dept == 1) { ?>
                                                    style="background-color: #404e67;color:white;" <?php } ?>>
                                                <td><?php echo $i; ?></td>

                                                <td>
                                                    <?php


                                                    if ($his_sql_result['type'] == 'fund_required') {

                                                        echo '<a href="#" class="badge badge-info" data-raisedfund-id="' . $raisedFundId . '" id="fundhistorybtn" data-toggle="modal" data-target="#fundHistoryModal_mis_history">' .
                                                            strtoupper($his_sql_result['type']) . '</a>';

                                                    } else {
                                                        echo $his_sql_result['type'];
                                                    }



                                                    ?>




                                                </td>

                                                <td><?php echo $his_sql_result['remark']; ?></td>
                                                <td><?php echo $his_sql_result['created_at']; ?></td>
                                                <td><?php if ($his_sql_result['schedule_date'] != '0000-00-00') {
                                                    echo $his_sql_result['schedule_date'];
                                                } ?>
                                                </td>
                                                <td><?php echo $material_with_conditon_string; ?></td>
                                                <td><?php echo get_member_name($his_sql_result['engineer']); ?></td>
                                                <td><?php echo $his_sql_result['pod']; ?></td>
                                                <td><?php

                                                if ($is_material_dept == 1) {
                                                    $material_dept_userid = $his_sql_result['material_dept_userid'];

                                                    echo getesurvUsername($material_dept_userid);
                                                } else {
                                                    echo get_member_name($his_sql_result['created_by']);
                                                }




                                                ?></td>
                                                <td> <?php if ($his_sql_result['attachment']) { ?><a
                                                            href="<?php echo $his_sql_result['attachment']; ?>"
                                                            target="_blank">View Attachment</a> <?php }

                                                echo $materialbtns;
                                                ?></td>
                                                <td> <?php if ($his_sql_result['attachment2']) { ?><a
                                                            href="<?php echo $his_sql_result['attachment2']; ?>"
                                                            target="_blank">View Attachment</a> <?php } ?></td>

                                                <td><?php if ($his_sql_result['delivery_date'] != '0000-00-00') {
                                                    echo $his_sql_result['delivery_date'];
                                                } ?>
                                                </td>
                                                <td><?php echo $his_sql_result['delivery_address']; ?></td>
                                                <td><?php echo $his_sql_result['serial_number']; ?></td>


                                                <td><?php echo $his_sql_result['contact_person_name']; ?></td>
                                                <td><?php echo $his_sql_result['contact_person_mob']; ?></td>
                                                <td> <?php if ($his_sql_result['customerIssue_Attachment']) { ?><a
                                                            href="<?php echo $his_sql_result['customerIssue_Attachment']; ?>"
                                                            target="_blank">View Attachment</a> <?php }


                                                ?></td>
                                                <td><?php echo $his_sql_result['notSubmitted_Issues']; ?></td>
                                                <td><?php echo $his_sql_result['OtherIssues']; ?></td>


                                            </tr>
                                            <?php $i++;
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="card">
                            <div class="card-block">

                                <h5>Fund History</h5>
                                <hr>
                                <?php




                                ?>
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                     
                                     <?php 
                                     
                                     require_once('getFundHistory.php');
                                     ?>
                                     
                                        </div>
                                        <!-- end of col-lg-12 -->
                                    </div>
                                    <!-- end of row -->
                                </div>


                            </div>
                        </div>





                    </div>
                </div>


            </div>
        </div>
    </div>




    <!-- Updated Modal -->
    <div class="modal fade" id="fundHistoryModal_mis_history" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document"> <!-- Removed extra modal -->
            <div class="modal-content">

                <div class="modal-body">
                    <!-- Spinner Loader -->
                    <div id="fundHistoryLoader" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="text-muted mt-2">Fetching fund history...</p>
                    </div>

                    <!-- Fund Data -->
                    <div id="fundHistoryContent_mis_id" class="p-3 d-none"></div> <!-- Initially Hidden -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(document).on("click", "#fundhistorybtn", function () {
                let raisedFundId = $(this).data("raisedfund-id"); // Get raisedFundId from clicked button
                let atmid = $("#atmid_fund").text().trim(); // Fetch ATM ID

                $("#fundHistoryLoader").removeClass("d-none"); // Show Spinner
                $("#fundHistoryContent_mis_id").addClass("d-none"); // Hide Data Section

                $.ajax({
                    url: 'get_mis_FundHistory.php',
                    type: 'POST',
                    data: {
                        atmid: atmid,
                        raisedFundId: raisedFundId // Pass raisedFundId in AJAX request
                    },
                    success: function (response) {
                        $("#fundHistoryContent_mis_id").html(response).removeClass("d-none"); // Show Data
                        $("#fundHistoryLoader").addClass("d-none"); // Hide Spinner
                    },
                    error: function () {
                        $("#fundHistoryLoader").html("<p class='text-danger'>❌ Failed to fetch data. Try again.</p>");
                    }
                });
            });
        });

    </script>


    <?php include('footer.php');

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


        function fetchFundRequiredContent() {
            $("#status_col").html('<div class="loader">Loading...</div>');
            return fetch(`./fund_management.php`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .catch(error => {
                    console.error('Error fetching HTML:', error);
                    return 'Error loading content.'; // Fallback content
                });
        }


        function throttle(f, delay) {
            var timer = null;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = window.setTimeout(function () {
                    f.apply(context, args);
                },
                    delay || 1000);
            };
        }


        $(document).ready(function () {
            $(".js-example-basic-single").select2();
        });

        // $("#address_type").on("change",function(){ debugger; 
        function setaddress() {
            debugger;
            var address_type = $('#address_type').val();
            if (address_type == 'Branch') {
                $('#address').val('Branch');
                $('#address').attr('readonly', true);
                $('#Contactperson_name').hide();
                $('#Contactperson_mob').hide();
                $('#Contactperson_name_text').attr('required', false);
                $('#Contactperson_mob_text').attr('required', false);
                $('#address').show();
            }
            if (address_type == 'Other') {
                $('#address').val('');
                $('#address').attr('readonly', false);
                $('#Contactperson_name').show();
                $('#Contactperson_mob').show();
                $('#Contactperson_name_text').attr('required', true);
                $('#Contactperson_mob_text').attr('required', true);
                //  $('#address').show();
            }
        }

        $("#status").on("change", function () {
            var status = $(this).val();
            $("#status_col").html('');



            if (status == 'update') {
                var html = '<input type="hidden" name="status" value="update"><div class="col-sm-12"><label>Update Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'dispatch') {
                var html = '<input type="hidden" name="status" value="dispatch"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'schedule') {
                var html = '<input type="hidden" name="status" value="schedule"><div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><? $eng_sql = mysqli_query($con, "SELECT * FROM mis_loginusers where user_status=1 and designation=4");
                while ($eng_sql_result = mysqli_fetch_assoc($eng_sql)) { ?> <option value="<?php echo $eng_sql_result['id']; ?>"><?php echo $eng_sql_result['name']; ?></option> <?php } ?></select></div><div class="col-sm-4"><label>Schedule Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><label>Schedule Date</label><input type="date" name="schedule_date" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'material_requirement') {
                
                var html = `
                
                
                <input type="hidden" name="status" value="material_requirement">

<div class="table-responsive">
  <table class="table table-bordered" id="materialTable">
    <thead class="thead-light">
      <tr>
        <th>Request Material</th>
        <th>Material Condition</th>
        <th>Image (Multiple)</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="materialBody">
      <tr>
        <td>
          <select class="form-control" name="materials[0][material]">
            <option value="">Select</option>
            <?php 
              $mat_sql = mysqli_query($con, "SELECT * FROM material WHERE status=1");
              while ($mat_sql_result = mysqli_fetch_assoc($mat_sql)) { ?>
                <option value="<?php echo $mat_sql_result['material']; ?>">
                  <?php echo $mat_sql_result['material']; ?>
                </option>
            <?php } ?>
          </select>
        </td>
        <td>
          <select class="form-control" name="materials[0][condition]">
            <option value="">Select</option>
            <option value="Missing">Missing</option>
            <option value="Faulty">Faulty</option>
            <option value="Not Installed">Not Installed - By Project Team</option>
          </select>
        </td>
        <td>
          <input type="file" class="form-control" name="materials[0][images][]" multiple>
        </td>
        <td class="text-center text-muted">—</td>
      </tr>
    </tbody>
  </table>
</div>

<div class="mb-3">
  <button type="button" class="btn btn-info" id="addRow">+ Add More</button>
</div>

<!-- Other Fields -->
<div class="row">
  <div class="col-md-12 mb-3">
    <label>Remark</label>
    <input type="text" name="remark" class="form-control">
  </div>

  <div class="col-md-12 mb-3">
    <label>Dispatch Address 2</label>
    <input list="item_name" class="form-control" name="address" id="address" value="<?php echo isset($address_history) ? remove_special($address_history) : ''; ?>">
    <datalist id="item_name"></datalist>
  </div>

  <div class="col-md-6 mb-3">
    <label>Contact Person Name</label>
    <input type="text" class="form-control" name="Contactperson_name" value="<?php echo $name ?? ''; ?>" <?php echo ($name != '') ? 'readonly' : ''; ?>>
  </div>

  <div class="col-md-6 mb-3">
    <label>Contact Person Mobile</label>
    <input type="text" class="form-control" name="Contactperson_mob" value="<?php echo $mobile ?? ''; ?>" <?php echo ($mobile != '') ? 'readonly' : ''; ?>>
  </div>

  <div class="col-md-6 mb-3">
    <label>Email Attachment</label>
    <input type="file" class="form-control" name="emailAttachment_MaterialRequirement" required>
  </div>

  <div class="col-md-4 mt-2">
    <br>
    <input class="btn btn-success" type="submit" name="submit" value="Submit">
  </div>
</div>

                
                
                `;
                
                
                
                


            }
            else if (status == 'material_dispatch') {
                var html = '<input type="hidden" name="status" value="material_dispatch"><div class="col-sm-3"><label>Courier Agency</label><input type="text" name="courier" class="form-control"></div><div class="col-sm-3"><label>POD</label><input type="text" name="pod" class="form-control"></div><div class="col-sm-3"><label>Dispatch Date</label><input type="date" name="dispatch_date" class="form-control"></div><div class="col-sm-3"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-primary" type="submit" value="Update" name="submit"></div>';
            }
            else if (status == 'close') {

                var html = `<input type="hidden" name="status" value="close">
            <div class="col-sm-3"><label>Before Work</label><input type="file" name="image" class="form-control"></div>
            <div class="col-sm-3"><label>After Work</label><input type="file" name="image2" class="form-control" required></div>
            <div class="col-sm-3"><label>Serial No</label><input type="text" name="sno" class="form-control"></div>
            <div class="col-sm-3"><label>Close Type</label><select name="close_type" id="close_type" class="form-control" required><option value=""> Select </option><option value="replace"> Replace </option><option value="repair"> Repair </option><option value="Footage Call"> Footage Call </option></select></div>
            <div class="col-sm-12 oldMaterialDetails" style="display:none;">
            <br />
                <label>Old Material Details</label>
                <select name="oldMaterialDetails" id="oldMaterialDetails" class="form-control">
                  <option>-- Select --</option>
                  <option value="Old Material with Engineer">Old Material with Engineer</option>
                  <option value="Old Material Missing">Old Material Missing</option>
                  <option value="Old Material Scrap">Old Material Scrap</option>
                  <option value="Old Material in Service Center">Old Material in Service Center</option>
                  <option value="Old Material in Branch Office">Old Material in Branch Office</option>
                  <option value="Old Material in Dispached to Mumbai">Old Material in Dispached to Mumbai</option>
                </select>  
                </div>
            <div class="col-sm-4"><br><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><label>Engineer</label><select name="engineer" class="form-control"><option value="">Select</option> <?php $branch_sql = mysqli_query($con, "select distinct(engineer_user_id) as engid from mis_newsite where branch = '" . $branch . "' and engineer_user_id<>'' ");
            if (mysqli_num_rows($branch_sql) > 0) {
                while ($branchsqlres = mysqli_fetch_assoc($branch_sql)) {
                    $eng_userid = $branchsqlres['engid'];
                    $eng_sql = mysqli_query($con, "select name, id from mis_loginusers where id = '" . $eng_userid . "' ");
                    $eng_sql_result = mysqli_fetch_assoc($eng_sql); ?><option value="<?php echo $eng_sql_result['id']; ?>"><?php echo $eng_sql_result['name']; ?></option> <?php }
            } ?></select></div><div class="col-sm-4"><br><br><input class="btn btn-danger" value="Close" type="submit" name="submit"></div>` ;
            }
            else if (status == 'paste_control') {
                var html = '<input type="hidden" name="status" value="paste_control"><div class="col-sm-4"><label>Attache File</label><input type="file" name="image" class="form-control"></div><div class="col-sm-4"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-danger" value="Submit" type="submit" name="submit"></div>';
            }
            else if (status == 'material_available_in_branch') {
                var html = '<input type="hidden" name="status" value="material_available_in_branch"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'material_not_available') {
                var html = '<input type="hidden" name="status" value="material_not_available"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'broadband') {
                var html = '<input type="hidden" name="status" value="broadband"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'permission_require') {
                var html = '<input type="hidden" name="status" value="permission_require"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'reopen') {
                var html = '<input type="hidden" name="status" value="reopen"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'material_delivered') {
                
                var html = `<input type="hidden" name="status" value="material_delivered">
                
                <div class="col-sm-3"><label>Courier</label>
                <select name="courier" class="form-control">
                <?php 
                $courier_sql = mysqli_query($con,"select * from camp_couriers where status='active'");
                while($courier_sql_result = mysqli_fetch_assoc($courier_sql)){
                $couriername = $courier_sql_result['couriername'];
                ?>
                <option value="<?php echo $couriername ; ?>"><?php echo $couriername ; ?></option>

                
                <?php 
                    
                }
                
                ?>
                </select>
                </div>
                
                <div class="col-sm-3"><label>POD</label><input type="text" name="pod" class="form-control"></div>
                <div class="col-sm-3"><label>Product Serial Number</label><input type="text" name="serialNumber" class="form-control"></div>

                <div class="col-sm-3"><label>Delivery Date</label><input type="date" name="delivery_date" class="form-control"></div>
                
                <div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>`;
            }
            else if (status == 'material_in_transit') {
                var html = `<input type="hidden" name="status" value="material_in_transit">
                
                <div class="col-sm-3"><label>Courier</label>
                <select name="courier" class="form-control">
                <?php 
                $courier_sql = mysqli_query($con,"select * from camp_couriers where status='active'");
                while($courier_sql_result = mysqli_fetch_assoc($courier_sql)){
                $couriername = $courier_sql_result['couriername'];
                ?>
                <option value="<?php echo $couriername ; ?>"><?php echo $couriername ; ?></option>

                
                <?php 
                    
                }
                
                ?>
                </select>
                </div>
                
                <div class="col-sm-3"><label>POD</label><input type="text" name="pod" class="form-control"></div>
                <div class="col-sm-3"><label>Product Serial Number</label><input type="text" name="serialNumber" class="form-control"></div>

                <div class="col-sm-3"><label>Dispatch Date</label><input type="date" name="delivery_date" class="form-control"></div>
                
                <div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>`;
            }
            
            else if (status == 'MRS') {
                var html = '<input type="hidden" name="status" value="MRS"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            } else if (status == 'fund_required') {
                // let html = ""; // Declare html outside the fetchData function

                // function fetchData() {
                //     fetch(`./fund_management.php`)
                //         .then(response => response.text())
                //         .then(data => { 
                //             html = data; // Assign the received HTML to the variable
                //         })
                //         .catch(error => {
                //             console.error('Error fetching HTML:', error);
                //             html = 'Error loading content.';
                //         });
                // }

                // fetchData(); // Call the function to initiate the fetch

                // // Use a setTimeout to allow time for the fetch to complete 
                // setTimeout(() => { 
                //     $("#status_col").html(html); 
                // }, 1500); 


                fetchFundRequiredContent().then(fetchedHtml => {
                    $("#status_col").html(fetchedHtml);
                });




            }
            else if (status == 'customer_dependency') {
                var html = '<input type="hidden" name="status" value="customer_dependency"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            } else if (status == 'customer_issue') {
                var html = '<input type="hidden" name="status" value="customer_issue"><div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><? $eng_sql = mysqli_query($con, "SELECT * FROM mis_loginusers where user_status=1 and designation=4");
                while ($eng_sql_result = mysqli_fetch_assoc($eng_sql)) { ?> <option value="<?php echo $eng_sql_result['id']; ?>"><?php echo $eng_sql_result['name']; ?></option> <?php } ?></select></div><div class="col-sm-4"><label>Engineer Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><label>Attachment</label><input type="file" name="issue_file" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'not_submitted') {
                var html = `<input type="hidden" name="status" value="not_submitted">
            
            <div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><?php $eng_sql = mysqli_query($con, "SELECT * FROM mis_loginusers where user_status=1 and designation=4");
            while ($eng_sql_result = mysqli_fetch_assoc($eng_sql)) { ?> <option value="<?php echo $eng_sql_result['id']; ?>"><?php echo $eng_sql_result['name']; ?></option> <?php } ?></select></div>
            
            <div class="col-sm-4"><label>Engineer Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><label>Issues</label><select name="issue_list"  id="issue_list" class="form-control"><option value="">Select</option><option value="HDD Faulty">HDD Faulty</option><option value="HO Team">HO Team</option><option value="HDD Not Installed">HDD Not Installed</option><option value="HDD Missing">HDD Missing</option><option value="DVR Faulty">DVR Faulty</option><option value="DVR Missing">DVR Missing</option value="NVR Faulty">NVR Faulty<option value="NVR Missing">NVR Missing</option><option value="NVR Not Installed">NVR Not Installed</option><option value="Camera Missing">Camera Missing</option><option value="Camera Not Installed">Camera Not Installed</option><option value="Camera faulty">Camera faulty</option><option value="SMPS Issue">SMPS Issue</option><option value="Given Date Footage Missing">Given Date Footage Missing</option><option value="Given Time Footage Missing">Given Time Footage Missing</option><option value="SD Card Faulty">SD Card Faulty</option><option value="SD Card Missing">SD Card Missing</option><option value="SD Card Not Installed">SD Card Not Installed</option><option value="Other">Other</option></select></div><br><div class="col-sm-12 otherIssues" style="display:none;"><br><br><label>Other Issues</label><br><input type="text" name="otherIssues" id="otherIssues" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit" ></div>`;
            }
            else if (status == 'submitted') {
                var html = '<input type="hidden" name="status" value="submitted"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'pending_fund') {
                var html = '<input type="hidden" name="status" value="pending_fund"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }
            else if (status == 'acknowledge_fund') {

                var html = '<input type="hidden" name="status" value="acknowledge_fund"><div class="col-sm-12"><label>Upload Invoice</label><input type="file" name="fund_invoice" class="form-control" required></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
            }




            $("#status_col").html(html);
            $(".js-example-basic-single").select2();
            // $(".engsearch").select2();
        });


        $(document).on('change', '#close_type', function () {
            let close_type = $("#close_type").val();

            if (close_type == 'replace') {
                $(".oldMaterialDetails").css('display', 'block');
            } else {
                $(".oldMaterialDetails").css('display', 'none');
            }
        })

        $(document).on('change', '#issue_list', function () {
            let Other = $("#issue_list").val();

            if (Other == 'Other') {
                $(".otherIssues").css('display', 'block');
            } else {
                $(".otherIssues").css('display', 'none');
            }
        })


        $(document).on('keyup', '#address', throttle(function () {
            $("#item_name").html('');
            add = $(this).val();
            $.ajax({
                type: "POST",
                url: 'suggested_address.php',
                data: 'address=' + add,
                success: function (msg) {

                    $("#item_name").append(msg);


                }
            });
            //   alert(add);
        }));




        $(document).on('change', '#fund_type', function () {
            console.log($(this).val());
            $("#other_fund").html('');

            if ($(this).val() === 'Other') {
                // Create input fields for distance and amount
                var htmlinput = `
            <div class="row">
                <div class="col-sm-12">
                    <label>Enter Fund Type</label>
                    <input type="text" id="other_fund_type" name="other_fund_type" class="form-control" placeholder="other_fund_type">
                </div>
            </div>
        `;

                // Append the input fields to the container
                $("#other_fund").html(htmlinput);
            }
        });




        // Calculate fund amount dynamically based on the entered distance
        $(document).on('input', '#distance', function () {
            var distance = parseFloat($(this).val()); // Get the entered distance
            var fundAmount = 0;

            // Apply the calculation logic
            if (distance > 100) {
                fundAmount = (distance - 100) * 2.5;
            }

            // Update the fund amount field
            $("#fund_amount").val(fundAmount.toFixed(2)); // Format to 2 decimal places
        });
        
        
        
        
        $(document).ready(function(){
  let materialIndex = 1;


        $(document).on('click', '#addRow', function () {
      console.log('sa')
    let newRow = `
      <tr>
        <td>
          <select class="form-control" name="materials[${materialIndex}][material]">
            <option value="">Select</option>
            <?php 
              $mat_sql = mysqli_query($con, "SELECT * FROM material WHERE status=1");
              while ($mat_sql_result = mysqli_fetch_assoc($mat_sql)) { ?>
                <option value="<?php echo $mat_sql_result['material']; ?>">
                  <?php echo $mat_sql_result['material']; ?>
                </option>
            <?php } ?>
          </select>
        </td>
        <td>
          <select class="form-control" name="materials[${materialIndex}][condition]">
            <option value="">Select</option>
            <option value="Missing">Missing</option>
            <option value="Faulty">Faulty</option>
            <option value="Not Installed">Not Installed - By Project Team</option>
          </select>
        </td>
        <td>
          <input type="file" class="form-control" name="materials[${materialIndex}][images][]" multiple>
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
        </td>
      </tr>`;
    $('#materialBody').append(newRow);
    materialIndex++;
  });
            
        })

  $(document).on('click', '.removeRow', function () {
    $(this).closest('tr').remove();
  });

        


    </script>


    <?php
} else {
    ?>
    <script>
        window.location.href = "login.php";
    </script>
<? }
?>
</body>

</html>