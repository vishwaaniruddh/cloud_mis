<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

$id = $_GET['id'];
$sql = "select * from newcheckquality_images_app where visitid='".$id."'";
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="row">
                                        
                                        <?php
                                            $sql_res = mysqli_query($con,$sql);
                                            while($sql_result = mysqli_fetch_assoc($sql_res)){ 
                                            $images = $sql_result['link'];
                                            $name = $sql_result['key_name'];
                                            $name = str_replace("_"," ",$name);
                                        ?>
                                            
                                            <div class="col-sm-4">
                                             <u><h5 style="text-align:center"><?php echo $name;?></h5></u>
                                                <a href="<? echo $images; ?>">
                                                    <img src="<? echo $images; ?>" style="width:100%; padding:10px;" >    
                                                </a>
                                                
                                            </div>
                                        <? } ?>
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