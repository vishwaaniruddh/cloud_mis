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

                                <!--<div class="two_end">-->
                                    <h5>MIS CITY BULK <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="excelformat/bulk_city_format.xlsx" download>MIS CITY UPLOAD FORMAT</a>
                                <!--</div>-->

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
                                    $updatekey = 0;
                                    
                                    // echo '<pre>';print_r($rowData);echo '</pre>';die;    
                                    for ($i = 1; $i <= $row; $i++) {

                                        $zone = $rowData[$i][0][1];
                                        if($zone){
                                        $state = $rowData[$i][0][2];
                                        $_state = ucfirst($state);
                                        // echo $_state;
                                        $city = $rowData[$i][0][3];

                                        
                                            $sql = mysqli_query($con, "select * from newzone where zone_name = '" . $zone . "'");
                                            $sql_result = mysqli_fetch_assoc($sql);
                                            $num_rows = mysqli_num_rows($sql);
                                             
                                             
                                           if($num_rows>0) {
                                               $zoneid = $sql_result['id'];
                                            //   echo $zoneid;
                                            if(isset($zoneid) && $zoneid!='' ){
                                                
                                                    // echo "select state_id,state from state where zone='".$zoneid."' and state = '".$_state."'"."<br>" ;
                                                    $statesql = mysqli_query($con,"select state_id,state from state where zone='".$zoneid."' and state = '".$_state."' ");
                                                   
                                                    $statesql_res = mysqli_fetch_assoc($statesql);
                                                    $state_numrws = mysqli_num_rows($statesql);
                                                    // echo $state_numrws;
                                                    
                                                     $stateid = $statesql_res['state_id'];
                                                        // echo $stateid;
                                                    
                                                    if($state_numrws){
                                                        
                                                        // $checkcity = mysqli_query($con,"select city from mis_city_test2 where  where zone='".$zoneid."' and state = '".$stateid."' ");
                                                        // if($checkcity){
                                                        //     echo "City " .$city. "Already Exist!!"   ;
                                                        // } else{
                                                            $city_insert = "insert into mis_city_test2(city,zone_id,state_id) values ('".$city."','".$zoneid."','".$stateid."')  ";    
                                                        
                                                            if (mysqli_query($con, $city_insert)) {
                                                                $updatekey = $updatekey + 1;
                                                            }
                                                        // }
                                                    } else {
                                                         echo "State ".$state. " Not Found</br>";
                                                    }    
                                        } else {
                                            echo "Zone ".$zone. " Not Found</br>";
                                        }
                                           }
                                            
                                        }

                                    
                                        
                                    }
                                    
                                    
                                    if($updatekey>0){ ?>
									<script>
										var key = <?php echo $updatekey;?>;
										alert("Total no of rows updated : " + key);

									</script>
									<?php   }
                                
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