<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                
                                <div class="card">
                                    <div class="card-block">
                          
                          <h5><u>Add Engineer</u></h5>
                          <br>
                          <?
                          $_eng = mysqli_query($con,"select name from mis_loginusers where designation='4'");
                          if(isset($_POST['submit'])){
                              $user_id = $_POST['user_id'];
                              $eng = $_POST['engineer'];
                              $contact = $_POST['contact'];
                              $date = date('Y-m-d');
                              $userid = $_SESSION['userid'];
                              $statement = "insert into mis_eng(eng,contact,status,created_at,created_by,user_id) values('".$eng."','".$contact."','1','".$date."','".$userid."','".$user_id."')";
                              if(mysqli_query($con,$statement)){ ?>
                                    <script>
                                    swal("Great !", "Engineer Added Successfully !", "success");
                                    
                                    setTimeout(function(){ 
                                    window.location.href="add_eng.php";
                                    }, 2000);
                                    
                                    </script> 
                              <? }else{                                             echo mysqli_error($con);
                                            ?>
                                               
                                            <script>
                                                swal("Oops !", "Engineer Added Error !", "error");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="add_eng.php";
                                                    }, 2000);

                                            </script>

                              <? }
                          }
                          
                          
                          ?>
                          
                          
                                      <form action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">
                                          <div class="row">
                                               <div class="col-sm-3">
                                                   <select name="user_id" class="form-control" >
                                                       <option value="">Select</option>
                                                       <?php
                                                         if(mysqli_num_rows($_eng)>0){
                                                             while($_engdata = mysqli_fetch_assoc($_eng)){
                                                                 $_eng_name = $_engdata['name'];
                                                                 $_eng_id = $_engdata['id'];
                                                       ?>
                                                           <option value="<?php echo $_eng_id;?>"><?php echo $_eng_name;?></option>
                                                           <?php }}?>
                                                       </select>
                                                
                                              </div>
                                              <div class="col-sm-3">
                                                  <input type="text" name="engineer" class="form-control" placeholder="Name.. ">
                                              </div>
                                              
                                              <div class="col-sm-3">
                                                  <input type="text" name="contact" class="form-control"  placeholder="Contact.. ">
                                              </div>
                                              <br>
                                              <div class="col-sm-3">
            
                                                  <input type="submit" name="submit" value="Add Engineer" class="btn btn-success">                                      
                                              </div>
            
                                              
                                          </div>
                                      </form>

                                        
                                    </div>
                                </div>
                                
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h5><u>All Engineer</u></h5>
                                        <br>
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Contact</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? $i = 1 ; 
                                                $sql = mysqli_query($con,"select * from mis_eng where status=1");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['eng']; ?></td>
                                                        <td><? echo $sql_result['contact']; ?></td>
                                                    </tr>
                                                <? 
                                                $i++;
                                                } ?>
                                                
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