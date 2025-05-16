<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');

if($_SESSION['username']){ 

include('header.php');
 

?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


<style>
    
   th.address, td.address {
    white-space: inherit;
}
</style>

<style>
.vl {
  border-left: 3px solid grey;
  height: 65px;
  position: absolute;
  left: 50%;
  margin-left: -3px;
  top: 0;
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
                                            <label>Date</label>
                                            <input type="date" class="form-control" name="date" id="date" required >
                                        </div>
                                        
                                        
                                    </div>

                                    <div class="col" style="display:flex;justify-content:center;">
                                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                    </div>


                                </form>

                                <!--Filter End -->
                                <hr>

                            </div>
                        </div>
                        
                        <?php
                            if($_POST['submit']){
                                
                                $engsql = mysqli_query($con,"select id from mis_loginusers where designation = 4 order by name");
                                while($sql_res = mysqli_fetch_assoc($engsql)) {
                                    $engid = $sql_res['id'];
                                    $date = $_POST['date'];
                                    if($engid){
                                        // $statement = "SELECT user_id,mac_id,location,latitude,longitude,created_time FROM `eng_locations_backup` where  user_id = '".$engid."' and  cast(created_time as date) = '".$date."' GROUP by hour(created_time) ";
                                        $statement = "SELECT user_id,mac_id,location,latitude,longitude,created_time FROM `eng_locations` where  user_id = '".$engid."' and  cast(created_time as date) = '".$date."' GROUP by hour(created_time) ";
                                            $stmt = "insert into eng_locations_new(user_id,mac_id,location,latitude,longitude,created_time) ".$statement." ";
                                             
                                            $csql = mysqli_query($con,$stmt);
                                            
                                            
                                        }
                                    }
                                    if($csql)
                                            { ?>
                                               <script>alert('Inserted Successfully');</script>
                                           <? }
                                            else { ?>
                                                <script>alert('Something Wrong!!');</script>
                                         <?   }
                                
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