<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');
$today_date = date('Y-m-d');

$fid = $_GET['fid'];
if ($_SESSION['username']) {

    include('header.php');


?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


    <style>
        th.address,
        td.address {
            white-space: inherit;
        }
    </style>

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card">
                            <div class="card-block" style="overflow: auto;">

                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sn No.</th>
                                            <th>Atmid</th>
                                            <th>Bank </th>
                                            <th>Customer</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Address</th>
                                            <th>Engineer Name</th>
                                            <th>CSS BM Name</th>
                                            <th>Recording Date</th>
                                            <th>Recording From</th>
                                            <th>Recording To</th>
                                            <th>status</th>
                                            <th>resolution date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            $i = 1;
                                            $sql = "select * from footage_bulk_request where id='".$fid."' ";
                                            $sqlr = mysqli_query($con, $sql);
                                            $countsql = mysqli_num_rows($sqlr);
                                            if ($countsql > 0) {
                                                while ($sql_result = mysqli_fetch_assoc($sqlr)) {
                                                    $atm_id = $sql_result['atmid'];
                                                    $bank = $sql_result['bank'];
                                                    $customer = $sql_result['customer'];
                                                    $city = $sql_result['city'];
                                                    $state = $sql_result['state'];
                                                    $address = $sql_result['address'];
                                                    $eng_name = $sql_result['engg_name'];
                                                    $bm_name = $sql_result['css_bm'];
                                                    $recording_dt = $sql_result['recording_date'];
                                                    $recording_from = $sql_result['recording_from'];
                                                    $recording_to = $sql_result['recording_to'];
                                                    $status = $sql_result['status'];
                                                    $resolution_dt = $sql_result['resolution_date'];
                                                    
                                                }
                                            }   
                                                
                                        ?>
                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $atm_id;?></td>
                                                    <td><? echo $bank; ?></td>
                                                    <td><? echo $customer; ?></td>
                                                    <td><? echo $city; ?></td>
                                                    <td><? echo $state; ?></td>
                                                    <td><? echo $address; ?></td>
                                                    <td><? echo $eng_name; ?></td>
                                                    <td><? echo $bm_name; ?></td>
                                                    <td><? echo $recording_dt; ?></td>
                                                    <td><? echo $recording_from; ?></td>
                                                    <td><? echo $recording_to; ?></td>
                                                    <td><? echo $status; ?></td>
                                                    <td><? echo $resolution_dt; ?></td>
                                                </tr>
                                        <? $i++;
                                         ?>
                                    </tbody>
                                </table>
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