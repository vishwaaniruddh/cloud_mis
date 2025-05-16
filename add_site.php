<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

$con_sql = mysqli_query($con,"select * from contacts where type='c'");
        while($con_sql_result = mysqli_fetch_assoc($con_sql)){
            $cust[] = $con_sql_result['contact_first'];    
        }
        
        
$bank_sql = mysqli_query($con,"select * from bank");
    while($bank_sql_result = mysqli_fetch_assoc($bank_sql)){
    $bank[] = $bank_sql_result['bank_name'];    
}

//$city_sql = mysqli_query($con,"select * from quotation1citydet");
$city_sql = mysqli_query($con,"select * from mis_city");
    while($city_sql_result = mysqli_fetch_assoc($city_sql)){
    $city[] = $city_sql_result['city'];    
}

$state_sql = mysqli_query($con,"SELECT * FROM `state`");
    while($state_sql_result = mysqli_fetch_assoc($state_sql)){
    $state[] = $state_sql_result['state'];    
}

// $branch_sql = mysqli_query($con,"SELECT * FROM `cssbranch` order by location");
//     while($branch_sql_result = mysqli_fetch_assoc($branch_sql)){
//     $branch[] = $branch_sql_result['location'];    
// }

$branch_sql = mysqli_query($con,"SELECT * FROM `mis_branch_zone_master` order by branch");
    while($branch_sql_result = mysqli_fetch_assoc($branch_sql)){
    $branch[] = $branch_sql_result['branch'];    
}




$bm_sql = mysqli_query($con,"SELECT * FROM `bm`");
    while($bm_sql_result = mysqli_fetch_assoc($bm_sql)){
    $bm[] = $bm_sql_result['name'];    
}

$user_data_sql = mysqli_query($con,"select id,name from mis_loginusers where designation='4'");
       




        
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
    <style>
    .select2-container .select2-selection--single{height: auto !important;}
    </style> 
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                         <div class="two_end">
                                            <h5>Upload Bulk Sites</h5>
                                            <a class="btn btn-warning" href="bulk_site_upload.php" target="_new">BULK SITES UPLOAD</a>
                                        </div>
                                        <hr>
                                        <h3>Add Site</h3>
                                        <hr>
                                        <form action="process_addsite.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="">activity</label>
                                                    <select name="activity" class="form-control">
                                                        <option>Select</option>
                                                        <option value="RMS">RMS</option>
                                                        <option value="DVR Activity">DVR Activity</option>
                                                        <option value="Cloud">Cloud</option>
                                                    </select>
                                                </div>
                                            <div class="col-sm-3">
                                                <label for="">customer</label>
                                                <select class="form-control js-example-basic-single w-100"  name="customer" required>
                                                    <option value="">Select Customer</option>
                                                    <?
                                                    foreach($cust as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                                
                                                
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">bank</label>
                                                <select class="form-control js-example-basic-single w-100"  name="bank" required>
                                                    <option value="">Select Bank</option>
                                                    <?
                                                    foreach($bank as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                                

                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">atmid</label>
                                                <input type="text" name="atmid" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">atmid2</label>
                                                <input type="text" name="atmid2" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">atmid3</label>
                                                <input type="text" name="atmid3" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">trackerno</label>
                                                <input type="text" name="trackerno" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">address</label>
                                                <input type="text" name="address" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">city</label>
                                                <select class="form-control" name="city" required>
                                                    <option value="">Select City</option>
                                                    <?
                                                    foreach($city as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <label for="">state</label>
                                                <select class="form-control js-example-basic-single w-100"  name="state" required>
                                                    <option value="">Select Bank</option>
                                                    <?
                                                    foreach($state as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                                
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">zone</label>
                                                    <select name="zone" class="form-control">
                                                        <option>Select</option>
                                                        <option value="North">North</option>
                                                        <option value="South">South</option>
                                                        <option value="East">East</option>
                                                        <option value="West">West</option>
                                                    </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">branch</label>
                                                <select class="form-control js-example-basic-single w-100"  name="branch" required>
                                                    <option value="">Select Branch</option>
                                                    <?
                                                    foreach($branch as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                            
                                            <!--<div class="col-sm-3">-->
                                            <!--    <label for="">pincode</label>-->
                                            <!--    <input type="text" class="form-control" id="pincode" name="pincode" required>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="col-sm-3">-->
                                            <!--    <label for="">Live date</label>-->
                                            <!--    <input type="date" class="form-control" id="live_date" name="live_date" required>-->
                                            <!--</div>-->
                                            
                                            <div class="col-sm-3">
                                                <label for="">bm_name</label>
                                                <select class="form-control js-example-basic-single w-100"  name="bm_name" required>
                                                    <option value="">Select BM</option>
                                                    <?
                                                    foreach($bm as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                                
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">bm_number</label>
                                                <input type="text" name="bm_number" class="form-control">
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <label for="">engineer</label>
                                                <select class="form-control js-example-basic-single w-100"  name="engineer_user_id" required>
                                                    <option value="">Select Engineer</option>
                                                    <?
                                                     while($user_data_sql_result = mysqli_fetch_assoc($user_data_sql)){
                                                        $user_name = $user_data_sql_result['name'];
                                                        $user_id = $user_data_sql_result['id'];
                                                      ?>
                                                        <option value="<? echo trim($user_id); ?>"><? echo trim($user_name); ?></option>
                                                    <? } ?>
                                                </select>
                                                
                                                
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <label>Service Executive</label>
                                                <select class="form-control" name="serviceExecutive" required>
                                                    <option value="">-- Select --</option>
                                                    <?
                                                    $se_sql = mysqli_query($con,"select * from mis_loginusers where serviceExecutive=1");
                                                    while($se_sql_result = mysqli_fetch_assoc($se_sql)){ ?>
                                                       <option <? echo $se_sql_result['id'];?>>
                                                          <? echo $se_sql_result['name'];?> 
                                                       </option> 
                                                    <? }
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="col-sm-12">
                                                <br>
                                                <input type="submit" name="submit" class="btn btn-success">
                                            </div>
                                            
                                            
                                            </div>
                                        </form>
                                        
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
            $('.js-example-basic-single').select2();
        });
</script>

</body>

</html>