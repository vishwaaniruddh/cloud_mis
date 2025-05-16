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
                                    <h5>Mis Bulk NewVisit <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <!--<a class="btn btn-success" href="excelformat/bulk_fund_upload.xlsx" download>BULK FUND UPLOAD FORMAT</a>-->
                                </div>
                                <?

                                if (isset($_POST['submit'])) {
                                    $userid = $_SESSION['userid'];
                                    
                                    $date = date('Y-m-d h:i:s a', time());
                                    $only_date = date('Y-m-d');
                                    $target_dir = '../PHPExcel/';
                                    $file_name = $_FILES["images"]["name"];
                                    $file_tmp = $_FILES["images"]["tmp_name"];
                                    $file =  $target_dir . '/' . $file_name;


                                    $status = 1;
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
                                    // echo '<pre>';print_r($rowData);echo '</pre>';die;
                                    $row = $row - 2;
                                    $error = '0';
                                    $contents = '';
                                    $updatekey = 0;
                                    $error_array = array();
                                    // if ($row > 0) {
                                    //     $truncatesql = mysqli_query($con, "TRUNCATE TABLE mis_newsitetest");
                                    // }
                                    for ($i = 1; $i <= $row; $i++) {


                                        $atmid = $rowData[$i][0][4];
                                        if ($atmid) {


                                            //  $datetime = date('Y-m-d h:i:s');
                                            $userid = $_SESSION['userid'];
                                            // echo $userid; 

                                            $activity = $rowData[$i][0][0];

                                            $service = $rowData[$i][0][1];

                                            $customer = $rowData[$i][0][2];
                                            $bank = $rowData[$i][0][3];

                                            $atmid2 = $rowData[$i][0][5];
                                            $trackerno = $rowData[$i][0][6];
                                            $address = $rowData[$i][0][7];

                                            $pincode = $rowData[$i][0][8];
                                            $city = $rowData[$i][0][9];
                                            $state = $rowData[$i][0][10];
                                            $zone = $rowData[$i][0][11];

                                            $css_branch = $rowData[$i][0][12];
                                            $live_date = $rowData[$i][0][13];
                                            $live_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($live_date));
                                            
                                            $handover_date = $rowData[$i][0][14];
                                            $handover_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($handover_date));
                                            
                                            $css_bm_name = $rowData[$i][0][15];

                                            $sql = "insert into mis_newvisit_test(activity,service,customer,bank,atmid,atmid2,tracker_no,address,pincode,city,state,zone,css_branch,esurv_live_date,handover_date,css_bm_name,created_at,created_by) 
                                                values('" . $activity . "','" . $service . "','" . $customer . "','" . $bank . "','" . $atmid . "','" . $atmid2 . "','".$trackerno."','" . $adddress . "','" . $pincode . "','" . $city . "','" . $state . "','" . $zone . "','" . $css_branch . "','" . $live_date . "','" . $handover_date . "','" . $css_bm_name . "','" . $created_at . "','" . $created_by . "')";

                                            // $insert = mysqli_query($con,$sql); 
                                            if (mysqli_query($con, $sql)) {
                                                
                                                    $updatekey = $updatekey + 1;
                                                } else {
                                                    $sentence = "Atm ID " . $atmid . " not able to update its value";
                                                    array_push($error_array, $sentence);
                                                
                                            }
                                        } else {
                                            $sentence = "Row " . $i . " not have atmid";
                                            array_push($error_array, $sentence);
                                        }
                                    }
                                    if ($updatekey > 0) { ?>
                                        <script>
                                            var key = <?php echo $updatekey; ?>;
                                            alert("Total no of rows updated : " + key);
                                        </script>
                                <?php   }
                                }
                                ?>

                                <?php if (isset($error_array)) {
                                    if (count($error_array) > 0) {
                                ?>
                                        List of errors :
                                        <ul>
                                            <?php for ($i = 0; $i < count($error_array); $i++) { ?>
                                                <li><?php echo $error_array[$i]; ?></li>
                                            <?php } ?>
                                        </ul>
                                <?php }
                                } ?>

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