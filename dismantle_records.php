<? session_start();
include('config.php');

if($_SESSION['username']){ 
function getQuestion($id){
    global $con;
    $sql = mysqli_query($con,"select * from dismatleFormDetails where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['question'];
}
include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        <table class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <th>Sr no</th>
                                                <th>Customer</th>
                                                <th>Bank</th>
                                                <th>Created By</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            
                                                                                
                                        <!--get_member_name-->
                                        <?
                                        $sql = mysqli_query($con,"select * from dismantleFormResponse where status=1");
                                        
                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                            
                                            $id = $sql_result['id'];
                                            
                                            $inCounter=1; ?>
                                                <tr>
                                                    <td><? echo $inCounter; ?></td>
                                                    <td><? echo $sql_result['customer'];?></td>
                                                    <td><? echo $sql_result['bank'];?></td>
                                                    <td><? echo get_member_name($sql_result['created_by']);?></td>
                                                    <td><? echo $sql_result['created_at'];?></td>
                                                    <td><a href="viewDismantleRecords.php?id=<? echo $id; ?>">View</a></td>
                                                </tr>
                                        </table>
<? 
                                            // $quesSql = mysqli_query($con,"select * from dismantleFormResponseDetails where status=1");
                                            // while($quesSql_result = mysqli_fetch_assoc($quesSql)){
                                                
                                            //     $dismatleDetailId = $quesSql_result['dismatleDetailId'];
                                            //     echo '<h5>'.$inCounter . ') '. getQuestion($dismatleDetailId).'</h5>';
                                            //     echo $quesSql_result['response'];
                                            //     echo '<br>';
                                            //     $inCounter++;
                                            // }
                                            $inCounter++ ; 
                                        }
                                        
                                        
                                        ?>
                                        
                                        
                                        
                                        
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