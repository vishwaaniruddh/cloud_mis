<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

$id = $_GET['id'];
$sql = "select * from newcheckquality_videos_app where visitid='".$id."'";
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
                                            $videos = $sql_result['link'];
                                            $name = $sql_result['filename'];
                                            $name = str_replace("_"," ",$name);
                                        ?>
                                            
                                            <div class="col-sm-4">
                                             <u><h5 style="text-align:center"><?php echo $name;?></h5></u>
                                                <a href="<? echo $videos; ?>">
                                                    <iframe width="560" height="315" src="<?php echo $videos;?>" frameborder="0" allowfullscreen style="width:100%; padding:10px;"></iframe>   
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