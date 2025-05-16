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
                                
                                <?
                                
                                $id = $_GET['id'];
                                $sql= mysqli_query($con,"select * from mis_newsite where id='".$id."'");
                                $sql_result = mysqli_fetch_assoc($sql);
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        
                                        
                                        <?
                                        $id = $_POST['id'];
$activity = $_POST['activity'];
$customer = $_POST['customer'];
$bank = $_POST['bank'];
$atmid = $_POST['atmid'];
$trackerno = $_POST['trackerno'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zone = $_POST['zone'];
$branch = $_POST['branch'];
$bm_name = $_POST['bm_name'];
$bm_number = $_POST['bm_number'];
$created_by = $_POST['created_by'];
$created_at = $_POST['created_at'];
$status = $_POST['status'];
$engineer_user_id = $_POST['engineer_user_id'];


                                         $sql = "update mis_newsite set activity = '".$activity."',customer = '".$customer."',bank = '".$bank."',atmid = '".$atmid."',trackerno = '".$trackerno."',address = '".$address."',city = '".$city."',state = '".$state."',zone = '".$zone."',branch = '".$branch."',bm_name = '".$bm_name."',bm_number = '".$bm_number."',engineer_user_id = '".$engineer_user_id."' where id = '".$id."'" ; 
                                        
                                        if(mysqli_query($con,$sql)){ ?>
                                            <script>
                                                alert('Updated');
                                                window.location.href="atm_master.php";
                                            </script>
                                        <? }else{ ?>
                                            <script>
                                                alert('Error');
                                                window.location.href="atm_master.php";
                                            </script>
                                        <? } ?>

                      
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