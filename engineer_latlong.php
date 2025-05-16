<? session_start();
include('config.php');

if ($_SESSION['username']) {

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
                                    <h5>Engineer latlong <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <!--<a class="btn btn-success" href="mis_bulk.xls" download>MIS UPLOAD FORMAT</a>-->
                                </div>

                                <?

                                if (isset($_POST['submit'])) {
                                    $userid = $_SESSION['userid'];
                                    date_default_timezone_set('Asia/Kolkata');
                                    $date = date('Y-m-d h:i:s a', time());
                                    $only_date = date('Y-m-d');
                                    $target_dir = '../PHPExcel/';
                                    $file_name = $_FILES["images"]["name"];
                                    $file_tmp = $_FILES["images"]["tmp_name"];
                                    $file =  $target_dir . '/' . $file_name;

                                    $created_by = $_SESSION['userid'];
                                    $created_at = date('Y-m-d H:i:s');


                                    move_uploaded_file($file_tmp = $_FILES["images"]["tmp_name"], $target_dir . '/' . $file_name);
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
                                        $rowData[] = $sheet->rangeToArray(
                                            'A' . $row . ':' . $highestColumn . $row,
                                            null,
                                            true,
                                            false
                                        );
                                    }

                                    $row = $row - 2;
                                    $error = '0';
                                    $contents = '';
                                    // echo '<pre>';print_r($rowData);echo '</pre>';die;
                                    for ($i = 1; $i <= $row; $i++) {

                                        $atmid = $rowData[$i][0][0];
                                        if($atmid){
                                        $lat = $rowData[$i][0][4];
                                        $long = $rowData[$i][0][5];
                                        
                                        // if($lat=='' || $long==''){
                                            
                                        //     echo $atmid."<br>";
                                        // }
                                        //else{
                                        //     // echo "Lat Long available"." ->>"."atmid:".$atmid."<br>";
                                        // }
                                        // echo count($atmid);
                                        // echo $atmid." ->lat:".$lat." && long:".$long."<br>";

                                        
                                          $sql = mysqli_query($con,"select atmid,latitude,longitude from location_latlong ");
                                          while($sql_result = mysqli_fetch_row($sql)){
                                            $_atmid = $sql_result[0];
                                            $latitude = $sql_result[1];
                                            $longitude = $sql_result[2];
                                            // echo $_atmid."<br>";
                                          }
                                            
                                            if($lat=='' || $long =='') {
                                                echo "Latitude or Longitude not available for ".$atmid."<br>";
                                            } else{
                                                 
                                                 if($_atmid != $atmid){
                                                    //  echo $atmid."<br>";
                                                    $insertsql = mysqli_query($con,"insert into location_latlong(atmid,latitude,longitude) values('".$atmid."','".$lat."','".$long."')");
                                                    $count_insert = 1;
                                                    if($insertsql){
                                                        echo 'Record Created for ATMID: '. $atmid.'.<br>';
                                                    }
                                                }else{
                                                    $updatesql = mysqli_query($con,"update into location_latlong set latitude='".$lat."',longitude='".$long."' where atmid='".$atmid."' ");
                                                    $count_update = 1;
                                                    if($updatesql){
                                                        echo 'Record Updated for ATMID: '. $atmid.'.<br>';
                                                    }
                                                    // echo $lat." ".$long;
                                                }
                                            }
                                                
                                         
                                          
                                            
                                        }

                                    
                                        
                                    }
                                }
                                ?>
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