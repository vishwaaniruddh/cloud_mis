<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<style>
    .card-data{
        overflow-x: auto;
    }
        
</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                                                        <div class="two_end">
                                    <h5>Project Site Report <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="excelformat/process_report.xlsx" download>PROJECT SITE REPORT FORMAT</a>
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
   $updatekey = 0;
   $error_array = array();
   if($row>0){
       $truncatesql = mysqli_query($con,"TRUNCATE TABLE project_site");
   }
    for($i = 1; $i<=$row; $i++){
       
      
      $atmid = $rowData[$i][0][3];
        if($atmid){
        
        
          //  $datetime = date('Y-m-d h:i:s');
                $userid = $_SESSION['userid'];                                        
                $_activity = $rowData[$i][0][0];
                $activity = $_activity;
                if (strpos($_activity, 'E-Surveillance') !== false) {
                    $activity = 'RMS';
                }
                if (strpos($_activity, 'DVR') !== false || strpos($_activity, 'Router') !== false) {
                  $activity = 'DVR Activity';
                }
                if (strpos($_activity, 'Cloud') !== false) {
                    $activity = 'Cloud';
                }
                
                $customer = $rowData[$i][0][1];
                $bank = $rowData[$i][0][2];
                
             
                $sql = "insert into project_site(activity,customer,bank,atmid) values('".$activity."','".$customer."','".$bank."','".$atmid."')";
                
                if(mysqli_query($con,$sql)){ 
                    $updatekey = $updatekey + 1;
                }else{
                    $sentence = "Atm ID ".$atmid." not able to update its value";
                    array_push($error_array,$sentence); 
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
                                <div class="card">
							<div class="card-body">
								<div class="two_end">
									<h6>Project Site Table</h6>
									<!--<a class="btn btn-success" href="newsite_sucess_approve.php">Approve All To Main Site</a>-->
									<!--<a class="btn btn-success" href="newsite_sucess_excel.php">Bulk Report Download</a>--></div>
								<br>
								<div class="card-data">
									<table class="table table-bordered table-striped" id="data_table" style="width:100%;">
										<thead>
											<tr>
												<th>Sr no</th>
												<th>activity</th>
												<th>customer</th>
												<th>bank</th>
												<th>atmid</th>
											</tr>
										</thead>
										<tbody>
											<?
                                                $i=0;
                                                $sqldata = mysqli_query($con,"select * from project_site");
                                                while($sql_result = mysqli_fetch_assoc($sqldata)){
                                            ?>
												<tr>
													<td>
														<? echo ++$i;?>
													</td>
													<td>
														<? echo $sql_result['activity'] ; ?>
													</td>
													<td>
														<? echo $sql_result['customer'] ; ?>
													</td>
													<td>
														<? echo $sql_result['bank'] ; ?>
													</td>
													<td>
														<? echo $sql_result['atmid'] ; ?>
													</td>
												</tr>
													<? } ?>
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