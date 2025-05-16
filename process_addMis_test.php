<? session_start();
date_default_timezone_set('Asia/Kolkata');

include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                        
                                        
                                        <?
$status ='open';                      
$created_by = $_SESSION['userid'];                                        
// $created_at = date('Y-m-d');

$created_at = date('Y-m-d H:i:s');

$atmid = $_POST['atmid'];
$bank = $_POST['bank'];
$customer = $_POST['customer'];
$zone = $_POST['zone'];
$city = $_POST['city'];
$state = $_POST['state'];
$location = $_POST['location'];
$branch = $_POST['branch'];
$bm = $_POST['bm'];

$call_receive = $_POST['call_receive'];


$amount = $_POST['amount'];
$remarks = $_POST['remarks'];


// $remarks = 'NULL';
$amount = 'NULL';

$comp = $_POST['comp'];
$subcomp = $_POST['subcomp'];
$docket_no = $_POST['docket_no'];


$count = count($comp);

$mis_city_sql = mysqli_query($con,"select * from mis_city where city ='".$city."'");
if($mis_city_sql_result  = mysqli_fetch_assoc($mis_city_sql)){ 
    $mis_city = $mis_city_sql_result['id'];    
}
else{
    // mysqli_query($con,"insert into mis_city(city) values('".$city."')");
    // $mis_city = $con->insert_id; 
}

$engineer_sql = mysqli_query($con,"select * from mis_newsite where atmid like '%".$atmid."%'");
$engineer_user_id = "";
if(mysqli_num_rows($engineer_sql)>0){
    if($engsql_result = mysqli_fetch_assoc($engineer_sql)){
       $engineer_user_id = $engsql_result['engineer_user_id'];   
    }
}

$statement = "insert into mis_1_test(atmid,bank,customer,zone,city,state,location,call_receive_from,remarks,status,created_by,created_at,branch,bm) values('".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$call_receive."','".$remarks."','open','".$created_by."','".$created_at."','".$branch."','".$bm."')";

if(mysqli_query($con,$statement)){
    
    $mis_id = $con->insert_id ;
    
     for($i=0;$i<$count;$i++){
        
        $last_sql = mysqli_query($con,"select id from mis_details order by id desc");
        $last_sql_result = mysqli_fetch_assoc($last_sql);
        $last = $last_sql_result['id'];
        
        if(!$last){
            $last=0;
        }
        $ticket_id =  mb_substr(date('M'), 0, 1).date('Y') .date('m')  . date('d') . sprintf('%04u', $last) ;
        
        
     /*   $comp_sql=mysqli_query($con,"select * from mis_component where id='".$comp[$i]."'");
        $comp_sql_result= mysqli_fetch_assoc($comp_sql);
        $com = $comp_sql_result['name']; */
        $com = $comp[$i];
        
        $subcomp_sql=mysqli_query($con,"select * from mis_subcomponent where id='".$subcomp[$i]."'");
        $subcomp_sql_result= mysqli_fetch_assoc($subcomp_sql);
        $subcom = $subcomp_sql_result['name'];
        
        
         $detai_statement = "insert into mis_details_1_test(mis_id,atmid,component,subcomponent,engineer,docket_no,status,created_at,ticket_id,amount,mis_city,zone) values('".$mis_id."','".$atmid."','".$com."','".$subcom."','".$engineer_user_id."','".$docket_no[$i]."','".$status."','".$created_at."','".$ticket_id."','".$amount."','".$mis_city."','".$zone."')" ;
        if(mysqli_query($con,$detai_statement)){ 
        ?>


        <? 
        
    }
        
    }
    
    ?>
        <script>
        swal("Great !", "Call Created Successfully !", "success");
        
            setTimeout(function(){ 
                window.history.back();
            }, 2000);

    </script>

<?     
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