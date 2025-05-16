<?php session_start();
include('config.php');
date_default_timezone_set("Asia/Calcutta");   


if($_SESSION['username']){ 

include('header.php');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                                        <?php
                                        $id = $_GET['id'];
                                        $sql = mysqli_query($con,"select * from mis_detailsTest  where id= '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        
                                        $mis_id = $sql_result['mis_id']; 
                                        
                                        
                                        $atmid = $sql_result['atmid'];
                                        $date = date('Y-m-d');
                                        $userid = $_SESSION['userid'];
                                        
                                        $ide = $sql_result['id'];
                                        
                                        // echo "select * from mis_historyTest  where mis_id = '".$ide."' " ; 
                                        $detail_history = mysqli_query($con,"select * from mis_historyTest  where mis_id = '".$ide."' ");
                                        $fetch_detail_history = mysqli_fetch_assoc($detail_history);
                                        
                                        $address_history = $fetch_detail_history['delivery_address'];
                                        $mobile = $fetch_detail_history['contact_person_mob'];
                                        $name = $fetch_detail_history['contact_person_name'];
                                        // echo "<script> alert($name); </script>";
                                        
                                        $sql1 = mysqli_query($con,"select * from misTest where id = '".$mis_id."'");
                                        $sql1_result = mysqli_fetch_assoc($sql1);
                                        $branch = $sql1_result['branch'];
                                        
                                        
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
                                                                                <td><?php echo $sql_result['ticket_id'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">ATM ID</th>
                                                                                <td>
                                                                                    <span><?php echo $sql_result['atmid'];?></span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Bank</th>
                                                                                <td><?php echo $sql1_result['bank'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Location</th>
                                                                                <td><?php echo $sql1_result['location'];?></td>
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
                                                                                <td><?php echo $sql1_result['city'];?></td>
                                                                            </tr>
                                                                            
                                                                                <th scope="row">State</th>
                                                                                <td><?php echo $sql1_result['state'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Zone</th>
                                                                                <td><?php echo $sql1_result['zone'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Status</th>
                                                                                <td><?php echo $sql_result['status'];?></td>
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
                                        <?php
                                        $id = $_GET['id'];
                                        $sql = mysqli_query($con,"select * from mis_detailsTest  where id= '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                        
                                        $mis_id = $sql_result['mis_id']; 
                                        
                                        $mis_status = $sql_result['status'];
                                        // echo $mis_status;
                                        $status_view = 0;
                                         if($mis_status=='material_in_process'){
                                             $status_view = 1;
                                         }
                                        
                                        $sql1 = mysqli_query($con,"select * from misTest where id = '".$mis_id."'");
                                        $sql1_result = mysqli_fetch_assoc($sql1);
                                        
                                        $date = date('Y-m-d H:i:s');
                                        $date1 = date('Y-m-d');
                                        $date1=date_create($date1);
                                        $date2=date_create($sql_result['created_at']);
                                        $diff=date_diff($date1,$date2);
                                        $branch = $sql1_result['branch'];
                                        
                                        
                                        
                                        $branch_sql = mysqli_query($con,"Select * from mis_city where city like '%".$branch."%'");
                                        $branch_sql_result = mysqli_fetch_assoc($branch_sql) ; 
                                        
                                        $branch_id = $branch_sql_result['id'];
                                        
                                        
                                        
        
        
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
                                                                                <td><?php echo $sql_result['ticket_id'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Assigned Engineer</th>
                                                                                <td><?php ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Current Status</th>
                                                                                <td><?php echo $sql_result['status'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Component</th>
                                                                                <td><?php echo $sql_result['component'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Sub Component</th>
                                                                                <td><?php echo $sql_result['subcomponent'];?></td>
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
                                                                                    <span><?php echo $sql_result['created_at'];?></span>
                                                                                </td>
                                                                            </tr>
                                                                            
                                                                                <th scope="row">Created By</th>
                                                                                <td><?php echo get_member_name($sql1_result['created_by']);?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Down Time </th>
                                                                                <td><?php echo $diff->format("%a days");?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Remark</th>
                                                                                <td><?php echo $sql1_result['remarks']; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Branch</th>
                                                                                <td><?php echo $branch ;  ?></td>
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
                                                    
                                                    <?php if($mis_status == 'open' || $mis_status == 'Open') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="permission_require">Permission Required</option>
                                                        <option value="MRS">Material Pending</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'schedule' || $mis_status == 'schedule ' ) {?>
                                                        <option value="">Select</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="permission_require">Permission Required</option>
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="MRS">Material Pending</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_requirement') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>
                                                        <option value="material_dispatch">Material Dispatch</option>
                                                        <option value="material_in_process">Material in Process</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php }
                                                    
                                                   
                                                    
                                                    if($mis_status == 'fund_required') {?>
                                                        <option value="">Select</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="schedule">Schedule</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_dispatch') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="permission_require">Permission Required</option>     
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'close') {?>
                                                        <option value="">Select</option>
                                                        <option value="reopen">Reopen</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'permission_require') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_requirement">Material Requirement</option> 
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                   
                                                    if($mis_status == 'available') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option>    
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_dispatch">Material Dispatch</option> 
                                                        <option value="permission_require">Permission Required</option>     
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'cancelled') {?>
                                                        <option value="">Select</option>
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'MRS') {?>
                                                        <option value="">Select</option>
                                                        <option value="material_dispatch">Material Dispatch</option> 
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="material_requirement">Material Requirement</option> 
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_in_process') {?>
                                                        <option value="">Select</option>
                                                        <option value="close">Close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'material_delivered') {?>
                                                        <option value="">Select</option>
                                                        <option value="close">Close</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'customer_issue'  ) {?>
                                                        <option value="">Select</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="permission_require">Permission Required</option>
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="MRS">Material Pending</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'submitted'  ) {?>
                                                        <option value="">Select</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="permission_require">Permission Required</option>
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="MRS">Material Pending</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    if($mis_status == 'not_submitted'  ) {?>
                                                        <option value="">Select</option>
                                                        <option value="material_requirement">Material Requirement</option>
                                                        <option value="permission_require">Permission Required</option>
                                                        <option value="fund_required"> Fund Requirement</option>
                                                        <option value="schedule"> Schedule</option> 
                                                        <option value="MRS">Material Pending</option>
                                                        <option value="close">close</option>
                                                        <option value="customer_issue">Customer Issue</option>
                                                        <option value="submitted">Submitted</option>
                                                        <option value="not_submitted">Not Submitted</option>
                                                    <?php } 
                                                    
                                                    
                                                    ?>
                                                    
                                                    <!--<option value="update">Update</option>-->
                                                    
                                                </select> 
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        
                                        
                                        
                                        
                                        <?php
                                        

                                        $year = date('Y');
                                        $month = date('m');
                                        
                                        if(isset($_POST['status'])){

                                            if($_POST['status']=='dispatch' || $_POST['status']=='MRS' || $_POST['status'] =='permission_require' || $_POST['status']=='broadband' || $_POST['status']=='material_not_available' || $_POST['status'] =='material_available_in_branch'){
                                                $remark = $_POST['remark'];
                                                $status = $_POST['status'] ;
                                                echo $statement = "insert into mis_historyTest (mis_id,type,remark,status,created_at,created_by) values('".$id."','".$status."','".$remark."','1','".$date."','".$userid."')" ;
                                            }
                                            elseif($_POST['status']=='schedule'){
                                                $status = $_POST['status'] ;
                                                $engineer = $_POST['engineer'];
                                                $remark = $_POST['remark'];
                                                $schedule_date = $_POST['schedule_date']; 
                                                $statement = "insert into mis_historyTest (mis_id,type,engineer,remark,schedule_date,status,created_at,created_by,atmid) 
                                                values('".$id."','".$status."','".$engineer."','".$remark."','".$schedule_date."','1','".$date."','".$userid."','".$atmid."')" ;
                                                mysqli_query($con,"update mis_detailsTest  set engineer = '".$engineer."' where id = '".$id."'");
                                                
                                            }
                                            elseif($_POST['status']=='material_requirement'){
                                                $address = $_POST['address'];
                                                $status = $_POST['status'] ;
                                                $material = $_POST['material'];
                                                $material_condition = $_POST['material_condition'];
                                                $remark = $_POST['remark'];
                                                
                                                $emailAttachment_MaterialRequirement = $_FILES['emailAttachment_MaterialRequirement']['name'];
                                                $images_MaterialRequirement = $_FILES['images_MaterialRequirement']['name'];
                                                
                                                
                                                
                                                
                                                 if(!is_dir('MaterialRequirement/'.$year .'/'. $month.'/'.$atmid)){
                                                    mkdir('MaterialRequirement/'.$year .'/'. $month .'/'.$atmid , 0777 , true) ; 
                                                }
                                                // $MR_ = Material Requirement
                                                $MR_target_dir = 'MaterialRequirement/'.$year .'/'. $month.'/'. $atmid ;

                                                $emailAttachment_MaterialRequirement = $_FILES['emailAttachment_MaterialRequirement']['name'];
                                                 if (move_uploaded_file($_FILES["emailAttachment_MaterialRequirement"]["tmp_name"], $MR_target_dir .'/' .$emailAttachment_MaterialRequirement )) {
                                                    $emailAttachment_MaterialRequirementLink  = $MR_target_dir . '/' .$emailAttachment_MaterialRequirement ;
                                                 }
                                               
                                               
                                               
                                               $imageUrls = [];

                                                if(isset($_FILES['images_MaterialRequirement'])){
                                                    foreach ($_FILES['images_MaterialRequirement']['name'] as $index => $image_name) {
                                                        $image_tmp = $_FILES['images_MaterialRequirement']['tmp_name'][$index];
                                                        $image_url = $MR_target_dir . '/' . $image_name;
                                                
                                                        if (move_uploaded_file($image_tmp, $image_url)) {
                                                            $imageUrls[] = $image_url; // Store the URL in the array
                                                        } else {
                                                            echo "Error uploading file " . $image_name . "<br>";
                                                        }
                                                    }
                                                } else {
                                                    echo "No images uploaded.<br>";
                                                }
                                                
                                                // Convert the array of URLs to a comma-separated string
                                                $imageUrlsString = implode(',', $imageUrls);

   
                                                
                                                
                                                
                                                
                                                
                                                $contact_name= $_POST['Contactperson_name'];
                                                $contact_mob = $_POST['Contactperson_mob'];
                                                // $delivery_add = $_POST['address_type'];
                                                $statement = "insert into mis_historyTest (mis_id,type,material,material_condition,remark,status,created_at,created_by,delivery_address,contact_person_name,contact_person_mob,emailAttachment_MaterialRequirement,images_MaterialRequirement) 
                                                
                                                values('".$id."','".$status."','".$material."','".$material_condition."','".$remark."','1','".$date."','".$userid."','".$address."','".$contact_name."','".$contact_mob."','".$emailAttachment_MaterialRequirementLink."','".$imageUrlsString."')" ;
                                                
                                                mysqli_query($con,"insert into pre_material_inventory(mis_id,material,material_condition,remark,status,created_at,created_by,delivery_address) values('".$id."','".$material."','".$material_condition."','".$remark."','1','".$datetime."','".$userid."','".$delivery_address."')");
                                                
                                            }
                                            elseif($_POST['status']=='material_dispatch'){
                                                $status = $_POST['status'] ;
                                                $courier = $_POST['courier'];
                                                $pod = $_POST['pod'];
                                                $dispatch_date = $_POST['dispatch_date'];
                                                $remark = $_POST['remark'];
                                                $statement = "insert into mis_historyTest (mis_id,type,courier_agency,pod,dispatch_date,remark,status,created_at,created_by) values('".$id."','".$status."','".$courier."','".$pod."','".$dispatch_date."','".$remark."','1','".$date."','".$userid."')" ;
                                            }
                                            elseif($_POST['status']=='update'){
                                                $status = $_POST['status'] ;
                                                $remark = $_POST['remark'];
                                                $statement = "insert into mis_historyTest (mis_id,type,remark,status,created_at,created_by) 
                                                values('".$id."','".$status."','".$remark."','1','".$date."','".$userid."')" ;
                                            }
                                            elseif($_POST['status']=='material_delivered'){
                                                $status = $_POST['status'] ;
                                                $delivery_date = $_POST['delivery_date'];
                                                $statement = "insert into mis_historyTest (mis_id,type,status,created_at,created_by,delivery_date) values('".$id."','".$status."','1','".$date."','".$userid."','".$delivery_date."')" ;
                                            }
                                            elseif($_POST['status']=='paste_control'){
                                                $status = $_POST['status'] ;
                                                
                                                if(!is_dir('close_uploads/'.$year .'/'. $month.'/'.$atmid)){
                                                    mkdir('close_uploads/'.$year .'/'. $month .'/'.$atmid , 0777 , true) ; 
                                                }
                                                $target_dir = 'close_uploads/'.$year .'/'. $month.'/'. $atmid ;

                                                $image = $_FILES['image']['name'];
                                                 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .'/' .$image )) {
                                                    $link  = $target_dir . '/' .$image ;
                                                    $remark = $_POST['remark'];
                                                    $statement = "insert into mis_historyTest (mis_id,type,status,created_at,created_by,attachment) values('".$id."','".$status."','1','".$date."','".$userid."','".$link."')" ;
                                                 }   
                                            }
                                            elseif($_POST['status']=='close'){
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
                                                $link2 = "";
                                                $image = $_FILES['image']['name'];
                                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .'/' .$image )) {
                                                    $link  = $target_dir . '/' .$image ;
                                                }
                                                 
                                                $image2 = $_FILES['image2']['name'];
                                                if (move_uploaded_file($_FILES["image2"]["tmp_name"], $target_dir .'/' .$image2 )) {
                                                    $link2  = $target_dir . '/' .$image2 ;
                                                }
                                                
                                                $engineer = $_POST['engineer'];
                                                $remark = $_POST['remark'];
                                                $oldMaterialDetails = $_POST['oldMaterialDetails'];
                                                $statement = "insert into mis_historyTest (mis_id,type,attachment,attachment2,remark,status,created_at,created_by,close_type,serial_number,oldMaterialDetails) values('".$id."','".$status."','".$link."','".$link2."','".$remark."','1','".$date."','".$userid."','".$close_type."','".$sno."','".$oldMaterialDetails."')" ;
                                                mysqli_query($con,"update mis_detailsTest  set close_date = '".$date."' where id = '".$id."'");
                                            }
                                            elseif($_POST['status']=='fund_required' || $_POST['status']=='customer_dependency'){
                                                $remark = $_POST['remark'];
                                                $status = $_POST['status'];
                                                $statement = "insert into mis_historyTest (mis_id,type,remark,created_at,created_by) values('".$id."','".$status."','".$remark."','".$date."','".$userid."')" ;
                                            }
                                            elseif($_POST['status']=='reopen'){
                                                $remark = $_POST['remark'];
                                                $status = $_POST['status'];
                                                $statement = "insert into mis_historyTest (mis_id,type,remark,created_at,created_by) values('".$id."','".$status."','".$remark."','".$date."','".$userid."')" ;
                                                
                                                mysqli_query($con,"update mis_detailsTest set status = 'open', close_date = '' where id = '".$id."' ");
                                            }
                                            elseif($_POST['status']=='customer_issue'){
                                                $status = $_POST['status'] ;
                                                $year = date('Y');
                                                $month = date('m');
                                                
                                                
                                                if(!is_dir('customer_issue/'.$year .'/'. $month.'/'.$atmid)){
                                                    mkdir('customer_issue/'.$year .'/'. $month .'/'.$atmid , 0777 , true) ; 
                                                }
                                                $target_dir = 'customer_issue/'.$year .'/'. $month.'/'. $atmid ;
                                                $link = "";
                                               
                                                $image = $_FILES['issue_file']['name'];
                                                if (move_uploaded_file($_FILES["issue_file"]["tmp_name"], $target_dir .'/' .$image )) {
                                                    $link  = $target_dir . '/' .$image ;
                                                }
                                                 
                                                
                                                $engineer = $_POST['engineer'];
                                                $remark = $_POST['remark'];
                                                
                                                $statement = "insert into mis_historyTest (mis_id,type,engineer,remark,created_at,created_by,customerIssue_Attachment) values('".$id."','".$status."','".$engineer."','".$remark."','".$date."','".$userid."','".$link."')" ;
                                                
                                                mysqli_query($con,"update mis_detailsTest set status = '".$status."'  where id = '".$id."'");
                                            }
                                            elseif($_POST['status']=='submitted'){
                                                $remark = $_POST['remark'];
                                                $status = $_POST['status'];
                                                $statement = "insert into mis_historyTest (mis_id,type,remark,created_at,created_by) values('".$id."','".$status."','".$remark."','".$date."','".$userid."')" ;
                                                
                                                mysqli_query($con,"update mis_detailsTest set status = 'submitted', close_date = '' where id = '".$id."' ");
                                            }
                                            elseif($_POST['status']=='not_submitted'){
                                                
                                                $remark = $_POST['remark'];
                                                $status = $_POST['status'];
                                                $issues = $_POST['issue_list'];
                                                $otherIssues = $_POST['otherIssues'];
                                                
                                                
                                                $statement = "insert into mis_historyTest (mis_id,type,remark,created_at,created_by,notSubmitted_Issues,OtherIssues) values('".$id."','".$status."','".$remark."','".$date."','".$userid."','".$issues."','".$otherIssues."')" ;
                                                
                                                mysqli_query($con,"update mis_detailsTest set status = 'not_submitted' where id = '".$id."' ");
                                            }
                                            
                                            
                                            echo $statement;
                                            // die;
                                            
                                            
                                            if(mysqli_query($con,$statement)){
                                                if($status == 'reopen'){
                                                    $status = 'open';
                                                } else {
                                                    $status = $_POST['status'];
                                                }
                                            mysqli_query($con,"update mis_detailsTest  set status = '".$status."' where id = '".$id."'");
                                            
                                            ?>
                                                
                                            <script>
                                                swal("Great !", "Call Updated Successfully !", "success");
                                                
                                                    setTimeout(function(){ 
                                                        // window.location.href="mis_detailsTest_raj.php?id=<?php echo $id ; ?>";
                                                        window.location.href="mis_detailsTest.php?id=<?php echo $id ; ?>";
                                                        // window.location.reload();
                                                    }, 2000);

                                            </script>
                                            <?php }else{ 
                                            
                                            echo mysqli_error($con);
                                            ?>
                                               
                                            <script>
                                                swal("Oops !", "Call Updated Error !", "error");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="mis_detailsTest.php?id=<?php echo $id ; ?>";
                                                    }, 2000);

                                            </script>
                                            
                                            <?php } }
                                        
                                        ?>
                                        
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>?id=<?php echo $id ;?>" method="POST" enctype="multipart/form-data">
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
                                                    <th>Attchement 2</th>
                                                    <th>Material Delivered Date</th>
                                                    <th>Address (Material Requirement)</th>
                                                    <th>Serial Number</th>
                                                    <th>Contact Person Name</th>
                                                    <th>Contact Person Mobile</th>
                                                    <th>Customer Issue Attachment</th>
                                                    <th>Not Submitted Issues</th>
                                                    <th>Other Issues</th>
                                                    
                                                </tr>

                                            </thead>
                                            <tbody> 
                                                <?php
                                                
                                                $his_sql = mysqli_query($con,"select * from mis_historyTest  where mis_id ='".$id."'");
                                                $i = 1 ; 
                                                while($his_sql_result = mysqli_fetch_assoc($his_sql)){ 
                                                    $is_material_dept = $his_sql_result['is_material_dept'];
                                                    ?>
                                                    <tr <?php if($is_material_dept==1){ ?>  style="background-color: #404e67;color:white;"<?php }?>>
                                                        <td><?php echo $i ; ?></td>
                                                        <td><?php echo $his_sql_result['type'];  ?></td>
                                                        <td><?php echo $his_sql_result['remark'];  ?></td>
                                                        <td><?php echo $his_sql_result['created_at'];  ?></td>
                                                        <td><?php if($his_sql_result['schedule_date']!='0000-00-00'){ echo $his_sql_result['schedule_date']; }  ?></td>
                                                        <td><?php echo $his_sql_result['material'];  ?></td>
                                                        <td><?php echo get_member_name($his_sql_result['engineer']);  ?></td>
                                                        <td><?php echo $his_sql_result['pod'];  ?></td>
                                                        <td><?php 
                                                        
                                                        if($is_material_dept==1){
                                                            $material_dept_userid = $his_sql_result['material_dept_userid'] ; 
                                                            
                                                            echo getesurvUsername($material_dept_userid) ; 
                                                        }else{
                                                            echo get_member_name($his_sql_result['created_by']);                                                            
                                                        }
                                                        

                                                        
                                                        
                                                        ?></td>
                                                        <td> <?php if($his_sql_result['attachment']){ ?><a href="<?php echo $his_sql_result['attachment'];  ?>" target="_blank">View Attchment</a> <?php } ?></td>
                                                        <td> <?php if($his_sql_result['attachment2']){ ?><a href="<?php echo $his_sql_result['attachment2'];  ?>" target="_blank">View Attchment</a> <?php } ?></td>
                                                        
                                                        <td><?php if($his_sql_result['delivery_date']!='0000-00-00'){ echo $his_sql_result['delivery_date']; }  ?></td>
                                                        <td><?php echo $his_sql_result['delivery_address'];  ?></td>
                                                        <td><?php echo $his_sql_result['serial_number'];  ?></td>
                                                        
                                                        
                                                        <td><?php echo $his_sql_result['contact_person_name'];  ?></td>
                                                        <td><?php echo $his_sql_result['contact_person_mob'];  ?></td>
                                                        <td> <?php if($his_sql_result['customerIssue_Attachment']){ ?><a href="<?php echo $his_sql_result['customerIssue_Attachment'];  ?>" target="_blank">View Attchment</a> <?php } ?></td>
                                                        <td><?php echo $his_sql_result['notSubmitted_Issues'];  ?></td>
                                                        <td><?php echo $his_sql_result['OtherIssues'];  ?></td>
                                                        
                                                        
                                                    </tr>
                                                <?php $i++ ; } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>     
                                
                            </div>
                        </div>

 
                    </div>
                </div>
            </div>
                    
                    
    <?php include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="=login.php";
    </script>
<?php }
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
<!--            var html = '<input type="hidden" name="status" value="material_requirement"><div class="col-sm-6"><label>Material</label><select class="form-control" name="material"><option value="">Select</option><?php $mat_sql =mysqli_query($con,"select * from material where status=1 "); while($mat_sql_result = mysqli_fetch_assoc($mat_sql)){ ?> <option value="<?php echo $mat_sql_result['id'] ; ?>"><?php echo $mat_sql_result['material'] ; ?></option> <?php } ?></select></div><div class="col-sm-6"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-12"><label>Address</label><input class="form-control" name="address"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';-->
<!--        }-->
<script>


  function throttle(f, delay){
        var timer = null;
        return function(){
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = window.setTimeout(function(){
                f.apply(context, args);
            },
            delay || 1000);
        };
    }
    

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
        
        
    
    if(status=='update'){
            var html = '<input type="hidden" name="status" value="update"><div class="col-sm-12"><label>Update Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
    }
        else if(status == 'dispatch'){
            var html = '<input type="hidden" name="status" value="dispatch"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'schedule'){
            var html = '<input type="hidden" name="status" value="schedule"><div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><?$eng_sql = mysqli_query($con, "SELECT * FROM mis_loginusers where user_status=1 and designation=4"); while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?> <option value="<?php echo $eng_sql_result['id'];?>"><?php echo $eng_sql_result['name'];?></option> <?php }?></select></div><div class="col-sm-4"><label>Schedule Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><label>Schedule Date</label><input type="date" name="schedule_date" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'material_requirement'){
        // var html = '<input type="hidden" name="status" value="material_requirement"><div class="col-sm-6"><label>Request Material For Site</label><select class="form-control" name="material"><option value="">Select</option><?php $mat_sql =mysqli_query($con,"select * from material where status=1 "); while($mat_sql_result = mysqli_fetch_assoc($mat_sql)){ ?> <option value="<?php echo $mat_sql_result['material'] ; ?>"><?php echo $mat_sql_result['material'] ; ?></option> <?php } ?></select></div><div class="col-sm-6"><label>Material Conditions</label><select class="form-control" name="material_condition"><option value="">Select</option><option value="Missing">Missing</option><option value="Faulty">Faulty</option><option value="Not Installed">Not Installed</option></select></div><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-3"><label>Address Type</label><select class="form-control" id="address_type" name="address_type" onchange="setaddress()"  ><option value="Other" id="Other">Other</option></select></div><div class="col-sm-9" ><label>Address</label> <input class="form-control"  name="address" id="address" value="<?php echo $address_history; ?>" /></div><div class="col-sm-4" id="Contactperson_name" ><label for="Contactperson_name" >Contact Person Name</label><input type="text" class="form-control" name="Contactperson_name" id="Contactperson_name_text" value="<?php echo $name;  ?>"></div><div class="col-sm-4" id="Contactperson_mob" ><label for="Contactperson_mob">Contact Person Mobile</label><input type="text" class="form-control" name="Contactperson_mob"id="Contactperson_mob_text" value="<?php echo $mobile; ?>" ></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
           var html = `<input type="hidden" name="status" value="material_requirement">
           <div class="col-sm-6">
           <label>Request Material For Site</label>
           <select class="form-control" name="material">
           <option value="">Select</option>
           <?php $mat_sql =mysqli_query($con,"select * from material where status=1 "); 
           while($mat_sql_result = mysqli_fetch_assoc($mat_sql)){ ?>
           <option value="<?php echo $mat_sql_result['material'] ; ?>">
           <?php echo $mat_sql_result['material'] ; ?></option> <?php } ?>
           </select>
           </div>
           <div class="col-sm-6"><label>Material Conditions</label><select class="form-control" name="material_condition"><option value="">Select</option><option value="Missing">Missing</option><option value="Faulty">Faulty</option><option value="Not Installed">Not Installed - By Project Team</option></select></div>
           <div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div>
           <?php if ($address_history != '') {?> 
           <div class="col-sm-12"><label>Dispatch Address 1 </label><input class="form-control" name="address" id="address" value="<?php echo remove_special($address_history); ?>" ></div>
           <?php } else {?> <div class="col-sm-12"><label> Dispatch Address 2</label>
           <input list="item_name" class="form-control" name="address" id="address" value="<?php echo remove_special($address_history); ?>">
           <datalist id="item_name">  </datalist>
           </div> <?php } if ($name != '') {?>
           <div class="col-sm-4" id="Contactperson_name"><label for="Contactperson_name">Contact Person Name</label><input type="text" class="form-control" name="Contactperson_name" id="Contactperson_name_text" value="<?php echo $name; ?>" readonly="readonly"></div> 
           <?php } else {?> <div class="col-sm-4" id="Contactperson_name"><label for="Contactperson_name">Contact Person Name</label><input type="text" class="form-control" name="Contactperson_name" id="Contactperson_name_text" value="<?php echo $name; ?>"></div>
           <?php }  if ($mobile != '') {?> <div class="col-sm-6" id="Contactperson_mob"><label for="Contactperson_mob">Contact Person Mobile</label><input type="text" class="form-control" name="Contactperson_mob" id="Contactperson_mob_text" value="<?php echo $mobile; ?>" readonly="readonly"></div> 
           <?php } else {?> <div class="col-sm-6" id="Contactperson_mob"><label for="Contactperson_mob">Contact Person Mobile</label><input type="text" class="form-control" name="Contactperson_mob" id="Contactperson_mob_text" value="<?php echo $mobile; ?>"></div> <?php }?> 
           <div class="col-sm-12"><br /></div>
           <div class="col-sm-6"><label>Email Attachment</label><input type="file" class="form-control" name="emailAttachment_MaterialRequirement" required /></div>
           <div class="col-sm-6"><label>Image (multiple)</label><input type="file" class="form-control"  name="images_MaterialRequirement[]" required multiple /></div>
           
           <div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>`;  
            
        }
        else if(status == 'material_dispatch'){
            var html = '<input type="hidden" name="status" value="material_dispatch"><div class="col-sm-3"><label>Courier Agency</label><input type="text" name="courier" class="form-control"></div><div class="col-sm-3"><label>POD</label><input type="text" name="pod" class="form-control"></div><div class="col-sm-3"><label>Dispatch Date</label><input type="date" name="dispatch_date" class="form-control"></div><div class="col-sm-3"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-primary" type="submit" value="Update" name="submit"></div>';
        }
        else if(status == 'close'){

            var html = `<input type="hidden" name="status" value="close">
            <div class="col-sm-3"><label>Before Work</label><input type="file" name="image" class="form-control"></div>
            <div class="col-sm-3"><label>After Work</label><input type="file" name="image2" class="form-control" required></div>
            <div class="col-sm-3"><label>Serial No</label><input type="text" name="sno" class="form-control"></div>
            <div class="col-sm-3"><label>Close Type</label><select name="close_type" id="close_type" class="form-control" required><option value=""> Select </option><option value="replace"> Replace </option><option value="repair"> Repair </option><option value="Footage Call"> Footage Call </option></select></div>
            <div class="col-sm-12 oldMaterialDetails" style="display:none;">
            <br />
                <label>Old Material Details</label>
                <select name="oldMaterialDetails" id="oldMaterialDetails" class="form-control">
                  <option>-- Select --</option>
                  <option value="Old Material with Engineer">Old Material with Engineer</option>
                  <option value="Old Material Missing">Old Material Missing</option>
                  <option value="Old Material Scrap">Old Material Scrap</option>
                  <option value="Old Material in Service Center">Old Material in Service Center</option>
                  <option value="Old Material in Branch Office">Old Material in Branch Office</option>
                  <option value="Old Material in Dispached to Mumbai">Old Material in Dispached to Mumbai</option>
                </select>  
                </div>
            <div class="col-sm-4"><br><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><label>Engineer</label><select name="engineer" class="form-control"><option value="">Select</option> <?php $branch_sql = mysqli_query($con,"select distinct(engineer_user_id) as engid from mis_newsite where branch = '".$branch."' and engineer_user_id<>'' "); if(mysqli_num_rows($branch_sql)>0) { while($branchsqlres = mysqli_fetch_assoc($branch_sql)){ $eng_userid = $branchsqlres['engid']; $eng_sql = mysqli_query($con,"select name, id from mis_loginusers where id = '".$eng_userid."' "); $eng_sql_result = mysqli_fetch_assoc($eng_sql); ?><option value="<?php echo $eng_sql_result['id'];?>"><?php echo $eng_sql_result['name'];?></option> <?php } }?></select></div><div class="col-sm-4"><br><br><input class="btn btn-danger" value="Close" type="submit" name="submit"></div>` ;
        }
        else if(status == 'paste_control'){
            var html = '<input type="hidden" name="status" value="paste_control"><div class="col-sm-4"><label>Attache File</label><input type="file" name="image" class="form-control"></div><div class="col-sm-4"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-danger" value="Submit" type="submit" name="submit"></div>' ;
        }
        else if(status == 'material_available_in_branch'){
                var html = '<input type="hidden" name="status" value="material_available_in_branch"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'material_not_available'){
                var html = '<input type="hidden" name="status" value="material_not_available"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'broadband'){
                var html = '<input type="hidden" name="status" value="broadband"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'permission_require'){
                var html = '<input type="hidden" name="status" value="permission_require"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'reopen'){
                var html = '<input type="hidden" name="status" value="reopen"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'material_delivered'){
                var html = '<input type="hidden" name="status" value="material_delivered"><div class="col-sm-6"><label>Delivery Date</label><input type="date" name="delivery_date" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'MRS'){
                var html = '<input type="hidden" name="status" value="MRS"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'fund_required'){
                var html = '<input type="hidden" name="status" value="fund_required"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        else if(status == 'customer_dependency'){
                var html = '<input type="hidden" name="status" value="customer_dependency"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }  else if(status == 'customer_issue'){
            var html = '<input type="hidden" name="status" value="customer_issue"><div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><?$eng_sql = mysqli_query($con, "SELECT * FROM mis_loginusers where user_status=1 and designation=4"); while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?> <option value="<?php echo $eng_sql_result['id'];?>"><?php echo $eng_sql_result['name'];?></option> <?php }?></select></div><div class="col-sm-4"><label>Engineer Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><label>Attachment</label><input type="file" name="issue_file" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }  
        else if(status == 'not_submitted'){
            var html = '<input type="hidden" name="status" value="not_submitted"><div class="col-sm-4"><label>Engineer</label><select name="engineer" class="form-control js-example-basic-single"><option value="">Select</option><?php $eng_sql = mysqli_query($con, "SELECT * FROM mis_loginusers where user_status=1 and designation=4"); while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?> <option value="<?php echo $eng_sql_result['id'];?>"><?php echo $eng_sql_result['name'];?></option> <?php }?></select></div><div class="col-sm-4"><label>Engineer Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><label>Issues</label><select name="issue_list"  id="issue_list" class="form-control"><option value="">Select</option><option value="HDD Faulty">HDD Faulty</option><option value="HO Team">HO Team</option><option value="HDD Not Installed">HDD Not Installed</option><option value="HDD Missing">HDD Missing</option><option value="DVR Faulty">DVR Faulty</option><option value="DVR Missing">DVR Missing</option value="NVR Faulty">NVR Faulty<option value="NVR Missing">NVR Missing</option><option value="NVR Not Installed">NVR Not Installed</option><option value="Camera Missing">Camera Missing</option><option value="Camera Not Installed">Camera Not Installed</option><option value="Camera faulty">Camera faulty</option><option value="SMPS Issue">SMPS Issue</option><option value="Given Date Footage Missing">Given Date Footage Missing</option><option value="Given Time Footage Missing">Given Time Footage Missing</option><option value="SD Card Faulty">SD Card Faulty</option><option value="SD Card Missing">SD Card Missing</option><option value="SD Card Not Installed">SD Card Not Installed</option><option value="Other">Other</option></select></div><br><div class="col-sm-12 otherIssues" style="display:none;"><br><br><label>Other Issues</label><br><input type="text" name="otherIssues" id="otherIssues" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit" ></div>';
        }
        else if(status == 'submitted'){
                var html = '<input type="hidden" name="status" value="submitted"><div class="col-sm-12"><label>Remark</label><input type="text" name="remark" class="form-control"></div><div class="col-sm-4"><br><input class="btn btn-success" type="submit" name="submit"></div>';
        }
        
        $("#status_col").html(html);
        $(".js-example-basic-single").select2();
        // $(".engsearch").select2();
    });


$(document).on('change','#close_type',function(){
    let close_type = $("#close_type").val();
    
    if(close_type=='replace'){
        $(".oldMaterialDetails").css('display','block');
    }else{
        $(".oldMaterialDetails").css('display','none');
    }
})

$(document).on('change','#issue_list',function(){
    let Other = $("#issue_list").val();
    
    if(Other=='Other'){
        $(".otherIssues").css('display','block');
    }else{
        $(".otherIssues").css('display','none');
    }
})


$(document).on('keyup','#address',throttle(function(){
   $("#item_name").html('');
   add = $(this).val();
          $.ajax({
            type: "POST",
            url: 'suggested_address.php',
            data: 'address=' + add,
            success:function(msg) {
             
             $("#item_name").append(msg);
             
                
            }
          });
//   alert(add);
}));
    
    </script>
</body>

</html>