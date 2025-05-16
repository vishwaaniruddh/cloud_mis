<!DOCTYPE html>
<html lang="en">
    <?php //include('head.php');
      include('header.php');
    
    ?>
	
	<style>
    .table thead th, .jsgrid .jsgrid-table thead th {
    border-top: 0;
    border-bottom-width: 1px;
    font-weight: bold;
    font-size: .9rem;
    padding: 0.4375rem;
}
		.bt{
				border-top: 1px solid #1e1f33;
		  }
		  .br
		  {
				border-right: 1px solid #282844;
		  }
		  #accordion div.card-body {
		/*	margin:4px, 4px;
			padding:4px;
			background-color: green;
			width: 500px;  */
			height: 210px;
			overflow-x: hidden;
			overflow-y: scroll;
			text-align:justify;
		}
	</style>
	<style>
		.menu-icon
		{
			width: 33px;
			margin-right: 7%;
		}
	</style>
     <?php //include('top-navbar.php');?>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_settings-panel.html -->
                <!-- partial -->
                <!-- partial:partials/_sidebar.html -->
                <?php //include('navbar.php');?>
                <!-- partial -->
  <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
          <div class="center">
              
               <h3 class="page-title" >
                Footage Request
            </h3>
          </div>



            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                </ol>
            </nav> -->
          </div>
        
          <div class="row">
		     
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                                   
              <div class="card-body">
                  <h4 class="card-title">Footage Request Bulk Upload</h4>
				   <div class="two_end">
						<h5>Footage Request <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5>
						<a class="btn btn-success" href="footage_bulkupload_format.xlsx" download>BULK UPLOAD FORMAT</a>
					</div>
					
					<?php   $month = date('m'); 
                            $month = (int)$month;
                            $month_array = ["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];   
                            
                            if(isset($_POST['submit'])){
								    $total_data_insert = 0;$total_data_insert_atm_exist = 0;
									$userid = $_SESSION['userid']; 
                                    // $con = OpenCon();
									$date = date('Y-m-d h:i:s a', time());
									$only_date = date('Y-m-d');
									$target_dir = 'PHPExcel/';
									$file_name=$_FILES["images"]["name"];
									$file_tmp=$_FILES["images"]["tmp_name"];
									$file =  $target_dir.'/'.$file_name;


									$status ='open';                      
									$created_by = $_SESSION['userid'];
									//date_default_timezone_set('Asia/Kolkata');    
									$created_at = date('Y-m-d H:i:s');


									move_uploaded_file($file_tmp = $_FILES["images"]["tmp_name"], $target_dir . '/' . $file_name);
                                    include('../PHPExcel/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
                                    $inputFileName = $file;

									  try {
										$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
										$objReader = PHPExcel_IOFactory::createReader($inputFileType);
										$objPHPExcel = $objReader->load($inputFileName);
									  } catch (Exception $e) {
										die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
											$e->getMessage());
									  }

									  $sheet = $objPHPExcel->getSheet(0);
									  $highestRow = $sheet->getHighestRow();
									  $highestColumn = $sheet->getHighestColumn();

									  for ($row = 1; $row <= $highestRow; $row++) { 
										$rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
																		null, true, false);
																	
									  }
									  
									  	// echo '<pre>';print_r($rowData);echo '</pre>';die;

									$row = $row-2;
									$error = '0';
									$contents='';
                                    $n = 0;
									$footage_status = "Will Update Shortly";
									$website_link = "https://103.141.218.26/ComfortTechnoNew";
								
									for($i = 1; $i<=$row; $i++){
										 $id = $rowData[$i][0][0];
										 // echo $atmid;
										 $trans_date = $rowData[$i][0][1];
										 $trans_time = $rowData[$i][0][2];
										 $_check_exist = 0; $_check_count = 0;
										 if($trans_date!=''){
											// echo $trans_date;
										   $_check_exist++;
										   $transdate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($trans_date));
										   

										 }
										 
										  if($trans_time!=''){
											  
										    $_check_exist++;
                                            $transtime = $trans_time;											
                                            $transactiontime = date('H:i', PHPExcel_Shared_Date::ExcelToPHP($trans_time));
										  }
										  
										 // echo 'TransactionDate : '.$transdate.' ,TransactionTime : '.$transactiontime;die;
										  
										  if($_check_exist==2){
											   $_check_count = 1;
										       $transactiondatetime = $transdate." ".$transtime;
										  }
									
										if($_check_count==1){
												//$sql = mysqli_query($con,"select * from sites where ATMID = '".$atmid."'");
											
											   // if(mysqli_num_rows($sql)>0){ 
												    
														$cardno = $rowData[$i][0][3];

														$trace_no = $rowData[$i][0][4];
														$trans_amount = $rowData[$i][0][5];
														$claim_amount = $rowData[$i][0][6];

														$atm_id = $rowData[$i][0][7];
														$circle = $rowData[$i][0][8];
														$zone = $rowData[$i][0][9];

														$cash_managed_vendor = $rowData[$i][0][10];
														$ej_pulling_vendor = $rowData[$i][0][11];
														$footage_vendor = $rowData[$i][0][12];

														$atm_location = $rowData[$i][0][13];
														$ej_final_status = $rowData[$i][0][14];
														$start_time = $rowData[$i][0][15];
														$end_time = $rowData[$i][0][16];

														$trans_type = $rowData[$i][0][17];
														
														if($start_time!=''){
														   $start_time = date('H:i:s', PHPExcel_Shared_Date::ExcelToPHP($start_time));
														} 
														if($end_time!=''){
														   $end_time = date('H:i:s', PHPExcel_Shared_Date::ExcelToPHP($end_time));
														}
														
														//$created_at = date('Y-m-d H:i:s');
														$updated_at = date('Y-m-d H:i:s');
														// $created_by = 24;
														$updated_by = $created_by;
													//if($timeoftxn!='' && $start_time!='' && $end_time!='' && $claim_date!='' && $complaint_date!='' && $dateoftxn!=''){
													
													if($start_time!='' && $end_time!=''){
														
			                                            $n2 = str_pad($n + 1, 4, 0, STR_PAD_LEFT);
														$n++;
														$month_var = $month_array[$month-1];
														$unique_id = "HITACHI".$month_var.$n2;
														$statement = " INSERT INTO `footage_request_bulk_upload`( `bank_ticket_id`, `trans_datetime`, `trans_date`,  `trans_time`, `card_no`,`trace_no`, `trans_amount`, `claim_amount`, `atm_id`, `circle`, `zone`, `cash_managed_vendor`, `ej_pulling_vendor`, `footage_vendor`, `atm_location`, `ej_final_status`, `start_time`, `end_time`, `trans_type`, `unique_id`, `footage_status`, `website_link`, `created_by`, `updated_by`) 
														                                                VALUES ('".$id."','".$transactiondatetime."','".$transdate."','".$transtime."', '".$cardno."', '".$trace_no."','".$trans_amount."','".$claim_amount."','".$atm_id."','".$circle."','".$zone."','".$cash_managed_vendor."','".$ej_pulling_vendor."','".$footage_vendor."','".$atm_location."','".$ej_final_status."','".$start_time."','".$end_time."','".$trans_type."','".$unique_id."','".$footage_status."','".$website_link."','".$created_by."','".$updated_by."') ";
														//echo $statement;die;
														if(mysqli_query($con,$statement)){
															$total_data_insert = $total_data_insert + 1;
																	echo 'Request created for ATMID : ' . $atm_id ; 
																	echo '<br>';
														}
													}else{
														echo 'ATMID : ' . $atm_id . ' must have start and end time value'; 
																echo '<br>';
													}
											 
											}

									}
								// CloseCon($con);
								echo 'Total Footage Data Inserted : '.$total_data_insert;echo '<br>';
								echo 'Total ATM Not Exist in Site Table : '.$total_data_insert_atm_exist;
                     	    }
							?>
	   				
                           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            
                                            <div class="col-sm-4">
                                                <input type="file" name="images" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4">
                                                  <input type="submit" name="submit" value="upload" class="btn btn-danger">
                                            </div>
                                                
                                        </div>
                                    </form>                
                </div>
              </div>
            </div>

          </div>
        </div>



        <!-- content-wrapper ends -->
       <!-- partial:partials/_footer.html -->
                    <?php include('footer.php');?>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js">
        </script>
        <script src="vendors/js/vendor.bundle.addons.js">
        </script>
        <!-- endinject -->
        <!-- Plugin js for this page-->
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="js/off-canvas.js">
        </script>
        <script src="js/hoverable-collapse.js">
        </script>
        <script src="js/misc.js">
        </script>
        <script src="js/settings.js">
        </script>
        <script src="js/todolist.js"></script>
        <!--<script src="js/chart.js"></script>-->
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="js/dashboard.js"></script>
        
        <!-- End custom js for this page-->
        <!-- video.js -->
        <script src="js/dvrdashboard.js"></script>
		<script src="js/select2.js"></script>
        <!-- video.js -->
       <script>
	        $("#AtmID").change(function(){
				var AtmID= $("#AtmID").val();
				$('#atmid').val(AtmID);
			});
	   </script>
    
    </body>
</html>

