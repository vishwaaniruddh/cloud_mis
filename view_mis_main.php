<? session_start();
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


?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>




    <style>
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



    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card" id="filter">
                            <div class="card-block">
                                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>ATMID</label>
                                            <input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Customer</label>
                                            <select id="multiselect" class="form-control" name="customer[]" multiple="multiple">
                                                <?
                                                $i = 0;
                                                $con_sql = mysqli_query($con, "select * from contacts where type='c'");
                                                while ($con_sql_result = mysqli_fetch_assoc($con_sql)) { ?>
                                                    <option value="<? echo $con_sql_result['contact_first']; ?>" <? if ($_POST['customer'][$i] ==  $con_sql_result['contact_first']) { echo 'selected'; }  ?>>
                                                        <? echo $con_sql_result['contact_first']; ?>
                                                    </option>
                                                <?
                                                    $i++;
                                                } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label>From Call Login Date</label>
                                            <input type="date" name="fromdt" class="form-control" value="<? if ($_POST['fromdt']) { echo  $_POST['fromdt']; } else { echo '2021-03-23'; } ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label>To Call Login Date</label>
                                            <input type="date" name="todt" class="form-control" value="<? if ($_POST['todt']) { echo  $_POST['todt']; } else { echo date('Y-m-d'); } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Call Log By</label>
                                            <select id="callreceive" class="form-control" name="call_log_by">
                                                <option value="">Select</option>
                                                <? $call_sql = mysqli_query($con, "select distinct(created_by) as created_by  from mis where created_by <>''");

                                                while ($call_sql_result = mysqli_fetch_assoc($call_sql)) {
                                                    $created_by = $call_sql_result['created_by'];
                                                    $user_sql = mysqli_query($con, "select name from mis_loginusers where id='" . $created_by . "'");
                                                    $created_name = "";
                                                    if (mysqli_num_rows($user_sql) > 0) {
                                                        $user_name_row = mysqli_fetch_row($user_sql);
                                                        $created_name = $user_name_row[0];
                                                    }

                                                ?>
                                                    <option value="<? echo $call_sql_result['created_by']; ?>" <? if ($_POST['call_log_by'] == $call_sql_result['created_by']) { echo 'selected';}  ?>>
                                                        <? echo ucfirst($created_name); ?>
                                                    </option>
                                                <? } ?>
                                            </select>
                                        </div>


                                        <!--  <div class="col-md-2">
         <label>Call Receive From</label>
         <select id="callreceive" class="form-control" name="call_receive_from">
             <option value="">Select</option>
              <? $call_sql = mysqli_query($con, "select distinct(call_receive_from) as call_receive_from  from mis where call_receive_from <>''");

                while ($call_sql_result = mysqli_fetch_assoc($call_sql)) { ?>
                  <option value="<? echo $call_sql_result['call_receive_from']; ?>" <? if ($_POST['call_receive_from'] == $call_sql_result['call_receive_from']) { echo 'selected'; }  ?>>
               <? echo ucfirst($call_sql_result['call_receive_from']); ?>
            </option> 
               <? } ?>
         </select>
     </div>  -->


                                        <!--<div class="col-md-2">-->
                                        <!--<label>BM</label>-->
                                        <!--<select id="multiselect_bm" class="form-control" name="bm[]" multiple="multiple">-->
                                        <?
                                        //   $bm_sql = mysqli_query($con,"select * from bm where status=1 order by name");
                                        //   $i = 0;
                                        //   while($bm_sql_result = mysqli_fetch_assoc($bm_sql)){ 
                                        ?>
                                        <!--<option value="<? echo $bm_sql_result['name']; ?>" <? if ($_POST['bm'][$i] == $bm_sql_result['name']) { echo 'selected'; }  ?>>-->
                                        <!--<? echo ucfirst($bm_sql_result['name']); ?>-->
                                        <!--</option> -->
                                        <!--<?
                                            //   $i++; } 
                                            ?>-->
                                        <!--</select>-->
                                        <!--</div>    -->



                                        <div class="col-md-2">
                                            <label>Status</label>
                                            <select id="multiselect_status" class="form-control" name="status[]" multiple="multiple">
                                                <?
                                                $i = 0;
                                                $status_sql = mysqli_query($con, "select * from mis_status where status='1'");
                                                while ($status_sql_result = mysqli_fetch_assoc($status_sql)) { ?>
                                                    <option value="<? echo $status_sql_result['status_code']; ?>" <? if ($_POST['status'][$i] == $status_sql_result['status_code'] )  { echo 'selected'; }  ?>>
                                                        <? echo $status_sql_result['status_name']; ?>
                                                    </option>
                                                <?
                                                    $i++;
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Zone</label>
                                            <select id="multiselect_zone" class="form-control" name="zone[]" multiple="multiple">
                                                <?
                                                $i = 0;
                                                $state_sql = mysqli_query($con, "select distinct(zone) as zone from mis_newsite where zone <> '' ");
                                                while ($state_sql_result = mysqli_fetch_assoc($state_sql)) { ?>
                                                    <option value="<? echo $state_sql_result['zone']; ?>" <? if ($_POST['zone'][$i] == $state_sql_result['zone']) { echo 'selected'; } ?>>
                                                        <? echo ucfirst($state_sql_result['zone']); ?>
                                                    </option>
                                                <? $i++;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col" style="display:flex;justify-content:center;">
                                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                        <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                    </div>

                                </form>

                                <!--Filter End -->
                                <hr>

                            </div>
                        </div>
                        <!--Filter Start -->

                        <?

                        $userid  = $_SESSION['userid'];

                        $sql = mysqli_query($con, "select * from mis_loginusers where id='" . $userid . "'");
                        $sql_result = mysqli_fetch_assoc($sql);

                        $branch_result = $sql_result['branch'];
                        $branch = explode(',', $branch_result);
                        $branch = json_encode($branch);
                        $branch = str_replace(array('[', ']', '"'), '', $branch);
                        $branch = explode(',', $branch);
                        $branch = "'" . implode("', '", $branch) . "'";
                        if ($branch_result) {
                            $branch_query = " and b.mis_city in($branch)";
                        } else {
                            $branch_query = "";
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
                            $zone_query = "";
                        }






                        if (isset($_POST['submit'])) {
                            $call_log_by = $_POST['call_log_by'];
                            // $call_receive_from = $_POST['call_receive_from'];
                            $statement = "select a.remarks,a.id,a.bank,a.customer,a.zone,a.state,b.id,b.mis_id,b.atmid,b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date from mis a, mis_details b where 1 and b.mis_id = a.id $branch_query $zone_query";

                            if (isset($_POST['call_log_by']) && $_POST['call_log_by'] != '') {
                                $statement .= " and a.created_by = '" . $_POST['call_log_by'] . "'";
                            }


                            if (isset($_POST['atmid']) && $_POST['atmid'] != '') {
                                $statement .= " and b.atmid like '%" . $_POST['atmid'] . "%'";
                            }
                            if (isset($_POST['fromdt']) && $_POST['fromdt'] != '' && isset($_POST['todt']) && $_POST['todt'] != '') {

                                $date1 = $_POST['fromdt'];
                                $date2 = $_POST['todt'];
                                
                                if(count($_POST['status'])>0){
                                    if (in_array("close", $_POST['status'])){
                                       $statement .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
                                    } else{
                                        $statement .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
                                    }
                                }else{
                                     $statement .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
                                }
                            }

                            if (isset($_POST['customer']) && $_POST['customer'] != '') {

                                $cust = json_encode($_POST['customer']);
                                $cust = str_replace(array('[', ']', '"'), '', $cust);
                                $arr = explode(',', $cust);
                                $cust = "'" . implode("', '", $arr) . "'";
                                $statement .= " and a.customer in($cust)";
                            }

                            if (isset($_POST['status']) && $_POST['status'] != '') {

                                $status = json_encode($_POST['status']);
                                $status = str_replace(array('[', ']', '"'), '', $status);
                                $arr_status = explode(',', $status);
                                $status = "'" . implode("', '", $arr_status) . "'";
                                $statement .= " and b.status in($status)";
                            } else {
                                $statement .= " and b.status in('open','permission_require','dispatch','material_requirement','material_in_process','schedule','material_available_i','material_dispatch','cancelled','not_available','available','close')";
                            }

                            if (isset($_POST['zone']) && $_POST['zone'] != '') {

                                $zone = json_encode($_POST['zone']);
                                $zone = str_replace(array('[', ']', '"'), '', $zone);
                                $arr_zone = explode(',', $zone);
                                $zone = "'" . implode("', '", $arr_zone) . "'";
                                $statement .= " and a.zone in($zone)";
                            }
                            $statement .= " order by b.id desc";


                            if ($_POST['call_log_by'] == '' && $_POST['atmid'] == '' && $_POST['customer'] == '' && $_POST['status'] == '' && $_POST['zone'] == '') {
                                $statement = "select a.remarks,a.id,a.bank,a.customer,a.zone,a.state,b.id,b.mis_id,b.atmid,b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date from mis a, mis_details b 
                                    where 1 and b.mis_id = a.id and b.status in('open','permission_require','dispatch','material_requirement','material_in_process','schedule','material_available_i','material_dispatch','cancelled','not_available','available') 
                                    order by b.id desc";
                            }
                            
                           // echo $statement;die;
                        }
                        ?>
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

                            .open {
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


                        <? if (isset($_POST['submit'])) { ?>

                            <div class="card">
                                <div class="card-block">
                                    <div style="display:flex;justify-content:space-around;">
                                        <h5 style="text-align:center;">MIS Detailed Report</h5>

                                        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    </div>
                                    <hr>
                                    <h5 style="text-align:right;" id="row_count"></h5>
                                    <div class="custom_table_content">
                                        <table class="table table-bordered table-striped" id="data_table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
                                                    <th>TicketId</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>
                                                    <th>Atmid</th>
                                                    <th>Atm Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Component</th>
                                                    <th>Sub Component</th>
                                                    <th>Current Status</th>
                                                    <th>Status Remarks</th>
                                                    <th>Schedule Date</th>
                                                    <th>Material</th>
                                                    <th>Material Remark</th>
                                                    <th>Courier Agency (Material Dispatch)</th>
                                                    <th>POD (Material Dispatch)</th>
                                                    <th>Serial Number</th>
                                                    <th>Material dispatch date </th>
                                                    <th> Material Dispatch Remark</th>
                                                    <th>Attachment (Close)</th>
                                                    <th>Close Type</th>
                                                    <th>Close Remark</th>
                                                    <th>Last Action By</th>
                                                    <th>Call Close Date</th>
                                                    <th>Call Log Date</th>
                                                    <th>Call Log By</th>
                                                    <th>BM</th>
                                                    <th>Aging</th>
                                                    <th>Remark</th>
                                                    <th>Engineer Name</th>
                                                    <th>Engineer Contact Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                    $date = date('Y-m-d');
                                                    $date1 = date_create($date);
    
                                                    $i = 0;
    
                                                    $sql = mysqli_query($con, $statement);
                                                    while ($sql_result = mysqli_fetch_assoc($sql)) {
    
                                                        $id = $sql_result['id'];
                                                        $mis_id = $sql_result['mis_id'];
                                                        $sql1 = mysqli_query($con, "select * from mis where id='" . $mis_id . "'");
                                                        $sql1_result = mysqli_fetch_assoc($sql1);
                                                        $customer = $sql1_result['customer'];
                                                        $closed_date = $sql_result['close_date'];
    
                                                        if ($closed_date != '0000-00-00') {
                                                            $date1 = date_create($closed_date);
                                                        }
    
                                                        $date2 = $sql_result['created_at'];
                                                        $cust_date2 = date('Y-m-d', strtotime($date2));
    
                                                        $cust_date2 = date_create($cust_date2);
                                                        $diff = date_diff($date1, $cust_date2);
                                                        $atmid = $sql_result['atmid'];
    
                                                        $bm_sql = mysqli_query($con, "select bm from atm_info where atmid like '" . $atmid . "'");
                                                        $bm_sql_result = mysqli_fetch_assoc($bm_sql);
                                                        $bm_name = $bm_sql_result['bm'];
    
                                                        $site_sql = mysqli_query($con, "select DVRIP from sites where ATMID = '" . $atmid . "'");
                                                        $site_sql_result = mysqli_fetch_assoc($site_sql);
                                                        $dvrip = $site_sql_result['DVRIP'];
                                                        $status = $sql_result['status'];
                                                        $created_by = $sql1_result['created_by'];
                                                        $aging_day = $diff->format("%a");
    
                                                        $lastactionsql = mysqli_query($con, "select created_by,remark from mis_history where mis_id='" . $id . "' order by id desc");
                                                        $lastactionsql_result = mysqli_fetch_assoc($lastactionsql);
                                                        $lastactionuserid = $lastactionsql_result['created_by'];
                                                        $status_remark = $lastactionsql_result['remark'];
                                                ?>
                                                    <tr <? if ($aging_day > 3 && $status != 'close') { ?> style="background:red;color:white;" <? }
                                                                                                                                        if ($status == 'close') { ?> style="background:#28a745;color:white;" <?  } elseif ($status == 'schedule') {  ?> style="background:#6c757d;color:white;" <? } elseif ($status == 'open') {  ?> style="background:yellow;color:black;" <? }  ?>>
                                                        <td><? echo ++$i; ?></td>
                                                        <!-- <th><a href="delete_mis.php?id=<? echo $id; ?>" <? if ($aging_day > 3 && $status != 'close') { ?> style="color:white"  <? } ?>>Delete</a></th>-->
                                                        <td><a target="_blank" href="mis_details.php?id=<? echo $id; ?>" <? if ($aging_day > 3 && $status != 'close') { ?> style="color:white" <? } ?>><? echo $sql_result['ticket_id']; ?></a></td>
                                                        <td><? echo $customer; ?></td>

                                                        <td><? echo $sql1_result['bank']; ?></td>
                                                        <td><? echo $atmid; ?></td>

                                                        <td>
                                                            <? echo $sql1_result['location']; ?>

                                                        </td>
                                                        <td><? echo $sql1_result['city']; ?></td>
                                                        <td><? echo $sql1_result['state']; ?></td>

                                                        <td><? echo $sql_result['component']; ?></td>
                                                        <td><? echo $sql_result['subcomponent']; ?></td>
                                                        <td><? echo $status; ?></td>
                                                        <td><? echo $status_remark; ?></td>
                                                        <td><? echo get_mis_history('schedule_date', 'schedule', $id);  ?></td>
                                                        <td><? echo get_mis_history('material', 'material_requirement', $id);  ?></td>
                                                        <td><? echo get_mis_history('remark', 'material_requirement', $id);  ?></td>
                                                        <td><? echo get_mis_history('courier_agency', 'material_dispatch', $id);  ?></td>
                                                        <td><? echo get_mis_history('pod', 'material_dispatch', $id);  ?></td>
                                                        <td><? echo get_mis_history('serial_number', 'material_dispatch', $id);  ?></td>
                                                        <td><? echo get_mis_history('dispatch_date', 'material_dispatch', $id);  ?></td>
                                                        <td><? echo get_mis_history('remark', 'material_dispatch', $id);  ?></td>
                                                        <td>
                                                            <? if (get_mis_history('attachment', 'close', $id) != '') { ?>

                                                                <a target="_blank" href="http://cssmumbai.sarmicrosystems.com/css/dash/esir/<? echo get_mis_history('attachment', 'close', $id);  ?>">http://cssmumbai.sarmicrosystems.com/css/dash/esir/<? echo get_mis_history('attachment', 'close', $id);  ?></a>
                                                            <? } ?>

                                                        </td>
                                                        <td><? echo get_mis_history('close_type', 'close', $id);  ?></td>
                                                        <td><? echo get_mis_history('remark', 'close', $id);  ?></td>
                                                        <td><? echo get_member_name($lastactionuserid); ?></td>
                                                        <td><? echo get_mis_history('created_at', 'close', $id);  ?></td>
                                                        <td><? echo $sql_result['created_at']; ?></td>
                                                        <td><? echo get_member_name($created_by); ?></td>
                                                        <td><? echo $bm_name; ?></td>
                                                        <td><? echo $diff->format("%a days"); ?></td>
                                                        <td><? echo $sql_result['remarks']; ?></td>
                                                        <td><? echo get_eng('eng', get_mis_history('engineer', 'schedule', $id));  ?></td>
                                                        <td><? echo get_eng('contact', get_mis_history('engineer', 'schedule', $id));  ?></td>

                                                    </tr>


                                                <?    } ?>

                                            </tbody>
                                        </table>



                                    </div>


                                </div>
                            </div>

                        <? } ?>

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

        $('#multiselect_status').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

        $('#multiselect_zone').multiselect({
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



    //         $(document).ready(function() {
    //     $('#data_table').DataTable( {
    //   "pageLength": 20      
    //     });
    // });    



    // $(document).ready(function() {
    //  //Initialize your table
    //  var table = $('#data_table').dataTable();
    //  //Get the total rows
    //  $("#row_count").html('Total Records' + table.fnGetData().length);
    // });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">


<script>
    $(document).ready(function() {
        $('#data_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
            ]
        });
    });
</script>

</body>

</html>