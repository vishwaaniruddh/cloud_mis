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
                          
                          <h5><u>Add Branch</u></h5>
                          <br>
                          <?
                          
                          if(isset($_POST['submit'])){
                              $branch = $_POST['branch'];
                              
                              $date = date('Y-m-d');
                              $userid = $_SESSION['userid'];
                              $zone = $_POST['zone'];
                              $statement = "insert into mis_branch_zone_master(branch,zone,created_at) values('".$branch."','".$zone."','".$datetime."')";
                              if(mysqli_query($con,$statement)){ ?>
                                    <script>
                                    swal("Great !", "Branch Added Successfully !", "success");
                                    
                                    setTimeout(function(){ 
                                    window.location.href="add_branch.php";
                                    }, 2000);
                                    
                                    </script> 
                              <? }else{                                             echo mysqli_error($con);
                                            ?>
                                               
                                            <script>
                                                swal("Oops !", "Branch Added Error !", "error");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="add_branch.php";
                                                    }, 2000);

                                            </script>

                              <? }
                          }
                          
                          
                          ?>
                          
                          
                                      <form action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">
                                          <div class="row">
                                              <div class="col-sm-4">
                                                  <input type="text" name="branch" class="form-control" placeholder="Branch Name.. ">
                                              </div>
                                              <div class="col-sm-4">
                                                  <select class="form-control" name="zone" required>
                                                      <option value="">Select</option>
                                                      <option>East</option>
                                                      <option>West</option>
                                                      <option>North</option>
                                                      <option>South</option>
                                                      
                                                  </select>
                                              </div>
                                              <br>
                                              <div class="col-sm-4">
            
                                                  <input type="submit" name="submit" value="Add Branch" class="btn btn-success">                                      
                                              </div>
            
                                              
                                          </div>
                                      </form>

                                        
                                    </div>
                                </div>
                                
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h5><u>All Branch</u></h5>
                                        <br>
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Branch Name</th>
                                                    <th>Zone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? $i = 1 ; 
                                                $sql = mysqli_query($con,"select * from mis_branch_zone_master");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['branch']; ?></td>
                                                        <td><? echo $sql_result['zone']; ?></td>
                                                       
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