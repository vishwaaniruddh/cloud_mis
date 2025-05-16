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
                                        $sql = mysqli_query($con,"select distinct accessStatusType from accessStatus where status=1");
                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                            $accessStatusType = $sql_result['accessStatusType'];
                                            
                                            echo '<h4>'. $accessStatusType.'</h4><br>';
                                            $_sql = mysqli_query($con,"select * from accessStatus where accessStatusType='".$accessStatusType."' and status=1");
                                            while($_sql_result = mysqli_fetch_assoc($_sql)){
                                                   echo '<input type="checkbox" />&nbsp;&nbsp;'.$_sql_result['accessStatusName'] . '&nbsp;&nbsp;&nbsp;';
                                            }
                                            echo '<br>';                                            echo '<br>';
                                        }
                                        
                                        ?>
                                        
                                        
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