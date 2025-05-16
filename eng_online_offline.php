<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');
$today_date = date('Y-m-d');
// $last_date = "2022-07-20";
if ($_SESSION['username']) {

    include('header.php');


?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


    <style>
        th.address,
        td.address {
            white-space: inherit;
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
                                        <div class="col-md-3">
                                            <label>Engineer</label>
                                            <select name="engineer" class="form-control">
                                                <option value=""> Select Engineer</option>
                                                <? $ac_sql = mysqli_query($con, "SELECT id, name as engineer from mis_loginusers where  designation = 4 order by name ASC");
                                                while ($ac_sql_result = mysqli_fetch_assoc($ac_sql)) { 
                                                ?>
                                                
                                                    <option value="<? echo $ac_sql_result['id']; ?>" <? if (isset($_POST['engineer']) && $_POST['engineer'] == $ac_sql_result['engineer']) { echo 'selected';} ?>>
                                                        <? echo $ac_sql_result['engineer']; ?>
                                                    </option>
                                                <? } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Date</label>
                                            <input type="date" name="dt" class="form-control" value="<? if ($_POST['dt']){ echo  $_POST['dt']; } else {echo date('Y-m-d'); } ?>">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="col" style="display:flex;justify-content:center;">
                                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                    </div>


                                </form>

                                <!--Filter End -->
                                <hr>

                            </div>
                        </div>
                        
                        <?php
                            if($_POST['submit']){
                                $engid = $_POST['engineer'];
                                $date = $_POST['dt'];
                                if($engid){
                                    $statement = "SELECT * from mis_loginusers where  designation = 4 and id = '".$engid."' order by name ASC";
                                }
                                else 
                                {
                                    $statement = "SELECT * from mis_loginusers where  designation = 4 order by name ASC";
                                }
                            }
                        ?>
                        
                        <?php if($_POST['submit'] && $_POST['dt']) {
                            $date = $_POST['dt'];
                        ?>
                        <div class="card">
                            <div class="card-block" style="overflow: auto;">

                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sn No.</th>
                                            <th>Engineer Name</th>
                                            <!--<th>dvr </th>-->
                                            <th>Site Online</th>
                                            <th>Site Offline</th>
                                            <th>Online Percentage</th>
                                            <th>Footage Call</th>
                                            <th>Service Call</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $i = 1;
                                        // $csql = mysqli_query($con, "SELECT * from mis_loginusers where  designation = 4 order by name ASC");
                                        $csql = mysqli_query($con,$statement);
                                        $csql_rows = mysqli_num_rows($csql);
                                        if ($csql_rows != '') {
                                            while ($csql_result = mysqli_fetch_assoc($csql)) {
                                                $eng_id = $csql_result['id'];
                                                $eng_name = $csql_result['name'];
                                                $footagecount = 0;
                                                $servicecount = 0;

                                                $sql = "select atmid from mis_newsite where engineer_user_id='" . $eng_id . "' ";
                                                $oncount = 0;
                                                $offcount = 0;
                                                $sqlr = mysqli_query($con, $sql);
                                                $countsql = mysqli_num_rows($sqlr);
                                                if ($countsql > 0) {
                                                    while ($sql_result = mysqli_fetch_assoc($sqlr)) {

                                                        $atmid = $sql_result['atmid'];

                                                        $checkstatus = mysqli_query($con, "select * from site_status where atmid ='" . $atmid . "' and CAST(created_at as date)='" . $date . "' ");
                                                        // $checkstatus = mysqli_query($con,$checksql);
                                                        if (mysqli_num_rows($checkstatus) > 0) {
                                                            $checkstatus_result = mysqli_fetch_assoc($checkstatus);
                                                            $dvr_status = $checkstatus_result['dvr_status'];
                                                            
                                                            if ($dvr_status == "Online") {
                                                                $oncount = $oncount + 1;
                                                            } else {
                                                                $offcount = $offcount + 1;
                                                            }
                                                        }else{ echo "";}
                                                    }
                                                }

                                                $footagesql = mysqli_query($con, "select * from eng_footage_request_history where created_by = '" . $eng_id . "' and CAST(created_at as date)='" . $date . "' ");
                                                // $footagesql = mysqli_query($con,$footagesql);
                                                if (mysqli_num_rows($footagesql) > 0) {
                                                    while ($footage_res = mysqli_fetch_assoc($footagesql)) {
                                                        $update_status = $footage_res['update_status'];
                                                        $footage_id = $footage_res['footage_id'];

                                                        if ($update_status == "Available") {
                                                            $footagecount = $footagecount + 1;
                                                        }
                                                    }
                                                }
                                                
                                                
                                                // $servsql = mysqli_query($con,"SELECT * FROM `mis_details` where mis_id in (select id from mis) and engineer = '".$eng_id."' and atmid like 'test%'  "); 
                                                $servsql = mysqli_query($con,"SELECT * FROM `mis_details` where mis_id in (select id from mis) and engineer = '".$eng_id."'  ");
                                                if(mysqli_num_rows($servsql)>0) {
                                                    while($servsql_res = mysqli_fetch_assoc($servsql)) {
                                                        $misid = $servsql_res['id'];
                                                        // echo $misid."<br>";
                                                        
                                                        $historysql = mysqli_query($con,"select * from mis_history where mis_id = '".$misid."' and cast(schedule_date as date) = '".$date."' ");
                                                        if(mysqli_num_rows($historysql)>0){
                                                            $historysql_res = mysqli_fetch_assoc($historysql);
                                                            $his_id = $historysql_res['mis_id'];
                                                            $type = $historysql_res['type'];
                                                            
                                                            // echo $his_id."<br>";
                                                            // echo $type."<br>";
                                                            
                                                            if($type == "schedule" ){
                                                                // echo 1;
                                                                $detailsql = mysqli_query($con,"select * from mis_details where id = '".$his_id."' ");
                                                                while($detailsql_result = mysqli_fetch_assoc($detailsql)){
                                                                     
                                                                     $did = $detailsql_result['id'];
                                                                    $status = $detailsql_result['status'];
                                                                    if($status = 'close'){
                                                                        $servicecount = $servicecount + 1;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        
                                                    }
                                                }
    
                                        ?>
                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $eng_name; ?></td>
                                                    <td align="center">
                                                        <a href="eng_details.php?id=<? echo $eng_id; ?>&status=<? echo "Online";?>&date=<? echo $date;?>" target="_blank">
                                                            <? if ($oncount > 0) {
                                                                echo $oncount;
                                                            } ?>
                                                        </a>
                                                    </td>
                                                    <td align="center">
                                                        <a href="eng_details.php?id=<? echo $eng_id; ?>&status=<? echo "Offline";?>&date=<? echo $date;?>" target="_blank">
                                                            <? if ($offcount > 0) {
                                                                echo $offcount;
                                                            } ?>
                                                        </a>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                        if($offcount!='' && $oncount!=''){
                                                           $totalcount = $offcount + $oncount;
                                                           $calc = ($oncount/$totalcount)*100;
                                                           echo number_format((float)$calc, 2, '.', '')." %";
                                                        }else { echo "";} 
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <a href="footage_bulk_details.php?fid=<? echo $footage_id; ?>" target="_blank">
                                                            <? if ($footagecount > 0) {
                                                                echo $footagecount;
                                                            } ?>
                                                        </a>
                                                    </td>
                                                    <!--<td><? if($servicecount>0) { echo $servicecount; } ?></td>-->
                                                    
                                                    <td align="center">
                                                         <a href="servicecall_details.php?id=<? echo $eng_id; ?>&did=<? echo $did;?>" target="_blank">
                                                            <? if($servicecount>0) { echo $servicecount; } ?>
                                                         </a>
                                                    </td>
                                                </tr>
                                        <? $i++;
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <? } ?>
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



</body>

</html>