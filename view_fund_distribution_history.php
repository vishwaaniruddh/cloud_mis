<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
$atmid = $_REQUEST['atmid'];

?>


<style>
.dt-buttons{
    width:50%;
}

.table.dataTable,.dataTables_info, .dataTables_paginate.paging_simple_numbers{
    width:100% !important;
}
    th, td {
        text-align: center;
    }
</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                
                                <div class="card">
                                    <div class="card-block" >
                         
                                    <div class="row">
                                        <div class="col-sm-6" style="overflow-x:scroll;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4">Material</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Material</th>
                                                        <th>Dispatched Date</th>
                                                        <th>Dispatched To</th>
                                                        <th>Call Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    $spare_sql = mysqli_query($con,"select * from material_update where atmid='".$atmid."'");
                                                    while($spare_sql_result = mysqli_fetch_assoc($spare_sql)){
                                                        
                                                        $mis_id = $spare_sql_result['mis_id'];
                                                        $sparename= $spare_sql_result['material'] ;
                                                        $dispatch_date = $spare_sql_result['dispatch_date'];
                                                        $formdata = $spare_sql_result['formdata'] ; 
                                                        
                                                        $formdata_ar = json_decode($formdata);
            
                                                        if ($formdata_ar) {
                                                            $address_type = $formdata_ar->address_type;
                                                            $address = $formdata_ar->address;
                                                            $location = $address_type  ? $address_type .' ' . $address : $address ; 
                                                        } else {
                                                             $location = 'NA';
                                                        }
                                                        
                                                        $mis_details_sql = mysqli_query($con,"select * from mis_details where id='".$mis_id."'");
                                                        $mis_details_sql_result = mysqli_fetch_assoc($mis_details_sql);
                                                        $status = $mis_details_sql_result['status'];
                                                        
                                                        ?>
                                                        
                                                        <tr>
                                                            <td><?php echo $sparename ; ?></td>
                                                            <td><?php echo $dispatch_date ; ?></td>
                                                            <td style="white-space: normal !important;"><?php echo $location ; ?> </td>
                                                            <td><?php echo $status ; ?></td>
                                                        </tr>
                                                        
            
                                                        <?
                                                    }
                                                    
                                                    ?> 
                                        
                                        
                                            </tbody>
    </table>                             
                             </div>
                             
                             
                             
                             <div class="col-sm-6">
                                 
                                       <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" id="example2">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4">Fund</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Type Of Fund</th>
                                                        <th>Amount</th>
                                                        <th>Whom to TXN</th>
                                                        <th>Call Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                
                                                <?
                                                
                                                $fund_sql = mysqli_query($con, "
                                                SELECT * FROM (
                                                    SELECT * FROM fund_distribution_modern
                                                    UNION
                                                    SELECT * FROM fund_distribution
                                                ) AS combined_data
                                                WHERE atmid = '$atmid'
                                                ");
                                                
                                                if(mysqli_num_rows($fund_sql) > 0 ){
                                                
                                                while($fund_sql_result = mysqli_fetch_assoc($fund_sql)){
                                                    $AMOUNT = $fund_sql_result['AMOUNT'];
                                                    $Work_Type = $fund_sql_result['Work_Type'];
                                                    $Requester = $fund_sql_result['Requester'];
                                                    $mis_id_status = $fund_sql_result['mis_id'] ? true : false;
                                                    
                                                    if($mis_id_status){
                                                        $mis_details_sql = mysqli_query($con,"select * from mis_details where id='".$mis_id."'");
                                                        $mis_details_sql_result = mysqli_fetch_assoc($mis_details_sql);
                                                        $status = $mis_details_sql_result['status'];
                                                    }else{
                                                        $status = 'NA';
                                                    }
                                                    
                                                    ?>
                                                      
                                                        <tr>
                                                            <td><?php echo $Work_Type ; ?></td>
                                                            <td><?php echo $AMOUNT ; ?></td>
                                                            <td style="white-space: normal !important;"><?php echo $Requester ; ?> </td>
                                                            <td><?php echo $status ; ?></td>
                                                        </tr>
                                                    <?php
                                                    
                                                }
                                                    
                                                }else{
                                                    
                                                    ?>
                                                    <tr>
                                                        <td colspan="4">No Data Found</td>
                                                    </tr>
                                                    <?php
                                                }
                                                
                                                
                                                ?>
                                                
                                                </tbody>
                                            </table>
                             </div>
                             
                             
                         </div>               
    
    
    
    
                                    </div>
                                </div>
                                        
                                
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        

<?php


$sql = mysqli_query($con, "SELECT * FROM fund_distribution_modern WHERE atmid='" . mysqli_real_escape_string($con, $atmid) . "' ORDER BY created_at DESC");

$totalAmount = 0;
$totalTransactions = 0;
$payeeType = "";
$requester = "";
$lastFundTransferDate = "-";
$fundHistory = "";

if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        $totalAmount += $row['AMOUNT'];
        $totalTransactions++;
        $payeeType = $row['Payee_Type'];
        $requester = $row['Requester'];
        $lastFundTransferDate = $row['Fund_Transfer_Date'] ? date('d-M-Y', strtotime($row['Fund_Transfer_Date'])) : "-";

        $fundHistory .= "<tr class='hover-row'>
            <td><b>" . date('d-M-Y', strtotime($row['created_at'])) . "</b></td>
            <td><span class='badge badge-success'>₹" . number_format($row['AMOUNT'], 2) . "</span></td>
            <td>" . ucfirst($row['Requester']) . "</td>
            <td>" . date('d-M-Y', strtotime($row['Request_Date'])) . "</td>
            <td>" . date('d-M-Y', strtotime($row['Fund_Transfer_Date'])) . "</td>
            <td><span class='badge badge-primary'>" . ucfirst($row['Work_Type']) . "</span></td>
            <td>" . ucfirst($row['DESCRIPTION']) . "</td>
            <td>" . ucfirst($row['REMARK']) . "</td>
            <td><span class='badge badge-" . ($row['Fund_Transfer_Status'] == 'Completed' ? 'success' : 'warning') . "'>" . ucfirst($row['Fund_Transfer_Status']) . "</span></td>
            <td>" . ucfirst($row['Work_Status']) . "</td>
        </tr>";
    }

    echo "
        <h5 class='mb-3'>📊 <b>Fund Summary</b></h5>
        <div class='list-group'>
            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Total Amount:</b> <span class='text-success'>₹" . number_format($totalAmount, 2) . "</span>
            </div>

            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Total Transactions:</b> <span class='text-dark'>" . $totalTransactions . "</span>
            </div>
            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Last Fund Transfer Date:</b> <span class='text-danger'>" . $lastFundTransferDate . "</span>
            </div>
        </div>";


    echo "
    <br />
    <h5 class='mb-3'>📋 <b>Detailed Fund Transfer History</b></h5>
    <div class='historyFundData' style='overflow:scroll;'>
        <table class='table table-bordered table-striped table-hover dataTable js-exportable no-footer' id='example3'>
        <thead class='thead-dark'>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Requester</th>
                <th>Request Date</th>
                <th>Fund Transfer Date</th>
                <th>Work Type</th>
                <th>Description</th>
                <th>Remark</th>
                <th>Fund Status</th>
                <th>Work Status</th>
            </tr>
        </thead>
        <tbody>$fundHistory</tbody>
    </table>
    <div>
    ";
} else {
    echo "<p class='text-center text-danger'><b>No fund history available for this ATM.</b></p>";
}



