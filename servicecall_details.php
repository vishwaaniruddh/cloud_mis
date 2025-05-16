<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');
$today_date = date('Y-m-d');

$engid = $_GET['id'];
$misid = $_GET['did'];
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            $i = 1;
                                            echo $misid;
                                            
                                            $sql = "select * from mis where id in (select mis_id from mis_details where mis_id = '".$misid."') ";
                                            echo $sql;
                                            $sqlr = mysqli_query($con,$sql);
                                            if(mysqli_num_rows($sqlr)>0) {
                                            while($sql_res = mysqli_fetch_assoc($sqlr)){
                                                $atmid = $sql_res['atmid'];
                                                
                                                echo $atmid;
                                                
                                                $engdetailsql = mysqli_query($con,"select * from mis_newsite where atmid = '".$atmid."' ");
                                                $details = mysqli_fetch_assoc($engdetailsql);
                                                $bank = $details['bank'];
                                                $customer = $details['customer'];
                                                $city = $details['city'];
                                                $state = $details['state'];
                                                $address = $details['address'];
                                                
                                                $engnamesql = mysqli_query($con,"select name from mis_loginusers where id='".$engid."' ");
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