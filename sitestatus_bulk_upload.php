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
                                    <h5>Update Bulk Site Status <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
                                    <a class="btn btn-success" href="excelformat/bulk_site_status_excel.xlsx" download>BULK SITE STATUS UPLOAD FORMAT</a>

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
                                    // echo '<pre>';print_r($rowData);echo '</pre>';die;
                                    for ($i = 1; $i <= $row; $i++) {

                                        $atmid = $rowData[$i][0][0];

                                        if ($atmid) {

                                            $userid = $_SESSION['userid'];  
                                            $dvr_status = $rowData[$i][0][9];
                                            $dvr_date = $rowData[$i][0][10];
                                            $down_date = $rowData[$i][0][11];
                                            $down_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($down_date));
                                            $operate_status = $rowData[$i][0][12];   //current status
                                            $panel_status = $rowData[$i][0][13];
                                            $panel_down_date = $rowData[$i][0][14];
                                            $panel_down_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($panel_down_date));
                                            $errorcount = 0;
                                            
                                            $date = date("Y-m-d");
                                            $start_date = new DateTime($date);
                                            $since_start = $start_date->diff(new DateTime($down_date));
                                            
                                            $day = $since_start->d;
                                            // echo "Diff".$day;
                                            
                                            $aging = $day;

                                            
                                            $atmidcount = 0;
                                            $atmidsql = "select atmid from mis_newsite where atmid='" . $atmid . "' ";
                                            
                                            $atmidquery = mysqli_query($con, $atmidsql);
                                            if (mysqli_num_rows($atmidquery)==0) { 
                                                $sentence = "ATMID " . $atmid . " Not Exist!!";
                                                array_push($error_array, $sentence);
                                                $errorcount = 1;
                                            } else {
                                            }
                                            
                                            if($dvr_status=="Offline" and $panel_status=="Down")
                                            {
                                                $site_status = "DVR & Panel Down";
                                            }
                                            elseif($dvr_status=="Online" and $panel_status=="Down")
                                            {
                                                $site_status = "Panel Down";
                                            }
                                            
                                            elseif($dvr_status == "Offline" and $panel_status=="")
                                            {
                                                $site_status = "DVR Down";
                                            } else { }
                                            
                                            if($errorcount == 0){
                                                    $insertsql = "insert into site_status_success(`atmid`, `dvr_status`, `down_date`, `current_status`, `panel_status`, `panel_down_date`, `status`, `aging`, `site_status`, `created_at`, `created_by`) values('".$atmid."','".$dvr_status."','".$down_date."','".$operate_status."','".$panel_status."','".$panel_down_date."','0', '".$aging."', '".$site_status."' ,'".$created_at."','".$created_by."')";    
                                                    // echo $insertsql;
                                                    if(mysqli_query($con,$insertsql))
                                                    {
                                                      $updatekey = $updatekey + 1;
                                                    }else{
                                                        $sentence = "Atm ID ".$atmid." not able to insert its value";
                                                        array_push($error_array,$sentence); 
                                                    } 
                                            } else {
                                                $insert_data = "insert into site_status_error(`atmid`, `dvr_status`, `down_date`, `current_status`, `panel_status`, `panel_down_date`, `status`, `created_at`, `created_by`) values('".$atmid."', '".$dvr_status."', '".$down_date."', '".$operate_status."', '".$panel_status."', '".$panel_down_date."', '0', '".$created_at."','".$created_by."') ";
                                               // echo $insert_data;
                                                mysqli_query($con,$insert_data);
                                            }
                                            
                                        }
                                    }

                                    if($updatekey>0){ ?>
                                        <script>
                                            var key = <?php echo $updatekey;?>;
                                            alert("Total no of rows updated : "+key);</script>
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


                        <div class="card">
                            <div class="card-body">
                                <div class="two_end">
                                    <h6>Success Table</h6>
                                    <a class="btn btn-success" href="sitestatus_success_approve.php">Approve All To Site Status</a>
                                    <a class="btn btn-success" href="sitestatus_success_excel.php">Bulk Report Download</a>
                                </div>
                                <br>
                                <div class="card-data">
                                    <table class="table table-bordered table-striped" id="data_table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Sr no</th>
                                                <th>ATMID</th>
                                                <th>DVR Status</th>
                                                <th>Down Date</th>
                                                <th>Current Status</th>
                                                <th>Panel Status</th>
                                                <th>Panel Down Date</th>
                                                <th>Aging</th>
                                                <th>Site Status</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $i = 0;
                                            $sql = mysqli_query($con, "select * from site_status_success where status=0");
                                            while ($sql_result = mysqli_fetch_assoc($sql)) {
                                            ?>
                                                <tr>
                                                    <td><? echo ++$i; ?></td>
                                                    <td><? echo $sql_result['atmid']; ?></td>
                                                    <td><? echo $sql_result['dvr_status']; ?></td>
                                                    <td><? echo $sql_result['down_date']; ?></td>
                                                    <td><? echo $sql_result['current_status'];; ?></td>
                                                    <td><? echo $sql_result['panel_status']; ?></td>
                                                    <td><? echo $sql_result['panel_down_date']; ?></td>
                                                    <td><? echo $sql_result['aging']; ?></td>
                                                    <td><? echo $sql_result['site_status']; ?></td>
                                                    
                                                </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                </div>


                                <!--<a href="newsite_sucess_excel.php">Download</a>-->
                            </div>
                        </div>


                        <div class="card" id="err_card">
                            <div class="card-body">

                                <div class="two_end">
                                    <h6>Error Table</h6>
                                    <a href="#" id="delete_err" class="btn btn-danger">Delete All Records</a>
                                    <a class="btn btn-success" href="sitestatus_error_excel.php">Bulk Report Download</a>
                                </div>
                                <br>

                                <div class="card-data">
                                    <table class="table table-bordered table-striped" id="data_table2" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Sr no</th>
                                                <th>ATMID</th>
                                                <th>DVR Status</th>
                                                <th>Down Date</th>
                                                <th>Current Status</th>
                                                <th>Panel Status</th>
                                                <th>Panel Down Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $i = 0;
                                            $sql = mysqli_query($con, "select * from site_status_error where status=0");
                                            while ($sql_result = mysqli_fetch_assoc($sql)) {
                                            ?>
                                                <tr>
                                                    <td><? echo ++$i; ?></td>
                                                    <td><? echo $sql_result['atmid']; ?></td>
                                                    <td><? echo $sql_result['dvr_status']; ?></td>
                                                    <td><? echo $sql_result['down_date']; ?></td>
                                                    <td><? echo $sql_result['current_status'];; ?></td>
                                                    <td><? echo $sql_result['panel_status']; ?></td>
                                                    <td><? echo $sql_result['panel_down_date']; ?></td>
                                                </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!--<a href="newsite_sucess_excel.php">Download</a>-->
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
                url: 'delete_errsite.php',
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