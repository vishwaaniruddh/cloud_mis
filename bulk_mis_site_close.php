<?php 
/*
    Work in progress (^_^)
*/

session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
	<style>
		.card-data {
			overflow-x: auto;
		}

	</style>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="two_end">
									<h5>Site Bulk Close <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5> <a class="btn btn-success" href="" download>Site Bulk Close FORMAT</a> </div>
								<? 
                                      
                                      if(isset($_POST['submit'])){
                                        $userid = $_SESSION['userid'];
                                        $date = date('Y-m-d h:i:s a', time());
                                        $only_date = date('Y-m-d');
                                        $target_dir = '../PHPExcel/';
                                        $file_name=$_FILES["images"]["name"];
                                        $file_tmp=$_FILES["images"]["tmp_name"];
                                        $file =  $target_dir.'/'.$file_name;
                                        
                                        $status ='open';                      
                                        $created_by = $_SESSION['userid'];
                                        $created_at = date('Y-m-d H:i:s');
                                    
                                        move_uploaded_file($file_tmp=$_FILES["images"]["tmp_name"],$target_dir.'/'.$file_name);
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
                                            
                                            // echo count($sheet); 
                                        
                                          for ($row = 1; $row <= $highestRow; $row++) { 
                                            $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                                                            null, true, false);
                                                                        
                                          }
                                        // echo '<pre>';print_r($rowData);echo '</pre>';die;
                                        $row = $row-2;
                                        $error = '0';
                                        $contents='';
                                           $updatekey = 0;
                                        
                                           $error_array = array();
                                        
                                            for($i = 1; $i<=$row; $i++){
                                        
                                              $atmid = $rowData[$i][0][0]; 
                                              
                                              if($atmid){
                                              
                                            if(isset($rowData[$i][0][2]))
                                            { ?>
                                                <script>
                                                    alert("Error!! Please Upload Correct Excel Format!!");
                                                    window.location.href="bulk_mis_site_close.php";
                                                </script>  
                                            <? }else {
                                                
                                        
                                              
                                              $check = mysqli_query($con,"select atmid from mis where atmid = '".$atmid."'");
                                              $check_res = mysqli_fetch_assoc($check);
                                              $_atmid = $check_res['atmid'];
                                            //   echo '<pre>';print_r($_atmid);echo '</pre>';die;
                                               
                                              if($atmid != $_atmid){
                                                  echo "Atmid ID ".$atmid." not Exist!!</br>";
                                              } else 
                                                if($atmid){
                                                    
                                                        $userid = $_SESSION['userid']; 
                                                        // echo $userid;
                                                        $status = "close";
                                                        $remark = $rowData[$i][0][1];
                                                        // echo  $remark;
                                                        $created_at = $date = date('Y-m-d H:i:s');
                                                        
                                                        $search = mysqli_query($con,"select * from mis_details where atmid = '".$atmid."' ");
                                                        $search_rows = mysqli_num_rows($search);
                                                        while($search_result = mysqli_fetch_assoc($search)){
                                                            $misid = $search_result['id'];
                                                            $mis_atmid = $search_result['atmid'];
                                                            // echo $misid."<br>"; 
                                                            $mis_status = $search_result['status'];
                                                            $mis_ticketid = $search_result['ticket_id'];
                                                            
                                                            if($mis_status == 'close'){
                                                                $sentence = "Ticket ID ".$mis_ticketid." has status already closed. ";
                                                            array_push($error_array,$sentence); 
                                                            } else {
                                                                // $updatekey = $updatekey + 1;
                                                                echo $misid."=".$mis_ticketid."  "."<br>";
                                                            }
                                                            
                                                        }
                                                       // echo $misid;die;
                                                        // $update = mysqli_query($con,"update mis_details set status='".$status."' where atmid='".$misid."' ");
                                                        // // var_dump($update);
                                                        // if($update)
                                                        // {
                                                        //     $insertqry = mysqli_query($con,"insert into mis_history(mis_id,type,remark,status,created_at,created_by,close_type)values('".$misid."','".$status."','".$remark."',1,'".$created_at."','".$userid."','".$close_type."')");
                                                            
                                                        // }
                                                        // if($insertqry){ 
                                                        //     $updatekey = $updatekey + 1;
                                                        //     // $insertkey = $updatekey + 1;
                                                        // }else{
                                                        //     $sentence = "Ticket ID ".$ticketid." not able to update its value";
                                                        //     array_push($error_array,$sentence); 
                                                        // }
                                                    
                                                }else{
                                                    $sentence = "Row ".$i." not have atmid Id";
                                                    array_push($error_array,$sentence); 
                                                }
                                              
                                             }          
                                              }
                                        
                                           }
              if($updatekey>0){ ?>
									<script>
										var key = <?php echo $updatekey;?>;
										alert("Total no of rows updated : " + key);

									</script>
									<?php   }

                                    
                                }
                                ?>
										<?php if(isset($error_array)){ 
                                     if(count($error_array)>0){
                                  ?> List of errors :
											<ul>
												<?php for($i=0;$i<count($error_array);$i++){ ?>
													<li>
														<?php echo $error_array[$i];?>
													</li>
													<?php } ?>
											</ul>
											<?php }} ?>
												<form action="<? echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
													<div class="form-group row">
														<div class="col-sm-4">
															<input type="file" name="images" class="form-control" required> </div>
														<div class="col-sm-4">
															<input type="submit" name="submit" value="upload" class="btn btn-danger"> </div>
													</div>
												</form>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="two_end">
									<h6>Site Bulk Close Table</h6>
								</div>
								<br>
								<div class="card-data">
									<table class="table table-bordered table-striped" id="data_table" style="width:100%;">
										<thead>
											<tr>
												<th>Sr no</th>
												<th>Ticket ID</th>
												<th>Status</th>
												<th>Remark</th>
												
											</tr>
										</thead>
										<tbody>
											<?
                                                $i=0;
                                                $sqldata = mysqli_query($con,"select * from mis_details where atmid='".$atmid."' ");
                                                while($sql_result = mysqli_fetch_assoc($sqldata)){
                                                    $_misid = $sql_result['id'];
                                                    $closeData = mysqli_query($con,"select * from mis_history where mis_id='".$_misid."' and status=1 and close_type!='' ");
                                                    $closeData_result = mysqli_fetch_assoc($closeData);
                                            ?>
												<tr>
													<td>
														<? echo ++$i;?>
													</td>
													<td>
														<? echo $sql_result['ticket_id'] ; ?>
													</td>
													<td>
														<? echo $sql_result['status'] ; ?>
													</td>
													<td>
														<? echo $closeData_result['remark'] ; ?>
													</td>
													
												</tr>
												<? } ?>
										</tbody>
									</table>
								</div>
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
			window.location.href = "login.php";

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
