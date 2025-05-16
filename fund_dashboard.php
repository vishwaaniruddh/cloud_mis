<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    include('config.php');
    
    $created_by = $_SESSION['userid']; 
    
    $statement = "select sum(approved_amt) from mis_fund_transfer where current_status=4 and status=3" ;  
    if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
            {
            
            $date1 = $_POST['fromdt'] ; 
            $date2 = $_POST['todt'] ;
            
            $statement .=" and transferred_date >= '".$date1."' and transferred_date <= '".$date2."'";
            }
    $sql = mysqli_query($con,$statement);
    $sql_result = mysqli_fetch_row($sql);
    $totalentryamt = $sql_result[0];
    
    
    $salarystatement = "SELECT SUM(amount) FROM `mis_salary_fund_transfer` where current_status=4 and status=3" ;  
    if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
            {
            
            $date1 = $_POST['fromdt'] ; 
            $date2 = $_POST['todt'] ;
            
            $salarystatement .=" and transferred_date >= '".$date1."' and transferred_date <= '".$date2."'";
            }
    $salarysql = mysqli_query($con,$salarystatement);
    $salarysql_result = mysqli_fetch_row($salarysql);
    $totalsalaryamt = $salarysql_result[0]; 
    
    $totaltransferapproveamt = $totalentryamt + $totalsalaryamt;

?>
<link href="assets/css/userdashboard.css" rel="stylesheet" type="text/css" />
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    
                     <div class="card" id="filter">
                                    <div class="card-block">
                                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <div class="row">
                                                 
                                                 <div class="col-md-3">
                                                     <label>From Date</label>
                                                     <input type="date" name="fromdt" class="form-control" value="<? if(isset($_POST['fromdt'])){ echo  $_POST['fromdt']; }else{ echo '2021-03-23' ; } ?>">    
                                                 </div>
                                                 <div class="col-md-3">
                                                     <label>To Date</label>
                                                     <input type="date" name="todt" class="form-control" value="<? if(isset($_POST['todt'])){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>">    
                                                 </div>
                                                
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
                                 <div style="display:flex;justify-content:space-around;">
        <h5 style="text-align:center;"></h5>
       
        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
    </div>  
                    
                    <div class="card">
                          
                          <div class="main-section">
                    	<!--	<div class="dashbord email-content">
                    			<div class="title-section">
                    				<p>ENTRY AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-envelope-o" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1></h1>
                    				
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
                    					<h1></h1>
                    					
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
                    					<h1></h1>
                    				
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
                    					<h1><? echo $totaltransferrejectamt; ?> </h1>
                    				
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    				<a href="view_full_details.php?case=5" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a>
                    			</div>
                    		</div> -->
                    		
                    		
                    		<div class="dashbord email-content">
                    			<div class="title-section">
                    				<p>FUND TRANSFER AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-envelope-o" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totalentryamt;?></h1>
                    				
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    			<!--	<a href="view_full_details.php?case=6" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a> -->
                    			</div>
                    		</div>
                    		<div class="dashbord download-content">
                    			<div class="title-section">
                    				<p>SALARY FUND TRANSFER AMOUNT</p>
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
                    			<!--	<a href="view_full_staff_salary_details.php" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a> -->
                    			</div>
                    		</div>
                    		<div class="dashbord email-content">
                    			<div class="title-section">
                    				<p>TOTAL TRANSFER AMOUNT</p>
                    			</div>
                    			<div class="icon-text-section">
                    				<div class="icon-section">
                    					<i class="fa fa-envelope-o" aria-hidden="true"></i>
                    				</div>
                    				<div class="text-section">
                    					<h1><? echo $totaltransferapproveamt ?></h1>
                    				
                    				</div>
                    				<div style="clear:both;"></div>
                    			</div>
                    			<div class="detail-section">
                    			<!--	<a href="view_full_details.php?case=4" target="_blank">
                    					<p>View Detail</p>
                    					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                    				</a> -->
                    			</div>
                    		</div>
                    	
                    	</div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>    
<script>
  
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