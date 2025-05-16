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
                                    <h5>Update Bulk FUND<span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="excelformat/bulk_fund_upload.xlsx" download>BULK FUND UPLOAD FORMAT</a>
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
$created_at = date('Y-m-d');




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
       $truncatesql = mysqli_query($con,"TRUNCATE TABLE mis_newsitetest");
   }
    for($i = 1; $i<=$row; $i++){
       
      
      $atmid = $rowData[$i][0][3];
        if($atmid){
         
        
          //  $datetime = date('Y-m-d h:i:s');
                $userid = $_SESSION['userid'];                                        
                $type = $rowData[$i][0][0];
            
                $customer = $rowData[$i][0][1];
                $bank = $rowData[$i][0][2];
                
                $atmid2 = $rowData[$i][0][4];
                $atmid3 = $rowData[$i][0][5];
                $trackerno = $rowData[$i][0][6];
                $address = str_replace("'", "", $rowData[$i][0][7]);
                $city = $rowData[$i][0][8];
                $state = $rowData[$i][0][9];
                $zone = $rowData[$i][0][10];
                $branch = $rowData[$i][0][11];
                $bm_name = $rowData[$i][0][17];
                $bm_number = $rowData[$i][0][18];
                
                $sql = "insert into rnm_fund_test(type,subtype,atmid,bank,customer,zone,city,state,location,approval_amount,attach,remark,created_by,status,created_at,added_pos,payee_type,fundDetails,required_amount,account_number,beneficiary_name,ifsc_code,approved_by) 
    values('".$type."','".$subtype."','".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$approval_amount."','".$attach."','".$remark."','".$created_by."','".$status."','".$created_at."','".$added_pos."','".$payee_type."','".$fundDetails."','".$required_amount."','".$account_number."','".$beneficiary_name."','".$ifsc_code."','".$approved_by."')";
    
   // $insert = mysqli_query($con,$sql); 
    if (mysqli_query($con, $sql)) {
       $last_id = mysqli_insert_id($con);
       $req_id = $last_id;
       $approved_amt = 0;
       $req_amt = $required_amount;
       $action = 1;
       $created_date = $created_at;
       $status = 1;
       $remarks = "";
    $fundsql = "insert into mis_fund_requests_test(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
            values('".$req_id."','".$req_amt."','".$approved_amt."','".$created_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
       // mysqli_query($con,$fundsql); 
        if(mysqli_query($con,$fundsql)){ 
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