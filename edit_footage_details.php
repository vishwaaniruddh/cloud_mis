<? session_start();
include('config.php');
date_default_timezone_set("Asia/Calcutta");   


if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<style>
#Contactperson_name{display:none;}
#Contactperson_mob{display:none;}
</style>

            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <h5>SITE INFORMATION</h5>
                                        <hr>
                                        
                                        <?
                                        $id = $_GET['id'];
                                        $sql = mysqli_query($con,"select * from footage_bulk_request where id= '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        
                                        $footage_id = $sql_result['id']; 
                                        
                                        $atmid = $sql_result['atmid'];
                                        date_default_timezone_set("Asia/Calcutta");   
                                        $date = date('Y-m-d H:i:s');
                                        $userid = $_SESSION['userid'];
                                        
                                        $sql1 = mysqli_query($con,"select * from eng_footage_request_history where footage_id = '".$footage_id."'");
                                        $schedule_name = "";$current_status="";
                                        $footage_call_total = mysqli_num_rows($sql1);
                                        if($footage_call_total>0){
                                            while($sql1_result = mysqli_fetch_assoc($sql1)){
                                                if($sql1_result['update_status']=='Schedule'){
                                                   $created_by = $sql1_result['created_by'];
                                                   $engineer_sql = mysqli_query($con,"select name from mis_loginusers where id = '".$created_by."'");
                                                   $eng_as = mysqli_fetch_assoc($engineer_sql);
                                                   $schedule_name = $eng_as['name'];
                                                }
                                               $current_status = $sql1_result['update_status'];
                                            }
                                        }
                                        
                                        $mis_status = $current_status;
                                        ?>
                                                                <div class="view-info">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="general-info">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table m-0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <th scope="row">Customer </th>
                                                                                                        <td><? echo $sql_result['customer'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">ATM ID</th>
                                                                                                        <td>
                                                                                                            <span><? echo $sql_result['atmid'];?></span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Bank</th>
                                                                                                        <td><? echo $sql_result['bank'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Location</th>
                                                                                                        <td><? echo $sql_result['address'];?></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <tr>
                                                                                                        <th scope="row">City</th>
                                                                                                        <td><? echo $sql_result['city'];?></td>
                                                                                                    </tr>
                                                                                                    
                                                                                                        <th scope="row">State</th>
                                                                                                        <td><? echo $sql_result['state'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Zone</th>
                                                                                                        <td><? echo $sql_result['zone'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Status</th>
                                                                                                        <td><? echo $sql_result['status'];?></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of general info -->
                                                                        </div>
                                                                        <!-- end of col-lg-12 -->
                                                                    </div>
                                                                    
                                                                    <!-- end of row -->
                                                                </div>
                                                                
                                                                
                                    </div>
                                </div>
                                
                                
                                
                                                                <div class="card">
                                    <div class="card-block">

                                        <h5>CALL INFORMATION</h5>
                                        <hr>                                        
                                       
                                                                <div class="view-info">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="general-info">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table m-0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <th scope="row">CSS BM </th>
                                                                                                        <td><? echo $sql_result['css_bm'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Assigned Engineer</th>
                                                                                                        <td><? echo $schedule_name; ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Current Status</th>
                                                                                                        <td><? echo $current_status;?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Recording Date</th>
                                                                                                        <td><? echo $sql_result['recording_date'];?></td>
                                                                                                    </tr>
                                                                                                   
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <th scope="row">Created On</th>
                                                                                                        <td>
                                                                                                            <span><? echo $sql_result['created_at'];?></span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    
                                                                                                        <th scope="row">Created By</th>
                                                                                                        <td><? echo get_member_name($sql_result['created_by']);?></td>
                                                                                                    </tr>
                                                                                                   
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of general info -->
                                                                        </div>
                                                                        <!-- end of col-lg-12 -->
                                                                    </div>
                                                                    <!-- end of row -->
                                                                </div>
                                                                
                                                                
                                    </div>
                                </div>
                                
                               
                               
                                                               
                                <div class="card">
                                    <div class="card-block">
                                        <h5>Change Status</h5>
                                                                                <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <select class="form-control" name="status" id="status">
                                                    <option value=""> Select </option>
                                                    <option value="Schedule" <? if($mis_status == 'Schedule'){ echo 'selected' ; }?> > Schedule </option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        
                                        
                                        
                                        
                                        <?
                                           
                                        if(isset($_POST['status'])){

                                            if($_POST['status']=='Schedule'){
                                                $status = $_POST['status'] ;
                                                $engineer = $_POST['engineer'];
                                                $schedule_date = $_POST['schedule_date']; 
                                                $statusfootage_sql = mysqli_query($con,"select * from eng_footage_request_history where footage_id ='".$id."' AND update_status='Schedule'");
                                                if(mysqli_num_rows($statusfootage_sql)==0){
                                                    $statement = "insert into eng_footage_request_history(footage_id,update_status,update_details,created_by,created_at) values('".$id."','".$status."','".$schedule_date."','".$userid."','".$date."')" ;
                                                   
                                                }else{
                                                    $statement = "update eng_footage_request_history set created_by = '".$engineer."',update_details='".$schedule_date."',schedule_by='".$userid."',created_at='".$date."' where id = '".$id."' AND update_status='Schedule'";
                                                }
                                                   
                                            }
                                            if(mysqli_query($con,$statement)){
                                            ?>
                                                
                                            <script>
                                                swal("Great !", "Call Updated Successfully !", "success");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="edit_footage_details.php?id=<? echo $id ; ?>";
                                                    }, 2000);

                                            </script>
                                            <? }else{ 
                                            
                                            echo mysqli_error($con);
                                            ?>
                                               
                                            <script>
                                                swal("Oops !", "Call Updated Error !", "error");
                                                
                                                    setTimeout(function(){ 
                                                        // window.location.href="mis_details.php?id=<? echo $id ; ?>";
                                                    }, 2000);

                                            </script>
                                            
                                            <? } }
                                        
                                        ?>
                                        
                                <form action="<? echo $_SERVER['PHP_SELF'];?>?id=<? echo $id ;?>" method="POST" enctype="multipart/form-data">
                                        <div class="row" id="status_col">    
                                        
                                        </div>
                                </form>
                                        
                                        
                                    </div>
                                </div>
                                
                                 
                                
                                
                                <div class="card">
                                    <div class="card-block" style="overflow:scroll;">
                                        <h5>FOOTAGE CALL INFORMATION</h5>

                                        <hr>
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                <th>Sn No</th>
                                                <th>Details/ Schedule Date</th>
                                                <th>Engineer</th>
                                                <th>Action By</th>
                                                <th>Created Date</th>
                                                
                                                
                                                </tr>

                                            </thead>
                                            <tbody> 
                                                <?
                                                $footage_call_sql1 = mysqli_query($con,"select * from eng_footage_request_history where footage_id = '".$footage_id."'");
                                                if(mysqli_num_rows($footage_call_sql1)>0){
                                                     $i = 1 ; 
                                                    while($his_sql_result = mysqli_fetch_assoc($footage_call_sql1)){ 
                                                        $engineer_name = "";
                                                        $created_by = get_member_name($his_sql_result['created_by']);
                                                        if($his_sql_result['update_status']=='Schedule'){
                                                            $engineer_name = get_member_name($his_sql_result['created_by']);
                                                            if($his_sql_result['schedule_by']>0){
                                                              $created_by = get_member_name($his_sql_result['schedule_by']);
                                                            }
                                                        }
                                                    ?>
                                                    <tr >
                                                        <td><? echo $i ; ?></td>
                                                        
                                                        <td><? echo $his_sql_result['update_details'];  ?></td>
                                                        <td><? echo $engineer_name;  ?></td>
                                                        <td><? echo $created_by;  ?></td>
                                                        <td><? echo $his_sql_result['created_at'];  ?></td>
                                                        
                                                    </tr>
                                                <? $i++ ; } }?>

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
        window.location.href="=login.php";
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

<!--else if(status == 'material_requirement'){-->
<!--            var html = '<input type="hidden" name="status" value="material_requirement"><div class="col-sm-6"><label>Material</label><select class="form-control" name="material"><option value="">Select</option><? $mat_sql =mysqli_query($con,"select * from material where status=1 "); while($mat_sql_result = mysqli_fetch_assoc($mat_sql)){ ?> <option value="<? echo $mat_sql_result['id'] ; ?>"><? echo $mat_sql_result['material'] ; ?></option> <? } ?></select></div><div class="col-sm-6"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-12"><label>Address</label><input class="form-control" name="address"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';-->
<!--        }-->
<script>
    $(document).ready(function(){
        $(".js-example-basic-single").select2();
    });
     
    // $("#address_type").on("change",function(){ debugger; 
    function setaddress(){ debugger;
        var address_type = $('#address_type').val();
        if(address_type=='Branch'){
            $('#address').val('Branch');
            $('#address').attr('readonly',true);
            $('#Contactperson_name').hide();
            $('#Contactperson_mob').hide();
             $('#Contactperson_name_text').attr('required',false);
            $('#Contactperson_mob_text').attr('required',false);
            $('#address').show();
        }
        if(address_type=='Other'){
            $('#address').val('');
            $('#address').attr('readonly',false);
             $('#Contactperson_name').show();
             $('#Contactperson_mob').show();
               $('#Contactperson_name_text').attr('required',true);
            $('#Contactperson_mob_text').attr('required',true);
            //  $('#address').show();
        }
    }

    $("#status").on("change",function(){    
    var status = $(this).val();
    $("#status_col").html('');
        if(status == 'dispatch'){
            var html = '<input type="hidden" name="status" value="dispatch"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'Schedule'){
            var html = '<input type="hidden" name="status" value="Schedule"><div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><? $eng_sql = mysqli_query($con,"select * from mis_loginusers"); while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?> <option value="<? echo $eng_sql_result['id'];?>"><? echo $eng_sql_result['name'];?></option> <? }?></select></div><div class="col-sm-4"><label>Schedule Date</label><input type="date" name="schedule_date" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'material_requirement'){
            var html = '<input type="hidden" name="status" value="material_requirement"><div class="col-sm-6"><label>Request Material For Site</label><select class="form-control" name="material"><option value="">Select</option><? $mat_sql =mysqli_query($con,"select * from material where status=1 "); while($mat_sql_result = mysqli_fetch_assoc($mat_sql)){ ?> <option value="<? echo $mat_sql_result['material'] ; ?>"><? echo $mat_sql_result['material'] ; ?></option> <? } ?></select></div><div class="col-sm-6"><label>Material Conditions</label><select class="form-control" name="material_condition"><option value="">Select</option><option value="Missing">Missing</option><option value="Faulty">Faulty</option><option value="Not Installed">Not Installed</option></select></div><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-3"><label>Address Type</label><select class="form-control" id="address_type" name="address_type" onchange="setaddress()"><option value="Branch">Branch</option><option value="Other" id="Other">Other</option></select></div><div class="col-sm-9" ><label>Address</label> <input class="form-control" readonly name="address" id="address"  value="Branch"/></div><div class="col-sm-4" id="Contactperson_name" ><label for="Contactperson_name" >Contact Person Name</label><input type="text" class="form-control" name="Contactperson_name" id="Contactperson_name_text"></div><div class="col-sm-4" id="Contactperson_mob" ><label for="Contactperson_mob">Contact Person Mobile</label><input type="text" class="form-control" name="Contactperson_mob"id="Contactperson_mob_text" ></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'material_dispatch'){
            var html = '<input type="hidden" name="status" value="material_dispatch"><div class="col-sm-3"><label>Courier Agency</label><input type="text" name="courier" class="form-control"></div><div class="col-sm-3"><label>POD</label><input type="text" name="pod" class="form-control"></div><div class="col-sm-3"><label>Dispatch Date</label><input type="date" name="dispatch_date" class="form-control"></div><div class="col-sm-3"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-primary" type="submit" value="Update" name="submit"></div>';
        }else if(status == 'close'){
            var html = '<input type="hidden" name="status" value="close"><div class="col-sm-4"><label>Attache File</label><input type="file" name="image" class="form-control"></div><div class="col-sm-4"><label>Close Type</label><select name="close_type" class="form-control"><option value=""> Select </option><option value="replace"> Replace </option><option value="repair"> Repair </option></select></div><div class="col-sm-4"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-danger" value="Close" type="submit" name="submit"></div>' ;
        }else if(status == 'paste_control'){
            var html = '<input type="hidden" name="status" value="paste_control"><div class="col-sm-4"><label>Attache File</label><input type="file" name="image" class="form-control"></div><div class="col-sm-4"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-danger" value="Submit" type="submit" name="submit"></div>' ;
        }
        else if(status == 'material_available_in_branch'){
                var html = '<input type="hidden" name="status" value="material_available_in_branch"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'material_not_available'){
                var html = '<input type="hidden" name="status" value="material_not_available"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'broadband'){
                var html = '<input type="hidden" name="status" value="broadband"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'permission_require'){
                var html = '<input type="hidden" name="status" value="permission_require"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'reopen'){
                var html = '<input type="hidden" name="status" value="reopen"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'material_delivered'){
                var html = '<input type="hidden" name="status" value="material_delivered"><div class="col-sm-6"><label>Delivery Date</label><input type="date" name="delivery_date" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'MRS'){
                var html = '<input type="hidden" name="status" value="MRS"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        
        
        $("#status_col").html(html);
        $(".js-example-basic-single").select2();
    });

   
    </script>
</body>

</html>