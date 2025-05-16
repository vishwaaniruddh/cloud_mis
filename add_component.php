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
                                        
                                        <?
                                        
                                        if(isset($_POST['submit']) && isset($_POST['component'])){
                                            $name = $_POST['component'];
                                            $date = date('Y-m-d');
                                            $statement = "insert into mis_component(name,status,created_at) values('".$name."','1','".$date."')" ;
                                            
                                            if(mysqli_query($con,$statement)){ ?>
                                            
                                            <script>
                                                alert('Component Added');
                                            </script>
                                                
                                                

                                            <? }
                                            else{
                                                echo mysqli_error($con);
                                            }
                                        }
                                        
                                        ?>
                                        <form action="<? echo $_SERVER['PHP_SELF'] ;?>" method="POST">
                                            <h3>Add Component</h3>
                                            <div class="row">
                                                <div class="col-sm-8">

                                                    <input type="text" name="component" class="form-control" placeholder="">
                                                </div>
                                                <div class="col-sm-4">

                                                    <input type="submit" name="submit" value="Add" class="btn btn-success">
                                                </div>
                                            </div>    
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-block">
                                           <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th>SR</th>
                                                        <th>Component</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? 
                                                    $sql = mysqli_query($con,"select * from mis_component where status=1 order by id desc");
                                                    $i=0;
                                                    while($sql_result = mysqli_fetch_assoc($sql)){ ?>
                                                        <tr>
                                                            <th><? echo ++$i; ?></th>
                                                            <th><? echo $sql_result['name']; ?></th>
                                                            <th><a class="btn btn-danger" href="#">Actions</a></th>
                                                        </tr>    
                                                    <? }  ?>
                                                    
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