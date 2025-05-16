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
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <form action="process_add_user.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Email / userid</label>
                                                    <input type="email" name="uname" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Password</label>
                                                    <input type="password" name="pwd" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Contact</label>
                                                    <input type="number" id="contact" name="contact" class="form-control" onkeypress="return validInput(event);" >
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
                                
                                
                                
                                
                                
                                <div class="card">
                                    <div class="card-block">
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User ID</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                    <th>Contact No.</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from mis_loginusers");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['id']; ?></td>
                                                        <td><? echo $sql_result['name']; ?></td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['uname']; ?></td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['pwd']; ?></td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['contact']; ?></td>
                                                        <td>
                                                            <a class="btn btn-danger" href="allot_perm.php?id=<? echo $sql_result['id']; ?>">Permission</a>
                                                            <a class="btn btn-danger" href="menu_perm.php?id=<? echo $sql_result['id'];?>">Menu Permission</a>
                                                        </td>
                                                    </tr>    
                                                <? $i++; }?>
                                                
                                            </tbody>
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