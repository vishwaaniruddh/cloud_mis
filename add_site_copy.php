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
    $bank[] = $bank_sql_result['bank'];    
}

$city_sql = mysqli_query($con,"select * from quotation1citydet");
    while($city_sql_result = mysqli_fetch_assoc($city_sql)){
    $city[] = $city_sql_result['city'];    
}

$state_sql = mysqli_query($con,"SELECT * FROM `state`");
    while($state_sql_result = mysqli_fetch_assoc($state_sql)){
    $state[] = $state_sql_result['state'];    
}

$branch_sql = mysqli_query($con,"SELECT * FROM `cssbranch` order by location");
    while($branch_sql_result = mysqli_fetch_assoc($branch_sql)){
    $branch[] = $branch_sql_result['location'];    
}

$bm_sql = mysqli_query($con,"SELECT * FROM `bm`");
    while($bm_sql_result = mysqli_fetch_assoc($bm_sql)){
    $bm[] = $bm_sql_result['name'];    
}

$user_data_sql = mysqli_query($con,"select id,name from mis_loginusers");
       




        
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <!--<button type="button" name="bulk_upload_site" class="btn btn-warning">Bulk Upload Site</button>-->
                                
                                <div class="card">
                                    <div class="card-block">
                                        <div class="two_end">
                                            <h5>Upload Bulk Sites</h5>
                                            <a class="btn btn-warning" href="bulk_site_upload.php" target="_new">BULK SITES UPLOAD</a>
                                        </div>
                                        <hr>
                                        <h3>Add Site</h3>
                                        <hr>
                                        <form action="process_addsite_copy.php" method="POST">
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
                                                <select class="form-control" name="customer" required>
                                                    <option value="">Select Customer</option>
                                                    <?
                                                    foreach($cust as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                                
                                                
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">bank</label>
                                                <select class="form-control" name="bank" required>
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
                                                <label for="">zone</label>
                                                    <select name="zone" id="zone" class="form-control">
                                                        <option>Select Zone</option>
                                                        <option value="3">North</option>
                                                        <option value="1">South</option>
                                                        <option value="4">East</option>
                                                        <option value="2">West</option>
                                                    </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">state</label>
                                                <select class="form-control" name="state" id="state" required>
                                                    <option value="">Select State</option>
                                                    
                                                </select>
                                                
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">branch</label>
                                                <select class="form-control" name="branch" id="branch" >
                                                    <option value="">Select Branch</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">city</label>
                                                <select class="form-control" id="city" name="city" required>
                                                    <option value="">Select City</option>
                                                    <?
                                                    foreach($city as $key=>$val){ ?>
                                                        <option value="<? echo trim($val); ?>"><? echo trim($val); ?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="col-sm-3">
                                                <label for="">address</label>
                                                <input type="text" name="address" id="address" class="form-control">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">pincode</label>
                                                <input type="text" class="form-control" id="pincode" name="pincode" required>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <label for="">Live date</label>
                                                <input type="date" class="form-control" id="live_date" name="live_date" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="">bm_name</label>
                                                <select class="form-control" name="bm_name" required>
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
                                                <select class="form-control" id="engineer_user_id" name="engineer_user_id" >
                                                    <option value="">Select Engineer</option>
                                                  
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
    // function selectBranch(branch){
    //     // var zone=this.value;

    //     // $("#city").val('');
    //     // $("#branch").val('');
        
    //     $.ajax({
    //         url:"fill_by_zone.php",
    //         data: 'branch='+branch,
    //         type: "POST",
    //         success: function(data){
    //             var obj = JSON.parse(data);
                
    //             var zone = obj['zone'];
    //             $("#zone").val(zone);
                
    //              $.ajax({
    //                     type: "POST",
    //                     url: 'get_zone.php',
    //                     data: 'zone_id='+zone,
    //                     success:function(msg) {
    //                         document.getElementById("branch").innerHTML = '<option value="">Branch</option>';
    //                         $("#branch").html(msg);
    //                         $('#state option[value="' + branch + '"]').prop('selected', true);
    //                     }
    //                 });
    //         }
    //     });

        
    // }
    $("#branch").on('change',function(){ debugger;
            var zone_id = $("#zone").val();
            var state_id = $("#state").val();
            var branch_id = $("#branch").val();
            
            $.ajax({

                type: "POST",
                url: 'get_engineer.php',
                data: {zone_id : zone_id, state_id: state_id, branch_id: branch_id },
                success:function(msg) {
                    console.log(msg);
                    debugger;
                    document.getElementById("engineer_user_id").innerHTML = '<option value="">Select Engineer</option>';
                   
                    $("#engineer_user_id").html(msg);
                }
            });
        });
    
    $("#state").on('change',function(){ debugger;
            var zone_id = $("#zone").val();
            var state_id = $("#state").val();
            
            $.ajax({

                type: "POST",
                url: 'get_branch.php',
                data: {zone_id : zone_id, state_id: state_id },
                success:function(msg) {
                    console.log(msg);
                    debugger;
                    document.getElementById("branch").innerHTML = '<option value="">Select Branch</option>';
                   
                    $("#branch").html(msg);
                }
            });
        });
            $("#zone").on('change',function(){
            var zone_id = $("#zone").val();
            $.ajax({

                type: "POST",
                url: 'get_state.php',
                data: 'zone_id='+zone_id,
                success:function(msg) {
                    console.log(msg);
                    debugger;
                    document.getElementById("state").innerHTML = '<option value="">Select State</option>';
                   
                    $("#state").html(msg);
                }
            });
        });
        
        // $("#branch").on('change',function(){
        //     var zone_id = $("#zone").val();
        //     var branch_id = $("#branch").val();
        //     $.ajax({
        //         debugger;
        //         type: "GET",
        //         url: 'get_eng.php',
        //         data: {"branch_id" : branch_id,"zone_id" : zone_id },
        //         success:function(msg) {
        //             console.log(msg);
        //             debugger;
        //             document.getElementById("engineer_user_id").innerHTML = '<option value="">Select Engineer</option>';
                   
        //             $("#engineer_user_id").html(msg);
        //         }
        //     });
        // });
        
        
        
    
</script>


</body>

</html>