<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');
$datetime = date('Y-m-d H:i:s');

$userid = $_POST['created_by'];
$atm_id  = $_POST['atm_id'];
$router_id =                            $_POST['router_id'];
$router_name =                          $_POST['router_name'];
$antenna =                              $_POST['antenna'];
$network_provider =                     $_POST['network_provider'];
$sim_operator =                         $_POST['sim_operator'];
$panel_make =                           $_POST['panel_make'];
$backroom_eml_installed =               $_POST['backroom_eml_installed'];
$backroom_sensor =                      $_POST['backroom_sensor'];
$keypad_status =                        $_POST['keypad_status'];
$siren_status =                         $_POST['siren_status'];
$hooter_status =                        $_POST['hooter_status'];
$panic_switch_status =                  $_POST['panic_switch_status'];
$panic_switch_connected_to_hooter =     $_POST['panic_switch_connected_to_hooter'];
$hood_door_sensor_connected_to_hooter = $_POST['hood_door_sensor_connected_to_hooter'];
$atm_hood_door_sensor =                 $_POST['atm_hood_door_sensor'];
$atm_chest_door_sensor =                $_POST['atm_chest_door_sensor'];
$atm_vibration_sensor =                 $_POST['atm_vibration_sensor'];
$atm_thermal_sensor =                   $_POST['atm_thermal_sensor'];
$atm_removal_sensor =                   $_POST['atm_removal_sensor'];
$lobby_temp =                           $_POST['lobby_temp'];
$lobby_pir_motion =                     $_POST['lobby_pir_motion'];
$atm_maindoor_shutter =                 $_POST['atm_maindoor_shutter'];
$glass_break =                          $_POST['glass_break'];
$panel_temper_switch =                  $_POST['panel_temper_switch'];
$ups_fails_alert =                      $_POST['ups_fails_alert'];
$ac_mains_fails =                       $_POST['ac_mains_fails'];
$ups_battery_removal =                  $_POST['ups_battery_removal'];
$smoke_detector =                       $_POST['smoke_detector'];
$cctv_123_removal =                     $_POST['cctv_removal'];
$AC1_removal_sensor =                   $_POST['AC1_removal_sensor'];
$AC2_removal_sensor =                   $_POST['AC2_removal_sensor'];
$spk_mic_twoway_device =                $_POST['spk_mic_twoway_device'];
$panel_battery_count =                  $_POST['panel_battery_count'];
$panel_battery_backup =                 $_POST['panel_battery_backup'];
$all_wire_cover =                       $_POST['all_wire_cover'];
$relay_box =                            $_POST['relay_box'];
$ac_connected_to_relay =                $_POST['ac_connected_to_relay'];
$signage_lollipop_lobby_light =         $_POST['signage_lollipop_lobby_light'];
$dvr_name =                             $_POST['dvr_name'];
$camera_1 =                             $_POST['camera_1'];
$camera_2 =                             $_POST['camera_2'];
$camera_3 =                             $_POST['camera_3'];
$camera_4 =                             $_POST['camera_4'];
$ip_camera =                            $_POST['ip_camera'];
$all_camera_alignment =                 $_POST['all_camera_alignment'];
$hdd_capacity =                         $_POST['hdd_capacity'];
$hdd_status =                           $_POST['hdd_status'];
$start =                                $_POST['start'];
$end =                                  $_POST['end'];
$other_remark =                         $_POST['other_remark'];
$site_tested_by =                       $_POST['site_tested_by'];

// var_dump($_POST);
 $insert = mysqli_query($con,"insert into eng_pmc_report(atm_id, router_name, router_id, antenna, network_provider,sim_operator, panel_make, backroom_eml_installed, backroom_sensor, keypad_status, siren_status, hooter_status, panic_switch_status, panic_switch_connected_to_hooter, hood_door_sensor_connected_to_hooter, atm_hood_door_sensor, atm_chest_door_sensor, atm_vibration_sensor, atm_thermal_sensor, atm_removal_sensor, lobby_temp, lobby_pir_motion, atm_maindoor_shutter, glass_break, panel_temper_switch, ups_fails_alert, ac_mains_fails, ups_battery_removal, smoke_detector, cctv_123_removal, AC1_removal_sensor, AC2_removal_sensor, spk_mic_twoway_device, panel_battery_count, panel_battery_backup, all_wire_cover_by_pvc_pipe_or_not, relay_box, ac_connected_to_relay, signage_lollipop_lobby_light_connected, dvr_name, camera_1, camera_2, camera_3, camera_4, ip_camera, all_camera_alignment, hdd_capacity, hdd_status, start, end, other_remark, site_tested_by,created_at,created_by) values ('".$atm_id."','".$router_name."', '".$router_id."', '".$antenna."', '".$network_provider."', '".$sim_operator."', '".$panel_make."', '".$backroom_eml_installed."', '".$backroom_sensor."', '".$keypad_status."', '".$siren_status."','".$hooter_status."', '".$panic_switch_status."', '".$panic_switch_connected_to_hooter."', '".$hood_door_sensor_connected_to_hooter."','".$atm_hood_door_sensor."', '".$atm_chest_door_sensor."', '".$atm_vibration_sensor."', '".$atm_thermal_sensor."', '".$atm_removal_sensor."', '".$lobby_temp."', '".$lobby_pir_motion."', '".$atm_maindoor_shutter."', '".$glass_break."', '".$panel_temper_switch."', '".$ups_fails_alert."', '".$ac_mains_fails."', '".$ups_battery_removal."', '".$smoke_detector."', '".$cctv_123_removal."', '".$AC1_removal_sensor."', '".$AC2_removal_sensor."', '".$spk_mic_twoway_device."', '".$panel_battery_count."', '".$panel_battery_backup."', '".$all_wire_cover."', '".$relay_box."', '".$ac_connected_to_relay."', '".$signage_lollipop_lobby_light."', '".$dvr_name."', '".$camera_1."', '".$camera_2."', '".$camera_3."', '".$camera_4."', '".$ip_camera."', '".$all_camera_alignment."', '".$hdd_capacity."', '".$hdd_status."', '".$start."', '".$end."', '".$other_remark."', '".$site_tested_by."','".$datetime."','".$userid."')");

// $insert = mysqli_query($con,"insert into eng_pmc_report(router_name, router_id, antenna) values ('".$router_name."', '".$router_id."', '".$antenna."')");
if($insert)
{
    $msg = ['msg' => 'Data Inserted', 'code' => 200];
    echo json_encode($msg);
}
else
{
    $msg = ['msg' => 'Something Wrong', 'code' => 500];
    echo json_encode($msg);
}








?>