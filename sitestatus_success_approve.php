<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<style>
    .card-body{
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
                                    <div class="card-body">
                                        
                                        <?
                                
                                $date = date("Y-m-d");
                                $i=0;
                                $created_by = $_SESSION['userid'];
                                $created_at = date('Y-m-d H:i:s');
                                
                                $sql = mysqli_query($con,"select * from site_status_success where status=0");
                                while($sql_result = mysqli_fetch_assoc($sql)){
                                    
                                    $atmid = $sql_result['atmid'] ; 
                                    $dvr_status = $sql_result['dvr_status'] ; 
                                    $down_date = $sql_result['down_date'] ; 
                                    $current_status = $sql_result['current_status'] ; 
                                    $panel_status = $sql_result['panel_status'] ; 
                                    $panel_down_date = $sql_result['panel_down_date'] ; 
                                    $aging = $sql_result['aging'] ; 
                                    $site_status = $sql_result['site_status'];
                                    
                                    
                                    $insertsql = mysqli_query($con,"insert into site_status(`atmid`, `dvr_status`, `down_date`, `current_status`, `panel_status`, `panel_down_date`, `status`, `aging`, `site_status`, `created_at`, `created_by`) 
                                     values('".$atmid."','".$dvr_status."','".$down_date."','".$current_status."','".$panel_status."','".$panel_down_date."','1', '".$aging."', '".$site_status."' ,'".$created_at."','".$created_by."')");
                                    
                                    if($insertsql){
                                        mysqli_query($con,"update site_status_success set status=1 where atmid='".$atmid."'");
                                        $i++;
                                    }
                                    

                                    
                                }
                                
                                ?>
                                <p>Total <? echo $i ; ?> Record's inserted into site status</p>
                                 <script>
                                 setTimeout(function(){ 
                                      window.location.href = "sitestatus_bulk_upload.php";
                                   }, 2000);
                                    
                                </script>
                                        
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
    


</body>

</html>