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
                                    <h5>MIS uploa excel <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
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


                                    $status = 'open';
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

                                        $atmid = $rowData[$i][0][1];
                                        if($atmid){
                                                                                   
                                        $dt1 = $rowData[$i][0][2];
                                        $dt2 = $rowData[$i][0][3];
                                        $dt3 = $rowData[$i][0][4];
                                        $dt4 = $rowData[$i][0][5];
                                        $dt5 = $rowData[$i][0][6];
                                        $dt6 = $rowData[$i][0][7];

                                        
                                            
                                            // echo $num_rows; 
                                          
                                            if(isset($atmid) && $atmid!='' ){
                                            // if(isset($atmid) && $atmid!='' && isset($docket_number) && $docket_number!='' ){
                                            

                                            $statement = "insert into esurv_network(atmid,date_1,date_2,date_3,date_4,date_5,date_6) values('" . $atmid . "','" . $dt1 . "','" . $dt2 . "','" . $dt3 . "','" . $dt4 . "','" . $dt5 . "','" . $dt6 . "')";

                                            if (mysqli_query($con, $statement)) {

                                                
                                                    echo 'record created for ' .$atmid;
                                                    echo '<br>';
                                                
                                            }
                                        } else {
                                            echo "Not Found</br>";
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