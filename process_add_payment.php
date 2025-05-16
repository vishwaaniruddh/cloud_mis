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
                                        
                                        
                                        <?
                              //  echo '<pre>';print_r($_POST);echo '</pre>';die;
$totalrow = $_POST['totalrow'];                                
$atmidarray = $_POST['atmid']; //echo '<pre>';print_r($atmid);echo '</pre>'; 
$bankarray = $_POST['bank'];
$customerarray = $_POST['customer'];
$zonearray = $_POST['zone'];
$cityarray = $_POST['city'];
$statearray = $_POST['state'];
$locationarray = $_POST['location'];
$typearray = $_POST['type'];
$subtypearray = $_POST['subtype'];
$approved_byarray = $_POST['approved_by'];
$payee_type = $_POST['payee_type'];
$fundDetailsarray = $_POST['fundDetails'];
$approval_amountarray = $_POST['approval_amount'];
$required_amountarray = $_POST['required_amount'];
$beneficiary_name = $_POST['beneficiary_name'];
$account_number = $_POST['account_number'];
$ifsc_code = $_POST['ifsc_code'];
$remark = $_POST['remark'];
$approved_byarray = $_POST['approved_by'];
$_sendyear = $_POST['year'];
$_sendmonth = $_POST['month'];
$_bill_date = $_POST['bill_date'];
$_due_date = $_POST['due_date'];
$_invoice_no = $_POST['invoice_no'];

    $created_by = $_SESSION['userid'];
    $status = 4;
    $created_at = date('Y-m-d');
    
    
    $year = date('Y');      
    $month = date('m') ; 
                          
if (!is_dir('addfund/'.$year  .'/'.$month)) {
    mkdir('addfund/'.$year.'/'.$month, 0777, true);
}        

$target_dir = 'addfund/'.$year.'/'.$month;


$file_name=$_FILES["image"]["name"];

if($file_name){

    $file_tmp=$_FILES["image"]["tmp_name"];
    $file_name = str_replace(" ","",$file_name);
    
    move_uploaded_file($file_tmp=$_FILES["image"]["tmp_name"],$target_dir.'/'.$file_name);
    $attach = 'http://cssmumbai.sarmicrosystems.com/css/dash/esir/' . $target_dir.'/'.$file_name;
}


 for($i=0;$i<$totalrow;$i++){  
     $type = $typearray[$i];
     $subtype = $subtypearray[$i];
     $atmid = $atmidarray[$i];
     $atmid = $atmidarray[$i];
     $bank = $bankarray[$i];
     $customer = $customerarray[$i];
     $zone = $zonearray[$i];
     $city = $cityarray[$i];
     $state = $statearray[$i];
     $location = $locationarray[$i];
     $approval_amount = $approval_amountarray[$i];
     $required_amount = $required_amountarray[$i];
     $fundDetails = $fundDetailsarray[$i];
     $approved_by = $approved_byarray[$i];
     
    $sql = "insert into rnm_fund(type,subtype,atmid,bank,customer,zone,city,state,location,approval_amount,attach,remark,created_by,status,created_at,added_pos,payee_type,fundDetails,required_amount,account_number,beneficiary_name,ifsc_code,approved_by,year,month,bill_date,due_date,invoice_no) 
    values('".$type."','".$subtype."','".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$approval_amount."','".$attach."','".$remark."','".$created_by."','".$status."','".$created_at."','".$added_pos."','".$payee_type."','".$fundDetails."','".$required_amount."','".$account_number."','".$beneficiary_name."','".$ifsc_code."','".$approved_by."','".$_sendyear."','".$_sendmonth."','".$_bill_date."','".$_due_date."','".$_invoice_no."')";
    
   // $insert = mysqli_query($con,$sql); 
    if (mysqli_query($con, $sql)) {
       $last_id = mysqli_insert_id($con);
       $req_id = $last_id;
       $approved_amt = 0;
       $req_amt = $required_amount;
       $action = 1;
       $created_date = $created_at;
       $status = 4;
       $remarks = "";
    $fundsql = "insert into mis_fund_requests(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
            values('".$req_id."','".$req_amt."','".$req_amt."','".$created_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
    mysqli_query($con,$fundsql); 
    }
 }
                                        ?>
                                          
     <script>
        window.location.href="add_send_payment.php";
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
        window.location.href="auth/login.php";
    </script>
<? }
    ?>
</body>

</html>