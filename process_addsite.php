<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
<?php

$datetime = date('Y-m-d h:i:s');
$serviceExecutive = $_REQUEST['serviceExecutive'];

$userid = $_SESSION['userid'];                                        
$activity = $_POST['activity'];
$customer = $_POST['customer'];
$bank = $_POST['bank'];
$atmid = $_POST['atmid'];
$atmid2 = $_POST['atmid2'];
$atmid3 = $_POST['atmid3'];
$trackerno = $_POST['trackerno'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zone = $_POST['zone'];
$branch = $_POST['branch'];
$bm_name = $_POST['bm_name'];
$bm_number = $_POST['bm_number'];
$engineer_user_id = $_POST['engineer_user_id'];
// $pincode = $_POST['pincode'];
// $live_dt = $_POST['live_date'];
// $live_dt = date('Y-m-d',$live_dt);


$sql = "insert into mis_newsite(activity,customer,bank,atmid,atmid2,atmid3,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,engineer_user_id,created_by,created_at,serviceExecutive) values('".$activity."','".$customer."','".$bank."','".$atmid."','".$atmid2."','".$atmid3."','".$trackerno."','".$address."','".$city."','".$state."','".$zone."','".$branch."','".$bm_name."','".$bm_number."','1','".$engineer_user_id."','".$userid."','".$datetime."','".$serviceExecutive."')";

if(mysqli_query($con,$sql)){ ?>
    <script>
        alert('Site Added Successfully !');
        window.location.href="sites.php";
    </script>
<? }else{ ?>
    <script>
        alert('Site Added Error !');
        window.history.back();
    </script>
<?  } ?>
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