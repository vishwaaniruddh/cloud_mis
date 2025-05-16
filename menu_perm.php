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
                                        
                                        
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" id="data_table">
                                          <thead>
                                            <tr>
                                                <th>SR</th>
                                                <th>Name</th>
                                                <th>username</th>
                                                <th>Edit</th>
                                            </tr>
                                          </thead>
                                            
                                        <tbody>
                                            <? $i = 1; 
                                            $sql = mysqli_query($con,"select * from mis_loginusers");
                                            while($sql_result = mysqli_fetch_assoc($sql)){
                                            $id = $sql_result['id'];
                                            ?>
                                               <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $sql_result['name'];?></td>
                                                    <td><? echo $sql_result['uname']; ?></td>
                                                    <td><a href="allotmenu_perm.php?id=<? echo $id ; ?>" class="btn btn-danger" style="color:white;">Edit</a></td>
                                                </tr>
                                            <? $i++; } ?>

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



</body>

</html>