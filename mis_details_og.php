<? session_start();
include('config.php');
date_default_timezone_set("Asia/Calcutta");   


if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<style>
/*#Contactperson_name{display:none;}*/
/*#Contactperson_mob{display:none;}*/
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
                                        $sql = mysqli_query($con,"select * from mis_details where id= '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        
                                        $mis_id = $sql_result['mis_id']; 
                                        
                                        $atmid = $sql_result['atmid'];
                                        $date = date('Y-m-d');
                                        $userid = $_SESSION['userid'];
                                        
                                        $sql1 = mysqli_query($con,"select * from mis where id = '".$mis_id."'");
                                        $sql1_result = mysqli_fetch_assoc($sql1);
                                        
                                        
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
                                                                                                        <th scope="row">Ticket ID </th>
                                                                                                        <td><? echo $sql_result['ticket_id'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">ATM ID</th>
                                                                                                        <td>
                                                                                                            <span><? echo $sql_result['atmid'];?></span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Bank</th>
                                                                                                        <td><? echo $sql1_result['bank'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Location</th>
                                                                                                        <td><? echo $sql1_result['location'];?></td>
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
                                                                                                        <td><? echo $sql1_result['city'];?></td>
                                                                                                    </tr>
                                                                                                    
                                                                                                        <th scope="row">State</th>
                                                                                                        <td><? echo $sql1_result['state'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Zone</th>
                                                                                                        <td><? echo $sql1_result['zone'];?></td>
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
                                        <?
                                        $id = $_GET['id'];
                                        $sql = mysqli_query($con,"select * from mis_details where id= '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        
                                        $mis_id = $sql_result['mis_id']; 
                                        
                                        $mis_status = $sql_result['status'];
                                        $status_view = 0;
                                         if($mis_status=='material_in_process'){
                                             $status_view = 1;
                                         }
                                        
                                        $sql1 = mysqli_query($con,"select * from mis where id = '".$mis_id."'");
                                        $sql1_result = mysqli_fetch_assoc($sql1);
                                        
                                        $date = date('Y-m-d H:i:s');
                                        $date1 = date('Y-m-d');
                                        $date1=date_create($date1);
                                        $date2=date_create($sql_result['created_at']);
                                        $diff=date_diff($date1,$date2);
        
        
        
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
                                                                                                        <th scope="row">Ticket ID </th>
                                                                                                        <td><? echo $sql_result['ticket_id'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Assigned Engineer</th>
                                                                                                        <td><? ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Current Status</th>
                                                                                                        <td><? echo $sql_result['status'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Component</th>
                                                                                                        <td><? echo $sql_result['component'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Sub Component</th>
                                                                                                        <td><? echo $sql_result['subcomponent'];?></td>
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
                                                                                                        <td><? echo get_member_name($sql1_result['created_by']);?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Down Time </th>
                                                                                                        <td><? echo $diff->format("%a days");?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Remark</th>
                                                                                                        <td><? echo $sql1_result['remarks']; ?></td>
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
                                                    <option value="dispatch" <? if($mis_status == '1'){ echo 'selected' ; }?> style="<? if($status_view==1){ echo 'display:none'; } ?>"> Open </option>
                                                    <option value="schedule" <? if($mis_status == 'schedule'){ echo 'selected' ; }?> style="<? if($status_view==1){ echo 'display:none'; } ?>" > Schedule </option>
                                                    <option value="material_requirement" <? if($mis_status == 'material_requirement'){ echo 'selected' ; }?> style="<? if($status_view==1){ echo 'display:none'; } ?>"> Material Requirement </option>
                                                    <!--<option value="material_available_in_branch" <? if($mis_status == 'material_available_in_branch'){ echo 'selected' ; }?>> Material Available In Branch </option>-->
                                                    <!--<option value="material_not_available" <? if($mis_status == 'material_not_available'){ echo 'selected' ; }?>> Material Not Available </option>-->
                                                    <!--<option value="broadband" <? if($mis_status == 'broadband'){ echo 'selected' ; }?>> Broadband </option>-->
                                                    <option value="permission_require" <? if($mis_status == 'permission_require'){ echo 'selected' ; }?> style="<? if($status_view==1){ echo 'display:none'; } ?>"> Permission Require </option>
                                                    <option value="material_dispatch" <? if($mis_status == 'material_dispatch'){ echo 'selected' ; }?> style="<? if($status_view==1){ echo 'display:none'; } ?>"> Material Dispatch </option>
                                                    <option value="material_delivered" <? if($mis_status == 'material_delivered'){ echo 'selected' ; }?> style="<? if($status_view==1){ echo 'display:none'; } ?>"> Material Delivered </option>
                                                    <!--<option value="paste_control" <? if($mis_status == 'paste_control'){ echo 'selected' ; }?>> Paste Control </option>-->
                                                    <option value="close" <? if($mis_status == 'close'){ echo 'selected' ; }?> > Close </option>
                                                    <!--<option value="reopen" <? if($mis_status == 'reopen'){ echo 'selected' ; }?>> Reopen </option>-->
                                                    <option value="MRS" <? if($mis_status == 'MRS'){ echo 'selected' ; }?> style="<? if($status_view==1){ echo 'display:none'; } ?>"> Material Pending </option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        
                                        
                                        
                                        
                                        <?
                                        
                                        if(isset($_POST['status'])){

                                            if($_POST['status']=='dispatch' || $_POST['status']=='MRS' || $_POST['status'] =='permission_require' || $_POST['status']=='broadband' || $_POST['status']=='material_not_available' || $_POST['status'] =='material_available_in_branch'){
                                                $remark = $_POST['remark'];
                                                $status = $_POST['status'] ;
                                                echo $statement = "insert into mis_history(mis_id,type,remark,status,created_at,created_by) values('".$id."','".$status."','".$remark."','1','".$date."','".$userid."')" ;
                                            }elseif($_POST['status']=='schedule'){
                                                $status = $_POST['status'] ;
                                                $engineer = $_POST['engineer'];
                                                $remark = $_POST['remark'];
                                                $schedule_date = $_POST['schedule_date']; 
                                                $statement = "insert into mis_history(mis_id,type,engineer,remark,schedule_date,status,created_at,created_by) values('".$id."','".$status."','".$engineer."','".$remark."','".$schedule_date."','1','".$date."','".$userid."')" ;
                                                mysqli_query($con,"update mis_details set engineer = '".$engineer."' where id = '".$id."'");
                                                
                                            }elseif($_POST['status']=='material_requirement'){
                                                $address = $_POST['address'];
                                                $status = $_POST['status'] ;
                                                $material = $_POST['material'];
                                                $material_condition = $_POST['material_condition'];
                                                $remark = $_POST['remark'];
                                                
                                                $contact_name= $_POST['Contactperson_name'];
                                                $contact_mob = $_POST['Contactperson_mob'];
                                                // $delivery_add = $_POST['address_type'];
                                                $statement = "insert into mis_history(mis_id,type,material,material_condition,remark,status,created_at,created_by,delivery_address,contact_person_name,contact_person_mob) values('".$id."','".$status."','".$material."','".$material_condition."','".$remark."','1','".$date."','".$userid."','".$address."','".$contact_name."','".$contact_mob."')" ;
                                                
                                                mysqli_query($con,"insert into material_inventory(mis_id,material,material_condition,remark,status,created_at,created_by,delivery_address) values('".$id."','".$material."','".$material_condition."','".$remark."','1','".$date."','".$userid."','".$delivery_address."')");
                                                
                                            }elseif($_POST['status']=='material_dispatch'){
                                                $status = $_POST['status'] ;
                                                $courier = $_POST['courier'];
                                                $pod = $_POST['pod'];
                                                $dispatch_date = $_POST['dispatch_date'];
                                                $remark = $_POST['remark'];
                                                $statement = "insert into mis_history(mis_id,type,courier_agency,pod,dispatch_date,remark,status,created_at,created_by) values('".$id."','".$status."','".$courier."','".$pod."','".$dispatch_date."','".$remark."','1','".$date."','".$userid."')" ;
                                            }elseif($_POST['status']=='material_delivered'){
                                                $status = $_POST['status'] ;
                                                $delivery_date = $_POST['delivery_date'];
                                                $statement = "insert into mis_history(mis_id,type,status,created_at,created_by,delivery_date) values('".$id."','".$status."','1','".$date."','".$userid."','".$delivery_date."')" ;
                                            }elseif($_POST['status']=='paste_control'){
                                                $status = $_POST['status'] ;
                                                
                                                if(!is_dir('close_uploads/'.$year .'/'. $month.'/'.$atmid)){
                                                    mkdir('close_uploads/'.$year .'/'. $month .'/'.$atmid , 0777 , true) ; 
                                                }
                                                $target_dir = 'close_uploads/'.$year .'/'. $month.'/'. $atmid ;

                                                $image = $_FILES['image']['name'];
                                                 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .'/' .$image )) {
                                                    $link  = $target_dir . '/' .$image ;
                                                    $remark = $_POST['remark'];
                                                    $statement = "insert into mis_history(mis_id,type,status,created_at,created_by,attachment) values('".$id."','".$status."','1','".$date."','".$userid."','".$link."')" ;
                                                 }   
                                            }elseif($_POST['status']=='close'){
                                                $status = $_POST['status'] ;
                                                $year = date('Y');
                                                $month = date('m');
                                                $close_type = $_POST['close_type'];
                                                $serial_no = $_POST['sno'];
                                                if(!is_dir('close_uploads/'.$year .'/'. $month.'/'.$atmid)){
                                                    mkdir('close_uploads/'.$year .'/'. $month .'/'.$atmid , 0777 , true) ; 
                                                }
                                                $target_dir = 'close_uploads/'.$year .'/'. $month.'/'. $atmid ;
                                                $link = "";
                                                $image = $_FILES['image']['name'];
                                                 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .'/' .$image )) {
                                                    $link  = $target_dir . '/' .$image ;
                                                    
                                                 }
                                                 
                                                 $remark = $_POST['remark'];
                                                    $statement = "insert into mis_history(mis_id,type,attachment,remark,status,created_at,created_by,close_type,serial_number) values('".$id."','".$status."','".$link."','".$remark."','1','".$date."','".$userid."','".$close_type."','".$sno."')" ;
                                                     mysqli_query($con,"update mis_details set close_date = '".$date."' where id = '".$id."'");
                                            }
                                            if(mysqli_query($con,$statement)){
                                            mysqli_query($con,"update mis_details set status = '".$status."' where id = '".$id."'");
                                            
                                            ?>
                                                
                                            <script>
                                                swal("Great !", "Call Updated Successfully !", "success");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="mis_details.php?id=<? echo $id ; ?>";
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
                                        <h5>CALL DISPATCH INFORMATION</h5>

                                        <hr>
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                <th>Sn No</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Date</th>
                                                <th>Schedule Date</th>
                                                <th>Require Material Name </th>
                                                <th>Engineer</th>
                                                <th>POD</th>
                                                <th>Action By</th>
                                                <th>Attchement</th>
                                                <th>Material Delivered Date</th>
                                                <th>Address (Material Requirement)</th>
                                                <th>Serial Number</th>
                                              
                                                <th>Contact Person Name</th>
                                                <th>Contact Person Mobile</th>
                                                
                                                
                                                </tr>

                                            </thead>
                                            <tbody> 
                                                <?
                                                
                                                $his_sql = mysqli_query($con,"select * from mis_history where mis_id ='".$id."'");
                                                $i = 1 ; 
                                                while($his_sql_result = mysqli_fetch_assoc($his_sql)){ 
                                                    $is_material_dept = $his_sql_result['is_material_dept'];
                                                    ?>
                                                    <tr <? if($is_material_dept==1){ ?>  style="background-color: #404e67;color:white;"<? }?>>
                                                        <td><? echo $i ; ?></td>
                                                        <td><? echo $his_sql_result['type'];  ?></td>
                                                        <td><? echo $his_sql_result['remark'];  ?></td>
                                                        <td><? echo $his_sql_result['created_at'];  ?></td>
                                                        <td><? if($his_sql_result['schedule_date']!='0000-00-00'){ echo $his_sql_result['schedule_date']; }  ?></td>
                                                        <td><? echo $his_sql_result['material'];  ?></td>
                                                        <td><? echo $his_sql_result['engineer'];  ?></td>
                                                        <td><? echo $his_sql_result['pod'];  ?></td>
                                                        <td><? echo get_member_name($his_sql_result['created_by']);  ?></td>
                                                        <td> <? if($his_sql_result['attachment']){ ?><a href="<? echo $his_sql_result['attachment'];  ?>" target="_blank">View Attchment</a> <? } ?></td>
                                                        <td><? if($his_sql_result['delivery_date']!='0000-00-00'){ echo $his_sql_result['delivery_date']; }  ?></td>
                                                        <td><? echo $his_sql_result['delivery_address'];  ?></td>
                                                        <td><? echo $his_sql_result['serial_number'];  ?></td>
                                                        
                                                        
                                                        <td><? echo $his_sql_result['contact_person_name'];  ?></td>
                                                        <td><? echo $his_sql_result['contact_person_mob'];  ?></td>
                                                        
                                                    </tr>
                                                <? $i++ ; } ?>

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
        }else if(status == 'schedule'){
            var html = '<input type="hidden" name="status" value="schedule"><div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><? $eng_sql = mysqli_query($con,"select * from mis_loginusers"); while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?> <option value="<? echo $eng_sql_result['id'];?>"><? echo $eng_sql_result['name'];?></option> <? }?></select></div><div class="col-sm-4"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><label>Schedule Date</label><input type="date" name="schedule_date" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'material_requirement'){
            var html = '<input type="hidden" name="status" value="material_requirement"><div class="col-sm-6"><label>Request Material For Site</label><select class="form-control" name="material"><option value="">Select</option><? $mat_sql =mysqli_query($con,"select * from material where status=1 "); while($mat_sql_result = mysqli_fetch_assoc($mat_sql)){ ?> <option value="<? echo $mat_sql_result['material'] ; ?>"><? echo $mat_sql_result['material'] ; ?></option> <? } ?></select></div><div class="col-sm-6"><label>Material Conditions</label><select class="form-control" name="material_condition"><option value="">Select</option><option value="Missing">Missing</option><option value="Faulty">Faulty</option><option value="Not Installed">Not Installed</option></select></div><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-3"><label>Address Type</label><select class="form-control" id="address_type" name="address_type" onchange="setaddress()"><option value="Other" id="Other">Other</option></select></div><div class="col-sm-9" ><label>Address</label> <input class="form-control"  name="address" id="address" /></div><div class="col-sm-4" id="Contactperson_name" ><label for="Contactperson_name" >Contact Person Name</label><input type="text" class="form-control" name="Contactperson_name" id="Contactperson_name_text"></div><div class="col-sm-4" id="Contactperson_mob" ><label for="Contactperson_mob">Contact Person Mobile</label><input type="text" class="form-control" name="Contactperson_mob"id="Contactperson_mob_text" ></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }else if(status == 'material_dispatch'){
            var html = '<input type="hidden" name="status" value="material_dispatch"><div class="col-sm-3"><label>Courier Agency</label><input type="text" name="courier" class="form-control"></div><div class="col-sm-3"><label>POD</label><input type="text" name="pod" class="form-control"></div><div class="col-sm-3"><label>Dispatch Date</label><input type="date" name="dispatch_date" class="form-control"></div><div class="col-sm-3"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-primary" type="submit" value="Update" name="submit"></div>';
        }else if(status == 'close'){
            var html = '<input type="hidden" name="status" value="close"><div class="col-sm-4"><label>Attache File</label><input type="file" name="image" class="form-control"></div><div class="col-sm-4"><label>Serial No</label><input type="text" name="sno" class="form-control"></div><div class="col-sm-4"><label>Close Type</label><select name="close_type" class="form-control"><option value=""> Select </option><option value="replace"> Replace </option><option value="repair"> Repair </option></select></div><div class="col-sm-4"><br><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><br><input class="btn btn-danger" value="Close" type="submit" name="submit"></div>' ;
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