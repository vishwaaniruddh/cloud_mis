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
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="two_end">
									<h5>Update Mapping Bulk Sites <span style="font-size:12px; color:red;">(Bulk Upload)</span></h5> <a class="btn btn-success" href="excelformat/Bulk_Site_Update_Format.xlsx" download>MAPPING BULK SITES UPDATE FORMAT</a> </div>
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

    //  Read your Excel workbook

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
  
//  Loop through each row of the worksheet in turn

  for ($row = 1; $row <= $highestRow; $row++) { 
      
       //  Read a row of data into an array
       
    $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);
          
           //  Insert row data array into your database of choice here                      
  }

$row = $row-2;
$error = '0';
$contents='';
  $atmnot_found = "";$total_atm = 0;$totalupdated_atm=0;
  // echo '<pre>';print_r($rowData);echo '</pre>';die;
      for($i = 1; $i<=$row; $i++)
       {
          
          $atmid = $rowData[$i][0][0];
         
            if($atmid)
            {
                $total_atm = $total_atm + 1;
                 $searchatmid = mysqli_query($con,"select atmid from mis_newsite where atmid='".$atmid."' ");
                  if(mysqli_num_rows($searchatmid)==0){
                      $atmnot_found = $atmnot_found.$atmid.",";
                  }else{
                    $userid = $_SESSION['userid'];                                        
                    $eng_code = $rowData[$i][0][1];
                    
                      $searchengid = mysqli_query($con,"select id from mis_loginusers where id='".$eng_code."' ");
                      if(mysqli_num_rows($searchengid)==0){
                            $usernot_found = $usernot_found.$eng_code.",";
                      }else{
                            $updatesql="update mis_newsite set engineer_user_id='".$eng_code."' where atmid='".$atmid."' ";
                            $updatequery= mysqli_query($con,$updatesql);
                            if($updatequery){
                                $totalupdated_atm = $totalupdated_atm + 1;
                            }
                      }
                    
                    
                  }
            }
          
       }
       echo "ATM ID Not Found : ".$atmnot_found."</br>";
       echo "ENG ID Not Found : ".$usernot_found."</br>";
       echo "Total ATMID Updated : ".$totalupdated_atm." Out of ".$total_atm;
                                }
                                ?>
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
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">


			</script>
			<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
			<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
			<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">
			<script>
				$("#delete_err").on('click', function() {
					if (confirm('Are you sure to delete all Records ?')) {
						$.ajax({
							type: "POST",
							url: 'delete_err_ajax.php',
							success: function(msg) {
								if (msg == 1) {
									$("#err_card").load(location.href + " #err_card>*", "");
								}
							}
						});
					} else {
						alert('Canceled');
					}
				});
				$(document).ready(function() {
					$('#data_table').DataTable({
						dom: 'Bfrtip',
						buttons: ['copy', 'excel', 'csv', 'pdf', ]
					});
					$('#data_table2').DataTable({
						dom: 'Bfrtip',
						buttons: ['copy', 'excel', 'csv', 'pdf', ]
					});
				});

			</script>
			</body>

			</html>
