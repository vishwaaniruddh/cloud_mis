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
										<h5 style="text-align:center;">View PMC Report</h5>
										<!--<a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>--></div>
									<hr>
									<h5 style="text-align:right;" id="row_count"></h5>
									<div class="custom_table_content">
										<table class="table table-bordered table-striped" id="data_table" style="width:100%;">
											<thead>
												<tr>
													<th>SR</th>
													<th>ATM ID</th>
													<th>Router Id</th>
													<th>Router Name</th>
													<th>Antenna</th>
													<th>Sim Operator</th>
													<th>Atm Address</th>
													<th>Panel Make</th>
													<th>Backroom Sensor</th>
													<th>KeyPad Status</th>
													<th>Siren Status</th>
													<th>Hooter Status</th>
													<th>Panic Switch Status</th>
													<th>Panic Switch Connected To Hooter</th>
													<th>ATM Hood door sensor</th>
													<th>atm chestdoor sensor</th>
													<th>atm vibraation sensor</th>
													<th>atm thermal sensor</th>
													<th>atm removal sensor</th>
													<th>lobby temperature</th>
													<th>lobby pir motion</th>
													<th>atm main door shutter</th>
													<th>glass break</th>
													<th>panel temper switch</th>
													<th>ups fails alert</th>
													<th>ac mains fails</th>
													<th>ups battery removal</th>
													<th>smoke detector</th>
													<th>cctv 1,2 & 3 removal</th>
													<th>1 ac removal sensor</th>
													<th>2 ac removal sensor</th>
													<th>Speaker & Mic/two-way devices </th>
													<th>Panel battery count</th>
													<th>panel battery backup</th>
													<th>all wire cover by pvc pipe or not</th>
													<th>relay box</th>
													<th>ac connected to relay</th>
													<th>signage,lollipop,lobby light connected to relay timing</th>
													<th>dvr name</th>
													<th>camera 1</th>
													<th>camera 2</th>
													<th>camera 3</th>
													<th>camera 4</th>
													<th>ip camera</th>
													<th>all camera allignment as per requirement</th>
													<th>hdd capacity</th>
													<th>hdd status</th>
													<th>start</th>
													<th>end</th>
													<th>other remark</th>
													<th>site tester by</th>
													<th>Created by</th>
													
												</tr>
											</thead>
										    <tbody>
										        <?php 
										        $i =1;
										        $sql = mysqli_query($con,"select * from eng_pmc_report");
                                                while($sql_data = mysqli_fetch_assoc($sql))
                                                {
                                                    $created_by = $sql_data['created_by'];
                                                    $user_sql = mysqli_query($con,"select name from mis_loginusers where id='".$created_by."'");
                                                    $created_name = "";
                                                    if(mysqli_num_rows($user_sql)>0){
                                                        $user_name_row = mysqli_fetch_row($user_sql);
                                                        $created_name = $user_name_row[0];
                                                    }    
                                                
										        ?>
										        <tr>
    										        <td><?=$i;?></td>
    										        <td><?=$sql_data['atm_id'];?></td>
                                                    <td><?=$sql_data['router_id'];?></td>
                                                    <td><?=$sql_data['router_name'];?></td>
                                                    <td><?=$sql_data['antenna'];?></td>
                                                    <td><?=$sql_data['sim_operator'];?></td>
                                                    <td><?=$sql_data['panel_make'];?></td>
                                                    <td><?=$sql_data['backroom_sensor'];?></td>
                                                    <td><?=$sql_data['keypad_status'];?></td>
                                                    <td><?=$sql_data['siren_status'];?></td>
                                                    <td><?=$sql_data['hooter_status'];?></td>
                                                    <td><?=$sql_data['panic_switch_status'];?></td>
                                                    <td><?=$sql_data['panic_switch_connected_to_hooter'];?></td>
                                                    <td><?=$sql_data['hood_door_sensor_connected_to_hooter'];?></td>
                                                    <td><?=$sql_data['atm_hood_door_sensor'];?></td>
                                                    <td><?=$sql_data['atm_chest_door_sensor'];?></td>
                                                    <td><?=$sql_data['atm_vibration_sensor'];?></td>
                                                    <td><?=$sql_data['atm_thermal_sensor'];?></td>
                                                    <td><?=$sql_data['atm_removal_sensor'];?></td>
                                                    <td><?=$sql_data['lobby_temp'];?></td>
                                                    <td><?=$sql_data['lobby_pir_motion'];?></td>
                                                    <td><?=$sql_data['atm_maindoor_shutter'];?></td>
                                                    <td><?=$sql_data['glass_break'];?></td>
                                                    <td><?=$sql_data['panel_temper_switch'];?></td>
                                                    <td><?=$sql_data['ups_fails_alert'];?></td>
                                                    <td><?=$sql_data['ac_mains_fails'];?></td>
                                                    <td><?=$sql_data['ups_battery_removal'];?></td>
                                                    <td><?=$sql_data['smoke_detector'];?></td>
                                                    <td><?=$sql_data['cctv_123_removal'];?></td>
                                                    <td><?=$sql_data['AC1_removal_sensor'];?></td>
                                                    <td><?=$sql_data['AC2_removal_sensor'];?></td>
                                                    <td><?=$sql_data['spk_mic_twoway_device'];?></td>
                                                    <td><?=$sql_data['panel_battery_count'];?></td>
                                                    <td><?=$sql_data['panel_battery_backup'];?></td>
                                                    <td><?=$sql_data['all_wire_cover_by_pvc_pipe_or_not'];?></td>
                                                    <td><?=$sql_data['relay_box'];?></td>
                                                    <td><?=$sql_data['ac_connected_to_relay'];?></td>
                                                    <td><?=$sql_data['signage_lollipop_lobby_light_connected'];?></td>
                                                    <td><?=$sql_data['dvr_name'];?></td>
                                                    <td><?=$sql_data['camera_1'];?></td>
                                                    <td><?=$sql_data['camera_2'];?></td>
                                                    <td><?=$sql_data['camera_3'];?></td>
                                                    <td><?=$sql_data['camera_4'];?></td>
                                                    <td><?=$sql_data['ip_camera'];?></td>
                                                    <td><?=$sql_data['all_camera_alignment'];?></td>
                                                    <td><?=$sql_data['hdd_capacity'];?></td>
                                                    <td><?=$sql_data['hdd_status'];?></td>
                                                    <td><?=$sql_data['start'];?></td>
                                                    <td><?=$sql_data['end'];?></td>
                                                    <td><?=$sql_data['other_remark'];?></td>
                                                    <td><?=$sql_data['site_tested_by'];?></td>
                                                    <td><?=$created_name;?></td>
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
						buttons: ['copy', 'excel', 'csv', 'pdf', ]
					});
				});

			</script>
			</body>

			</html>
