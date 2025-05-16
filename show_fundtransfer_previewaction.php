<? session_start();
include('config.php');

if($_SESSION['username']){ 
$_resultdata = 0;

if(isset($_POST['apps'])){ 
    if(!empty($_POST['apps'])){
        $app=$_POST['apps'];
       // echo '<pre>';print_r($app);echo '</pre>';
        if(!empty($app)){
            $transresult=mysqli_query($con,"select max(trans_id) from mis_fund_transfer"); 
           // $rowcount=mysqli_num_rows($transresult);
            $trans=mysqli_fetch_row($transresult);
            $rowcount = $trans[0];
            $tid= $rowcount+1;
            for($x=0;$x<count($app);$x++){  
                $_id = $app[$x];
            //    echo 'id:'.$_id.' next ';
                $postsql="select fund_remark,account_number,trans_id from mis_fund_transfer where id='".$app[$x]."'";
        	    $posttable=mysqli_query($con,$postsql);    
                $postrow=mysqli_fetch_row($posttable);
                $fund_details = $postrow[0];
                $account_number = $postrow[1];
                $transid = $postrow[2];
                
                /* if($rowcount==0){
                     $tid = 1;
                 }else{
                     $trans=mysqli_fetch_row($transresult);
                     $tid = $trans[0];
                     $tid++;
                 } */
                 
                // echo $tid;die;
                
                $updatesql = "update mis_fund_transfer SET status= 3,trans_id='".$tid."' WHERE trans_id='".$transid."' and account_number = '".$account_number."' and fund_remark ='".$fund_details."'"; 
                mysqli_query($con,$updatesql);
                ?>
               
               <script>
                  window.location.href="show_fundtransfer_detail.php";

               </script>  
           
          <?  }
           
        }
    }
}
}
?>