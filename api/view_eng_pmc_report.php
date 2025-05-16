<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$routerid = $_POST['routerid'];

$sql = mysqli_query($con,"select * from eng_pmc_report where router_id = '".$routerid."' ");
$sql_data = mysqli_fetch_assoc($sql);

$dataArray = array();
$data['router_name'] = $sql_data['router_name'];
$data['router_id']   = $sql_data['router_id'];
$data['antenna']   = $sql_data['antenna'];
$data['sim_operator']   = $sql_data['sim_operator'];
$data['panel_make']   = $sql_data['panel_make'];
$data['backroom_sensor']   = $sql_data['backroom_sensor'];
$data['keypad_status']   = $sql_data['keypad_status'];
$data['siren_status']   = $sql_data['siren_status'];
$data['hooter_status']   = $sql_data['hooter_status'];
$data['panic_switch_status']   = $sql_data['panic_switch_status'];
$data['panic_switch_connected_to_hooter']   = $sql_data['panic_switch_connected_to_hooter'];
$data['hood_door_sensor_connected_to_hooter']   = $sql_data['hood_door_sensor_connected_to_hooter'];
$data['atm_hood_door_sensor']   = $sql_data['atm_hood_door_sensor'];
$data['atm_chest_door_sensor']   = $sql_data['atm_chest_door_sensor'];
$data['atm_vibration_sensor']   = $sql_data['atm_vibration_sensor'];
$data['atm_thermal_sensor']   = $sql_data['atm_thermal_sensor'];
$data['atm_removal_sensor']   = $sql_data['atm_removal_sensor'];
$data['lobby_temp']   = $sql_data['lobby_temp'];
$data['lobby_pir_motion']   = $sql_data['lobby_pir_motion'];
$data['atm_maindoor_shutter']   = $sql_data['atm_maindoor_shutter'];
$data['glass_break']   = $sql_data['glass_break'];
$data['panel_temper_switch']   = $sql_data['panel_temper_switch'];
$data['ups_fails_alert']   = $sql_data['ups_fails_alert'];
$data['ac_mains_fails']   = $sql_data['ac_mains_fails'];
$data['ups_battery_removal']   = $sql_data['ups_battery_removal'];
$data['smoke_detector']   = $sql_data['smoke_detector'];
$data['cctv_123_removal']   = $sql_data['cctv_123_removal'];
$data['AC1_removal_sensor']   = $sql_data['AC1_removal_sensor'];
$data['AC2_removal_sensor']   = $sql_data['AC2_removal_sensor'];
$data['spk_mic_twoway_device']   = $sql_data['spk_mic_twoway_device'];
$data['panel_battery_count']   = $sql_data['panel_battery_count'];
$data['panel_battery_backup']   = $sql_data['panel_battery_backup'];
$data['all_wire_cover_by_pvc_pipe_or_not']   = $sql_data['all_wire_cover_by_pvc_pipe_or_not'];
$data['relay_box']   = $sql_data['relay_box'];
$data['ac_connected_to_relay']   = $sql_data['ac_connected_to_relay'];
$data['signage_lollipop_lobby_light_connected']   = $sql_data['signage_lollipop_lobby_light_connected'];
$data['dvr_name']   = $sql_data['dvr_name'];
$data['camera_1']   = $sql_data['camera_1'];
$data['camera_2']   = $sql_data['camera_2'];
$data['camera_3']   = $sql_data['camera_3'];
$data['camera_4']   = $sql_data['camera_4'];
$data['ip_camera']   = $sql_data['ip_camera'];
$data['all_camera_alignment']   = $sql_data['all_camera_alignment'];
$data['hdd_capacity']   = $sql_data['hdd_capacity'];
$data['hdd_status']   = $sql_data['hdd_status'];
$data['start']   = $sql_data['start'];
$data['end']   = $sql_data['end'];
$data['other_remark']   = $sql_data['other_remark'];
$data['site_tested_by']   = $sql_data['site_tested_by'];
$data['camera_4']   = $sql_data['camera_4'];

array_push($dataArray,$data); 


if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>500,'res_data' => "Something Wrong"]);
}

echo json_encode($array);	

?>