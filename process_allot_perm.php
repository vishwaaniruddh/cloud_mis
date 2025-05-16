<? session_start();
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
                                <div class="card">
                                    <div class="card-block">
                                       
                                       
                                       
                                       <?
                                       $cities = $_POST['cities'];
                                       $userid = $_POST['userid'];
                                       
$cities=json_encode($cities);
$cities=str_replace( array('[',']','"') , ''  , $cities);
$arr=explode(',',$cities);
$cities = "" . implode ( ",", $arr )."";


$zone = $_POST['zone'];
$zone=json_encode($zone);
$zone=str_replace( array('[',']','"') , ''  , $zone);
$zone=explode(',',$zone);
$zone = "" . implode ( ",", $zone )."";

$cust_id = $_POST['cust_id'];
$cust_id=json_encode($cust_id);
$cust_id=str_replace( array('[',']','"') , ''  , $cust_id);
$cust_id=explode(',',$cust_id);
$cust_id = "" . implode ( ",", $cust_id )."";


 $statement = "update mis_loginusers set branch ='".$cities."', zone='".$zone."', cust_id='".$cust_id."' where id='".$userid."'" ;



if(mysqli_query($con,$statement)){ ?>
   <script>
       alert('Done !');
       window.location.href="permissions.php";
   </script>
   
<? }




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