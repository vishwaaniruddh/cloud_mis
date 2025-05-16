<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('headertest.php');
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
                                       
                                       
                                       
                                       
                                    //   var_dump($_REQUEST);
                                       
                                    //   return ;
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




$callTypes = $_REQUEST['callTypes'];
$callTypes=json_encode($callTypes);
$callTypes=str_replace( array('[',']','"') , ''  , $callTypes);
$callTypes=explode(',',$callTypes);
$callTypes = "" . implode ( ",", $callTypes )."";

$banks = $_POST['banks'];
$banks=json_encode($banks);
$banks=str_replace( array('[',']','"') , ''  , $banks);
$banks=explode(',',$banks);
$banks = "" . implode ( ",", $banks )."";


 $statement = "update mis_loginusers set branch ='".$cities."', zone='".$zone."', cust_id='".$cust_id."',callTypePermission='".$callTypes."',bankPermission='".$banks."' where id='".$userid."'" ;



if(mysqli_query($con,$statement)){ ?>
   <script>
       alert('Done !');
       window.location.href="./add_user.php";
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