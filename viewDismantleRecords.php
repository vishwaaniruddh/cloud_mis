<? session_start();
include('config.php');

if($_SESSION['username']){ 
function getQuestion($id){
    global $con;
    $sql = mysqli_query($con,"select * from dismatleFormDetails where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['question'];
}
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
                                        
                                                         
                                        <!--get_member_name-->
                                        <?
                                        $id = $_REQUEST['id'];
                                            
                                            
                                        $inCounter=1;
                                        $quesSql = mysqli_query($con,"select * from dismantleFormResponseDetails where dismantleFormResponseID='".$id."' and status=1");
                                        while($quesSql_result = mysqli_fetch_assoc($quesSql)){
                                            $image_url = $quesSql_result['image_url'];
                                            $dismatleDetailId = $quesSql_result['dismatleDetailId'];
                                            echo '<h5>'.$inCounter . ') '. getQuestion($dismatleDetailId).'</h5>';
                                            echo $quesSql_result['response'];
                                            if($image_url){
                                                echo '<br>';
                                                echo '<img src="'.$image_url.'jpg" style="width:200px; height:200px;object-fit:cover;"/>';
                                            }
                                            echo '<br>';
                                            $inCounter++;
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