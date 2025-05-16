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
                                    <h5>MIS Tracker <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="mis_bulk.xls" download>MIS UPLOAD FORMAT</a>
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

$row = $row-2;
$error = '0';
$contents='';

    for($i = 1; $i<=$row; $i++){
        
      $atmid = $rowData[$i][0][0];
        if($atmid){
            $sql = mysqli_query($con,"select * from sites where ATMID like '".$atmid."'");
        
        
            $call_receive = $rowData[$i][0][7];
            $component = $rowData[$i][0][8];
            $subcomponent =$rowData[$i][0][9];
            $docket_number =$rowData[$i][0][10];
            $remarks =$rowData[$i][0][11];
         
$amount = 'NULL';
         
         
        
        if($sql_result = mysqli_fetch_assoc($sql)){
            $customer = strtoupper($sql_result['Customer']);
            $bank = $sql_result['Bank'];
            $location = $sql_result['SiteAddress'];
            $city = $sql_result['City'];
            $state = $sql_result['State'];
            $zone = $sql_result['Zone'];
        }else{
            $bank =$rowData[$i][0][1];
            $customer =$rowData[$i][0][2];
            $zone = $rowData[$i][0][3];
            $city = $rowData[$i][0][4];
            $state = $rowData[$i][0][5];
            $location = $rowData[$i][0][6];            
        }



$statement = "insert into mis(atmid,bank,customer,zone,city,state,location,call_receive_from,remarks,status,created_by,created_at) values('".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$call_receive."','".$remarks."','open','".$created_by."','".$created_at."')";

if(mysqli_query($con,$statement)){
    
    $mis_id = $con->insert_id ;
    
        
        $last_sql = mysqli_query($con,"select id from mis_details order by id desc");
        $last_sql_result = mysqli_fetch_assoc($last_sql);
        $last = $last_sql_result['id'];
        
        if(!$last){
            $last=0;
        }
        $ticket_id =  mb_substr(date('M'), 0, 1).date('Y') .date('m')  . date('d') . sprintf('%04u', $last) ;
        
        $detai_statement = "insert into mis_details(mis_id,atmid,component,subcomponent,docket_no,status,created_at,ticket_id,amount) values('".$mis_id."','".$atmid."','".$component."','".$subcomponent."','".$docket_number."','open','".$created_at."','".$ticket_id."','".$amount."')" ;
        if(mysqli_query($con,$detai_statement)){
            echo 'record created for ATMID' . $atmid ; 
            echo '<br>';
         }
        
    }
    
}

         
         
         
         
         
         
         
         
         

     }


                                    
                                }
                                ?>
                                
                                
                                
                                
                                
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