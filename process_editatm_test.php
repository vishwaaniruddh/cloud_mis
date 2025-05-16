<?php session_start();
include('config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <?php                 
                    // print_r($_POST); die;
                        $id = $_POST['id'];
                        // echo $id; die;
                        $sql= mysqli_query($con,"select * from mis_newsite where id='".$id."'");
                        $sql_result = mysqli_fetch_assoc($sql);
                        $old_status = $sql_result['status'];
                    ?>
                    <div class="card">
                        <div class="card-body">
                        <?
                            $userid = $_SESSION['userid'];
                            
                            // $id = $_POST['id'];
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
                            $engineer_user_id = $_POST['engineer_user_id'];
                            $status = $_POST['status']; //1: Active 0: In-active
                            $remark = $_POST['remark'];
                            $serviceExecutive = $_REQUEST['serviceExecutive'];
                            
                            $Regional_Coordinator = $_REQUEST['Regional_Coordinator'];
                            $Surveillance_Head = $_REQUEST['Surveillance_Head'];
                            
                            $arr_misid = array();
                            $arr_idd = array();
                            $arr_atmid = array();
                            
                            $date = date('Y-m-d');
                                $datetime = date('Y-m-d H:i:s');                                
                                $sql = "update mis_newsite set activity = '".$activity."',customer = '".$customer."',bank = '".$bank."',atmid = '".$atmid."',trackerno = '".$trackerno."',address = '".$address."',city = '".$city."',state = '".$state."',zone = '".$zone."',branch = '".$branch."',bm_name = '".$bm_name."',bm_number = '".$bm_number."',engineer_user_id = '".$engineer_user_id."',status = '".$status."',created_at = '".$datetime."',serviceExecutive = '".$serviceExecutive."' ,
                                Regional_Coordinator = '".$Regional_Coordinator."' , Surveillance_Head = '".$Surveillance_Head."'
                                where id = '".$id."' " ; 
                            // echo $sql; 
                            if(mysqli_query($con,$sql)){
                           
                                $detailsql = mysqli_query($con,"select * from mis_details where atmid = '".$atmid."' and status!='close' ");
                                while($detailsql_result = mysqli_fetch_assoc($detailsql)) {
                                    $idd = $detailsql_result['id'];
                                    $misid = $detailsql_result['mis_id'];
                                    $misstatus = $detailsql_result['status'];
                                    $_atmid = $detailsql_result['atmid'];
                                    
                                    // array_push($arr_atmid,$_atmid);
                                    
                                    array_push($arr_misid,$misid);
                                    
                                    array_push($arr_idd,$idd);
                                }
                                
                                    // $_atmid = json_encode($arr_atmid);
                                    // $_atmid = str_replace(array('[', ']', '"'), '', $_atmid);
                                    // $arr_atmid = explode(',', $_id);
                                    // $atm_id = "'" . implode("', '", $arr_atmid) . "'";
                                    
                                    
                                    $_id = json_encode($arr_misid);
                                    $_id = str_replace(array('[', ']', '"'), '', $_id);
                                    $arr_misid_id = explode(',', $_id);
                                    $misid = "'" . implode("', '", $arr_misid_id) . "'";
                                    
                                   
                                    
                                    // $_idd = json_encode($arr_idd);
                                    // $_idd = str_replace(array('[', ']', '"'), '', $_idd);
                                    // $ar_idd = explode(',', $_idd);
                                    // $mid = "'" . implode("', '", $ar_idd) . "'";
                                    
                                    // print_r($misid); 
                                 
                            if($status == 0) { 
                                // echo 1;
                                if(count($arr_misid)>0){
                                    // echo 1;
                                    $update_mis_detail = mysqli_query($con,"update mis_details set status = 'close', close_date = '".$date."' where mis_id in ($misid) ");
                                    if($update_mis_detail){
                                        // echo 1;
                                       for($i=0;$i<count($arr_idd);$i++){
                                            // echo $misid;
                                            mysqli_query($con,"insert into mis_history(mis_id,type,remark,status,created_at,created_by) values('".$arr_idd[$i]."','close','".$remark."','1','".$datetime."','".$userid."')");
                                            
                                            mysqli_query($con,"insert into store_mis_details(mis_id,atmid,status_type,status,created_at,created_by) values ('".$arr_idd[$i]."','".$atmid."','".$misstatus."','".$status."','".$datetime."','".$userid."') ");
                                        }
                                           
                                       } else{ echo 2; }
                                }
                                else{
                                    echo "not updated";
                                }
                            }
                                else if($status == 1){
                                    
                                    $fetchdata = mysqli_query($con,"select * from store_mis_details where atmid = '".$atmid."' ");
                                    while($fetch_result = mysqli_fetch_assoc($fetchdata)){
                                    
                                    $mis_id_history = $fetch_result['mis_id'];
                                    $last_status = $fetch_result['status_type'];
                                    $atmid = $fetch_result['atmid'];
                                    
                                    $del_history = mysqli_query($con,"delete from mis_history where mis_id = '".$mis_id_history."' ");
                                    if($del_history){
                                        mysqli_query($con,"update mis_details set status = '".$last_status."', close_date = '0000-00-00' where id = '".$mis_id_history."' ");
                                    
                                        mysqli_query($con,"update mis_newsite set status = 1 where atmid = '".$atmid."' ");
                                        
                                        if($mis_id_history!='') {
                                            mysqli_query($con, "delete from store_mis_details where mis_id = '".$mis_id_history."' ");
                                        } else{
                                            // for($i=0;$i<count($arr_idd);$i++){
                                            //     mysqli_query($con,"insert into store_mis_details(mis_id,atmid,status_type,status,created_at,created_by) values ('".$arr_idd[$i]."','".$atmid."','".$misstatus."','".$status."','".$datetime."','".$userid."') ");
                                            // }   
                                        }
                                        
                                    }
                                }                    
                                       
                            } else { echo " ";}
                            ?>
                            <script>
                            alert('Updated');
                            window.location.href = "sitestest.php";
                            </script>
                            <?php }else{ ?>
                            <script>
                            alert('Error');
                            window.location.href = "sitestest.php";
                            </script>
                            <?php } ?>


                        </div>
                    </div>



                </div>
            </div>


        </div>
    </div>
</div>


<?php include('footer.php');
    }
else{ ?>

<script>
window.location.href = "login.php";
</script>
<?php }
    ?>



</body>

</html>