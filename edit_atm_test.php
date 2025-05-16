<?php session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <?php                                
                        $id = $_GET['id'];
                        // echo $id;
                        $sql= mysqli_query($con,"select * from mis_newsite where id='".$id."'");
                        $sql_result = mysqli_fetch_assoc($sql);
                        $Regional_Coordinator = $sql_result['Regional_Coordinator'];
                        $Surveillance_Head = $sql_result['Surveillance_Head'];
                        
                        // $status= $sql_result['status'];
                        // echo $status;
                       
                        
                        $user_data_sql = mysqli_query($con,"select id,name from mis_loginusers where designation='4' order by name asc ");
                    ?>
                    <div class="card">
                        <div class="card-body">

                            <form action="process_editatm_test.php" method="POST">
                                
                                <div class="row">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <div class="col-sm-3">
                                        <label>activity</label>
                                        <input type="text" name="activity" class="form-control"
                                            value="<?php echo $sql_result['activity'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>customer</label>
                                        <input type="text" name="customer" class="form-control"
                                            value="<?php echo $sql_result['customer'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>bank</label>
                                        <input type="text" name="bank" class="form-control"
                                            value="<?php echo $sql_result['bank'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>atmid</label>
                                        <input type="text" name="atmid" class="form-control"
                                            value="<?php echo $sql_result['atmid'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>trackerno</label>
                                        <input type="text" name="trackerno" class="form-control"
                                            value="<?php echo $sql_result['trackerno'];?>">
                                    </div>

                                    <div class="col-sm-5">
                                        <label>address</label>
                                        <input type="text" name="address" class="form-control"
                                            value="<?php echo $sql_result['address'];?>">
                                    </div>

                                    <div class="col-sm-2">
                                        <label>city</label>
                                        <input type="text" name="city" class="form-control"
                                            value="<?php echo $sql_result['city'];?>">
                                    </div>

                                    <div class="col-sm-2">
                                        <label>state</label>
                                        <input type="text" name="state" class="form-control"
                                            value="<?php echo $sql_result['state'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>zone</label>
                                        <input type="text" name="zone" class="form-control"
                                            value="<?php echo $sql_result['zone'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>branch</label>
                                        <input type="text" name="branch" class="form-control"
                                            value="<?php echo $sql_result['branch'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>bm_name</label>
                                        <input type="text" name="bm_name" class="form-control"
                                            value="<?php echo $sql_result['bm_name'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label>bm_number</label>
                                        <input type="text" name="bm_number" class="form-control"
                                            value="<?php echo $sql_result['bm_number'];?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="">engineer</label>
                                        <select class="form-control" name="engineer_user_id" required>
                                            <option value="">Select Engineer</option>
                                            <?php $engineer_id = $sql_result['engineer_user_id'];
                                            while($user_data_sql_result = mysqli_fetch_assoc($user_data_sql)){
                                                $user_name = $user_data_sql_result['name'];
                                                $user_id = $user_data_sql_result['id'];
                                            ?>
                                            <option value="<?php echo trim($user_id); ?>"
                                                <?php if($user_id==$engineer_id){ echo 'selected';}?>>
                                                <?php echo trim($user_name); ?> (<?php echo trim($user_id); ?>)
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <label>Status</label>
                                        <select id="status" name="status" class="form-control" >
                                            <option value="">Select Status</option>
                                            <?php  $status= $sql_result['status']; ?>
                                            <option value="1" <?php if(isset($status)) { if($status== 1){ echo 'selected' ;  }} ?>>Active</option>
                                            <option value="0" <?php if(isset($status)) { if($status == 0){ echo 'selected' ;  }} ?>>In-Active</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label>Remark</label>
                                        <input type="text" name="remark" class="form-control" placeholder="Remark">
                                    </div>
                                    
                                    <div class="col-sm-12">
                                                <label>Service Executive</label>
                                                <select class="form-control" name="serviceExecutive" required>
                                                    <option value="">-- Select --</option>
                                                    <?
                                                    $se_sql = mysqli_query($con,"select * from mis_loginusers where serviceExecutive=1");
                                                    while($se_sql_result = mysqli_fetch_assoc($se_sql)){ ?>
                                                       <option <? echo $se_sql_result['id'];?> <? if($se_sql_result['name']== $sql_result['serviceExecutive']){ echo 'selected'; }   ?>>
                                                          <? echo $se_sql_result['name'];?> 
                                                       </option> 
                                                    <? }
                                                    ?>
                                                </select>
                                    </div>
                                    
                                    
                                    <!--Regional_Coordinator-->
                                    
                                    
                                      <div class="col-sm-12">
                                                <label>Regional Coordinator</label>
                                                <select class="form-control" name="Regional_Coordinator" required>
                                                    <option value="">-- Select --</option>
                                                    <?
                                                    $se_sql = mysqli_query($con,"select * from mis_loginusers where user_status=1");
                                                    while($se_sql_result = mysqli_fetch_assoc($se_sql)){ ?>
                                                       <option value="<? echo $se_sql_result['id'];?>" <? if($se_sql_result['id']== $Regional_Coordinator ){ echo 'selected'; }   ?>>
                                                          <? echo $se_sql_result['name'];?> 
                                                       </option> 
                                                    <? }
                                                    ?>
                                                </select>
                                    </div>
                                    
                                    
                                    <div class="col-sm-12">
                                                <label>Surveillance Head</label>
                                                <select class="form-control" name="Surveillance_Head" required>
                                                    <option value="">-- Select --</option>
                                                    <?
                                                    $se_sql = mysqli_query($con,"select * from mis_loginusers where user_status=1");
                                                    while($se_sql_result = mysqli_fetch_assoc($se_sql)){ ?>
                                                       <option value="<? echo $se_sql_result['id'];?>" <? if($se_sql_result['id']== $Surveillance_Head ){ echo 'selected'; }   ?>>
                                                          <? echo $se_sql_result['name'];?> 
                                                       </option> 
                                                    <? }
                                                    ?>
                                                </select>
                                    </div>
                                    
                                    
                                    <!--Regional_Coordinator-->
                                    
                                    <!--Surveillance_Head-->
                                    
                                    
                                    
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <br>
                                        <input type="submit" name="submit" class="btn btn-danger">
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


<?php include('footer.php');
    }
else{ ?>

<script>
window.location.href = "login.php";
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



</body>

</html>