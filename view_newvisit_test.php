<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');


?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


<style>
    
   th.address, td.address {
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
                                        <div class="col-md-2">
                                            <label>Activity</label>
                                            <select name="activity" class="form-control">
                                            <option value=""> Select Activity</option>
                                            <? $ac_sql = mysqli_query($con,"select distinct(activity) as activity from mis_newsite where status=1");
                                            while($ac_sql_result = mysqli_fetch_assoc($ac_sql)){ ?>
                                            <option value="<? echo $ac_sql_result['activity'];?>" <? if(isset($_POST['activity']) && $_POST['activity']==$ac_sql_result['activity'] ){ echo 'selected'; } ?>>
                                            <? echo $ac_sql_result['activity'];?>
                                            </option>
                                            <? } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>ATMID</label>
                                            <input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>">     
                                        </div>
                                        <div class="col-md-3">
                                            <label>From Visit Date</label>
                                            <input type="date" name="fromdt" class="form-control" value="<? if($_POST['fromdt']){ echo  $_POST['fromdt']; }else{ echo '2022-12-12' ; } ?>">    
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label>To Visit Date</label>
                                            <input type="date" name="todt" class="form-control" value="<? if($_POST['todt']){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">    
                                        </div>
                                    </div>
                                    
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
                                    $activity = $_POST['activity'];
                                    $statement = "select a.id as ID,a.created_at as Created_AT,a.* from mis_newvisit a inner join mis_newsite b on a.atmid=b.atmid where b.activity='".$activity."' and a.atmid like '%".$_POST['atmid']."%'  ";
                                }
                                     
                                if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
                                {
                                    $date1 = $_POST['fromdt'] ; 
                                    $date2 = $_POST['todt'] ;
                                    $statement .=" and CAST(a.created_at AS DATE) >= '".$date1."' and CAST(a.created_at AS DATE) <= '".$date2."'";
                                }
                        
                                $statement.= " order by a.id desc" ; 
                        
                                // echo strtolower($statement); 
                            ?>  
                            
                           <?php if($_POST['submit']){ ?>
                                <div class="card">
                                    <div class="card-block" style="overflow: auto;">
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
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
                                                    <td class="address" style="width:415px !important; ">location</td>
                                                    
                                                    
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
                                                
                                            <?php
                                            $i=1;
                                            
                                            
                                            $sql = mysqli_query($con,$statement);
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
                                            $engineer = get_eng_name('name','contact',$engineer);
                                            
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
                                            // $router_name = $visit_details_sql_result['router_name'];
                                            // $routerid = $visit_details_sql_result['routerid'];
                                            $other_status = $visit_details_sql_result['other_status'];
                                            $ip_cam = $visit_details_sql_result['ip_cam'];
                                            $sd_card_status = $visit_details_sql_result['sd_card_status'];
                                            // echo $sd_card_status."<br>";
                                            
                                            ?>
                                                <tr>
                                                    <td><? echo $i; ?></td>
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
                                                    <td class="address">
                                                        <p><? echo $location; ?></p>
                                                    </td>
                                                    
                                                    
                                                    <td><? echo $type; ?></td> 
                                                    <td><? echo $status; ?></td> 
                                                    <td><? echo $cam1; ?></td> 
                                                    <td><? echo $cam2; ?></td> 
                                                    <td><? echo $cam3; ?></td> 
                                                    <td><? echo $cam4; ?></td> 
                                                    <td><? echo $hdd_status; ?></td> 
                                                    <td><? echo $router_name; ?></td> 
                                                    <td><? echo $routerid; ?></td> 
                                                    <td><? echo $other_status; ?></td> 
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

<? $i++; } ?>
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