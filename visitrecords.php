<?php session_start();
include('config.php');

if($_SESSION['username']){
include('header.php');
?>

        <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <h2>Visit Reports</h2>
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">    
                                            <thead>
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Name</th>
                                                    <th>ATMID</th>
                                                    <th>Call Given By</th>
                                                    <th>Bank</th>
                                                    <th>Purpose</th>
                                                    <th>Created By</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $count = 1 ; 
                                                $sql = mysqli_query($con,"select * from appportal_atmvisit where status=1 order by id desc");
                                                while($sql_result = mysqli_fetch_assoc($sql)){
                                                $name = $sql_result['name'];
                                                $atmid = $sql_result['atmid'];
                                                $bank = $sql_result['bank'];
                                                $purpose = $sql_result['purpose'];
                                                $callby = $sql_result['callby'];
                                                $created_by = $sql_result['created_by'];
                                                $created_at = $sql_result['created_at'];
                                                ?>
                                                <tr>
                                                    <td><? echo $count ; ?></td>
                                                    <td><? echo $name; ?></td>
                                                    <td><? echo $atmid; ?></td>
                                                    <td><? echo $callby?></td>
                                                    <td><? echo $bank; ?></td>
                                                    <td><? echo $purpose; ?></td>
                                                    <td><? echo get_member_name($created_by) ; ?></td>
                                                    <td><? echo $created_at ; ?></td>
                                                </tr>
                                                <? $count++; } ?>
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
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
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