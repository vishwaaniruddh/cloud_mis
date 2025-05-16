<?php session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');


?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function disable(id){

        Swal.fire({
              title: 'Are you sure?',
              text: "Think twice to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Proceed it!'
            }).then((result) => {
              if (result.isConfirmed) {
                
                   jQuery.ajax({
                            type: "POST",
                            url: 'update_checkqualitystatus.php',
                           data: 'id='+id,
                                success:function(msg) {
                                    
                                    if(msg==1){
                                            Swal.fire(
                                              'Updated!',
                                              'Status has been changed.',
                                              'success'
                                            );
                                            
                                            setTimeout(function(){ 
                                        window.location.reload();
                                    }, 2000);
                                    
                                    }else if(msg==0 || msg==2){
                                        
                                        Swal.fire(
                                         'Cancelled',
                                          'Your imaginary file is safe :)',
                                          'error'
                                            );
                                            
                                            
            
                                    }
                                    
                                }
                   });
            
            
              }
            })

    }
</script>
	<style>
		th.address,
		td.address {
			white-space: inherit;
		}


    .select2-container .select2-selection--single{height: auto !important;}
 </style>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
					   <div class="card" id="filter">
							<div class="card-block">
								<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
									<div class="row">
									    <div class="col-md-4">
										<label>ATM ID</label>
                                            <div class="input-group input-group-button">
                                                 <select class="form-control js-example-basic-single w-100" id="atmid" name="atmid" required>
                                                <option value="">Select ATM ID</option>
                                                    <?  $atm_sql = mysqli_query($con,"SELECT distinct(ATMID) FROM `sites_comfort`");
                                                       while($atm_sql_result = mysqli_fetch_assoc($atm_sql)){  ?>
                                                          <option value="<? echo strtoupper($atm_sql_result['ATMID']); ?>">
                                                       <?  echo strtoupper($atm_sql_result['ATMID']); ?>
                                                    </option> 
                                                       <? } ?>
                                              </select>
                                            </div>
                                        </div>
										<div class="col-md-3">
											<label>DateTime</label>
										
											<input type="datetime-local" class="form-control" name="datetime" id="datetime">
										</div>
									</div>
									<div class="col" style="display:flex;justify-content:center;">
										<input type="submit" id="submit" name="submit" value="Update" class="btn btn-primary"> </div>
								</form>
								<!--Filter End -->
								<hr> </div>
						</div> 
					    <?php 
					   $updatekey = 0;
					   if($_POST['submit']){
					       
					       $atmid = $_POST['atmid'];
					       $datetime = $_POST['datetime'];
					       $receivedtime = str_replace('T',' ',$datetime);
					       
					       //var_dump($receivedtime);echo "<br>";
                            $userid = $_SESSION['userid']; 
                            
            		        $qry = mysqli_query($con,"SELECT SN FROM `sites_comfort` WHERE ATMID = '".$atmid."' ");
                         
                            if(mysqli_num_rows($qry)){
                            while($sitesql_result = mysqli_fetch_assoc($qry)){
            			    $SN = $sitesql_result['SN'];
                    			    $updatesql= " UPDATE `network_report_com` SET `router`='".$receivedtime."',`dvr`='".$receivedtime."',`panel`='".$receivedtime."' where `SN`='".$SN."'";
                    				$month_result = mysqli_query($con,$updatesql);
                    				if($month_result){
                    				   // up network site
                    				   $update_network_list = mysqli_query($con,"update `network_report_list_com` set `router_status` = 1,`panel_status` = 1,`dvr_status` = 1,`router_lastcommunication` = '".$receivedtime."',`dvr_lastcommunication` = '".$receivedtime."',`panel_lastcommunication` = '".$receivedtime."' where `ATMID` = '".$atmid."' "); 
                        				if($update_network_list){
                        				    $updatekey = $updatekey + 1;  
                        				    echo 'ATMID '.$atmid.' updated its value.';
                        				}
                    				}
                                }
                            }
                        
                
                        }else { }
					  if($updatekey>0){ ?>
                                <script>
                                    var key = <?php echo $updatekey;?>;
                                    alert("Total no of rows updated : "+key);</script>
                       <?php } ?>
					   
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<? include('footer.php');
    }
else{ ?>
		<script>
			window.location.href = "login.php";

		</script>
		<? }
    ?>
    
			<script src="../datatable/jquery.dataTables.js"></script>
			<script src="../datatable/dataTables.bootstrap.js"></script>
			<!--<script src="../datatable/dataTables.buttons.min.js"></script>-->
			<script src="../datatable/buttons.flash.min.js"></script>
			<!--<script src="../datatable/jszip.min.js"></script>-->
			<!--<script src="../datatable/pdfmake.min.js"></script>-->
			<script src="../datatable/vfs_fonts.js"></script>
			<script src="../datatable/buttons.html5.min.js"></script>
			<script src="../datatable/buttons.print.min.js"></script>
			<script src="../datatable/jquery-datatable.js"></script>
			<script>
			    $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
			</script>
			
			</body>

			</html>
