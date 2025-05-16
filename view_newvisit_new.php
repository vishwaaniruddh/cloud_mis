<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');


?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


<style>
    
/*   th.address, td.address {*/
/*    white-space: inherit;*/
/*}*/
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
     <input type="text" name="atmid" class="form-control" value="<? echo $_REQUEST['atmid']; ?>">     
 </div>

 
 
 
 
 
 
 <div class="col-md-3">
     <label>From Visit Date</label>
     <input type="date" name="fromdt" class="form-control" value="<? if($_REQUEST['fromdt']){ echo  $_REQUEST['fromdt']; }else{ echo '2022-12-12' ; } ?>">    
 </div>
 
 <div class="col-md-3">
     <label>To Visit Date</label>
     <input type="date" name="todt" class="form-control" value="<? if($_REQUEST['todt']){ echo  $_REQUEST['todt']; }else{ echo date('Y-m-d') ; } ?>">    
 </div>
  
 
 
 
 </div>
 
  <div class="col" style="display:flex;justify-content:center;">
     <input type="submit" name="submit" value="Filter" class="btn btn-primary">
 </div>


</form>

<style>
    html{
        text-transform: inherit !important;
    }
</style>
    
    <!--Filter End -->
    <hr>
          
      </div>
    </div>
    
    
    
    <? if($_REQUEST['submit'] || isset($_GET['page']) ){
        $activity = $_REQUEST['activity'];
        $statement = "select a.id as ID,a.created_at as Created_AT,a.* from mis_newvisit a inner join mis_newsite b on a.atmid=b.atmid where
        b.activity in('RMS','Cloud')";
        
        $sqlappCount = "select count(1) as total from mis_newvisit a inner join mis_newsite b on a.atmid=b.atmid where
        b.activity in('RMS','Cloud')";
     
     
     // Query to get the total number of records

    if(isset($_REQUEST['atmid']) && $_REQUEST['atmid']!=''){
                 $statement .= " and a.atmid like '%".$_REQUEST['atmid']."%'";
                 $sqlappCount.= " and a.atmid like '%".$_REQUEST['atmid']."%'";
             }
             
             
      if(isset($_REQUEST['fromdt']) && $_REQUEST['fromdt']!='' && isset($_REQUEST['todt']) && $_REQUEST['todt']!='')
{

$date1 = $_REQUEST['fromdt'] ; 
$date2 = $_REQUEST['todt'] ;

$statement .=" and CAST(a.created_at AS DATE) >= '".$date1."' and CAST(a.created_at AS DATE) <= '".$date2."'";
$sqlappCount .=" and CAST(a.created_at AS DATE) >= '".$date1."' and CAST(a.created_at AS DATE) <= '".$date2."'";
}


$statement.= " order by a.id desc" ; 

// echo $statement ; 


$result = mysqli_query($con, $sqlappCount);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$page_size = 10;
$offset = ($current_page - 1) * $page_size;


$total_pages = ceil($total_records / $page_size);

$window_size = 10;
$start_window = max(1, $current_page - floor($window_size / 2));
$end_window = min($start_window + $window_size - 1, $total_pages);
$sql = "$statement LIMIT $offset, $page_size";
   
    }
    


    ?>
    
    
    
    
    
                           
                           
                           
                           
                           
                           
                           
                           
                           
                           
                           
                           <? if($_REQUEST['submit'] || isset($_GET['page']) ){
                           ?>
                               
                           
                                <div class="card">
                                    <div class="card-block" style="overflow: auto;">
                                        <h3 class="center">Total Records : <? echo $total_records; ?></h3>
                                        <br>
                                        
                                        <form action="newvisitexcl_web.php" method="POST">
                                            
                                            <input type="hidden" name="statement" value="<? echo $statement; ?>">
                                            
                                            <input type="hidden" name="atmid" value="<? echo $_REQUEST['atmid']; ?>">
                                            <input type="hidden" name="date1" value="<? echo $date1; ?>">
                                            <input type="hidden" name="date2" value="<? echo $date2; ?>">
                                         <input type="submit" class="btn btn-secondary" value="Excel" target="_blank">
                                        </form>
                                        
                                        
                                        <table class="table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td>Sn No.</td>
                                                    <td>Images</td>
                                                    <td>Activity</td>
                                                    <td>ATMID</td>
                                                    <td>Bank</td>
                                                    <td>Customer</td>
                                                    <td>Zone</td>
                                                    <td>City</td>
                                                    <td>State</td>
                                                    <td>location</td>        
                                                    <td>Type</td>
                                                    <td>DVR Status</td>
                                                    <td>Camera 1</td>
                                                    <td>Camera 2</td>
                                                    <td>Camera 3</td>
                                                    <td>Camera 4</td>
                                                    <td>HDD Status / SD </td>
                                                    <td>Router Name</td>
                                                    <td>Router ID</td>
                                                    <td>Other Remark</td>
                                                    <td>IP Camera</td>
                                                    <th>SD card status</th>
                                                    <td>EML</td>
                                                    <td>Panic</td>
                                                    <td>Twoway</td>
                                                    <td>Hooter</td>
                                                    <td>Machine Sensor</td>
                                                    <td>Shutter</td>
                                                    <td>Glass Break Sensor</td>
                                                    <td>PIR</td>
                                                    <td>AC Connection</td>
                                                    <td>Relay Connection</td>
                                                    <td>Panel Battery</td>
                                                    <td>Count Panel Battery</td>
                                                    <td>Panel Name</td>
                                                    <td>Router Name</td>
                                                    <td>Router Id</td>
                                                    <td>Remark</td>
                                                    <td>Created By</td>
                                                    <td>Datetime</td>
                                                    <td>Engineer</td>
                                                    <td>Eng contact</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                          
                                          $counter = ($current_page - 1) * $page_size + 1;
                                          $sql = mysqli_query($con, $sql);
                        while($sql_result = mysqli_fetch_assoc($sql)){
                            
                        $id = $sql_result['ID'];
                        $atmid = $sql_result['atmid'];
                        $bank = $sql_result['bank'];
                        $customer = $sql_result['customer'];
                        $zone = $sql_result['zone'];
                        $city = $sql_result['city'];
                        $state = $sql_result['state'];
                        $location = $sql_result['location'];
                        
                        
                        
                        
                        
                        
                        $engineer = $sql_result['engineer'];
                        $engineer = get_eng('eng',$engineer);
                        
                        $eng_contact = $sql_result['eng_contact'];
                        $eml = $sql_result['eml'];
                        $panic = $sql_result['panic'];
                        $twoway = $sql_result['twoway'];
                        $hooder = $sql_result['hooder'];
                        $machine_sensor = $sql_result['machine_sensor'];
                        $shutter = $sql_result['shutter'];
                        $glass_break_sensor = $sql_result['glass_break_sensor'];
                        $pir = $sql_result['pir'];
                        $acCon = $sql_result['acCon'];
                        $relayCon = $sql_result['relayCon'];
                        $panel_battery = $sql_result['panel_battery'];
                        $panel_name = $sql_result['panel_name'];
                        $router_name = $sql_result['router_name'];
                        $router_id = $sql_result['router_id'];
                        $remark = $sql_result['remark'];
                        $count_panel_battery = $sql_result['count_panel_battery'];
                        $userid = get_member_name($sql_result['created_by']);
                        $datetime = $sql_result['Created_AT'];
                        
                        
                        
                        $visit_details_sql = mysqli_query($con,"select * from visitsite_details where visit_id='".$id."' order by id desc");
                        $visit_details_sql_result = mysqli_fetch_assoc($visit_details_sql);
                        
                        $type = $visit_details_sql_result['type'];
                        $status = $visit_details_sql_result['status'];
                        $cam1 = $visit_details_sql_result['cam1'];
                        $cam2 = $visit_details_sql_result['cam2'];
                        $cam3 = $visit_details_sql_result['cam3'];
                        $cam4 = $visit_details_sql_result['cam4'];
                        $hdd_status = $visit_details_sql_result['hdd_status'];
                        $router_name = $visit_details_sql_result['router_name'];
                        $routerid = $visit_details_sql_result['routerid'];
                        $other_status = $visit_details_sql_result['other_status'];
                        $ip_cam = $visit_details_sql_result['ip_cam'];
                        $sd_card_status = $visit_details_sql_result['sd_card_status'];
                        
                        ?>



                                                <tr>
                                                    <td><? echo $counter; ?></td>
                                                    <td>
                                                        <form action="view_newvisitdownload.php" method="POST">
                                                            <input type="hidden" name="id" value="<? echo $id; ?>">
                                                            <input type="submit" name="download" value="Images" class="btn btn-primary">
                                                        </form>
                                                        <a href="view_newvisitimages.php?id=<? echo $id; ?>" target="_blank">View Images</a>
                                                    </td>
                                                    <td><? echo $sql_result['activity'];?></td>
                                                    <td><? echo $atmid; ?> </td>
                                                    <td><? echo $bank; ?> </td>
                                                    <td><? echo $customer; ?> </td>
                                                    <td><? echo $zone; ?> </td>
                                                    <td><? echo $city; ?> </td>
                                                    <td><? echo $state; ?> </td>
                                                    <td class="address" >
                                                        <p><? echo $location; ?></p>
                                                    </td>
                                                    
                                                    
                                                    <td><? echo $type ; ?></td> 
                                                    <td><? echo $status ; ?></td> 
                                                    <td><? echo $cam1 ; ?></td> 
                                                    <td><? echo $cam2 ; ?></td> 
                                                    <td><? echo $cam3 ; ?></td> 
                                                    <td><? echo $cam4 ; ?></td> 
                                                    <td><? echo $hdd_status ; ?></td> 
                                                    <td><? echo $router_name ; ?></td> 
                                                    <td><? echo $routerid ; ?></td> 
                                                    <td><? echo $other_status ; ?></td> 
                                                    <td><? echo $ip_cam; ?></td>
                                                    <td><? echo $sd_card_status; ?></td>
                                                    
                                                    
                                                    

                                                    <td><? echo $eml; ?> </td>
                                                    <td><? echo $panic; ?> </td>
                                                    <td><? echo $twoway; ?> </td>
                                                    <td><? echo $hooder; ?> </td>
                                                    <td><? echo $machine_sensor; ?> </td>
                                                    <td><? echo $shutter; ?> </td>
                                                    <td><? echo $glass_break_sensor; ?> </td>
                                                    <td><? echo $pir; ?> </td>
                                                    <td><? echo $acCon; ?> </td>
                                                    <td><? echo $relayCon; ?> </td>
                                                    <td><? echo $panel_battery; ?> </td>
                                                    <td><? echo $count_panel_battery; ?> </td>
                                                    <td><? echo $panel_name; ?> </td>
                                                    <td><? echo $router_name; ?> </td>
                                                    <td><? echo $router_id; ?> </td>
                                                    <td><? echo $remark; ?> </td>
                                                    <td><? echo $userid; ?> </td>
                                                    <td><? echo $datetime; ?> </td>
                                                    <td><? echo $engineer; ?> </td>
                                                    <td><? echo $eng_contact; ?> </td>
                                                </tr>


    
<? $counter++; } ?>
                                            </tbody>
                                        </table>

                                        
                                        
                                        
                                       
                                        
                                    </div>
                                    
                                     
                                        <? 

										$atmid = $_REQUEST['atmid'];
										$fromdt = $_REQUEST['fromdt'];
										$todt = $_REQUEST['todt'];
										
										
										
echo '<div class="pagination"><ul>';
if ($start_window > 1) {

    echo "<li><a href='?page=1&&atmid=$atmid&&fromdt=$fromdt&&todt=$todt'>First</a></li>";
    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid='.$atmid.'&&fromdt='.$fromdt.'&&todt='.$todt.'">Prev</a></li>';
}

for ($i = $start_window; $i <= $end_window; $i++) {
?>
    <li class="<? if ($i == $current_page) { echo 'active'; }?>" >
        <a href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&fromdt=<? echo $fromdt; ?>&&todt=<? echo $todt; ?>" >
            <? echo $i;  ?>
        </a>        
    </li>

 <? }

if ($end_window < $total_pages) {

    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid='.$atmid.'&&fromdt='.$fromdt.'&&todt='.$todt.'">Next</a></li>';
    echo '<li><a href="?page=' . $total_pages . '&&atmid='.$atmid.'&&fromdt='.$fromdt.'&&todt='.$todt.'">Last</a></li>';
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
                                
                            <? } ?>
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



</body>

</html>