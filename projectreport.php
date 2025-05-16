<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <? include('config.php'); 

// function get_member_name($id){
//     global $con;
    
//     $sql = mysqli_query($con,"select * from mis_loginusers where id ='".$id."'");
//     $sql_result = mysqli_fetch_assoc($sql);
    
//     return $sql_result['name'];
// }


$project_schedule_today_sql = mysqli_query($con,"SELECT count(1) as today_schedule FROM `mis_details` where status='open' and DATE(`created_at`) = CURDATE() and call_type='Service'");
$project_schedule_today_sql_result= mysqli_fetch_assoc($project_schedule_today_sql);
$project_today_schedule = $project_schedule_today_sql_result['today_schedule'];

$project_schedule_all_sql = mysqli_query($con,"SELECT count(1) as all_schedule FROM `mis_details` where status='open' and call_type='Project'");
$project_schedule_all_sql_result = mysqli_fetch_assoc($project_schedule_all_sql);
$project_all_schedule = $project_schedule_all_sql_result['all_schedule'];


$service_schedule_today_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where DATE(`created_at`) = CURDATE() and call_type='Service'");
$service_schedule_today_sql_result= mysqli_fetch_assoc($service_schedule_today_sql);
$service_today_schedule = $service_schedule_today_sql_result['today_schedule'];


$service_schedule_all_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where call_type='Service'");
$service_schedule_all_sql_result= mysqli_fetch_assoc($service_schedule_all_sql);
$service_all_schedule = $service_schedule_all_sql_result['today_schedule'];



$footage_schedule_today_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where DATE(`created_at`) = CURDATE() and call_type='Footage'");
$footage_schedule_today_sql_result= mysqli_fetch_assoc($footage_schedule_today_sql);
$footage_today_schedule = $footage_schedule_today_sql_result['today_schedule'];


$footage_schedule_all_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where call_type='Footage'");
$footage_schedule_all_sql_result= mysqli_fetch_assoc($footage_schedule_all_sql);
$footage_all_schedule = $footage_schedule_all_sql_result['today_schedule'];


$other_schedule_today_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where DATE(`created_at`) = CURDATE() and call_type='Other'");
$other_schedule_today_sql_result= mysqli_fetch_assoc($other_schedule_today_sql);
$other_today_schedule = $other_schedule_today_sql_result['today_schedule'];


$other_schedule_all_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where call_type='Other'");
$other_schedule_all_sql_result= mysqli_fetch_assoc($other_schedule_all_sql);
$other_all_schedule = $other_schedule_all_sql_result['today_schedule'];



$open_project_sql = mysqli_query($con,"select count(1) as open_project_count from mis_details where status='Open' and call_type='Project'"); 
$open_project_sql_result = mysqli_fetch_assoc($open_project_sql);
$open_project_count = $open_project_sql_result['open_project_count'];

$open_service_sql = mysqli_query($con,"select count(1) as open_service_count from mis_details where status='Open' and call_type='Service'"); 
$open_service_sql_result = mysqli_fetch_assoc($open_service_sql);
$open_service_count = $open_service_sql_result['open_service_count'];

$open_footage_sql = mysqli_query($con,"select count(1) as open_footage_count from mis_details where status='Open' and call_type='Footage'"); 
$open_footage_sql_result = mysqli_fetch_assoc($open_footage_sql);
$open_footage_count = $open_footage_sql_result['open_footage_count'];


$open_other_sql = mysqli_query($con,"select count(1) as open_other_count from mis_details where status='Open' and call_type='Other'"); 
$open_other_sql_result = mysqli_fetch_assoc($open_other_sql);
$open_other_count = $open_other_sql_result['open_other_count'];



?>

<table border="1" class="table">
    <tr>
        <th>Current Status</th>
        <th>Project</th>
        <th>Service</th>
        <th>Footage</th>
        <th>Other</th>
    </tr>
    <tr>
        <td>Schedule Today</td>
        <td><a href="projectreportdetail.php?status=schedule_today&type=Project"> <? echo $project_today_schedule; ?> </a></td>
        <td><a href="projectreportdetail.php?status=schedule_today&type=Service"><? echo $service_today_schedule; ?></a></td>
        <td><a href="projectreportdetail.php?status=schedule_today&type=Footage"><? echo $footage_today_schedule; ?></a></td>
        <td><a href="projectreportdetail.php?status=schedule_today&type=Other"><? echo $other_today_schedule; ?> </a> </td>
    </tr>
    <tr>
        <td>All Schedule</td>
        <td><a href="projectreportdetail.php?status=all&type=Project"><? echo $project_all_schedule ; ?></a></td>
        <td><a href="projectreportdetail.php?status=all&type=Service"><? echo $service_all_schedule; ?></a></td>
        <td><a href="projectreportdetail.php?status=all&type=Footage"><? echo $footage_all_schedule; ?></a></td>
        <td><a href="projectreportdetail.php?status=all&type=Other"><? echo $other_all_schedule; ?></a></td>
    </tr>
    <tr>
        <td>Open</td>
        <td><? echo $open_project_count; ?></td>
        <td><? echo $open_service_count; ?></td>
        <td><? echo $open_footage_count ; ?></td>
        <td><? echo $open_other_count; ?></td>
    </tr>
    <tr>
        <td>Material</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>



<br/>
<br/><br/>

<table class="table table-bordered table-striped" id="data_table" style="width:100%;">
    <thead>
        <tr>
            <th>Sr No</th>
            <th>Name</th>
            <th>Total Sites</th>
            <th>Done</th>
            <th>Percentage</th>
            <th>Result</th>
        </tr>    
    </thead>
    <tbody>
        
    
    <? $count = 1 ; 
    $sql = mysqli_query($con,"SELECT engineer_user_id,count(1) as total_sites FROM `mis_newsite` where engineer_user_id >0 group by engineer_user_id");
    while($sql_result = mysqli_fetch_assoc($sql)){ 
    $engineer_user_id = $sql_result['engineer_user_id'];
    $total_sites = $sql_result['total_sites']; 
    
    // echo "select count(1) as all from mis_details where engineer='".$engineer_user_id."' and DATE(created_at) = CURDATE()";
    
    $rec_sql = mysqli_query($con,"select count(1) as all_count from mis_details where engineer='".$engineer_user_id."' and DATE(created_at) = CURDATE()");
    $rec_sql_result = mysqli_fetch_assoc($rec_sql);
    $total_count_all = $rec_sql_result['all_count'];
    
    $rec_sql1 = mysqli_query($con,"select count(1) as close from mis_details where engineer='".$engineer_user_id."' and DATE(created_at) = CURDATE() and status='close'");
    $rec_sql1_result = mysqli_fetch_assoc($rec_sql1);
    $total_count_close = $rec_sql1_result['close'];
    
    if($total_count_close>0 && $total_count_all>0 ){
        $total_percentage_done = ($total_count_close/$total_count_all)*100;
        if($total_percentage_done>80){
            $presence = 'Present';
        }else{
            $presence = 'Absent';
        }
    }else{
        $total_percentage_done = '0';
        $presence = 'Absent';
    }

    
    ?>
    
        <tr <? if($total_count_all>0){ ?> style="background:gray;" <? } ?>>
            <td><? echo $count; ?></td>
            <td><? echo get_member_name($engineer_user_id)  ; ?></td>
            <td><? echo $total_count_all ; ?></td>
            <td><? echo $total_count_close ; ?></td>
            <td><? echo $total_percentage_done . '%'; ?></td>
            <td><? echo $presence; ?></td>
        </tr>
    <? $count++ ; 
    }
    ?>
        
</tbody>
</table>

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