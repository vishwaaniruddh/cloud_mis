<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    include('config.php');
    
    $created_by = $_SESSION['userid']; 
    
    /*
    
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
    */
    
   // $vendorstatement = "SELECT SUM(required_amount) FROM `mis_fund_transfer` WHERE type='Vendor payment'" ;  
    $vendorstatement1 = "SELECT SUM(approved_amt),fund_remark FROM `mis_fund_transfer` WHERE status='3' AND current_status='4' " ; 
    if(isset($_POST['submit'])){
        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
        {
        
        $date1 = $_POST['fromdt'] ; 
        $date2 = $_POST['todt'] ;
        $vendorstatement .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
        $vendorstatement1 .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
        }
    }
   // $vendorsql = mysqli_query($con,$vendorstatement);
  //  $vendorsql_result = mysqli_fetch_row($vendorsql);
  //  $totalvendoramt = $vendorsql_result[0]; 
    $vendorstatement1 .=" group by fund_remark";
    
    $vendorsql1 = mysqli_query($con,$vendorstatement1);
    
    $salarystatement = "SELECT SUM(amount),fund_remark FROM `mis_salary_fund_transfer` WHERE status='3' AND current_status='4' " ;  
    if(isset($_POST['submit'])){
        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
        {
        
        $date1 = $_POST['fromdt'] ; 
        $date2 = $_POST['todt'] ;
        $salarystatement .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
        }
    }
    $salarystatement .=" group by fund_remark";
    $salarysql = mysqli_query($con,$salarystatement);
   
   // $salarysql_result = mysqli_fetch_row($salarysql);
   // $totalsalaryamt = $salarysql_result[0]; 
    

?>
<link href="assets/css/userdashboard.css" rel="stylesheet" type="text/css" />
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        
                        <div class="card" id="filter">
                                    <div class="card-block">
                                        
                                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <div class="row">
                                                 
                                                 <div class="col-md-3">
                                                     <label>From Date</label>
                                                     <input type="date" name="fromdt" class="form-control" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }?>">    
                                                 </div>
                                                 <div class="col-md-3">
                                                     <label>To Date</label>
                                                     <input type="date" name="todt" class="form-control" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; } ?>">    
                                                 </div>
                                                 <!--<div class="col-md-2">
                                                     <label>Status</label>
                                                     <select id="multiselect_status" class="form-control" name="status">
                                                         <option value="all" <? if(isset($_POST['status'])) { if($_POST['status']=='all'){ echo 'selected' ;  }} ?>>All</option>
                                                         <option value="4" <? if(isset($_POST['status'])) { if($_POST['status']=='4'){ echo 'selected' ;  } } ?>>Transferred</option>
                                                         <option value="0" <? if(isset($_POST['status'])) { if($_POST['status']=='0'){ echo 'selected' ;  } } ?>>Rejected</option>
                                                     </select>
                                                 </div> -->
                                                 
                                            </div>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>
                                    
                                    <!--Filter End -->
                                    <hr>
                                          
                                      </div>
                                    </div>
                                <!--Filter Start -->
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form action="cmsexp_payment.php" method="POST">
                                             <input type="hidden" name="todt" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo '';}?>">
                                             <input type="hidden" name="fromdt" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '';}?>">
                                             <input type="submit" name="submit" value="Excel">
                                        </form> 
                                    </div>
                                </div>
                          
                          <div class="main-section">
                    	     <table class="table table-bordered table-striped table-hover dataTable no-footer" style="width:100%">
                    	        <thead>
                    	            <tr><th>E-Surveillance Payment</th></tr>
                                    <tr><th>Name</th><th>Amount</th><th>Details</th></tr>
                                </thead>
                    	        <tbody>
                    	            <? $total_vendor = 0;
                    	            
                    	            while($vendorsql_result = mysqli_fetch_array($vendorsql1)){ 
                    	              
                    	              $total_vendor = $total_vendor + $vendorsql_result[0];
                    	            ?>
                    	            <tr>
                    	               <td>
                    	                    <? echo $vendorsql_result[1]; ?>
                    	               </td>     
                    	               <td><? echo $vendorsql_result[0]; ?></td>
                    	               <td>
                    	                   <a data-toggle="modal" data-payment="1" data-id="<? echo $vendorsql_result[1]; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">
                    	                       View Details
                    	                   </a>
                    	               </td>    
                    	            </tr>
                    	            <? } ?>
                    	            <tr>
                    	                <td>Total E-Surveillance Payment</td><td><? echo $total_vendor; ?></td>
                    	            </tr>
                    	        </tbody> 
                    	         <thead>
                    	            <tr><th>Salary Payment</th></tr>
                                    <tr><th>Name</th><th>Amount</th><th>Details</th></tr>
                                </thead>
                    	        <tbody>
                    	            <? $total_salary = 0;
                    	            
                    	            while($salarysql_result = mysqli_fetch_array($salarysql)){ 
                    	              
                    	              $total_salary = $total_salary + $salarysql_result[0];
                    	            ?>
                    	            <tr>
                    	                  <td>
                    	                    <? echo $salarysql_result[1]; ?>
                    	                  </td>     
                    	                  <td><? echo $salarysql_result[0]; ?></td>
                    	                  <td>
                    	                      <a data-toggle="modal" data-payment="2" data-id="<? echo $salarysql_result[1]; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">
                    	                          View Details
                    	                      </a>       
                    	                  </td>
                    	            </tr>
                    	            <? } ?>
                    	            <tr>
                    	                <td>Total Salary Payment</td><td><? echo $total_salary; ?></td>
                    	            </tr>
                    	            <?
                    	              $totalpay = $total_salary + $total_vendor;
                    	            ?>
                    	            <thead>
                        	            <tr><th>Total Payment</th><th></th></tr>
                                        
                                    </thead>
                                    <tbody>
                                        <tr><td>Total Amount</td><td><? echo $totalpay; ?></td></tr>
                                    </tbody>
                    	        </tbody> 
                    	     </table>
                    		<!--
                    		<div class="dashbord email-content">
                    			<div class="title-section">
                    				<p>VENDOR PAYMENT AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-envelope-o" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totalvendoramt;?></h1>
                    				
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_details.php?case=6" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div>
                    		<div class="dashbord download-content">
                    			<div class="title-section">
                    				<p>SALARY PAYMENT AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-download" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totalsalaryamt; ?></h1>
                    					
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_staff_salary_details.php" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div>  -->
                    	
                    	</div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>    

<!-- large modal -->
<div class="modal fade" id="myModalDetail" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>More Details</h6>
          <div class="card">
            <div class="card-block" id="result_status" style=" overflow: auto;">
              
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>


<script>
   $(document).on("click", ".open-DetailDialog", function () {
     var fund_remark = $(this).data('id');
     var type = $(this).data('payment');
     $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "show_payment_details.php",  
        data: {fund_remark:fund_remark,type:type},
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $(".modal-body #result_status").html(response); 
            //alert(response);
        }
     });
    // $(".modal-body #result_status").val( reqStatus );
});

 $("#show_filter").css('display','none');
    
        $("#hide_filter").on('click',function(){
           $("#filter").css('display','none');
           $("#show_filter").css('display','block');
        });
        $("#show_filter").on('click',function(){
          $("#filter").css('display','block');
           $("#show_filter").css('display','none');
        });
</script>


 <? include('footer.php'); ?>
<? 
 }
?>