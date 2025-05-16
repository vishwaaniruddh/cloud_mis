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
                                $sql = mysqli_query($con,"select * from mis_newsitetest_success where status=0");
                                while($sql_result = mysqli_fetch_assoc($sql)){
                                    
                                    $activity = $sql_result['activity'] ; 
                                    $customer = $sql_result['customer'] ; 
                                    $bank = $sql_result['bank'] ; 
                                    $atmid = $sql_result['atmid'] ; 
                                    $atmid2 = $sql_result['atmid2'] ; 
                                    $atmid3 = $sql_result['atmid3'] ; 
                                    $trackerno = $sql_result['trackerno'] ; 
                                    $address = $sql_result['address'] ; 
                                    $city = $sql_result['city'] ; 
                                    $state = $sql_result['state'] ; 
                                    $zone = $sql_result['zone'] ; 
                                    $branch = $sql_result['branch'] ; 
                                    $bm_name = $sql_result['bm_name'] ; 
                                    $bm_number = $sql_result['bm_number'] ; 
                                    $engineer = $sql_result['engineer_user_id'];
                                    
                                    $insql = "insert into mis_newsite(activity,customer,bank,atmid,atmid2,atmid3,trackerno,address,city,state,zone,branch,bm_name,bm_number,created_by,created_at,status,engineer_user_id) 
                                    values('".$activity."','".$customer."','".$bank."','".$atmid."','".$atmid2."','".$atmid3."','".$trackerno."','".$address."','".$city."','".$state."','".$zone."','".$branch."','".$bm_name."',
                                    '".$bm_number."','','".$date."',1,'".$engineer."')" ;
                                    
                                    if(mysqli_query($con,$insql)){
                                        mysqli_query($con,"update mis_newsitetest_success set status=1 where atmid='".$atmid."'");
                                        $i++;
                                    }
                                    

                                    
                                }
                                
                                ?>
                                <p>Total <? echo $i ; ?> Record/s inserted into main site (Test)</p>
                                        
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