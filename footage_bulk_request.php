<? session_start();
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
									<h5>Footage Bulk Report <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5> <a class="btn btn-success" href="excelformat/footage_bulk_request.xlsx" download>FOOTAGE BULK REPORT FORMAT</a> </div>
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
//   if($row>0){
//       $truncatesql = mysqli_query($con,"TRUNCATE TABLE footage_bulk_request");
//   }
    for($i = 1; $i<=$row; $i++){
       
      
      $atmid = $rowData[$i][0][3];
    //   echo $atmid;
        if($atmid){
        
        
          //  $datetime = date('Y-m-d h:i:s');
                $userid = $_SESSION['userid'];                                        
                $call_recieve_date = $rowData[$i][0][0];
                $call_recieve_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($call_recieve_date));
                $customer = $rowData[$i][0][1];
                $bank = $rowData[$i][0][2];
                $eng_name = $rowData[$i][0][4];
                $address = $rowData[$i][0][5];
                $city = $rowData[$i][0][6];
                $state = $rowData[$i][0][7];
                $zone = $rowData[$i][0][8];
                $css_bm = $rowData[$i][0][9];
                $format = $rowData[$i][0][10];
                $recording_date = $rowData[$i][0][11];
                $recording_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($recording_date));
                // echo $recording_date;
                $recording_from = $rowData[$i][0][12];
                $recording_from = date('H:i', PHPExcel_Shared_Date::ExcelToPHP($recording_from));
                
                $recording_to = $rowData[$i][0][13];
                $recording_to = date('H:i', PHPExcel_Shared_Date::ExcelToPHP($recording_to));
                $status = $rowData[$i][0][14];
                $rca_report = $rowData[$i][0][15];
                $action_req = $rowData[$i][0][16];
                $resolution_date = $rowData[$i][0][17];
                $resolution_date =  date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($resolution_date));
                
                
                // echo $recording_to; die;
                $insertcheck =mysqli_fetch_assoc(mysqli_query($con,"select * from footage_bulk_request where atmid='".$atmid."' and recording_date = '".$recording_date."' and recording_to = '".$recording_to."' and recording_from = '".$recording_from."' "));
                $to_check = $insertcheck['recording_to'];
                $from_check  = $insertcheck['recording_from'];
                
                if($to_check=='' && $from_check == ''){   
             
                    $sql = "insert into footage_bulk_request(`call_recieve_date`, `customer`, `bank`, `atmid`, `engg_name`, `address`, `city`, `state`, `zone`, `css_bm`, `format`, `recording_date`, `recording_from`, `recording_to`, `status`, `rca_report`, `action_taken`, `resolution_date`, `created_by`) values
                                                            ('".$call_recieve_date."','".$customer."','".$bank."','".$atmid."','".$eng_name."','".$address."','".$city."','".$state."','".$zone."','".$css_bm."','".$format."','".$recording_date."','".$recording_from."','".$recording_to."','".$status."','".$rca_report."','".$action_req."','".$resolution_date."','".$userid."'   )";
                    
                    if(mysqli_query($con,$sql)){ 
                        $updatekey = $updatekey + 1;
                    }else{
                        $sentence = "Atm ID ".$atmid." not able to update its value";
                        array_push($error_array,$sentence); 
                    }
                }
                else
                {
                   
                    $sentence = "Your requested <b> Atmid :</b> ".$atmid.",<b> Recording Date: </b>".$recording_date.", <b>Recording from: </b> ".$recording_from." , <b>Recording to: </b> ".$recording_to." already exist";
                    array_push($error_array,$sentence); 
                }
        }else{
            // $sentence = "Rows not have data";
            // array_push($error_array,$sentence); 
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
									<h6>Footage Table</h6>
									<!--<a class="btn btn-success" href="newsite_sucess_approve.php">Approve All To Main Site</a>-->
									<!--<a class="btn btn-success" href="newsite_sucess_excel.php">Bulk Report Download</a>--></div>
								<br>
								<div class="card-data">
									<table class="table table-bordered table-striped" id="data_table" style="width:100%;">
										<thead>
											<tr>
												<th>Sr no</th>
												<th>call recieve date</th>
												<th>customer</th>
												<th>bank</th>
												<th>atmid</th>
												<th>Engineer Name</th>
												<th>Address</th>
												<th>City</th>
												<th>state</th>
												<th>zone</th>
												<th>css bm</th>
												<th>format</th>
												<th>recording Date</th>
												<th>recording from</th>
												<th>recording to</th>
												<th>status</th>
												<th>rca report</th>
												<th>action taken</th>
												<th>resolution date</th>
												<!--<th>created By</th>-->
												
											</tr>
										</thead>
										<tbody>
											<?
                                                $i=0;
                                                $sqldata = mysqli_query($con,"select * from footage_bulk_request");
                                                while($sql_result = mysqli_fetch_assoc($sqldata)){
                                            ?>
												<tr>
													<td>
														<? echo ++$i;?>
													</td>
													<td>
														<? echo $sql_result['call_recieve_date'] ; ?>
													</td>
													<td>
														<? echo $sql_result['customer'] ; ?>
													</td>
													<td>
														<? echo $sql_result['bank'] ; ?>
													</td>
													<td>
														<? echo $sql_result['atmid'] ; ?>
													</td>
													<td>
														<? echo $sql_result['engg_name'] ; ?>
													</td>
													<td>
														<? echo $sql_result['address'] ; ?>
													</td>
													<td>
														<? echo $sql_result['city'] ; ?>
													</td>
													<td>
														<? echo $sql_result['state'] ; ?>
													</td>
													<td>
														<? echo $sql_result['zone'] ; ?>
													</td>
													<td>
														<? echo $sql_result['css_bm'] ; ?>
													</td>
													<td>
														<? echo $sql_result['format'] ; ?>
													</td>
													<td>
														<? echo $sql_result['recording_date'] ; ?>
													</td>
													<td>
														<? echo $sql_result['recording_from'] ; ?>
													</td>
													<td>
														<? echo $sql_result['recording_to'] ; ?>
													</td>
													<td>
														<? echo $sql_result['status'] ; ?>
													</td>
													<td>
														<? echo $sql_result['rca_report'] ; ?>
													</td>
													<td>
														<? echo $sql_result['action_taken'] ; ?>
													</td>
													<td>
														<? echo $sql_result['resolution_date'] ; ?>
													</td>
													<!--<td>-->
													<!--	<? echo $sql_result['created_by'] ; ?>-->
													<!--</td>-->
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
