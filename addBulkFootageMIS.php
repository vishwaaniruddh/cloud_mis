<?php include('config.php');



if ($_SESSION['username']) {

    include('header.php');
?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        
                        

                                    <?php
if (isset($_POST['submit'])) {
    
    
 function convertExcelTime($timeRaw) {
        return is_numeric($timeRaw) ? gmdate('H:i:s', $timeRaw * 86400) : date('H:i:s', strtotime($timeRaw));
    }




    
    ?>
                            <div class="card">
                            <div class="card-body">
    <?php
    
    $userid = $_SESSION['userid'];
    
$status ='Pending';                      
$created_by = $_SESSION['userid'];
$created_at = date('Y-m-d H:i:s');



    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d h:i:s a', time());
    $only_date = date('Y-m-d');
    $target_dir = '../PHPExcel/';
    $file_name = $_FILES["images"]["name"];
    $file_tmp = $_FILES["images"]["tmp_name"];
    $file =  $target_dir . '/' . $file_name;

    // Move uploaded file
    move_uploaded_file($file_tmp, $target_dir . '/' . $file_name);
    
    include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
    $inputFileName = $file;

    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
    }

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    for ($row = 1; $row <= $highestRow; $row++) {
        $rowData[] = $sheet->rangeToArray(
            'A' . $row . ':' . $highestColumn . $row,
            null,
            true,
            false
        );
    }

    $row = $row - 2;
    $error = '0';

    for ($i = 1; $i <= $row; $i++) {
      


$call_type = 'Footage';
echo
$atmid = $rowData[$i][0][0];
$footage_requestBy = $rowData[$i][0][1]; 
$footage_format = $rowData[$i][0][2];
$footage_date = $rowData[$i][0][3]; 

$fromtime = $rowData[$i][0][4]; 
$totime = $rowData[$i][0][5];
$footage_txn_time = $rowData[$i][0][6];

$call_receive = $rowData[$i][0][7];  // batch
$docket_no =  $rowData[$i][0][8];
$remarks = htmlspecialchars($rowData[$i][0][9]); // 9 for remarks



  if (is_numeric($footage_date)) {
        $unixDate = ($footage_date - 25569) * 86400; // Excel's date system starts at 25569 (1 Jan 1970 in Unix time)
        $footage_date = gmdate('Y-m-d', $unixDate);
            } else {
                $footage_date = date('Y-m-d', strtotime($footage_date));
            }
            

$fromtime = convertExcelTime($fromtime);  // Start time
$totime = convertExcelTime($totime);    // End time
$footage_txn_time = convertExcelTime($footage_txn_time);    // TXN time


        
        
        
$get_atmsql = mysqli_query($con,"select * from mis_newsite where atmid like '".$atmid."'");
if($get_atmsql_result = mysqli_fetch_assoc($get_atmsql)){
    
    
    
$bank = $get_atmsql_result['bank'];
$customer = $get_atmsql_result['customer'];
$zone = $get_atmsql_result['zone'];
$city = $get_atmsql_result['city'];
$state = $get_atmsql_result['state'];
$location = $get_atmsql_result['address'];
$location = mysqli_real_escape_string($con, $location);
$branch = $get_atmsql_result['branch'];
$bm = $get_atmsql_result['bm_name'];

















$amount = 'NULL';


// get Service Executive
$servicesql = mysqli_query($con,"select serviceExecutive from mis_newsite where atmid='".$atmid."'");
$servicesql_result = mysqli_fetch_assoc($servicesql);
$serviceExecutive = $servicesql_result['serviceExecutive'];



$mis_city_sql = mysqli_query($con,"select * from mis_city where city ='".$city."'");
if($mis_city_sql_result  = mysqli_fetch_assoc($mis_city_sql)){
    $mis_city = $mis_city_sql_result['id'];    
}else{
    mysqli_query($con,"insert into mis_city(city) values('".$city."')");
    $mis_city = $con->insert_id ; 
}

$engineer_sql = mysqli_query($con,"select * from mis_newsite where atmid like '%".$atmid."%'");
$engineer_user_id = "";
if(mysqli_num_rows($engineer_sql)>0){
    if($engsql_result = mysqli_fetch_assoc($engineer_sql)){
       $engineer_user_id = $engsql_result['engineer_user_id'];   
    }
}

 $statement = "insert into mis(atmid,bank,customer,zone,city,state,location,call_receive_from,remarks,status,created_by,created_at,branch,bm,call_type,serviceExecutive) 
values('".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$call_receive."','".$remarks."','open','".$created_by."','".$created_at."','".$branch."','".$bm."','".$call_type."','".$serviceExecutive."')";
//echo '<br>';
if(mysqli_query($con,$statement)){
    
    $mis_id = $con->insert_id ;
    
        
        
        
        
        
        
        

        
        
        
        $last_sql = mysqli_query($con,"select id from mis_details order by id desc");
        $last_sql_result = mysqli_fetch_assoc($last_sql);
        $last = $last_sql_result['id'];
        
        if(!$last){
            $last=0;
        }
        $ticket_id =  mb_substr(date('M'), 0, 1).date('Y') .date('m')  . date('d') . sprintf('%04u', $last) ;
        
         $detai_statement = "insert into mis_details(mis_id,atmid,engineer,docket_no,status,created_at,ticket_id,amount,mis_city,zone,footage_date,fromtime,totime,call_type,case_type,
         branch,footage_requestBy,footage_format,footage_txn_time,footage_status) 
        values('".$mis_id."','".$atmid."','".$engineer_user_id."','".$docket_no."','".$status."','".$created_at."','".$ticket_id."','".$amount."','".$mis_city."','".$zone."','".$footage_date."','".$fromtime."','".$totime."','Footage','".$call_receive."','".$branch."','".$footage_requestBy."','".$footage_format."','".$footage_txn_time."','Pending')" ;
        mysqli_query($con,$detai_statement);
        
        
        echo 'ticket locked Successfully !' ;
        echo '<br/>';
    
     
}

            
          
    }
    }
        

  
}

                                ?>
                            
                        
                        <div class="card">
                            <div class="card-block">

                                <div class="two_end">
                                    <h5>Bulk Footage Upload <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="./excelformat/footageBulkUploadFormat.xlsx" download>Footage UPLOAD FORMAT</a>
                                </div>

                            
                                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
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
} else { ?>

    <script>
        window.location.href = "login.php";
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