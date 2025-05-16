<?php session_start();
include('config.php');
error_reporting(0);

if($_SESSION['username']){ 

include('header.php');

if(isset($_REQUEST['engid'])){
    
}else{
$ses_engid=$_SESSION['engid'] ; 
    
}


function get_misstate($id){
    global $con;
    $sql = mysqli_query($con,"select * from mis_newsite where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['state'];
}

$engid = $_REQUEST['engid'];


?>
<style>
html{
    text-transform: inherit !important;
}
    nav{
        display:none !important;
    }
    .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="expanded"][vertical-effect="shrink"] .pcoded-content {
    margin-left: 0;
}
.line-on-side {
    border-bottom: 1px solid #dadada;
    line-height: 0.1em;
    margin: 10px 0 20px;
}
.line-on-side span {
    background: #F6F7FB;
    padding: 0 10px;
}
</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
 <style>
    .select2-container .select2-selection--single{height: auto !important; }
    .select2-selection__choice {background-color:cyan; }
}
 </style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                            <? if(basename(__FILE__)=='appportalSitestest.php'){ ?>
                                <h2 class="card-subtitle line-on-side center font-small-3 pt-2">
                                    <span>CSS App Portal</span>
                                </h2>
                                <div class="card">
                                    <div class="card-block">
                                        <ul class="nav">
                                              <li class="nav-item">
                                                <a class="nav-link" aria-current="page" id="project" href="appportalInstallation.php?engid=<? echo $engid; ?>">Project</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link active" id="sites" href="appportalSitestest.php?engid=<? echo $engid; ?>">Sites</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="ATMVisit" href="appportal.php?engid=<? echo $engid; ?>">ATM Visit</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" href="appvisitrecords.php?engid=<? echo $engid; ?>">Visit Records</a>
                                              </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <? } ?>
                                
                                
                                
                                
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form id="sitesForm" action="<?php echo basename(__FILE__); ?>?engid=<? echo $_REQUEST['engid']; ?>" method="POST">
                                            <div class="row">
                                                 
                                                <div class="col-md-12">
                                                    <label>ATMID</label>
                                                    
                                                    <select name="atmid" id="multiselect" class="form-control js-example-basic-single" >
                                                        
                                                        <?php 
                                                            $i = 0;
                                                            $atmidlist= mysqli_query($con,"SELECT id,atmid from mis_newsite  ");
        											        while($fetch_data = mysqli_fetch_assoc($atmidlist)){
        											            
        											     ?>
    											        <option value="<?php echo $fetch_data['atmid'] ?>">
    											         <?php echo $fetch_data['atmid'];?>
    											         </option>
    											       <?php 
        											    }  ?>
                                                    </select>
                                                    
                                                </div>

                                            </div>
                                            <br>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>
                                    
                                    <!--Filter End -->
                                    <hr>
                                          
                                      </div>
                                    </div>


                            <?php
                            
                            
                            
                            if($_POST['submit']) {
                                   
                                    $atm_sql = "select id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status from mis_newsite where 1 ";
                                
                            } 
                            
                            
                            if(isset($_POST['atmid']) && $_POST['atmid']!=''){
                                $atmid = $_POST['atmid'];
                                
                                $atmid = json_encode($atmid);
                                $atmid = str_replace(array('[', ']', '"'), '', $atmid);
                                $arr_atmid = explode(',', $atmid);
                                $atmid = "'" . implode("', '", $arr_atmid) . "'";
                                
                                // echo 111; 
                                // $atm_sql = "select id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status from mis_newsite where id in ($atmid)  and status= 1 ";
                                $atm_sql .= "and atmid=$atmid " ;
                            }
                            

                            
                               
                                // $atm_sql .= "order by id desc";
                               
                              echo $atm_sql;
                               
                               ?>
                                <div class="card" id="filter_content"> 
                                    <div class="card-body" style="overflow:auto;">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Activity</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>
                                                    <th>ATMID</th>
                                                    <th>Tracker No</th>
                                                    <th>Address</th>
                                                    <th>city</th>
                                                    <th>State</th>
                                                    <th>Zone</th>
                                                    <th>Branch</th>
                                                    <th>CSS BM Name</th>
                                                    <th>CSS BM Number</th>
                                                    <th>Engineer Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ;
                                                if(isset($_POST['submit'])){
                                                    
                                                // echo $atmid; die;
                                                $atm_sql_res = mysqli_query($con,$atm_sql);
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
                                                     $engg_user_id = $atm_sql_result['engineer_user_id'];
                                                     if(is_null($engg_user_id) || $engg_user_id==''){
                                                        $eng_name = "-";
                                                     } else {
                                                        //  $eng_name = $engg_user_id;
                                                         $user_sql = mysqli_query($con,"select * from mis_loginusers where id='".$engg_user_id."'");
                                                         if(mysqli_num_rows($user_sql)==0){
                                                             $eng_name = "-";
                                                         }
                                                         else{
                                                           $user_sql_result = mysqli_fetch_assoc($user_sql);
                                                            $eng_name = $user_sql_result['name'];
                                                         }
                                                     }
                                                     
                                                     if($atm_sql_result['status']== 1 ){
                                                         $status = "Active";
                                                     } else{ $status = "In-Active"; }
                                                
                                                $customer = $atm_sql_result['customer'];
                                                $bank = $atm_sql_result['bank'];
                                                $id = $atm_sql_result['id'];
                                                ?>
                                                
                                                 <tr>
                                                     <td><?php echo $i; ?></td>
                                                     <td><?php echo $atm_sql_result['activity']; ?></td>
                                                     <td><?php echo $atm_sql_result['customer']; ?></td>
                                                     <td><?php echo $atm_sql_result['bank']; ?></td>
                                                     <td><?php echo $atm_sql_result['atmid']; ?></td>
                                                     <td><?php echo $atm_sql_result['trackerno']; ?></td>
                                                     
                                                     
                                                     <td><?php echo $atm_sql_result['address']; ?></td>
                                                     <td><?php echo $atm_sql_result['city']; ?></td>
                                                     <td><?php echo $atm_sql_result['state']; ?></td>
                                                     <td><?php echo $atm_sql_result['zone']; ?></td>
                                                     <td><?php echo $atm_sql_result['branch']; ?></td>
                                                     <td><?php echo $atm_sql_result['bm_name']; ?></td>
                                                     <td><?php echo $atm_sql_result['bm_number']; ?></td> 
                                                     <td><?php echo $eng_name;?></td>
                                                     <td>
                                                         <? if($status=='Active'){ ?>
                                                         <a href="inactiveSites.php?engid=<? echo $engid; ?>&&id=<? echo $id; ?>&&customer=<? echo $customer; ?>&bank=<? echo $bank; ?>">
                                                             <?php echo $status; ?>
                                                             </a>
                                                         <? }else{ ?>
                                                         <?php echo $status; ?>
                                                         <? } ?>
                                                         
                                                         </td>

                                                 </tr>
                                                <?php $i++; 
                                                }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
<script>
     $(document).ready(function() {
        $('.js-example-basic-single').select2();
        // $('.js-example-basic-single').find(':selected');
        // maximumSelectionLength: 100
    });
    
    
    
</script>




    <?php include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<?php }
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
        // $('.js-example-basic-single').find(':selected');
        // maximumSelectionLength: 100
    });
    
    
    
</script>


</body>

</html>