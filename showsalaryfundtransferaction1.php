<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    
    include('config.php');
    
    if(isset($_POST['reqs'])){
        $app = json_decode($_POST['reqs']);
        $trans_id = $_POST['trans_id'];
        $batch_no = "";
        $action_by = $_SESSION['userid'];
        $chexcelsql="select filename from mis_salary_fund_transfer_excel_test where trans_id=".$trans_id;
        $filerow = 0;
        if($chexceltable=mysqli_query($con,$chexcelsql)){
            $filerow =  mysqli_num_rows($chexceltable);
        }
        if($filerow>0){
            $chexceltable=mysqli_query($con,$chexcelsql);
            $batchrow = mysqli_fetch_row($chexceltable);
            $batch_no = $batchrow[0]; 
        }else{
            $excelsql="select id from mis_salary_fund_transfer_excel_test order by id desc";
            $exceltable=mysqli_query($con,$excelsql); 
            if(mysqli_num_rows($exceltable)>0){
              $excelrowdata=mysqli_fetch_row($exceltable);
              $n = $excelrowdata[0];
              $n = $n + 1;
            }else{
              $n = 1;
            }
            
            $joindate = date('dmY');
            $filename = "CS".$n.$joindate;  
            
            $insertexcelsql = "insert into mis_salary_fund_transfer_excel_test(filename,trans_id) 
                    values('".$filename."','".$trans_id."')";
            mysqli_query($con,$insertexcelsql);
            
           /*  */
            $batch_no = $filename;
        }
        
        
        for($x=0;$x<count($app);$x++){ 
            $req_id = $app[$x];
            $currentstatus_sql="select current_status from mis_salary_fund_transfer WHERE req_id = ".$req_id;
            $currentstatustable=mysqli_query($con,$currentstatus_sql); 
            $currentstatusrow = mysqli_fetch_row($currentstatustable);
            $_currentstatus = $currentstatusrow[0];
            $updatesql = "";
            if($_currentstatus==1){
              $updatesql = "update mis_salary_fund_transfer SET current_status = 2, batch_no= '".$batch_no."',action_by= '".$action_by."' WHERE req_id = ".$req_id; 
            }
            if($_currentstatus==2){
              $updatesql = "update mis_salary_fund_transfer SET current_status = 3,action_by= '".$action_by."' WHERE req_id = ".$req_id;   
            }
            if($_currentstatus==3){
              $updatesql = "update mis_salary_fund_transfer SET current_status = 4,action_by= '".$action_by."' WHERE req_id = ".$req_id;   
            }
            if($updatesql!=""){
            mysqli_query($con,$updatesql); 
            }
        }
        
        
    } ?>
    
  <script>
     
     window.location.href="showsalaryfundtransfer1.php";
 </script>
    <?
}else{
    
}
?>