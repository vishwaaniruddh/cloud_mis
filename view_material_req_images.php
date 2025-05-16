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
                                        
                                        
                                        $mis_id = $_REQUEST['mis_id'];
                                        
                                        // echo "select * from mis_history where mis_id='".$mis_id."' and type='material_requirement' order by id desc" ; 
                                        $history_sql = mysqli_query($con,"select * from mis_history where mis_id='".$mis_id."' and type='material_requirement' order by id desc");
                                        $history_sql_result = mysqli_fetch_assoc($history_sql);
                                        
                                        $emailAttachment_MaterialRequirement = $history_sql_result['emailAttachment_MaterialRequirement'] ;
                                        $images_MaterialRequirement = $history_sql_result['images_MaterialRequirement'] ; 
                                            
                                            
                                            
                                            
                                            
                                            
                                        
                                        
                                        ?>
                                        <h5>Email Attachment</h6>
                                        
                                        <?
                                        if($emailAttachment_MaterialRequirement){
                                            ?>
                                            <a href="<?php echo $emailAttachment_MaterialRequirement ; ?>" download>Download</a>                                            
                                            <?
                                        }else{
                                            echo 'No Email Attchment Found !';
                                        }
                                        ?>
                                        

                                        
                                        <hr>
                                        <h5>Images and Videos</h5>
                                        
                                        <div class="row">
                                        <?
                                            $images_n_videos = explode(',' , $images_MaterialRequirement);
                                            
                                            foreach ($images_n_videos as $file) {
                                                
                                                ?>
                                                <div class="col-sm-3">
                                                    
                                                    <?
                                                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                                $fileType = explode('/', mime_content_type($file))[0];
                                            
                                                if ($fileType === 'image') {
                                                       echo '<a href="' . $file . '" target="_blank">';
                                                        echo '<img src="' . $file . '" alt="Image" style="width:100%;" />';
                                                        echo '</a>';
                                                } elseif ($fileType === 'video') {
                                                    echo '<video width="320" height="240" controls>';
                                                    echo '<source src="' . $file . '" type="video/' . $fileExtension . '">';
                                                    echo 'Your browser does not support the video tag.';
                                                    echo '</video>';
                                                }
                                                
                                                ?>
                                                </div>
                                                <?
                                            }
                                            

                                        
                                        ?>
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

