<? session_start();
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
                                
                                <?
                                
                                $id = $_GET['id'];
                                $sql= mysqli_query($con,"select * from mis_newsite where id='".$id."'");
                                $sql_result = mysqli_fetch_assoc($sql);
                                
                                $user_data_sql = mysqli_query($con,"select id,name from mis_loginusers where designation='4' order by name asc ");
                                ?>
                                <div class="card">
                                    <div class="card-body">

                      <form action="process_editatm.php" method="POST">
                          <input type="hidden" name="id" value="<? echo $id; ?>">
                          <div class="row">
<div class="col-sm-3">
<label>activity</label>
<input type="text" name="activity" class="form-control" value="<? echo $sql_result['activity'];?>">
</div>

<div class="col-sm-3">
<label>customer</label>
<input type="text" name="customer" class="form-control" value="<? echo $sql_result['customer'];?>">
</div>

<div class="col-sm-3">
<label>bank</label>
<input type="text" name="bank" class="form-control" value="<? echo $sql_result['bank'];?>">
</div>

<div class="col-sm-3">
<label>atmid</label>
<input type="text" name="atmid" class="form-control" value="<? echo $sql_result['atmid'];?>">
</div>

<div class="col-sm-3">
<label>trackerno</label>
<input type="text" name="trackerno" class="form-control" value="<? echo $sql_result['trackerno'];?>">
</div>

<div class="col-sm-3">
<label>address</label>
<input type="text" name="address" class="form-control" value="<? echo $sql_result['address'];?>">
</div>

<div class="col-sm-3">
<label>city</label>
<input type="text" name="city" class="form-control" value="<? echo $sql_result['city'];?>">
</div>

<div class="col-sm-3">
<label>state</label>
<input type="text" name="state" class="form-control" value="<? echo $sql_result['state'];?>">
</div>

<div class="col-sm-3">
<label>zone</label>
<input type="text" name="zone" class="form-control" value="<? echo $sql_result['zone'];?>">
</div>

<div class="col-sm-3">
<label>branch</label>
<input type="text" name="branch" class="form-control" value="<? echo $sql_result['branch'];?>">
</div>

<div class="col-sm-3">
<label>bm_name</label>
<input type="text" name="bm_name" class="form-control" value="<? echo $sql_result['bm_name'];?>">
</div>

<div class="col-sm-3">
<label>bm_number</label>
<input type="text" name="bm_number" class="form-control" value="<? echo $sql_result['bm_number'];?>">
</div>

<div class="col-sm-3">
    <label for="">engineer</label>
    <select class="form-control" name="engineer_user_id" required>
        <option value="">Select Engineer</option>
        <? $engineer_id = $sql_result['engineer_user_id'];
         while($user_data_sql_result = mysqli_fetch_assoc($user_data_sql)){
            $user_name = $user_data_sql_result['name'];
            $user_id = $user_data_sql_result['id'];
          ?>
            <option value="<? echo trim($user_id); ?>" <?php if($user_id==$engineer_id){ echo 'selected';}?>><? echo trim($user_name); ?></option>
        <? } ?>
    </select>
    
    
</div>




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