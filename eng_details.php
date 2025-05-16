<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');
$today_date = date('Y-m-d');

$eng_id = $_GET['id'];
$status = $_GET['status'];
$date = $_GET['date'];
// echo $status;
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
                                            <th>CSS BM Name </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            $i = 1;
                                            // echo $eng_id;
                                            
                                            
                                            
                                            // $sqlr = mysqli_query($con, "select * from mis_newsite where engineer_user_id='" . $eng_id . "' ");
                                            // $countsql = mysqli_num_rows($sqlr);
                                            // if ($countsql > 0) {
                                            //     while ($sql_result = mysqli_fetch_assoc($sqlr)) {
                                                    
                                            //         $atmid = $sql_result['atmid'];
                                            //         // echo $atmid;
                                            //         $site_sql = "select atmid,dvr_status from site_status where atmid='".$atmid."' and dvr_status = '".$status."'";
                                            //         echo $site_sql;
                                            //         $sitesql = mysqli_query($con,$site_sql);
                                            //         if(mysqli_num_rows($sitesql)>0){
                                            //             while($result = mysqli_fetch_assoc($sitesql)) {
                                                            
                                            //             $atm_id = $result['atmid'];
                                            //             $dvr_status = $result['dvr_status'];
                                            //             // echo $dvr_status;
                                                        
                                                        
                                            //             $engnamesql = mysqli_query($con,"select name from mis_loginusers where id='".$eng_id."' ");
                                            //             $engnamesql_res = mysqli_fetch_assoc($engnamesql);
                                            //             $eng_name = $engnamesql_res['name'];
                                                        
                                                        
                                            //             $bank = $sql_result['bank'];
                                            //             $customer = $sql_result['customer'];
                                            //             $address = $sql_result['address'];
                                            //             $city = $sql_result['city'];
                                            //             $state = $sql_result['state'];
                                            //             $bm_name = $sql_result['bm_name'];
                                                        
                                            //             }
                                            //         }
                                            
                                            
                                            $sql = "select * from site_status where atmid in(select atmid from mis_newsite where engineer_user_id='".$eng_id."') and dvr_status = '".$status."' and cast(created_at as date) = '".$date."' ";
                                            // echo $sql;
                                            $sqlr = mysqli_query($con,$sql);
                                            if(mysqli_num_rows($sqlr)>0) {
                                            while($sql_res = mysqli_fetch_assoc($sqlr)){
                                                $atmid = $sql_res['atmid'];
                                                
                                                $engdetailsql = mysqli_query($con,"select * from mis_newsite where atmid = '".$atmid."' ");
                                                $details = mysqli_fetch_assoc($engdetailsql);
                                                $bank = $details['bank'];
                                                $customer = $details['customer'];
                                                $city = $details['city'];
                                                $state = $details['state'];
                                                $address = $details['address'];
                                                $bm_name = $details['bm_name'];
                                                
                                                $engnamesql = mysqli_query($con,"select name from mis_loginusers where id='".$eng_id."' ");
                                                $engnamesql_res = mysqli_fetch_assoc($engnamesql);
                                                $eng_name = $engnamesql_res['name'];
                                                
                                        ?>
                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $atmid;?></td>
                                                    <td><? echo $bank; ?></td>
                                                    <td><? echo $customer; ?></td>
                                                    <td><? echo $city; ?></td>
                                                    <td><? echo $state; ?></td>
                                                    <td><? echo $address; ?></td>
                                                    <td><? echo $eng_name; ?></td>
                                                    <td><? echo $bm_name; ?></td>
                                                </tr>
                                        <? $i++;
                                        }
                                            }
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