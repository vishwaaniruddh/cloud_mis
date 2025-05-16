<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

$id = $_GET['id'];

$sql = mysqli_query($con,"select * from mis_loginusers where id = '".$id."' ");
$sqlr = mysqli_fetch_assoc($sql);

?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <form action="process_designation.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <input type="hidden" name="id" id="id" value="<? echo $sqlr['id'];?>">
                                                    <label>Name</label>
                                                    <input type="text" name="name" value="<? echo $sqlr['name'];?>" class="form-control" readonly>
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Designation</label>
                                                    <select name="desgn" id="desgn" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="4">Engineer</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
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
<script>
function validInput(e) {
  e = (e) ? e : window.event;
  a = document.getElementById('contact');
  cPress = (e.which) ? e.which : e.keyCode;

  if (cPress > 31 && (cPress < 48 || cPress > 57)) {
    return false;
  } else if (a.value.length >= 10) {
    return false;
  }

  return true;
}
</script>


</body>

</html>