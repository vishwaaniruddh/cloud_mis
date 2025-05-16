<? session_start();
include('config.php');

function send_approve_email($reqid,$atmid,$bank,$customer,$address,$amt,$fundDetails,$to){
  //  reqid, customer, bank, atmid, address, approveamt, fund
    $from = 'sujit7299@gmail.com';
    $subject = "Fund Approved Details";
    $message = "<b>Details of the fund requested.</b>";
    $message .= "<h1>ID :".$reqid."<br>Customer :".$customer."<br>Bank : ".$bank."<br>ATM ID : ".$atmid."<br>Address : ".$address." <br>Amount : ".$amt."<br>Fund Details : ".$fundDetails."</h1>";
    $header = "From:".$from." \r\n";
    // $header .= "Cc:prabir.d06@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
     
    $retval = mail ($to,$subject,$message,$header);
    
}

function send_reject_email($reqid,$atmid,$bank,$customer,$address,$amt,$fundDetails,$to){
  //  reqid, customer, bank, atmid, address, approveamt, fund
    $from = 'sujit7299@gmail.com';
    $subject = "Fund Approved Details";
    $message = "<b>Details of the fund requested.</b>";
    $message .= "<h1>ID :".$reqid."<br>Customer :".$customer."<br>Bank : ".$bank."<br>ATM ID : ".$atmid."<br>Address : ".$address." <br>Amount : ".$amt."<br>Fund Details : ".$fundDetails."</h1>";
    $header = "From:".$from." \r\n";
    // $header .= "Cc:prabir.d06@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
     
    $retval = mail ($to,$subject,$message,$header);
    
}

if($_SESSION['username']){ 
    $user_level = $_SESSION['level'];
    $req_id = $_POST['req_id'];
    $req_amt = $_POST['req_amt'];
    $approved_amt = $_POST['approved_amt'];
    $created_by = $_SESSION['userid'];
    $action = $_POST['action'];
    $remarks = $_POST['remarks'];
    $created_date = date('Y-m-d');
    $status = $_POST['status'];
    if($action==1){
        if($status==3){
            if($req_amt<=500){
                $status = 5;
            }
        }
        if($status==4){
            if($req_amt<=2000){
                $status = 5;
            }
        }
    }
  
  /*  $sql = "insert into mis_fund_requests(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
            values('".$req_id."','".$req_amt."','".$approved_amt."','".$created_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
    mysqli_query($con,$sql);
    
    $updatesql = "update rnm_fund SET required_amount = '".$req_amt."', status= '".$status."' WHERE id = ".$req_id; 
   
    mysqli_query($con,$updatesql);  */
    
    
    $rnm_stmt = "select created_by,atmid,bank,customer,location,fundDetails from rnm_fund where id='".$req_id."'";
    $rnm_sql = mysqli_query($con,$rnm_stmt);
    $rnm_rowresult = mysqli_fetch_row($rnm_sql);
    
     $_rnmfundcreatedby = $rnm_rowresult[0];
     $_rnmfundatmid = $rnm_rowresult[1];
     $_rnmfundbank = $rnm_rowresult[2];
     $_rnmfundcustomer = $rnm_rowresult[3];
     $_rnmfundlocation = $rnm_rowresult[4];
     $_rnmfundDetails = $rnm_rowresult[5];
    
    for($i=$user_level;$i>0;$i--){
        
        
        if($i==1){
            
            $user_statement = "select email,cust_id from mis_loginusers where id='".$_rnmfundcreatedby."'" ;
            $user_sql = mysqli_query($con,$user_statement);
            $user_rowresult = mysqli_fetch_row($user_sql);
            $to_email = $user_rowresult[0];
            if($action==1){
              send_approve_email($req_id,$_rnmfundatmid,$_rnmfundbank,$_rnmfundcustomer,$_rnmfundlocation,$approved_amt,$_rnmfundDetails,$to_email);
            }else{
                send_reject_email($req_id,$_rnmfundatmid,$_rnmfundbank,$_rnmfundcustomer,$_rnmfundlocation,$approved_amt,$_rnmfundDetails,$to_email);
            }
        }else{
            $user_statement = "select email,cust_id from mis_loginusers where level='".$i."'" ;
            $user_sql = mysqli_query($con,$user_statement);
            while($con_sql_result = mysqli_fetch_assoc($user_sql)){
                $user_email = $con_sql_result['email'];
                $cust_id = $con_sql_result['cust_id'];
                if($action==1){
                send_approve_email($req_id,$_rnmfundatmid,$_rnmfundbank,$_rnmfundcustomer,$_rnmfundlocation,$approved_amt,$_rnmfundDetails,$user_email);
                }else{
                 send_reject_email($req_id,$_rnmfundatmid,$_rnmfundbank,$_rnmfundcustomer,$_rnmfundlocation,$approved_amt,$_rnmfundDetails,$user_email);   
                }
            }
        }
    }
    
    $oneupperlevel = $user_level + 1;
    if($oneupperlevel==5){
        $oneupperlevel = 6;
    }
    $userlevel_statement = "select email,cust_id from mis_loginusers where level='".$oneupperlevel."'" ;
    $userlevel_sql = mysqli_query($con,$userlevel_statement);
    $userlevel_rowresult = mysqli_fetch_row($userlevel_sql);
    $upperto_email = $userlevel_rowresult[0];
    if($action==1){
      send_approve_email($req_id,$_rnmfundatmid,$_rnmfundbank,$_rnmfundcustomer,$_rnmfundlocation,$approved_amt,$_rnmfundDetails,$upperto_email);
    }else{
        send_reject_email($req_id,$_rnmfundatmid,$_rnmfundbank,$_rnmfundcustomer,$_rnmfundlocation,$approved_amt,$_rnmfundDetails,$upperto_email);
    }
    
    echo $req_id."_".$action;
 ?>
    
<?php    
}else{ ?>
    
    <script>
        window.location.href="auth/login.php";
    </script>
<? } ?>