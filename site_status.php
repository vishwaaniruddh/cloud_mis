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
                                        
                                                                        <div class="two_end">
                                    <h5>Update Bulk Sites <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="excelformat/bulk_site_call.xlsx" download>BULK SITES UPLOAD FORMAT</a>
                                </div>
                                        
                                        
                                        
                                     <?
                                    if(isset($_POST['submit'])){
                                    $userid = $_SESSION['userid']; 
                                    
                                        $date = date('Y-m-d h:i:s a', time());
                                        $only_date = date('Y-m-d');
                                        $target_dir = '../PHPExcel/';
                                        $file_name=$_FILES["images"]["name"];
                                        $file_tmp=$_FILES["images"]["tmp_name"];
                                        $file =  $target_dir.'/'.$file_name;
                                    
                                    
                                    $status ='open';                      
                                    $created_by = $_SESSION['userid'];
                                    $created_at = date('Y-m-d H:i:s');
                                    
                                    
                                    
                                    
                                        move_uploaded_file($file_tmp=$_FILES["images"]["tmp_name"],$target_dir.'/'.$file_name);
                                        include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
                                        $inputFileName = $file;
                                    
                                      try {
                                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                        $objPHPExcel = $objReader->load($inputFileName);
                                      } catch (Exception $e) {
                                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
                                            $e->getMessage());
                                      }
                                    
                                      $sheet = $objPHPExcel->getSheet(0);
                                      $highestRow = $sheet->getHighestRow();
                                      $highestColumn = $sheet->getHighestColumn();
                                    
                                      for ($row = 1; $row <= $highestRow; $row++) { 
                                        $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                                                        null, true, false);
                                                                    
                                      }
                                    // echo '<pre>';print_r($rowData);echo '</pre>';die;
                                    $row = $row-2;
                                    $error = '0';
                                    $contents='';
                                       $insertkey = 0;
                                       $updatekey = 0;
                                       $error_array = array();
                                       
                                        for($i = 1; $i<=$row; $i++){
                                          $atmid = $rowData[$i][0][0];
                                            if($atmid){
                                                    $userid = $_SESSION['userid'];  
                                                    $site_id = $rowData[$i][0][0];
                                                    $site_name = $rowData[$i][0][1];
                                                    $eng_name = $rowData[$i][0][2];
                                                    
                                                    $engsql = mysqli_query($con,"select id from mis_loginusers where name = '".$eng_name."' ");
                                                    $engsql_result = mysqli_fetch_row($engsql);
                                                    $eng_userid = $engsql_result[0];
                                                    
                                                    $checksql = mysqli_query($con,"select site_id from site_status where site_id = '".$atmid."' ");
                                                    $count = mysqli_num_rows($checksql);
                                                    
                                                    if($count==0){
                                                        $insertsql = mysqli_query($con,"insert into site_status(site_id,site_name,eng_user_id,eng_name,status,created_by,created_at) values('".$atmid."','".$site_name."','".$eng_userid."','".$eng_name."','1','".$userid."','".$created_at."')");    
                                                        if($insertsql)
                                                        {
                                                          $updatekey = $insertkey + 1;
                                                        }else{
                                                            $sentence = "Atm ID ".$atmid." not able to insert its value";
                                                            array_push($error_array,$sentence); 
                                                        }
                                                        
                                                    }
                                                    else if($count==1)
                                                    {
                                                        $updatesql = mysqli_query($con,"update site_status set site_id = '".$atmid."', site_name = '".$site_name."', eng_user_id = '".$eng_userid."', eng_name = '".$eng_name."', status = '0', updated_at = '".$created_at."', updated_by = '".$userid."' ");
                                                        if($updatesql){
                                                         $updatekey = $updatekey + 1;
                                                        }else{
                                                            $sentence = "Atm ID ".$atmid." not able to update its value";
                                                            array_push($error_array,$sentence); 
                                                        }
                                                    }
                                                    
                                            }else{
                                                $sentence = "Row ".$i." not have atmid";
                                                array_push($error_array,$sentence); 
                                            }
                                    
                                       }
                                                  if($updatekey>0){ ?>
                                                        <script>
                                                            var key = <?php echo $updatekey;?>;
                                                            alert("Total no of rows updated : "+key);</script>
                                               <?php   }
                                               
                                               if($insertkey>0) { ?>
                                                        <script>
                                                            var key = <?php echo $insertkey;?>;
                                                            alert("Total no of rows inserted : "+key);</script>
                                                <?php    } }
                                ?>
                                
                                
                                  <?php if(isset($error_array)){ 
                                     if(count($error_array)>0){
                                  ?>
                                    List of errors :
                                    <ul>
                                        <?php for($i=0;$i<count($error_array);$i++){ ?>
                                          <li><?php echo $error_array[$i];?></li>
                                        <?php } ?>
                                    </ul>
                                <?php }} ?>
                                
                                    <form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            
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