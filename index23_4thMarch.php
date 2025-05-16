<? session_start();

if($_SESSION['username']){ 

include('header.php');


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
               
?>

        <script src="https://code.highcharts.com/highcharts.js"></script>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                
                                
                                
                                
                                
                               


                                
                                <form>
                                    <?php $oncount = 0;
                                          $offcount = 0; $nvrcount = 0;
                                        $sql = mysqli_query($con,"SELECT id from mis_loginusers where  designation = 4 and user_status=1 ");
                                         $counteng = mysqli_num_rows($sql);
                                        if(mysqli_num_rows($sql)>0 ){
                                        while($res = mysqli_fetch_assoc($sql)){
                                            $eng_id = $res['id'];
                                            
                                             
                                            $statement = "select user_id,location,created_time from eng_locations where user_id='".$eng_id."' order by id desc limit 1";
                                             
                                            $sqle = mysqli_query($con,$statement);
                                            // $fetchrow = mysqli_fetch_row($sqle);
                                            // if($eng_id==277){
                                            //     echo mysqli_num_rows($sqle);
                                            // }
                                            if(mysqli_num_rows($sqle)>0 ){
                                                $engnamesql_res = mysqli_fetch_assoc($sqle);
                                                
                                                $eng_user_id = $engnamesql_res['user_id'];
                                                $location = $engnamesql_res['location'];
                                                
                                                $created_time = $engnamesql_res['created_time'];
                                                $created_date = date("Y-m-d", strtotime($created_time)); 
                                                
                                                $datetime = date("Y-m-d H:i:s");
                                                $date = date("Y-m-d");
                                                $start_date = new DateTime($datetime);  
                                                
                                                $since_start = $start_date->diff(new DateTime($created_time));
                                               
                                                $hr = $since_start->h;
                                                // echo 'Created Time : '. $created_time."<br>";
                                                // echo 'created_date' .$created_date."<br>";
                                                // echo $datetime."<br>"; die;
                                                
                                                if($date == $created_date) {
                                                    if($hr<=1)
                                                    {
                                                       $oncount =$oncount+1;
                                                       
                                                    }
                                                    else if($hr > 1){
                                                       $offcount = $offcount+1;
                                                    }
                                                }else{
                                                    $offcount = $offcount+1;
                                                }
                                            }else {
                                               $nvrcount = $nvrcount+1;
                                                
                                                
                                            }
                                        } 
                                    
                                    ?>

                                    <div class="row">
                                        
                                        
                                         <div class="col-xl-3 col-md-6">
                                            <div class="card" style="background:linear-gradient(to right,#fe9365,#feb798); color: white;">
                                            <div class="card-block">
                                            <div class="row align-items-center">
                                            <div class="col-8">
                                            <h4 class="f-w-600" style="color:white;"><?= $counteng; ?></h4>
                                            <h6 class="m-b-0" style="color:white;">Total Engineer</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                            <i class="feather icon-bar-chart f-28"></i>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                        </div>


                                        
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card" style="background:linear-gradient(to right,#0ac282,#0df3a3);color: white;">
                                            <div class="card-block">
                                            <div class="row align-items-center">
                                            <div class="col-8">
                                            <a href="total_status.php?status=<?php echo "online";?>" target="_blank"><h4 class="f-w-600" style="color:white;"><? echo $oncount; ?> </h4></a>
                                            <h6 class="m-b-0" style="color:white;">Total Online</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                            <i class="feather icon-file-text f-28"></i>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                        
                                        
                                                                                
                                                                                
                                        <div class="col-xl-3 col-md-6">
                                        <div class="card" style="background:linear-gradient(to right,#fe5d70,#fe909d);color: white;">
                                        <div class="card-block">
                                        <div class="row align-items-center">
                                        <div class="col-8">
                                         <a href="total_status.php?status=<?php echo "offline";?>" target="_blank"><h4 class="f-w-600" style="color:white;"><? echo $offcount; ?></h4></a> 
                                        <h6 class=" m-b-0" style="color:white;">Total Offline</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                        <i class="feather icon-calendar f-28"></i>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-xl-3 col-md-6">
                                        <div class="card" style="
    background: linear-gradient(to right,#01a9ac,#01dbdf);
    color: white;
">
                                        <div class="card-block">
                                        <div class="row align-items-center">
                                        <div class="col-8">
                                        <a href="total_status.php?status=<?php echo "neverused";?>" target="_blank"><h4 class="f-w-600" style="color:white;"><? echo $nvrcount; ?></h4></a> 
                                        <h6 class="m-b-0" style="color:white;">Never Used</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                        <i class="feather icon-download f-28"></i>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                              
                                    </div>
                                    <? } ?>
                                </form>
                                <!--Filter End -->

                                
                                
                                
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        <div id="container" style="width:100%; height:400px;"></div>
    
    <ul style="display:flex;justify-content: center; ">
        
                                 
<?php
    $start = 0;
    $end = 240;
    $interval = 24;
    
    for ($i = $start; $i < $end; $i += $interval) {
        $rangeStart = $i;
        $rangeEnd = $i + $interval ;
        $series = "$rangeStart-$rangeEnd";
        
        ?>
        
        <li style="margin:5px;">
                <a style="color: red; font-weight: 600;" href="?to=<? echo $rangeStart ; ?>&&from=<? echo $rangeEnd; ?>">
                    <? echo $series ; ?>
                </a>
            
        </li>
        <?
        
        
    }
?>
    </ul>   
<? 
                                        
                                        
if(isset($_REQUEST['to']) && isset($_REQUEST['from'])){
    $to = $_REQUEST['to'];
    $from = $_REQUEST['from'];
}else{
    $to = 0 ;
    $from = 24 ; 
}

            
$mis_sql =  mysqli_query($con,"SELECT created_by, (SELECT CONCAT(name) from mis_loginusers WHERE id= a.created_by) AS eng_name, count(1) as mymisrecord FROM `mis_history` a WHERE

created_at >= DATE_SUB(NOW(), INTERVAL $from HOUR)
AND created_at < DATE_SUB(NOW(), INTERVAL $to HOUR)

and created_by is not null  
            group by created_by");
            $eng = '' ; 
            $mymisrecordcount = '';
while($mis_sql_result = mysqli_fetch_assoc($mis_sql)){
    $eng_name =  $mis_sql_result['eng_name'];
    $mymisrecord = $mis_sql_result['mymisrecord'];
    $eng .= "'$eng_name',";
    $mymisrecordcount .= $mymisrecord . ',';
    
}

$mymisrecordcount = rtrim($mymisrecordcount, ",");
$eng = rtrim($eng, ",");


?>                  
            
            
            
                                    </div>
                                </div>
                                
                                
                                
                                
                                
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
                                                        
                                                        $total_east = $open_east_amt + $mip_east_amt + $mr_east_amt + $mdis_east_amt + $pr_east_amt + $sch_east_amt + $md_east_amt ;
                                                        // $close_east_amt;
                                                        $total_west = $open_west_amt + $mip_west_amt + $mr_west_amt + $mdis_west_amt + $pr_west_amt + $sch_west_amt + $md_west_amt ;
                                                        // $close_west_amt;
                                                        $total_south = $open_south_amt + $mip_south_amt + $mr_south_amt + $mdis_south_amt + $pr_south_amt + $sch_south_amt + $md_south_amt ;
                                                        // $close_south_amt;
                                                        $total_north = $open_north_amt + $mip_north_amt + $mr_north_amt + $mdis_north_amt + $pr_north_amt + $sch_north_amt + $md_north_amt ;
                                                        // $close_north_amt;
                                                        $total_grand_total = $open_grand_total + $mip_grand_total + $mr_grand_total + $mdis_grand_total + $pr_grand_total + $sch_grand_total + $md_grand_total ;
                                                        // $close_grand_total;
                                                        
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
                                                      <!--<tr>-->
                                                      <!--    <td>8</td>-->
                                                      <!--    <td>Close</td>-->
                                                      <!--    <td><? if($close_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "east";?>"><?= $close_east_amt; }else{?><?=$close_east_amt; }?></a></td>-->
                                                      <!--    <td><? if($close_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "north";?>"><?= $close_north_amt; }else{?><?=$close_north_amt; }?></a></td>-->
                                                      <!--    <td><? if($close_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "south";?>"><?= $close_south_amt; }else{?><?=$close_south_amt; }?></a></td>-->
                                                      <!--    <td><? if($close_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&zone=<? echo "west";?>"><?= $close_west_amt; }else{?><?=$close_west_amt; }?></a></td>-->
                                                      <!--    <td><?= $close_grand_total?></td>-->
                                                      <!--</tr>-->
                                                       <tr>
                                                          <td>8</td> 
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
</div>
</div>
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              
                  
                  
        <script>
        
        document.addEventListener('DOMContentLoaded', function () {
        const chart = Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Last <? echo $to; ?> - <? echo $from ;?> Hours On MIS'
            },
            xAxis: {
                categories: [<? echo $eng; ?>]
            },
            yAxis: {
                title: {
                    text: 'Count'
                }
            },
            series: [{
                name: '',
                data: [<? echo $mymisrecordcount; ?>]
            }]
        });
    });
    
        </script>
    
    
      
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>
</body>

</html>