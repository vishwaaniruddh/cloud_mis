<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    include('config.php');
    
    $created_by = $_SESSION['userid']; 
    
    $statement = "select sum(required_amount) from rnm_fund where created_by ='".$created_by."'" ;  
    $sql = mysqli_query($con,$statement);
    $sql_result = mysqli_fetch_row($sql);
    $totalentryamt = $sql_result[0];
    
    $approverejectstatement = "SELECT id FROM `rnm_fund` WHERE created_by='".$created_by."'" ;  
    $approverejectsql = mysqli_query($con,$approverejectstatement);
    $totalapproveamt = 0;
    $totalrejectamt = 0;
    $totaltransferapproveamt = 0;
    $totaltransferrejectamt = 0;
    while($approverejectsql_result = mysqli_fetch_assoc($approverejectsql)){ 
        $req_id=$approverejectsql_result['id'];
                                                
        $_approvesql="select approved_amt,action from mis_fund_requests where req_id='".$req_id."' order by id desc limit 1";
        $_approvetable=mysqli_query($con,$_approvesql);   
        $approverowcount=mysqli_num_rows($_approvetable);
        if($approverowcount>0){
          $approvesql_result = mysqli_fetch_row($_approvetable);
          if($approvesql_result[1]==1){
             $totalapproveamt = $totalapproveamt + $approvesql_result[0];
          }
        }
        
        
        $_rejectsql="select approved_amt from mis_fund_requests where action=0 and status<6 and req_id='".$req_id."' order by id desc";
        $_rejecttable=mysqli_query($con,$_rejectsql);   
        $rejectrowcount=mysqli_num_rows($_rejecttable);
        if($rejectrowcount>0){
          $rejectsql_result = mysqli_fetch_row($_rejecttable); 
          $totalrejectamt = $totalrejectamt + $rejectsql_result[0];
        }
        
        $_transferapprovesql="select approved_amt from mis_fund_transfer where current_status=4 and transferred_date!='0000-00-00' and req_id='".$req_id."' order by id desc";
        $_transferapprovetable=mysqli_query($con,$_transferapprovesql);   
        $transapproverowcount=mysqli_num_rows($_transferapprovetable);
        if($transapproverowcount>0){
          $transferapprovesql_result = mysqli_fetch_row($_transferapprovetable);
          $totaltransferapproveamt = $totaltransferapproveamt + $transferapprovesql_result[0];
        }
        
        
        $_transferrejectsql="select approved_amt from mis_fund_transfer where current_status=0 and req_id='".$req_id."' order by id desc";
        $_transferrejecttable=mysqli_query($con,$_transferrejectsql);   
        $transrejectrowcount=mysqli_num_rows($_transferrejecttable);
        if($transrejectrowcount>0){
          $transferrejectsql_result = mysqli_fetch_row($_transferrejecttable);
          $totaltransferrejectamt = $totaltransferrejectamt + $transferrejectsql_result[0];
        }
    } 
    
    /*
    $approvestatement = "SELECT SUM(rf.required_amount) FROM `rnm_fund` as rf JOIN `mis_fund_requests` as mfr ON mfr.req_id=rf.id WHERE rf.created_by='".$created_by."' and mfr.action=1" ;  
    $approvesql = mysqli_query($con,$approvestatement);
    $approvesql_result = mysqli_fetch_row($approvesql);
    $totalapproveamt = $approvesql_result[0]; */

?>
<link href="assets/css/userdashboard.css" rel="stylesheet" type="text/css" />
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                          
                          <div class="main-section">
                    		<div class="dashbord email-content">
                    			<div class="title-section">
                    				<p>ENTRY AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-envelope-o" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totalentryamt;?></h1>
                    				<!--	<span>+7% email list penetration</span>-->
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_details.php?case=1" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div>
                    		<div class="dashbord download-content">
                    			<div class="title-section">
                    				<p>APPROVED AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-download" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totalapproveamt; ?> <!--<small>k</small>--></h1>
                    					<!--<span>12% have started download</span>-->
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_approve_details.php" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div>
                    		<div class="dashbord product-content">
                    			<div class="title-section">
                    				<p>REJECTED AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-credit-card" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totalrejectamt;?> <!--<small>$</small>--></h1>
                    					<!--<span>$ 272 credit in your account</span>-->
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_reject_details.php" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div>
                    
                    		<div class="dashbord email-content">
                    			<div class="title-section">
                    				<p>TRANSFER AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-envelope-o" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totaltransferapproveamt ?></h1>
                    				<!--	<span>+7% email list penetration</span> -->
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_details.php?case=4" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div>
                    		<div class="dashbord download-content">
                    			<div class="title-section">
                    				<p>TRANSFER REJECT AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-download" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totaltransferrejectamt; ?> <!--<small>k</small>--></h1>
                    				<!--	<span>12% have started download</span>  -->
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_details.php?case=5" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div>
                    	<!--	<div class="dashbord product-content">
                    			<div class="title-section">
                    				<p>SALES FROM YOUR CREDIT-CARD</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-credit-card" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1>360 <small>$</small></h1>
                    					<span>$ 272 credit in your account</span>
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="#">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div> -->
                    	</div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>    


 <? include('footer.php'); ?>
<? 
 }
?>