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
                                    <a class="btn btn-success" href="excelformat/Add_Sites.xlsx" download>BULK SITES UPLOAD FORMAT</a>
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
$date = date('Y-m-d');
$_date = str_replace("-","_",$date);

// $table = mysqli_query($con,"show tables in `comsarmi_cncindia` where `sites_comfort_`");

 $sitebackup = mysqli_query($con,"create table sites_comfort_".$_date." as select * from sites_comfort ");
 
//  $site_circle_backup = mysqli_query($con,"create table site_circle_comfort_".$_date." as select * from site_circle_comfort  ");
 
 
// echo "create table sites_comfort_".$_date." as select * from sites_comfort"."<br>";

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
   $updatekey = 0;
   $error_array = array();
   
    for($i = 1; $i<=$row; $i++){
       
      
      $old_atmid = $rowData[$i][0][3];
        if($old_atmid){
         
          //  $datetime = date('Y-m-d h:i:s');
                $userid = $_SESSION['userid']; 
                $atmid = $rowData[$i][0][2];
                // echo $i."  ";
                // echo "update sites_comfort set ATMID = '".$atmid."',TrackerNo='".$old_atmid."' where atmid = '".$old_atmid."'"."<br>";
                
                $updatesql = "update sites_comfort set ATMID = '".$atmid."',TrackerNo='".$old_atmid."' where ATMID = '".$old_atmid."' ";
             
                if(mysqli_query($con,$updatesql)){ 
                    $updatekey = $updatekey + 1;
                    
                //     $update_site_circle = "update site_circle_comfort set ATMID='".$atmid."' where ATMID = '".$old_atmid."' ";
                //   $update_circle = mysqli_query($con,$update_site_circle);
                    
                }else{
                    $sentence = "Atm ID ".$atmid." not able to update its value";
                    array_push($error_array,$sentence); 
                }
            // }else{
            //     // $sentence = "Atm ID ".$atmid." is not exist in table. ";
            //     // array_push($error_array,$sentence); 
            // } 
    
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

                                    
                                }
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