<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');
$today_date = date('Y-m-d');

$status = $_GET['status'];

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
                                            <th>S. No.</th>
                                            <th>Engineer Name</th>
                                            <th>Location </th>
                                            <th>Contact</th>
                                            <th>Created Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                             $oncount = 0;
                                        $offcount = 0;  $i = 1;
                                        $sql = mysqli_query($con,"SELECT id from mis_loginusers where  designation = 4 and user_status = 1");
                                        
                                        if(mysqli_num_rows($sql)>0 ){
                                        while($res = mysqli_fetch_assoc($sql)){
                                            $eng_id = $res['id'];
                                            $view = 0;
                                            $statement = "select user_id,location,created_time from eng_locations where user_id='".$eng_id."' order by id desc limit 1";
                                             
                                            $sqle = mysqli_query($con,$statement);
                                            // $fetchrow = mysqli_fetch_row($sqle);
                                            // if($eng_id==277){
                                            //     echo mysqli_num_rows($sqle);
                                            // }
                                            if(mysqli_num_rows($sqle)>0 ){
                                                $engnamesql_res = mysqli_fetch_assoc($sqle);
                                                
                                                $eng_user_id = $engnamesql_res['user_id'];
                                                $location = $engnamesql_res['location'];
                                                
                                                $created_time = $engnamesql_res['created_time'];
                                                $created_date = date("Y-m-d", strtotime($created_time)); 
                                                
                                                $datetime = date("Y-m-d H:i:s");
                                                $date = date("Y-m-d");
                                                $start_date = new DateTime($datetime);  
                                                
                                                $since_start = $start_date->diff(new DateTime($created_time));
                                               
                                                $hr = $since_start->h;
                                                // echo 'Created Time : '. $created_time."<br>";
                                                // echo 'created_date' .$created_date."<br>";
                                                // echo $datetime."<br>"; die;
                                                
                                                if($date == $created_date) {
                                                    if($hr<=1)
                                                    {
                                                        if($status=='online'){
                                                            $view = 1;
                                                        }
                                                       
                                                    }
                                                    else if($hr > 1){
                                                        if($status=='offline'){
                                                            $view = 1;
                                                        }
                                                        
                                                    }
                                                }else{
                                                     if($status=='offline'){
                                                            $view = 1;
                                                        }
                                                }
                                            }else {
                                               
                                                if($status == "neverused"){
                                                    $view = 1;
                                                     $location = "-";
                                                    $created_time = "-";
                                                }
                                                
                                            }
                                            
                                            
                                           if($view==1){
                                            $sql_name = mysqli_query($con,"select name,contact from mis_loginusers where id ='".$eng_user_id."'  ");
                                            $sql_result_name = mysqli_fetch_assoc($sql_name);
                                            $eng_name = $sql_result_name['name'];
                                            $contact = $sql_result_name['contact'];
                                        ?>
                                                <tr>
                                                    <td><? echo $i."_".$eng_user_id; ?></td>
                                                    <td><? echo $eng_name;?></td>
                                                    <td><? echo $location; ?></td>
                                                    <td><? echo $contact; ?></td>
                                                    <td><? echo $created_time; ?></td>
                                                </tr>
                                        <? $i++; 
                                           } 
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