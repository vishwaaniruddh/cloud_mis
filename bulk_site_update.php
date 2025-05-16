<? session_start();
include('config.php');

if ($_SESSION['username']) {

    include('header.php');
?>

    <style>
        .card-data {
            overflow-x: auto;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-block">

                                <div class="two_end">
                                    <h5>Update Bulk Sites <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="excelformat/bulk_site_excel.xlsx" download>BULK SITES UPLOAD FORMAT</a>

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


                                    $status = 'open';
                                    $created_by = $_SESSION['userid'];
                                    $created_at = date('Y-m-d H:i:s');




                                    move_uploaded_file($file_tmp = $_FILES["images"]["tmp_name"], $target_dir . '/' . $file_name);
                                    include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
                                    $inputFileName = $file;

                                    //  Read your Excel workbook

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

                                    //  Loop through each row of the worksheet in turn

                                    for ($row = 1; $row <= $highestRow; $row++) {

                                        //  Read a row of data into an array

                                        $rowData[] = $sheet->rangeToArray(
                                            'A' . $row . ':' . $highestColumn . $row,
                                            null,
                                            true,
                                            false
                                        );

                                        //  Insert row data array into your database of choice here                      
                                    }

                                    $row = $row - 2;
                                    $error = '0';
                                    $contents = '';
                                    $updatekey = 0;
                                    $error_array = array();
                                    
                                    $atmnot_found = "";$total_atm = 0;$totalupdated_atm=0;
                                    // echo '<pre>';print_r($rowData);echo '</pre>';die;
                                    for ($i = 1; $i <= $row; $i++) {

                                        $atmid = $rowData[$i][0][3];
                                        // echo $atmid;

                                        if ($atmid) {

                                            $userid = $_SESSION['userid'];
                                            // echo $userid;
                                            $activity = $rowData[$i][0][0];
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
                                            $bm_name = $rowData[$i][0][12];
                                            $bm_number = $rowData[$i][0][13];
                                            $engineer = $rowData[$i][0][14];
                                            $errorcount = 0;


                                            $atmidcount = 0;
                                            $atmidsql = "select atmid from mis_newsitetest where atmid='" . $atmid . "' ";
                                            $atmidquery = mysqli_query($con, $atmidsql);
                                            if ($atmidsqlresult = mysqli_fetch_assoc($atmidquery)) {
                                                $sentence = "ATMID " . $atmid . " Exist!!";
                                                array_push($error_array, $sentence);
                                               
                                            } else {
                                                $atmidcount = 1;
                                                echo "ATM ID Not Found : ".$atmid." </br>";
                                                
                                            }

                                            $branchcount = 0;
                                            $branchsql = "select id from newbranch where branch = '" . $branch . "' ";
                                            $branchquery = mysqli_query($con, $branchsql);
                                            $branchsqlresult = mysqli_num_rows($branchquery);
                                            if ($branchsqlresult > 0) {
                                            } else {
                                                $branchcount = 1;
                                            }


                                            $zonecount = 0;
                                            $zonesql = "select id from newzone where zone_name = '" . $zone . "' ";
                                            $zonequery = mysqli_query($con, $zonesql);
                                            $zonesqlresult = mysqli_num_rows($zonequery);
                                            if ($zonesqlresult > 0) {
                                            } else {
                                                $zonecount = 1;
                                            }

                                            
                                            if ($zonecount == 0 && $branchcount==0 && $atmidcount==0 && $errorcount == 0) {
                                                
                                                $total_atm = $total_atm + 1;
                                                
                                                $searchatmid = mysqli_query($con,"select atmid from mis_newsitetest where atmid='".$atmid."' ");
                                                
                                                    $userid = $_SESSION['userid']; 
                                                    
                                                    $updatesql="update mis_newsitetest set atmid='".$atmid."', `activity`='".$activity."',`customer`='".$customer."',`bank`='".$bank."',`atmid2`='".$atmid2."',`atmid3`='".$atmid3."',`trackerno`='".$trackerno."',`address`='".$address."',`city`='".$city."',`state`='".$state."',`zone`='".$zone."',`branch`='".$branch."',`bm_name`='".$bm_name."',`bm_number`='".$bm_number."',`created_by`='".$created_by."',`created_at`='".$created_at."',`status`='1',engineer_user_id='".$engineer."' where atmid='".$atmid."' ";
                                                    // echo $updatesql;
                                                    $updatequery= mysqli_query($con,$updatesql);
                                                    if($updatequery){
                                                        $totalupdated_atm = $totalupdated_atm + 1;
                                                    }
                                                  
                                            } 
                                        }
                                    }

                                    // echo "ATM ID Not Found : ".$atmnot_found." Please Insert It First.</br>";
                                    echo "<b>Please Insert It First.</b><br>";
                                    echo "Total ATMID Updated : ".$totalupdated_atm." Out of ".$total_atm;
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">


<script>
    $("#delete_err").on('click', function() {
        if (confirm('Are you sure to delete all Records ?')) {
            $.ajax({

                type: "POST",
                url: 'delete_err_ajax.php',
                success: function(msg) {
                    if (msg == 1) {
                        $("#err_card").load(location.href + " #err_card>*", "");
                    }
                }
            });
        } else {
            alert('Canceled');
        }





    });


    $(document).ready(function() {


        $('#data_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
            ]
        });

        $('#data_table2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
            ]
        });

    });
</script>



</body>

</html>