<? session_start();
include('config.php');

if($_SESSION['username']){ 
    
        function total_amount($con,$status,$zone){
            $close_east_query = mysqli_query($con,"SELECT COUNT(id) FROM `mis_details` WHERE status='".$status."' AND zone='".$zone."'");
            $close_east_query_res = mysqli_fetch_row($close_east_query); 
            $close_east_amt = $close_east_query_res[0];
            return $close_east_amt;
        }


                $user_id = $_SESSION['userid'];  
                $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
                $user_sql = mysqli_query($con,$user_statement);
                $user_rowresult = mysqli_fetch_row($user_sql);
                //echo '<pre>';print_r($user_rowresult);echo '</pre>';die;
                $_userlevel = $user_rowresult[0];
               
include('header.php');
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<style>
              a:not([href]) {
                  padding: 5px;
              }
              .btn-group{
                      border: 1px solid #cccccc;
              }
              
              
              
              ul.dropdown-menu{
                  transform: translate3d(0px, 2%, 0px) !important;
                      overflow: scroll !important;
                      max-height:250px;
              }
          label{
                  font-weight: 900;
    font-size: 16px;
          }
          </style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                            
         <style>
             .indication{
                 display:flex;
                 background:#404e67;
             }
             .indication span{
                 width:15px;
                 height:15px;
                 border:1px solid white;
                 border-radius:25px;
                 margin: 10px;
             }
             .open{
                 background:white;
             }
             .close{
                 background:#e29a9a;
             }
             .schedule{
                 background:#d09f45;
             }
   
   th.address, td.address {
    white-space: inherit;
}

         </style>
  
                               <div class="card">
                                 <div class="card-block" style=" overflow: auto;">
                                   <h4 class="card-title">
                                    <!--<i class="fas fa-chart-pie"></i>-->
                                           
                                          </h4>
                                          
                                          <div>
                                              <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable" style="width:100%">
                                                  <thead>
                                                      <th>S.No.</th>
                                                      <th>Current Status</th>
                                                      <th>EAST</th>
                                                      <th>NORTH</th>
                                                      <th>SOUTH</th>
                                                      <th>WEST</th>
                                                      <th>GRAND TOTAL</th>
                                                  </thead>
                                                  <tbody>
                                                      <?php
                                                      
                                                        $close_east_amt = total_amount($con,'close','east');
                                                        $close_west_amt = total_amount($con,'close','west');
                                                        $close_north_amt = total_amount($con,'close','north');
                                                        $close_south_amt = total_amount($con,'close','south');
                                                        
                                                        $md_east_amt = total_amount($con,'material_delivered','east');
                                                        $md_west_amt = total_amount($con,'material_delivered','west');
                                                        $md_north_amt = total_amount($con,'material_delivered','north');
                                                        $md_south_amt = total_amount($con,'material_delivered','south');
                                                        
                                                        $mdis_east_amt = total_amount($con,'material_dispatch','east');
                                                        $mdis_west_amt = total_amount($con,'material_dispatch','west');
                                                        $mdis_north_amt = total_amount($con,'material_dispatch','north');
                                                        $mdis_south_amt = total_amount($con,'material_dispatch','south');
                                                        
                                                        $mip_east_amt = total_amount($con,'material_in_process','east');
                                                        $mip_west_amt = total_amount($con,'material_in_process','west');
                                                        $mip_north_amt = total_amount($con,'material_in_process','north');
                                                        $mip_south_amt = total_amount($con,'material_in_process','south');
                                                        
                                                        $mr_east_amt = total_amount($con,'material_requirement','east');
                                                        $mr_west_amt = total_amount($con,'material_requirement','west');
                                                        $mr_north_amt = total_amount($con,'material_requirement','north');
                                                        $mr_south_amt = total_amount($con,'material_requirement','south');
                                                        
                                                        $open_east_amt = total_amount($con,'open','east');
                                                        $open_west_amt = total_amount($con,'open','west');
                                                        $open_north_amt = total_amount($con,'open','north');
                                                        $open_south_amt = total_amount($con,'open','south');
                                                        
                                                        $pr_east_amt = total_amount($con,'permission_require','east');
                                                        $pr_west_amt = total_amount($con,'permission_require','west');
                                                        $pr_north_amt = total_amount($con,'permission_require','north');
                                                        $pr_south_amt = total_amount($con,'permission_require','south');
                                                        
                                                        $sch_east_amt = total_amount($con,'schedule','east');
                                                        $sch_west_amt = total_amount($con,'schedule','west');
                                                        $sch_north_amt = total_amount($con,'schedule','north');
                                                        $sch_south_amt = total_amount($con,'schedule','south');
                                                        
                                                        $open_grand_total = $open_east_amt + $open_north_amt + $open_south_amt + $open_west_amt; 
                                                        $mip_grand_total = $mip_east_amt + $mip_north_amt + $mip_south_amt + $mip_west_amt; 
                                                        $mr_grand_total = $mr_east_amt + $mr_north_amt + $mr_south_amt + $mr_west_amt; 
                                                        $mdis_grand_total = $mdis_east_amt + $mdis_north_amt + $mdis_south_amt + $mdis_west_amt;
                                                        
                                                        $pr_grand_total = $pr_east_amt + $pr_north_amt + $pr_south_amt + $pr_west_amt; 
                                                        $sch_grand_total = $sch_east_amt + $sch_north_amt + $sch_south_amt + $sch_west_amt; 
                                                        $md_grand_total = $md_east_amt + $md_north_amt + $md_south_amt + $md_west_amt; 
                                                        $close_grand_total = $close_east_amt + $close_north_amt + $close_south_amt + $close_west_amt; 
                                                        
                                                        $total_east = $open_east_amt + $mip_east_amt + $mr_east_amt + $mdis_east_amt + $pr_east_amt + $sch_east_amt + $md_east_amt + $close_east_amt;
                                                        $total_west = $open_west_amt + $mip_west_amt + $mr_west_amt + $mdis_west_amt + $pr_west_amt + $sch_west_amt + $md_west_amt + $close_west_amt;
                                                        $total_south = $open_south_amt + $mip_south_amt + $mr_south_amt + $mdis_south_amt + $pr_south_amt + $sch_south_amt + $md_south_amt + $close_south_amt;
                                                        $total_north = $open_north_amt + $mip_north_amt + $mr_north_amt + $mdis_north_amt + $pr_north_amt + $sch_north_amt + $md_north_amt + $close_north_amt;
                                                        $total_grand_total = $open_grand_total + $mip_grand_total + $mr_grand_total + $mdis_grand_total + $pr_grand_total + $sch_grand_total + $md_grand_total + $close_grand_total;
                                                        
                                                      ?>
                                                      <tr>
                                                          <td>1</td>
                                                          <td>OPEN</td>
                                                          <td><? if($open_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&zone=<? echo "east";?>"><?= $open_east_amt; }else{?><?=$open_east_amt; }?></a></td>
                                                          <td><? if($open_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&zone=<? echo "north";?>"><?= $open_north_amt; }else{?><?=$open_north_amt; }?></a></td>
                                                          <td><? if($open_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&zone=<? echo "south";?>"><?= $open_south_amt; }else{?><?=$open_south_amt; }?></a></td>
                                                          <td><? if($open_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&zone=<? echo "west";?>"><?= $open_west_amt; }else{?><?=$open_west_amt; }?></a></td>
                                                          <td><?= $open_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>2</td>
                                                          <td>Material In Process</td>
                                                          <td><? if($mip_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&zone=<? echo "east";?>"><?= $mip_east_amt; }else{?><?=$mip_east_amt; }?></a></td>
                                                          <td><? if($mip_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&zone=<? echo "north";?>"><?= $mip_north_amt; }else{?><?=$mip_north_amt; }?></a></td>
                                                          <td><? if($mip_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&zone=<? echo "south";?>"><?= $mip_south_amt; }else{?><?=$mip_south_amt; }?></a></td>
                                                          <td><? if($mip_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&zone=<? echo "west";?>"><?= $mip_west_amt; }else{?><?=$mip_west_amt; }?></a></td>
                                                          <td><?= $mip_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>3</td>
                                                          <td>Material Requirement</td>
                                                          <td><? if($mr_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&zone=<? echo "east";?>"><?= $mr_east_amt; }else{?><?=$mr_east_amt; }?></a></td>
                                                          <td><? if($mr_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&zone=<? echo "north";?>"><?= $mr_north_amt; }else{?><?=$mr_north_amt; }?></a></td>
                                                          <td><? if($mr_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&zone=<? echo "south";?>"><?= $mr_south_amt; }else{?><?=$mr_south_amt; }?></a></td>
                                                          <td><? if($mr_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&zone=<? echo "west";?>"><?= $mr_west_amt; }else{?><?=$mr_west_amt; }?></a></td>
                                                          <td><?= $mr_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>4</td>
                                                          <td>Material Dispatch</td>
                                                          <td><? if($mdis_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&zone=<? echo "east";?>"><?= $mdis_east_amt; }else{?><?=$mdis_east_amt; }?></a></td>
                                                          <td><? if($mdis_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&zone=<? echo "north";?>"><?= $mdis_north_amt; }else{?><?=$mdis_north_amt; }?></a></td>
                                                          <td><? if($mdis_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&zone=<? echo "south";?>"><?= $mdis_south_amt; }else{?><?=$mdis_south_amt; }?></a></td>
                                                          <td><? if($mdis_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&zone=<? echo "west";?>"><?= $mdis_west_amt; }else{?><?=$mdis_west_amt; }?></a></td>
                                                          <td><?= $mdis_grand_total?></td>
                                                      </tr>
                                                      
                                                       <tr>
                                                           <td>5</td>
                                                          <td>Permission Require</td>
                                                          <td><? if($pr_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&zone=<? echo "east";?>"><?= $pr_east_amt; }else{?><?=$pr_east_amt; }?></a></td>
                                                          <td><? if($pr_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&zone=<? echo "north";?>"><?= $pr_north_amt; }else{?><?=$pr_north_amt; }?></a></td>
                                                          <td><? if($pr_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&zone=<? echo "south";?>"><?= $pr_south_amt; }else{?><?=$pr_south_amt; }?></a></td>
                                                          <td><? if($pr_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&zone=<? echo "west";?>"><?= $pr_west_amt; }else{?><?=$pr_west_amt; }?></a></td>
                                                          <td><?= $pr_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>6</td>
                                                          <td>Schedule</td>
                                                          <td><? if($sch_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&zone=<? echo "east";?>"><?= $sch_east_amt; }else{?><?=$sch_east_amt; }?></a></td>
                                                          <td><? if($sch_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&zone=<? echo "north";?>"><?= $sch_north_amt; }else{?><?=$sch_north_amt; }?></a></td>
                                                          <td><? if($sch_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&zone=<? echo "south";?>"><?= $sch_south_amt; }else{?><?=$sch_south_amt; }?></a></td>
                                                          <td><? if($sch_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&zone=<? echo "west";?>"><?= $sch_west_amt; }else{?><?=$sch_west_amt; }?></a></td>
                                                          <td><?= $sch_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>7</td>
                                                          <td>Material Delivered</td>
                                                          <td><? if($md_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&zone=<? echo "east";?>"><?= $md_east_amt; }else{?><?=$md_east_amt; }?></a></td>
                                                          <td><? if($md_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&zone=<? echo "north";?>"><?= $md_north_amt; }else{?><?=$md_north_amt; }?></a></td>
                                                          <td><? if($md_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&zone=<? echo "south";?>"><?= $md_south_amt; }else{?><?=$md_south_amt; }?></a></td>
                                                          <td><? if($md_west_amt!=0) {?><a href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&zone=<? echo "west";?>"><?= $md_west_amt; }else{?><?=$md_west_amt; }?></a></td>
                                                          <td><?= $md_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>8</td>
                                                          <td>Close</td>
                                                          <td><? if($close_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "east";?>"><?= $close_east_amt; }else{?><?=$close_east_amt; }?></a></td>
                                                          <td><? if($close_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "north";?>"><?= $close_north_amt; }else{?><?=$close_north_amt; }?></a></td>
                                                          <td><? if($close_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "south";?>"><?= $close_south_amt; }else{?><?=$close_south_amt; }?></a></td>
                                                          <td><? if($close_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "west";?>"><?= $close_west_amt; }else{?><?=$close_west_amt; }?></a></td>
                                                          <td><?= $close_grand_total?></td>
                                                      </tr>
                                                       <tr>
                                                          <td>9</td> 
                                                          <td>Grand Total</td>
                                                          <td><?= $total_east?></td>
                                                          <td><?= $total_north?></td>
                                                          <td><?= $total_south?></td>
                                                          <td><?= $total_west?></td>
                                                          <td><?= $total_grand_total?></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
               
               <br />               <br />               <br />
               
               
               <?
$project_schedule_today_sql = mysqli_query($con,"SELECT count(1) as today_schedule FROM `mis_details` where status='open' and DATE(`created_at`) = CURDATE() and call_type='Project' group by atmid");
$project_schedule_today_sql_result= mysqli_fetch_assoc($project_schedule_today_sql);
$project_today_schedule = $project_schedule_today_sql_result['today_schedule'];

$project_schedule_all_sql = mysqli_query($con,"SELECT count(1) as all_schedule FROM `mis_details` where status='open' and call_type='Project' group by atmid");
$project_schedule_all_sql_result = mysqli_fetch_assoc($project_schedule_all_sql);
$project_all_schedule = $project_schedule_all_sql_result['all_schedule'];


$service_schedule_today_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where DATE(`created_at`) = CURDATE() and call_type='Service' group by atmid");
$service_schedule_today_sql_result= mysqli_fetch_assoc($service_schedule_today_sql);
$service_today_schedule = $service_schedule_today_sql_result['today_schedule'];


$service_schedule_all_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where call_type='Service' group by atmid");
$service_schedule_all_sql_result= mysqli_fetch_assoc($service_schedule_all_sql);
$service_all_schedule = $service_schedule_all_sql_result['today_schedule'];



$footage_schedule_today_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where DATE(`created_at`) = CURDATE() and call_type='Footage' group by atmid");
$footage_schedule_today_sql_result= mysqli_fetch_assoc($footage_schedule_today_sql);
$footage_today_schedule = $footage_schedule_today_sql_result['today_schedule'];


$footage_schedule_all_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where call_type='Footage' group by atmid");
$footage_schedule_all_sql_result= mysqli_fetch_assoc($footage_schedule_all_sql);
$footage_all_schedule = $footage_schedule_all_sql_result['today_schedule'];


$other_schedule_today_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where DATE(`created_at`) = CURDATE() and call_type='Other' group by atmid");
$other_schedule_today_sql_result= mysqli_fetch_assoc($other_schedule_today_sql);
$other_today_schedule = $other_schedule_today_sql_result['today_schedule'];


$other_schedule_all_sql = mysqli_query($con,"select count(1) as today_schedule from mis_details where call_type='Other' group by atmid");
$other_schedule_all_sql_result= mysqli_fetch_assoc($other_schedule_all_sql);
$other_all_schedule = $other_schedule_all_sql_result['today_schedule'];



$open_project_sql = mysqli_query($con,"select count(1) as open_project_count from mis_details where status='Open' and call_type='Project' group by atmid"); 
$open_project_sql_result = mysqli_fetch_assoc($open_project_sql);
$open_project_count = $open_project_sql_result['open_project_count'];

$open_service_sql = mysqli_query($con,"select count(1) as open_service_count from mis_details where status='Open' and call_type='Service' group by atmid"); 
$open_service_sql_result = mysqli_fetch_assoc($open_service_sql);
$open_service_count = $open_service_sql_result['open_service_count'];

$open_footage_sql = mysqli_query($con,"select count(1) as open_footage_count from mis_details where status='Open' and call_type='Footage' group by atmid"); 
$open_footage_sql_result = mysqli_fetch_assoc($open_footage_sql);
$open_footage_count = $open_footage_sql_result['open_footage_count'];


$open_other_sql = mysqli_query($con,"select count(1) as open_other_count from mis_details where status='Open' and call_type='Other' group by atmid"); 
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
               <br />               <br />
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>


<div id="donutChart" style="width: 100%; height: 400px;"></div>


                    
                    
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
    Highcharts.chart('donutChart', {
        chart: {
            type: 'pie',
        },
        title: {
            text: 'Status Distribution'
        },
        plotOptions: {
            pie: {
                innerSize: '50%', // Create a donut chart
                dataLabels: {
                    enabled: false
                }
            }
        },
        series: [{
            name: 'Status',
            data: [
                {
                    name: 'OPEN',
                    y: <?=$open_grand_total?>,
                    sliced: true,
                    selected: true
                },
                {
                    name: 'Material In Process',
                    y: <?=$mip_grand_total?>
                },
                {
                    name: 'Material Requirement',
                    y: <?=$mr_grand_total?>
                },
                {
                    name: 'Material Dispatch',
                    y: <?=$mdis_grand_total?>
                },
                {
                    name: 'Permission Require',
                    y: <?=$pr_grand_total?>
                },
                {
                    name: 'Schedule',
                    y: <?=$sch_grand_total?>
                },
                {
                    name: 'Material Delivered',
                    y: <?=$md_grand_total?>
                },
               
            ]
        }]
    });
});

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'process_rnmfund_action.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_");
            var textmsg = "Approval Done";
            if(res[1]==0){
                textmsg = "Rejected Done";
            }
            $('#approve_'+res[0]).prop('href','#');
            $('#approve_'+res[0]).html(textmsg);
            
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
            }
          });

        });

$(document).on("click", ".open-AddBookDialog", function () {
     var reqId = $(this).data('id');
     var req_amt = $(this).data('req_amt');
     var reqStatus = $(this).data('status');
     $(".modal-body #reqId").val( reqId );
     $(".modal-body #req_amt").val( req_amt );
     $(".modal-body #approved_amt").prop('max',req_amt );
     $(".modal-body #reqStatus").val( reqStatus );
});
$(document).on("click", ".open-DetailDialog", function () {
     var reqId = $(this).data('id');
     var reqStatus = $(this).data('status');
     $.ajax({    //create an ajax request to display.php
        type: "GET",
        url: "show_fund_details.php?req_id="+reqId,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $(".modal-body #result_status").html(response); 
            //alert(response);
        }
     });
    // $(".modal-body #result_status").val( reqStatus );
});
function selectAction(val){
    if(val==0){
        $("#approved_amt").prop('required',false);
        $("#approved_amt").prop('readonly',true);
        $("#remarks").prop('required',true);
        $("#approved_amt").prop('min',0);
    }else{
        $("#approved_amt").prop('required',true);
        $("#approved_amt").prop('readonly',false);
        $("#remarks").prop('required',false);
        $("#approved_amt").prop('min',1);
    }
}



    	$(document).ready(function() {
              $('#multiselect').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                $('#multiselect_bm').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                  $('#multiselect_status').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                $('#multiselect_zone').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
              
              
        });
                
    
        $("#show_filter").css('display','none');
    
        $("#hide_filter").on('click',function(){
           $("#filter").css('display','none');
           $("#show_filter").css('display','block');
        });
        $("#show_filter").on('click',function(){
          $("#filter").css('display','block');
           $("#show_filter").css('display','none');
        });
        
</script>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>
</body>
</html>