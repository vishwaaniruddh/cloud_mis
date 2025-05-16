<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');
$today_date = date('Y-m-d');
// $last_date = "2022-07-20";
if ($_SESSION['username']) {

    include('header.php');


?>
    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


    <style>
        th.address,
        td.address {
            white-space: inherit;
        }
        td {
            text-align:center;
        }
    </style>
    
    
    

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">

                        <div class="card" id="filter">
                            <div class="card-block">
                                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Engineer</label>
                                            <select name="engineer" class="form-control">
                                                <option value=""> Select Engineer</option>
                                                <? $ac_sql = mysqli_query($con, "SELECT id,name as engineer from mis_loginusers where id in (select created_by from mis_newvisit_app) ORDER BY `engineer` ASC");
                                                while ($ac_sql_result = mysqli_fetch_assoc($ac_sql)) { 
                                                ?>
                                                
                                                    <option value="<? echo $ac_sql_result['id']; ?>" <? if ($_POST['engineer'] == $ac_sql_result['id']) { echo 'selected';} ?>>
                                                        <? echo $ac_sql_result['engineer']; ?>
                                                    </option>
                                                <? } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Date</label>
                                            <input type="date" name="dt" class="form-control" value="<? if ($_POST['dt']){ echo $_POST['dt']; } else {echo date('Y-m-d'); } ?>">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="col" style="display:flex;justify-content:center;">
                                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                    </div>


                                </form>

                                <!--Filter End -->
                                <hr>

                            </div>
                        </div>
                        
                        
                        
                        <?php if($_POST['submit'] && $_POST['dt'] && $_POST['engineer']) {
                            
                             $engid = $_POST['engineer'];
                                $date = $_POST['dt'];
                                
                                 $statement = "SELECT *, min(created_at) as min, max(created_at) as max,count(id) as total_visit from mis_newvisit_app where 1 ";
                                 
                                if(isset($engid) && $engid!=''){
                                    $statement .= " and created_by = '".$engid."' ";
                                }
                                
                                if(isset($date) && $date!=''){
                                    $statement .= "and cast(created_at as date) = '".$date."' ";
                                }
                            
                        ?>
                        <div class="card">
                            <div class="card-block" style="overflow: auto;">

                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sn No.</th>
                                            <th>Engineer Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Total Work Hour</th>
                                            <th>Total Visit in One Day</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $i = 1;
                                        // $count_eng = 0;
                                        // echo $statement;
                                        $csql = mysqli_query($con,$statement);
                                            $num_rows = mysqli_num_rows($csql);
                                            while($csql_result = mysqli_fetch_assoc($csql)) {
                                                
                                                $eng_name = $csql_result['engineer'];
                                                $total_visit = $csql_result['total_visit'];
                                                
                                                $start_time = $csql_result['min'];
                                                    $starttime = date('Y-m-d H:i:s',strtotime($start_time));
                                                    $dateTime1 = date_create($starttime); 
                                                     
                                                $end_time = $csql_result['max'];
                                                    $endtime = date('Y-m-d H:i:s',strtotime($end_time));
                                                    $dateTime2 = date_create($endtime);
                                                    
                                                    $diff = date_diff($dateTime1,$dateTime2);
                                                $aging = $diff->format("%h : %i ");
                                                // echo $starttime;
                                        ?>
                                                <tr>
                                                    <td><?=$i; ?></td>
                                                    <td><?=$eng_name; ?></td>
                                                    <td><?=$start_time; ?></td>
                                                    <td><?=$end_time; ?></td>
                                                    <td><?=$aging; ?></td>
                                                    <td><?=$total_visit; ?></td>
                                                </tr>
                                        <? $i++;
                                            }
                                         ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <? } ?>
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