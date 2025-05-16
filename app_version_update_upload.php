<? session_start();
include('config.php');

  
        if(isset($_POST['submit'])){
            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d h:i:s');
            $target_dir = 'api/app_dwnld/comforteng.apk';
            $file_name=$_FILES["images"]["name"];
            $file_tmp=$_FILES["images"]["tmp_name"];
            $version = $_POST['version'];
            // To Delete previous videos  before next merge
            $folder_path = "api/app_dwnld";
               
            $files = glob($folder_path.'/*'); 
            foreach($files as $file) {   
                if(is_file($file)) {
                    unlink($file); 
                }
            }
            
            // End Delete

            if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_dir )) {
                $update = mysqli_query($con,"update eng_app_version set version = '".$version."',updated_at = '".$date."'");
                if($update==1){ ?>
                        <script>
                       swal("Good job!", "Uploaded !", "success");
                
                       </script> 
              <?php  }else{ ?>
                    <script>
                       swal("Wrong!", "Uploaded but not updated in table !", "error");
                
                       </script> 
            <?php  }
            }else{ ?>
                <script>
                       swal("Wrong!", "Not Uploaded !", "error");
                
                       </script> 
          <?php  }
        }
        
         $sql = mysqli_query($con,"select * from eng_app_version");
         $sql_data = mysqli_fetch_row($sql);
         $lastupdatedversion = $sql_data[0];
?>
<html>
    <head>
         <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.min.css" integrity="sha512-T584yQ/tdRR5QwOpfvDfVQUidzfgc2339Lc8uBDtcp/wYu80d7jwBgAxbyMh0a9YM9F8N3tdErpFI8iaGx6x5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
        </head>
        <body>
     
            <div class="pcoded-content m-5 ">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card p-4">
                                    <div class="card-block">
                                           <div class="two_end">
                                                <h5> Last Updated APK Version : <span style="font-size:18px; color:red;"><?php echo $lastupdatedversion; ?></span> </h5>
                                            </div>
                                    </div>
                                    <div class="card-block">
                                        
                                        <h4><span style="font-size:12px; color:red;">New Version Upload (Apk Upload)</span></h4>                              
                                
                                 <form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                             <div class="col-sm-4">
                                                <input type="text" name="version" class="form-control" required placeholder="version">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="file" name="images" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4">
                                                  <input type="submit" name="submit" value="upload" class="btn btn-danger">
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