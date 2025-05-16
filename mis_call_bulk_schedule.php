<?php session_start();
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
									<h5>Call Bulk Schedule <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5> <a class="btn btn-success" href="excelformat/mis_call_bulk_schedule.xlsx" download>Call Bulk Schedule Format</a> </div>
								<?php 
                                      
                                      if(isset($_POST['submit'])){
$userid = $_SESSION['userid']; 

    $date = date('Y-m-d h:i:s a', time());
    $only_date = date('Y-m-d');
    $target_dir = '../PHPExcel/';
    $file_name=$_FILES["images"]["name"];
    $file_tmp=$_FILES["images"]["tmp_name"];
    $file =  $target_dir.'/'.$file_name;


// $status ='open';                      
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

  for ($row = 1; $row <= $highestRow; $row++) { 
    $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);
                                
  }

$row = $row-2;
$error = '0';
$contents='';
   $updatekey = 0;
 //  echo $row;
 //   echo '<pre>';print_r($rowData);echo '</pre>';die;

   $error_array = array();

    for($i = 1; $i<=$row; $i++){
       
      
      $ticketid = $rowData[$i][0][0];
        if($ticketid){
        
        
          //  $datetime = date('Y-m-d h:i:s');
                $userid = $_SESSION['userid']; 
                // echo $userid;
                $status = $rowData[$i][0][1];
                $schedule_date = $rowData[$i][0][2];
                $schedule_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($schedule_date));
                $eng_id = $rowData[$i][0][3];
                $remark = $rowData[$i][0][4];
                // echo  $remark;
                $created_at = $date = date('Y-m-d H:i:s');
                $close_type = "schedule";
                
                $search = mysqli_query($con,"select * from mis_details where ticket_id = '".$ticketid."' ");
                $search_rows = mysqli_num_rows($search);
                $search_result = mysqli_fetch_assoc($search);
                $misid = $search_result['mis_id'];
                $misdetails_id = $search_result['id'];
                
                $update = mysqli_query($con,"update mis_details set status='".$status."',engineer = '".$eng_id."' where mis_id='".$misid."' ");
                // var_dump($update);
                if($update)
                {
                    $insertqry = mysqli_query($con,"insert into mis_history(mis_id,type,schedule_date,engineer,remark,status,created_at,created_by)values('".$misdetails_id."','".$status."','".$schedule_date."','".$eng_id."','".$remark."',1,'".$created_at."','".$userid."')");
                }
                
                if($insertqry){ 
                    $updatekey = $updatekey + 1;
                }else{
                    $sentence = "Ticket ID ".$ticketid." not able to update its value";
                    array_push($error_array,$sentence); 
                }
        
        }else{
            $sentence = "Row ".$i." not have ticket Id";
            array_push($error_array,$sentence); 
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
												<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
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
									<h6>Call Bulk Schedule Table</h6>
								</div>
								<br>
								<div class="card-data">
									<table class="table table-bordered table-striped" id="data_table" style="width:100%;">
										<thead>
											<tr>
												<th>Sr no</th>
												<th>Ticket ID</th>
												<th>Status</th>
												<th>Schedule date</th>
												<th>Engineer</th>
												<th>Remark</th>
												
											</tr>
										</thead>
										<tbody>
											<?
                                                $i=0;
                                               
                                                $scheduleData = mysqli_query($con,"select * from mis_history where mis_id='".$misid."' and status=1  order by id desc");
                                                $scheduleData_result = mysqli_fetch_assoc($scheduleData);
                                                
                                                $engData = mysqli_query($con,"select name from mis_loginusers where id = '".$eng_id."' ");
                                                $engData_result = mysqli_fetch_assoc($engData);
                                                
                                                $sqldata = mysqli_query($con,"select * from mis_details where mis_id='".$misid."' ");
                                                while($sql_result = mysqli_fetch_assoc($sqldata)){
                                            ?>
												<tr>
													<td>
														<?php echo ++$i;?>
													</td>
													<td>
														<?php echo $sql_result['ticket_id'] ; ?>
													</td>
													<td>
														<?php echo $sql_result['status'] ; ?>
													</td>
													<td>
														<?php echo $scheduleData_result['schedule_date'] ; ?>
													</td>
													<td>
														<?php echo $engData_result['name'] ; ?>
													</td>
													<td>
														<?php echo $scheduleData_result['remark'] ; ?>
													</td>
													
												</tr>
												<?php } ?>
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
	<?php include('footer.php');
    }
else{ ?>
		<script>
			window.location.href = "login.php";

		</script>
		<?php }
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
