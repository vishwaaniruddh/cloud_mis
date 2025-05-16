<? session_start();

date_default_timezone_set('Asia/Kolkata');
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

<style>
.vl-left {
  border-left: 3px solid grey;
  height: 108px;
  position: absolute;
  left: 50%;
  margin-left: -300px;
  top: 0;
}

.vl-right {
  border-left: 3px solid grey;
  height: 108px;
  position: absolute;
  left: 50%;
  margin-left: 300px;
  top: 0;
}

.vl-left-2 {
  border-left: 3px solid grey;
  height: 108px;
  position: absolute;
  left: 50%;
  margin-left: 10px;
  top: 0;
}
</style>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                           
                        <div class="card" id="filter">
                            <div class="card-block" style="background:#cccccc">
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
                                    <b><?echo $date; ?></b>
                                    <div class="row">
                                        <?php 
                                            // $totonoff = $oncount + $offcount;
                                            // $nvrused = $counteng - $totonoff;
                                        ?>
                                        <div class="col-md-3" align="center">
                                            <label >Total Engineer:</label> <a href="#" style="color:blue"> <? echo $counteng; ?> </a>
                                        </div>
                                        <div class="vl-left"></div>
                                        <div class="col-md-3" align="center">
                                            <label >Total Online :</label> <a href="total_status.php?status=<?php echo "online";?>" target="_blank" style="color:green"><? echo $oncount; ?> </a>
                                        </div>
                                        <div class="vl-left-2"></div>
                                        <div class="col-md-3" align="center">
                                            <label >Total Offline:</label> <a href="total_status.php?status=<?php echo "offline";?>" target="_blank" style="color:yellow"><? echo $offcount; ?></a> 
                                        </div>
                                        <div class="vl-right"></div>
                                        <div class="col-md-3" align="center">
                                            <label >Never Used:</label> <a href="total_status.php?status=<?php echo "neverused";?>" target="_blank" style="color:red"><? echo $nvrcount; ?></a> 
                                        </div>
                                    </div>
                                    <? } ?>
                                </form>
                                <!--Filter End -->
                                <hr>

                            </div>
                        </div>   
                        <div class="card" id="filter">
                            <div class="card-block">
                                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Engineer</label>
                                            <select name="engineer" class="form-control js-example-basic-single">
                                                <option value=""> Select Engineer</option>
                                                <? $ac_sql = mysqli_query($con, "SELECT id, name as engineer from mis_loginusers where  designation = 4 and user_status=1 order by name ASC");
                                                while ($ac_sql_result = mysqli_fetch_assoc($ac_sql)) { 
                                                ?>
                                                
                                                    <option value="<? echo $ac_sql_result['id']; ?>" <? if (isset($_POST['engineer']) && $_POST['engineer'] == $ac_sql_result['engineer']) { echo 'selected';} ?>>
                                                        <? echo $ac_sql_result['engineer']; ?>
                                                    </option>
                                                <? } ?>
                                            </select>
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
                                $engid = $_POST['engineer'];
                                if($engid){
                                    $statement = "SELECT * from mis_loginusers where  designation = 4 and user_status=1 and id = '".$engid."' order by name ASC";
                                }
                                else 
                                {
                                    $statement = "SELECT * from mis_loginusers where  designation = 4 and user_status=1 order by name ASC";
                                }
                            }
                        ?>
    
    
    
   <?php if($_POST['submit'] ) {
                           
                        ?>
                           
                                <div class="card">
                                    <div class="card-block" style="overflow: auto;">
                                        
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sn No.</th>
                                                    <th>Engineer Name</th>
                                                    <th class="address" style="width:100% !important; ">last location</th>
                                                    <th>Contact No.</th>
                                                    <th>Created Time</th>
                                                    <th>Status </th>
                                                    <!--<th>count</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?
                                                $i=1;
                                                
                                                // $csql = mysqli_query($con,"SELECT * from mis_loginusers where  designation = 4 order by name ASC");
                                                $csql = mysqli_query($con,$statement);
                                                $csql_rows = mysqli_num_rows($csql); 
                                                if($csql_rows!='') {
                                                    while ($csql_result = mysqli_fetch_assoc($csql)) {
                                                        $eng_id = $csql_result['id'];
                                                        $eng_name = $csql_result['name'];
                                                        $contact = $csql_result['contact'];
                                                        
                                                        $oncount = 0;
                                                        $offcount = 0;
                                                        
                                                        $statement = "select * from eng_locations where user_id='".$eng_id."'  order by id desc limit 1";
                                                        
                                                        $sql = mysqli_query($con,$statement);
                                                        $sql_result = mysqli_fetch_assoc($sql);
                                                        // print_r($sql_result); die;
                                                        
                                                            
                                                        $eng_user_id = $sql_result['user_id'];
                                                        $location = $sql_result['location'];
                                                        
                                                        $created_date = date("Y-m-d", strtotime($sql_result['created_time']));
                                                        $created_time = $sql_result['created_time'];
                                                        
                                                        $datetime = date(strtotime("Y-m-d H:i:s"));
                                                        $date = date("Y-m-d");
                                                        $start_date = new DateTime($datetime);
                                                        $since_start = $start_date->diff(new DateTime($created_time));
                                                        
                                                        $hr = $since_start->h;
                                                        $min = $since_start->i;
                                                        
                                                        if($date == $created_date) {
                                                            if($hr <=1)
                                                            {
                                                                $status = "Online";
                                                                $oncount = $oncount+1;
                                                            }
                                                            else if($hr > 1){
                                                                $status = "Offline";
                                                                $offcount = $offcount+1;
                                                            }
                                                        }
                                                        else
                                                        { $status = "Offline";}
                                                        
                                                        
                                                 ?>



                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $eng_name; ?></td>
                                                    <td class="address"><p><? echo $location; ?></p></td>
                                                    <td><? 
                                                        if($contact!='')
                                                        {
                                                            echo $contact;
                                                        }
                                                        else
                                                        {
                                                            echo "No Contact Found";
                                                        }
                                                    
                                                    
                                                    ?></td>
                                                    <td><? echo $created_time; ?></td>
                                                    <td><?php echo $status; ?></td>
                                                    <!--<td>Online:<? if($oncount>0) echo $oncount; ?></td>-->
                                                </tr>


    
<? $i++; } } ?>
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

<script>
     $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

</body>

</html>