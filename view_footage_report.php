<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

$designation = $_SESSION['designation'];
$bm_id = $_SESSION['bm_id'];

// error_reporting(1);

function get_mis_history($parameter,$type,$id){
    global $con;
    
    $sql = mysqli_query($con,"select $parameter from mis_history where type='".$type."' and mis_id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result[$parameter]; 
}


?>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<style>
		a:not([href]) {
			padding: 5px;
		}
		
		.btn-group {
			border: 1px solid #cccccc;
		}
		
		ul.dropdown-menu {
			transform: translate3d(0px, 2%, 0px) !important;
			overflow: scroll !important;
			max-height: 250px;
		}
		
		label {
			font-weight: 900;
			font-size: 16px;
		}

	</style>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						
							<style>
								.indication {
									display: flex;
									background: #404e67;
								}
								
								.indication span {
									width: 15px;
									height: 15px;
									border: 1px solid white;
									border-radius: 25px;
									margin: 10px;
								}
								
								.open {
									background: white;
								}
								
								.close {
									background: #e29a9a;
								}
								
								.schedule {
									background: #d09f45;
								}
								
								th.address,
								td.address {
									white-space: inherit;
								}

							</style>
							<div class="card">
								<div class="card-block">
									<div style="display:flex;justify-content:space-around;">
										<h5 style="text-align:center;">View Footage Report</h5>
										<!--<a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>--></div>
									<hr>
									<h5 style="text-align:right;" id="row_count"></h5>
									<div class="custom_table_content">
										<table class="table table-bordered table-striped" id="data_table" style="width:100%;">
											<thead>
												<tr>
													<th>SR</th>
													<th>View</th>
													<th>ATM ID</th>
													<th>Engineer Name</th>
													<th>Customer</th>
													<th>Bank</th>
													<th>Address</th>
													<th>City</th>
													<th>State</th>
													<th>Zone</th>
													<th>CSS BM</th>
													<th>Format</th>
													<th>Recording Date</th>
													<th>Current Status</th>
													<th>Created by</th>
													<th>Created Date</th>
												</tr>
											</thead>
										    <tbody>
										        <?php 
										        $i =1;
										        $sql = mysqli_query($con,"select * from footage_bulk_request");
                                                while($sql_data = mysqli_fetch_assoc($sql))
                                                {
                                                    $id = $sql_data['id'];
                                                    $atm_id = $sql_data['atmid'];
                                                    $site_sql = mysqli_query($con,"select engineer_user_id from mis_newsite where atmid='".$atm_id."'");
                                                    $created_by = "";
                                                    if(mysqli_num_rows($site_sql)>0){
                                                        $userid_row = mysqli_fetch_row($site_sql);
                                                        $created_by = $userid_row[0];
                                                    }
                                                    if($created_by!=""){
                                                        $user_sql = mysqli_query($con,"select name from mis_loginusers where id='".$created_by."'");
                                                        $eng_name = "";
                                                        if(mysqli_num_rows($user_sql)>0){
                                                            $user_name_row = mysqli_fetch_row($user_sql);
                                                            $eng_name = $user_name_row[0];
                                                        }  
                                                    }else{
                                                        $eng_name = "";
                                                    }
                                                    $created_user_name = get_member_name($sql_data['created_by']);
										        ?>
										        <tr>
    										        <td><?=$i;?></td>
    										        <td><a data-toggle="modal" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">View More</a></td>
    										        <td><?=$sql_data['atmid'];?></td>
                                                    <td><?=$eng_name;?></td>
                                                    <td><?=$sql_data['customer'];?></td>
                                                    <td><?=$sql_data['bank'];?></td>
                                                    <td><?=$sql_data['address'];?></td>
                                                    <td><?=$sql_data['city'];?></td>
                                                    <td><?=$sql_data['state'];?></td>
                                                    <td><?=$sql_data['zone'];?></td>
                                                    <td><?=$sql_data['css_bm'];?></td>
                                                    <td><?=$sql_data['format'];?></td>
                                                    <td><?=$sql_data['recording_date'];?></td>
                                                    <td><?=$sql_data['status'];?></td>
                                                    <td><?=$created_user_name;?></td>
                                                    <td><?=$sql_data['created_at'];?></td>
                                                    
										        </tr>
										        <? $i++;}?>
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
	
	<!-- large modal -->
<div class="modal fade" id="myModalDetail" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">History Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Footage Details</h6>
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
  
	
	<? include('footer.php');
    }
else{ ?>
		<script>
			window.location.href = "login.php";

		</script>
		<? }
    ?>
			<script>
				$(document).ready(function() {
					$('#multiselect').multiselect({
						buttonWidth: '100%',
						includeSelectAllOption: true,
						nonSelectedText: 'Select an Option'
					});
					$('#multiselect_bm').multiselect({
						buttonWidth: '100%',
						includeSelectAllOption: true,
						nonSelectedText: 'Select an Option'
					});
					$('#multiselect_status').multiselect({
						buttonWidth: '100%',
						includeSelectAllOption: true,
						nonSelectedText: 'Select an Option'
					});
					$('#multiselect_zone').multiselect({
						buttonWidth: '100%',
						includeSelectAllOption: true,
						nonSelectedText: 'Select an Option'
					});
				});
				$("#show_filter").css('display', 'none');
				$("#hide_filter").on('click', function() {
					$("#filter").css('display', 'none');
					$("#show_filter").css('display', 'block');
				});
				$("#show_filter").on('click', function() {
					$("#filter").css('display', 'block');
					$("#show_filter").css('display', 'none');
				});
				//         $(document).ready(function() {
				//     $('#data_table').DataTable( {
				//   "pageLength": 20      
				//     });
				// });    
				// $(document).ready(function() {
				//  //Initialize your table
				//  var table = $('#data_table').dataTable();
				//  //Get the total rows
				//  $("#row_count").html('Total Records' + table.fnGetData().length);
				// });

			</script>
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
				$(document).ready(function() {
					$('#data_table').DataTable({
						dom: 'Bfrtip',
    					buttons: [
                                   {
                                       extend: 'pdf',           
                                       exportOptions: {
                                            columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15] // indexes of the columns that should be printed,
                                        }                      // Exclude indexes that you don't want to print.
                                   },
                                   {
                                       extend: 'csv',
                                       exportOptions: {
                                            columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15] 
                                        }
                            
                                   },
                                   {
                                       extend: 'excel',
                                       exportOptions: {
                                            columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15] 
                                        }
                                   }         
                                ]  
					
					});
				});
				
				$(document).on("click", ".open-DetailDialog", function () {
                     var reqId = $(this).data('id');
                     $.ajax({    //create an ajax request to display.php
                        type: "GET",
                        url: "show_footage_details.php?id="+reqId,             
                        dataType: "html",   //expect html to be returned                
                        success: function(response){                    
                            $(".modal-body #result_status").html(response); 
                            //alert(response);
                        }
                     });
                    
                });

			</script>
			</body>

			</html>
