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
                                    
                                    
                                    <?
                                    
                                    if(isset($_POST['submit'])){
                                        $material = $_POST['material'];
                                        $date = date('Y-m-d');
                                        $statement = "insert into material(material,status,created_at) values('".$material."','1','".$date."')" ;
                                        
                                        if(mysqli_query($con,$statement)){ ?>
                                            <script>
                                                swal("Great !", "Material Added Successfully !", "success");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="material.php";
                                                    }, 2000);

                                            </script>
                                        <? }else{ ?>
                                            <script>
                                                swal("Oops !", "Material Added Error !", "error");
                                                
                                                    setTimeout(function(){ 
                                                        window.location.href="material.php";
                                                    }, 2000);

                                            </script>
                                        <? } } ?>
                                    
                                    
                                    
                                    <div class="card-block">
                                        <form action="<? echo $_SERVER['PHP_SELF']?>" method="POST">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" name="material" placeholder="Material Name ..." class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="submit" name="submit" value="submit" class="btn btn-success">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-block">
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?
                                                    $i = 1;
                                                    $sql = mysqli_query($con,"select * from material where status=1");
                                                    while($sql_result = mysqli_fetch_assoc($sql)){ ?>
                                                        <tr>
                                                            <td><? echo $i; ?></td>
                                                            <td><? echo $sql_result['material']; ?></td>
                                                            <td></td>
                                                        </tr>
                                                    <? $i++;}  ?>

                                                </tbody>
                                            </table>
                                        </div>
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