// -------------------------------------------------------------------------------- Archive Data --------------------------------------------------------------------------------



$sql = mysqli_query($con, "SELECT * FROM fund_distribution WHERE atmid='" . mysqli_real_escape_string($con, $atmid) . "' ORDER BY created_at DESC");

$totalAmount = 0;
$totalTransactions = 0;
$payeeType = "";
$requester = "";
$lastFundTransferDate = "-";
$fundHistory = "";

if (mysqli_num_rows($sql) > 0) {
    echo '<p> Archived Data </p>';
    while ($row = mysqli_fetch_assoc($sql)) {
        $totalAmount += $row['AMOUNT'];
        $totalTransactions++;
        $payeeType = $row['Payee_Type'];
        $requester = $row['Requester'];
        $lastFundTransferDate = $row['Fund_Transfer_Date'] ? date('d-M-Y', strtotime($row['Fund_Transfer_Date'])) : "-";

        $fundHistory .= "<tr class='hover-row'>
            <td><b>" . date('d-M-Y', strtotime($row['created_at'])) . "</b></td>
            <td><span class='badge badge-success'>₹" . number_format($row['AMOUNT'], 2) . "</span></td>
            <td>" . ucfirst($row['Requester']) . "</td>
            <td>" . date('d-M-Y', strtotime($row['Request_Date'])) . "</td>
            <td>" . date('d-M-Y', strtotime($row['Fund_Transfer_Date'])) . "</td>
            <td><span class='badge badge-primary'>" . ucfirst($row['Work_Type']) . "</span></td>
            <td>" . ucfirst($row['DESCRIPTION']) . "</td>
            <td>" . ucfirst($row['REMARK']) . "</td>
            <td><span class='badge badge-" . ($row['Fund_Transfer_Status'] == 'Completed' ? 'success' : 'warning') . "'>" . ucfirst($row['Fund_Transfer_Status']) . "</span></td>
            <td>" . ucfirst($row['Work_Status']) . "</td>
        </tr>";
    }

    echo "
        <h5 class='mb-3'>📊 <b>Fund Summary</b></h5>
        <div class='list-group'>
            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Total Amount:</b> <span class='text-success'>₹" . number_format($totalAmount, 2) . "</span>
            </div>

            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Total Transactions:</b> <span class='text-dark'>" . $totalTransactions . "</span>
            </div>
            <div class='list-group-item d-flex justify-content-between align-items-center'>
                <b>Last Fund Transfer Date:</b> <span class='text-danger'>" . $lastFundTransferDate . "</span>
            </div>
        </div>
";

    echo "
    <br />
    <h5 class='mb-3'>📋 <b>Detailed Fund Transfer History</b></h5>
    <div class='historyFundData' style='overflow:scroll;'>
    <table class='table table-bordered table-striped table-hover dataTable js-exportable no-footer' id='example4'>
        <thead class='thead-dark'>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Requester</th>
                <th>Request Date</th>
                <th>Fund Transfer Date</th>
                <th>Work Type</th>
                <th>Description</th>
                <th>Remark</th>
                <th>Fund Status</th>
                <th>Work Status</th>
            </tr>
        </thead>
        <tbody>$fundHistory</tbody>
    </table>
    <div>
    ";
}
?>


                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
       
       
       

    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
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

    $(document).ready(function(){
        var table = $('#example').DataTable();
        var table2 = $('#example2').DataTable();
        var table3 = $('#example3').DataTable();
        var table4 = $('#example4').DataTable();
        
        // // Wait for DataTable to fully initialize
        // setTimeout(function(){
        //     var totalRecords = table.page.info().recordsTotal;
        //     $('#totalRecords').text("Total Records: " + totalRecords);
        // }, 500); // Small delay to ensure DataTable is ready

        // // Update total records on table redraw
        // table.on('draw', function () {
        //     var totalRecords = table.page.info().recordsTotal;
        //     $('#totalRecords').text("Total Records: " + totalRecords);
        // });
    });

</script>
