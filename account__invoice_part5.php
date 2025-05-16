<?php
include('config.php');
if ($_SESSION['username']) {
    include('header.php');

    $designation = $_SESSION['designation'];
    $bm_id = $_SESSION['bm_id'];

    // error_reporting(1);
    function get_mis_history($parameter, $type, $id)
    {
        global $con;
        $sql = mysqli_query($con, "select $parameter from mis_history where type='" . $type . "' and mis_id='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result[$parameter];
    }

    // $userid = 275;
    $username = $_SESSION['username'];


    $usersql = mysqli_query($con, "select cust_id,zone from mis_loginusers where name='" . $username . "'");
    $userdata = mysqli_fetch_assoc($usersql);
    $_cust_ids = $userdata['cust_id'];
    $assigned_customers = explode(",", $_cust_ids);

    $bankPermission = $_SESSION['bankPermission'];
    $bankPermission_AR = explode(',', $bankPermission);
?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.2/sweetalert2.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

    <style>
    
    .sweet-alert.showSweetAlert.visible{
        z-index:9999999999999;
    }
        html {
            /*text-transform: inherit !important;*/
        }

        td a {
            color: #01a9ac;
            text-decoration: none;
        }

        td a:focus,
        td a:hover {
            text-decoration: none;
            color: chartreuse;
        }

        a:not([href]) {
            padding: 5px;
        }

        .btn-group {
            border: 1px solid #cccccc;
        }

        ul.dropdown-menu {
            transform: translate3d(0px, 2%, 0px) !important;
            overflow: scroll !important;
            max-height: 250px;
        }

        label {
            font-weight: 900;
            font-size: 16px;
        }
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

    foreach ($branch as $branchkey => $branchvalue) {
        $miscitysql = mysqli_query($con, "select * from mis_city where id='" . $branchvalue . "'");
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
    $zone = explode(',', $zone_result);

    $zone = json_encode($zone);
    $zone = str_replace(array('[', ']', '"'), '', $zone);
    $zone = explode(',', $zone);
    $zone = "'" . implode("', '", $zone) . "'";

    if ($zone_result) {
        $zone_query = " and b.zone in($zone)";
    } else {
        $zone_query = " ";
    }

    // echo $branch_query;die;


    $callTypePermission = $_SESSION['callTypePermission'];
    $callTypePermission_AR = explode(',', $callTypePermission);

    foreach ($callTypePermission_AR as $callTypePermission_key => $callTypePermission_val) {
        $calltypesql = mysqli_query($con, "select * from callType where id='" . $callTypePermission_val . "'");
        if ($calltypesql_result = mysqli_fetch_assoc($calltypesql)) {
            $callPermission[] = $calltypesql_result['call_type'];
        }
    }

    $callPermission = json_encode($callPermission);
    $callPermission = str_replace(array('[', ']', '"'), '', $callPermission);
    $callPermission = explode(',', $callPermission);
    $callPermission = "'" . implode("', '", $callPermission) . "'";

    if ($callTypePermission) {
        $callTypeQuery = " and b.call_type in($callPermission)";
    } else {
        $callTypeQuery = " ";
    }

    $bankPermission = $_SESSION['bankPermission'];
    $bankPermission_AR = explode(',', $bankPermission);
    $bankStrPermission = json_encode($bankPermission_AR);
    $bankStrPermission = str_replace(array('[', ']', '"'), '', $bankStrPermission);
    $bankStrPermission = explode(',', $bankStrPermission);
    $bankStrPermission = "'" . implode("', '", $bankStrPermission) . "'";

    if ($callTypePermission) {
        $bankQuery = " and a.bank in($bankStrPermission)";
    } else {
        $bankQuery = " ";
    }


    // print_r($branch);

    if (isset($_REQUEST['submit']) || isset($_GET['page'])) {

        $statement = "select a.*,b.customer,b.bank,b.address,b.city,b.state,b.zone,b.branch,
                
                (SELECT CONCAT(name) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_name,
                (SELECT CONCAT(contact) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_contact,
                a.isPaymentProcessed,a.img
                from eng_fund_request a
                    INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                    
                    where 1 and 
                a.req_status = 6 and 
                a.isPaymentProcessed = 1
                ";



        $sqlappCount = "select count(1) as total 
                from eng_fund_request a
                    INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                    
                    where 1 and 
                a.req_status = 6 and 
                a.isPaymentProcessed = 1
                
                ";



        if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
            $statement .= " and ( b.atmid = '" . $_REQUEST['atmid'] . "' ) ";
            $sqlappCount .= " and ( b.atmid = '" . $_REQUEST['atmid'] . "' ) ";
        }

        if (isset($_REQUEST['engineer']) && $_REQUEST['engineer'] != '') {



            $statement .= " and b.engineer_user_id = '" . $engineer . "'";
            $sqlappCount .= " and b.engineer_user_id = '" . $engineer . "'";
        }


        if (isset($_REQUEST['local_branch']) && $_REQUEST['local_branch'] != '') {
            $statement .= " and a.branch = '" . $_REQUEST['local_branch'] . "'";
            $sqlappCount .= " and a.branch = '" . $_REQUEST['local_branch'] . "'";
        }

        if (isset($_REQUEST['fromdt']) && $_REQUEST['fromdt'] != '' && isset($_REQUEST['todt']) && $_REQUEST['todt'] != '') {

            $date1 = $_REQUEST['fromdt'];
            $date2 = $_REQUEST['todt'];

            $statement .= " and CAST(a.created_at AS DATE) >= '" . $date1 . "' and CAST(a.created_at AS DATE) <= '" . $date2 . "'";
            $sqlappCount .= " and CAST(a.created_at AS DATE) >= '" . $date1 . "' and CAST(a.created_at AS DATE) <= '" . $date2 . "'";
        }



        if (isset($_REQUEST['customer']) && $_REQUEST['customer'] != '') {

            $cust = json_encode($_REQUEST['customer']);
            $cust = str_replace(array('[', ']', '"'), '', $cust);
            $arr = explode(',', $cust);
            $cust = "'" . implode("', '", $arr) . "'";
            $statement .= " and a.customer in($cust)";
            $sqlappCount .= " and a.customer in($cust)";
        }

        if (isset($_REQUEST['status']) && $_REQUEST['status'] != '') {

            $status = json_encode($_REQUEST['status']);
            $status = str_replace(array('[', ']', '"'), '', $status);
            $arr_status = explode(',', $status);
            $status = "'" . implode("', '", $arr_status) . "'";
            $statement .= " and a.req_status in($status)";
            $sqlappCount .= " and a.req_status in($status)";
        } else {
            $statement .= " and a.req_status in (0,1,2,3,4,5)";
            $sqlappCount .= " and b.status in (0,1,2,3,4,5)";
        }


        if (isset($_REQUEST['fund_type']) && $_REQUEST['fund_type'] != '') {
            $statement .= " and a.fund_type = '" . $fund_type . "'";
            $sqlappCount .= " and a.fund_type = '" . $fund_type . "'";
        }

        if (isset($_REQUEST['call_receive']) && $_REQUEST['call_receive'] != '') {
            $statement .= " and b.case_type = '" . $call_receive . "'";
            $sqlappCount .= " and b.case_type = '" . $call_receive . "'";
        }




        $statement .= " order by a.id desc";

        // echo $statement; 

        if ($_REQUEST['atmid'] == '' && $_REQUEST['fund_type'] == '' && $_REQUEST['engineer'] == '') {

            $date1 = $_REQUEST['fromdt'];
            $date2 = $_REQUEST['todt'];

            $statement = "select a.*,b.customer,b.bank,b.address,b.city,b.state,b.zone,b.branch,
                
                    (SELECT CONCAT(name) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_name,
                    (SELECT CONCAT(contact) from mis_loginusers WHERE id= b.engineer_user_id) AS eng_contact
                    ,a.isPaymentProcessed,a.img
                    from eng_fund_request a
                        INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                        
                        where 1 and 
                    a.req_status = 6 and 
                a.isPaymentProcessed = 1
                    ";



            $sqlappCount = "select count(1) as total 
                    from eng_fund_request a
                        INNER JOIN mis_newsite b ON b.atmid = a.atmid  
                        
                        where 1 and 
                    a.req_status = 6 and 
                a.isPaymentProcessed = 1
                    ";

            $statement .= " order by a.id desc";
        }


        // echo $statement;

        // Query to get the total number of records

        // echo $sqlappCount ; 

        $result = mysqli_query($con, $sqlappCount);
        $row = mysqli_fetch_assoc($result);
        $total_records = $row['total'];
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        $page_size = 20;

        $offset = ($current_page - 1) * $page_size;


        $total_pages = ceil($total_records / $page_size);

        $window_size = 20;

        $start_window = max(1, $current_page - floor($window_size / 2));
        $end_window = min($start_window + $window_size - 1, $total_pages);




        // Query to retrieve the records for the current page
        echo $sql_query = "$statement LIMIT $offset, $page_size";
    }

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
                                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>ATMID</label>
                                            <input type="text" name="atmid" class="form-control" value="<?php echo $_REQUEST['atmid']; ?>">
                                        </div>


                                        <div class="col-md-3">
                                            <label> Engineer </label>
                                            <select name="engineer" class="form-control">
                                                <option value=""> -- Select -- </option>
                                                <?php $eng_sql = mysqli_query($con, "select * from mis_loginusers where designation=4 and user_status=1");
                                                while ($eng_sql_result = mysqli_fetch_assoc($eng_sql)) { ?>
                                                    <option value="<?php echo $eng_sql_result['id']; ?>" <? if ($_REQUEST['engineer'] == $eng_sql_result['id']) {
                                                                                                            echo 'selected';
                                                                                                        } ?>>
                                                        <?php echo $eng_sql_result['name']; ?>
                                                    </option>
                                                <? } ?>
                                            </select>
                                        </div>




                                        <div class="col-md-3">
                                            <label>From Fund Requested Date</label>
                                            <input type="date" name="fromdt" class="form-control" value="<? if ($_REQUEST['fromdt']) {
                                                                                                                echo  $_REQUEST['fromdt'];
                                                                                                            } else {
                                                                                                                echo '2024-01-01';
                                                                                                            } ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label>To Fund Requested Date</label>
                                            <input type="date" name="todt" class="form-control" value="<? if ($_REQUEST['todt']) {
                                                                                                            echo  $_REQUEST['todt'];
                                                                                                        } else {
                                                                                                            echo date('Y-m-d');
                                                                                                        } ?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Fund Type</label>
                                            <select name="fund_type" id="fund_type" class="form-control">
                                                <option value="">-- Select --</option>

                                                <?php
                                                $callTypesql = mysqli_query($con, "Select * from engfundType where status=1");
                                                while ($callTypesql_result = mysqli_fetch_assoc($callTypesql)) {

                                                    $fundTypeId = $callTypesql_result['id'];
                                                    $fund_type_val = $callTypesql_result['fund_type'];

                                                    //  if(in_array($callTypeId,$callTypePermission_AR)){ 
                                                ?>
                                                    <option value="<?php echo $fund_type_val; ?>">
                                                        <?php echo $fund_type_val; ?>

                                                    </option>
                                                <?php  //}
                                                }

                                                ?>

                                            </select>
                                        </div>
                                        <script>
                                            $(document).on('change', '#call_type', function() {
                                                call_type = $(this).val();

                                                if (call_type == 'Project') {
                                                    option = `
                                                        <option value="">Select</option>
                                                   `;
                                                } else if (call_type == 'Service') {
                                                    option = `
                                                <option value="">Select</option>
                                                <option value="Customer / Bank">Customer / Bank</option>
                                                <option value="Internal">Internal</option>
                                                `;

                                                } else if (call_type == 'Footage') {
                                                    option = `
                                                    <option value=""> -- Select --</option>
                                                    <option>Transaction</option>
                                                    <option>Audit Case</option>
                                                    <option>BO Case </option>
                                                    <option>Chargeback</option>
                                                    <option>Fraud / Skimming / CRM Case</option>
                                                    <option>Cyber Crime</option>
                                                    <option>Dispute</option>
                                                    <option>Customer Request</option>
                                                    <option>Police Case</option>
                                                    <option>Shutter Assembly / Pre Arbitration</option>
                                                    `;
                                                }

                                                $("#call_receive").html(option);
                                            });
                                        </script>


                                        <!--<div class="col-sm-3">-->
                                        <!--    <label>Call Receive From </label>-->
                                        <!--    <select name="call_receive" id="call_receive" class="form-control"></select>-->
                                        <!--</div>-->
                                    </div>
                                    <br><br>
                                    <div class="col" style="display:flex;justify-content:center;">
                                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                        <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                    </div>

                                </form>

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

                            .open,
                            .Pending {
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
                        <?php if (isset($_REQUEST['submit']) || isset($_GET['page'])) {   ?>

                            <div class="card">
                                <div class="card-block">
                                    <div style="display:flex;justify-content:space-around;">
                                        <h5 style="text-align:center;">Fund Requested Detailed Report - <p>Total Records- <? echo $total_records;  ?></p>
                                        </h5>

                                        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    </div>


                                    <form action="exportMis.php" method="POST">
                                        <input type="hidden" name="exportSql" value="<? echo $statement; ?>">
                                        <input type="submit" name="exportMis" class="btn btn-primary" value="Export">
                                    </form>


                                    <hr>

                                    <h5 style="text-align:right;" id="row_count"></h5>
                                    <div class="custom_table_content">
                                        <table class="table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
                                                    <th>Atmid</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>

                                                    <th>Atm Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Branch</th>
                                                    <th>Fund Type</th>
                                                    <th>Fund Component</th>
                                                    <th>Fund Requested Date</th>

                                                    <th>Current Status</th>

                                                    <th>Engineer Name</th>
                                                    <th>Engineer Contact Number</th>


                                                    <th>Approved Amount</th>
                                                    <th>Aging</th>
                                                    <th>Invoice</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $date = date('Y-m-d');
                                                $date1 = date_create($date);

                                                $i = 0;

                                                $counter = ($current_page - 1) * $page_size + 1;
                                                $sql_app = mysqli_query($con, $sql_query);

                                                while ($sql_result = mysqli_fetch_assoc($sql_app)) {
                                                    $i++;
                                                    $isPaymentProcessed = $sql_result['isPaymentProcessed'];
                                                    $id = $sql_result['id'];
                                                    $createdBy = $sql_result['fund_requested_by'];
                                                    $img = $sql_result['img'];
                                                    $mis_id = $sql_result['mis_id'];


                                                    /*
                                                        $historydate = mysqli_query($con,"select created_at from mis_history where mis_id='".$id."' order by id desc limit 1");
                                                        $created_date_result = mysqli_fetch_row($historydate);
                                                        $created_date = $created_date_result[0]; */

                                                    $customer = $sql_result['customer'];
                                                    $bank = $sql_result['bank'];

                                                    $date2 = $sql_result['created_at'];
                                                    $cust_date2 = date('Y-m-d', strtotime($date2));

                                                    $cust_date2 = date_create($cust_date2);
                                                    $diff = date_diff($date1, $cust_date2);
                                                    $atmid = $sql_result['atmid'];

                                                    $status = $sql_result['req_status'];
                                                    $created_by = $sql_result['created_by'];
                                                    $aging_day = $diff->format("%a");

                                                    if ($status == 0) {
                                                        $current_status = 'Close';
                                                    }
                                                    if ($status == 1) {
                                                        $current_status = 'Eng_Request';
                                                    }
                                                    if ($status == 2) {
                                                        $current_status = 'Manager_Approved';
                                                    }
                                                    if ($status == 3) {
                                                        $current_status = 'Cashier_Paid';
                                                    }
                                                    if ($status == 4) {
                                                        $current_status = 'Invoice_Uploaded';
                                                    }
                                                    if ($status == 5) {
                                                        $current_status = 'Account_Verified';
                                                    }

                                                    $req_amt = $sql_result['requested_amount'];

                                                ?>
                                                    <tr <? if ($aging_day > 3 && $status != 0) { ?> style="background:#fe5d70c2;color:white;" <? }
                                                                                                                                            if ($status == 0) { ?> style="background:#0ac282;color:white;" <?  } elseif ($status > 1) {  ?> style="background:#6c757d;color:white;" <? } elseif ($status == 1) {  ?> style="background:yellow;color:black;" <? }  ?>>
                                                        <!--<td><? echo ++$i; ?></td>-->
                                                        <!-- <th><a href="delete_mis.php?id=<? echo $id; ?>" <? if ($aging_day > 3 && $status != 'close') { ?> style="color:white"  <? } ?>>Delete</a></th>-->

                                                        <td><? echo $counter; ?></td>
                                                        <td style=" background:white;    border: 1px solid black; ">
                                                            <a style=" text-decoration: none; font-weight: 700;" target="_blank" href="mis_details.php?id=<? echo $mis_id; ?>" <? if ($aging_day > 3 && $status != 0) { ?> style="color:white" <? } ?>>
                                                                <? echo ($sql_result['atmid'] ? $sql_result['atmid'] : '-'); ?>
                                                            </a>
                                                        </td>

                                                        <td><?php echo ($customer ? $customer : '-'); ?></td>
                                                        <td><?php echo ($bank ? $bank : '-'); ?></td>

                                                        <td>
                                                            <? echo ($sql_result['address'] ? $sql_result['address'] : '-'); ?>

                                                        </td>
                                                        <td><? echo ($sql_result['city'] ? $sql_result['city'] : '-'); ?></td>
                                                        <td><? echo ($sql_result['state'] ? $sql_result['state'] : '-'); ?></td>
                                                        <td><? echo ($sql_result['branch'] ? $sql_result['branch'] : '-'); ?></td>


                                                        <td><? echo ($sql_result['fund_type'] ? $sql_result['fund_type'] : '-'); ?></td>

                                                        <td><? echo ($sql_result['fund_component'] ? $sql_result['fund_component'] : '-'); ?></td>
                                                        <td><? echo ($sql_result['created_at'] ? $sql_result['created_at'] : '-'); ?></td>
                                                        <td><? echo ($current_status ? $current_status : '-'); ?></td>

                                                        <td> <? echo ($sql_result['eng_name'] ? $sql_result['eng_name'] : '-'); ?></td>
                                                        <td> <? echo ($sql_result['eng_contact'] ? $sql_result['eng_contact'] : '-'); ?></td>

                                                        <td> <? echo ($sql_result['approved_amount'] ? 'Rs - ' . $sql_result['approved_amount'] : '-'); ?> </td>


                                                        <td><? echo ($diff->format("%a days") ? $diff->format("%a days") : '-'); ?></td>
                                                        
                                                        <td>
                                                            <?php  if($img){ ?>
                                                            <a href="<?php echo $img; ?> " target="_blank">View</a></td>    
                                                            <? }else{
                                                            echo 'Not Available !';
                                                            }
                                                            ?>
                                                            
                                                        
                                                        
                                                        <td id="result_<?php echo $i; ?>">
                                                             <?php  if($img){ 
                                                             if ($status == 6 && $isPaymentProcessed==1) { ?>
                                                                <a data-toggle="modal" data-id="<?php echo $id; ?>" data-reqamt="<?php echo $req_amt; ?>" data-approveamt="<?php echo $sql_result['approved_amount']; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Pending</a>
                                                            <?php } else { ?>
                                                                Approved
                                                            <?php } 
                                                             }else{
                                                                 echo '-';
                                                             }
                                                             ?>

                                                        </td>
                                                    </tr>


                                                <? $counter++;
                                                } ?>

                                            </tbody>
                                        </table>
                                    </div>
<?php
                                    $customer = $_REQUEST['customer'];
                                    $customer = http_build_query(array('customer' => $customer));

                                    $status = $_REQUEST['status'];
                                    $status = http_build_query(array('status' => $status));

                                    $atmid = $_REQUEST['atmid'];
                                    $fromdt = $_REQUEST['fromdt'];
                                    $todt = $_REQUEST['todt'];
                                    $local_branch = $_REQUEST['local_branch'];

                                    echo '<div class="pagination"><ul>';
                                    if ($start_window > 1) {

                                        echo "<li><a href='?page=1&&atmid=$atmid&&$customer&&fromdt=$fromdt&&todt=$todt&&call_type=$call_type&&$status&&local_branch=$local_branch'>First</a></li>";
                                        echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '&&' . $customer . '&&fromdt=' . $fromdt . '&&todt=' . $todt . '&&call_type=' . $call_type . '&&' . $status . '&&local_branch=' . $local_branch . '">Prev</a></li>';
                                    }

                                    for ($i = $start_window; $i <= $end_window; $i++) {
                                    ?>
                                        <li class="<? if ($i == $current_page) {
                                                        echo 'active';
                                                    } ?>">
                                            <a href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&<? echo $customer; ?>&&fromdt=<? echo $fromdt; ?>&&todt=<? echo $todt; ?>&&call_type=<? echo $call_type; ?>&&<? echo $status; ?>&&local_branch=<? echo $local_branch; ?>">
                                                <? echo $i;  ?>
                                            </a>
                                        </li>

                                    <? }

                                    if ($end_window < $total_pages) {

                                        echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '&&' . $customer . '&&fromdt=' . $fromdt . '&&todt=' . $todt . '&&call_type=' . $call_type . '&&' . $status . '&&local_branch=' . $local_branch . '">Next</a></li>';
                                        echo '<li><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '&&' . $customer . '&&fromdt=' . $fromdt . '&&todt=' . $todt . '&&call_type=' . $call_type . '&&' . $status . '&&local_branch=' . $local_branch . '">Last</a></li>';
                                    }
                                    echo '</ul></div>';
                                    ?>
                                    <style>
                                        .pagination {
                                            display: flex;
                                            margin: 10px 0;
                                            padding: 0;
                                            justify-content: center;
                                        }

                                        .pagination li {
                                            display: inline-block;
                                            margin: 0 5px;
                                            padding: 5px 10px;
                                            border: 1px solid #ccc;
                                            background-color: #fff;
                                            color: #555;
                                            text-decoration: none;
                                        }

                                        .pagination li.active {
                                            border: 1px solid #007bff;
                                            background-color: #007bff;
                                            color: #fff;
                                        }

                                        .pagination li:hover:not(.active) {
                                            background-color: #f5f5f5;
                                            border-color: #007bff;
                                            color: #007bff;
                                        }
                                    </style>
                                </div>
                            </div>
                        <?php } ?>

                        <script>
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
                    <h4 class="modal-title" id="myModalLabel">Update</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
<form>
    <div class="row">
        <input type="hidden" id="fund_req_id" name="fund_req_id">

        <div class="col-sm-12">
            <label>Requested Amount</label>
            <input type="text" name="requested_amt" readonly id="requested_amt" class="form-control" value="1000"> <!-- Example value -->
        </div>

        <div class="col-sm-12">
            <label>
                <input type="checkbox" id="fill_full_amount"> Utilsed Full Amount
            </label>
        </div>

        <div class="col-sm-12">
            <label>Utilsed Amount</label>
            <input type="number" id="approved_amt" name="approved_amt" class="form-control">
        </div>

        <div class="col-sm-12">
            <label>Remarks</label>
            <input type="text" name="fund_remarks" class="form-control" id="fund_remarks">
        </div>

        <div class="col-sm-6">
            <br>
            <input type="submit" name="submit" class="btn btn-success">
        </div>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const requestedAmtInput = document.getElementById("requested_amt");
        const approvedAmtInput = document.getElementById("approved_amt");
        const fillFullAmountCheckbox = document.getElementById("fill_full_amount");

        // Fill approved amount with requested amount when checkbox is checked
        fillFullAmountCheckbox.addEventListener("change", function() {
            if (this.checked) {
                approvedAmtInput.value = requestedAmtInput.value;
                approvedAmtInput.setAttribute("readonly", true);
            } else {
                approvedAmtInput.value = "";
                approvedAmtInput.removeAttribute("readonly");
            }
        });

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
        var fund_id = $(this).data('id');
        $(".modal-body #fund_req_id").val(fund_id);
        $(".modal-body #requested_amt").val(approveamt);

        $("#approved_amt").attr({
            "max": reqAmt,
            "min": 1
        });
    });

    $('#myModal form').on('submit', function(e) {
        var req_amt = $(".modal-body #requested_amt").val();
        var app_amt = $(".modal-body #approved_amt").val();
        var fund_remarks = $(".modal-body #fund_remarks").val();
        var err = 0;

        if (fund_remarks === '') {
            err = 1;
            alert("Remarks must be required!");
            return false;
        }

        if (parseInt(app_amt) > parseInt(req_amt)) {
            err = 1;
            alert("Approved Amount must be less than or equal to Requested Amount!");
            return false;
        }

        if (err === 0) {
            e.preventDefault();
            $("#myModal .btn-success").hide();
            $.ajax({
                type: 'post',
                url: 'account__invoice_part5_process.php',
                data: $('#myModal form').serialize(),
                
                success: function(response) {
    $("#myModal .btn-success").show();
    if (response.status === 200) {
        $('#myModal').modal('toggle');
        swal("Good job!", response.message, "success");
        setTimeout(function() {
            window.location.href = "account__invoice_part5.php";
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

        // Check if the utilized amount is greater than the requested amount
        if (amount_utilised > requested_amt) {
            alert("Utilized amount cannot be greater than the requested amount.");
            $(this).val(''); // Clear the utilized amount field
        }
    });
</script>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
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
        })

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


<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>-->


</body>
</html>