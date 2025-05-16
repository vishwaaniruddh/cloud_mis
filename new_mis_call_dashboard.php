<?php session_start();
include('config.php');

if ($_SESSION['username']) {

    function total_amount($con, $status, $component)
    {
        $close_east_query = mysqli_query($con, "SELECT COUNT(id) FROM `mis_details` WHERE status='" . $status . "' AND component = '" . $component . "' ");
        $close_east_query_res = mysqli_fetch_row($close_east_query);
        $comp = $close_east_query_res[0];
        return $comp;
    }


    $user_id = $_SESSION['userid'];
    $user_statement = "select level,cust_id from mis_loginusers where id=" . $user_id;
    $user_sql = mysqli_query($con, $user_statement);
    $user_rowresult = mysqli_fetch_row($user_sql);
    //echo '<pre>';print_r($user_rowresult);echo '</pre>';die;
    $_userlevel = $user_rowresult[0];

    include('header.php');
?>

    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
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
        
        
        .loading {
            position: fixed;
            width: 100%;
            height: 100vh;
            background: #fff url('assets/loader.gif') no-repeat center center;
            z-index: 9999;
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
                        <div id="loading"></div>
                        
                        <div class="card">
                            <div class="card-block" style=" overflow: auto;">
                                <h4 class="card-title">
                                    <!--<i class="fas fa-chart-pie"></i>-->

                                </h4>

                                <div>
                                    <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable" style="width:100%">
                                        <thead>
                                            <th>S.No.</th>
                                            <th>↓ Components/Current Status →</th>
                                            <th>open</th>
                                            <th>MATERIAL IN PROCESS</th>
                                            <th>MATERIAL REQUIREMENT</th>
                                            <th>MATERIAL DISPATCH</th>
                                            <th>PERMISSION REQUIRE</th>
                                            <th>SCHEDULE</th>
                                            <th>MATERIAL DELIVERED</th>
                                            <th>CLOSE</th>
                                            <th>MRS</th>
                                            <th>service center</th>
                                            <th>cancelled</th>
                                            <th>fund required</th>
                                        </thead>
                                        <tbody>
                                            <?php

                                            /* switch */
                                            $switch_open = total_amount($con, 'open', 'switch');
                                            $switch_mip = total_amount($con, 'material_in_process', 'switch');
                                            $switch_material_req = total_amount($con, 'material_requirement', 'switch');
                                            $switch_mdispatch = total_amount($con, 'material_delivered', 'switch');
                                            $switch_prem = total_amount($con, 'permission_require', 'switch');
                                            $switch_schedule = total_amount($con, 'schedule', 'switch');
                                            $switch_mdelivered = total_amount($con, 'material_delivered', 'switch');
                                            $switch_close = total_amount($con, 'close', 'switch');
                                            $switch_MRS = total_amount($con, 'MRS', 'switch');
                                            $switch_service_center = total_amount($con, 'service_center', 'switch');
                                            $switch_cancelled = total_amount($con, 'cancelled', 'switch');
                                            $switch_fund_required = total_amount($con, 'fund required', 'switch');

                                            /* poe switch */
                                            $poe_open = total_amount($con, 'open', 'poe switch');
                                            $poe_mip = total_amount($con, 'material_in_process', 'poe switch');
                                            $poe_material_req = total_amount($con, 'material_requirement', 'poe switch');
                                            $poe_mdispatch = total_amount($con, 'material_delivered', 'poe switch');
                                            $poe_prem = total_amount($con, 'permission_require', 'poe switch');
                                            $poe_schedule = total_amount($con, 'schedule', 'poe switch');
                                            $poe_mdelivered = total_amount($con, 'material_delivered', 'poe switch');
                                            $poe_close = total_amount($con, 'close', 'poe switch');
                                            $poe_MRS = total_amount($con, 'MRS', 'poe switch');
                                            $poe_service_center = total_amount($con, 'service_center', 'poe switch');
                                            $poe_cancelled = total_amount($con, 'cancelled', 'poe switch');
                                            $poe_fund_required = total_amount($con, 'fund required', 'poe switch');

                                            /* AI DEVICE */
                                            $ai_open = total_amount($con, 'open', 'ai device');
                                            $ai_mip = total_amount($con, 'material_in_process', 'ai device');
                                            $ai_material_req = total_amount($con, 'material_requirement', 'ai device');
                                            $ai_mdispatch = total_amount($con, 'material_delivered', 'ai device');
                                            $ai_prem = total_amount($con, 'permission_require', 'ai device');
                                            $ai_schedule = total_amount($con, 'schedule', 'ai device');
                                            $ai_mdelivered = total_amount($con, 'material_delivered', 'ai device');
                                            $ai_close = total_amount($con, 'close', 'ai device');
                                            $ai_MRS = total_amount($con, 'MRS', 'ai device');
                                            $ai_service_center = total_amount($con, 'service_center', 'ai device');
                                            $ai_cancelled = total_amount($con, 'cancelled', 'ai device');
                                            $ai_fund_required = total_amount($con, 'fund required', 'ai device');

                                            /* SD CARD */
                                            $sd_card_open = total_amount($con, 'open', 'sd card');
                                            $sd_card_mip = total_amount($con, 'material_in_process', 'sd card');
                                            $sd_card_material_req = total_amount($con, 'material_requirement', 'sd card');
                                            $sd_card_mdispatch = total_amount($con, 'material_delivered', 'sd card');
                                            $sd_card_prem = total_amount($con, 'permission_require', 'sd card');
                                            $sd_card_schedule = total_amount($con, 'schedule', 'sd card');
                                            $sd_card_mdelivered = total_amount($con, 'material_delivered', 'sd card');
                                            $sd_card_close = total_amount($con, 'close', 'sd card');
                                            $sd_card_MRS = total_amount($con, 'MRS', 'sd card');
                                            $sd_card_service_center = total_amount($con, 'service_center', 'sd card');
                                            $sd_card_cancelled = total_amount($con, 'cancelled', 'sd card');
                                            $sd_card_fund_required = total_amount($con, 'fund required', 'sd card');

                                            /* false alert */
                                            $false_open = total_amount($con, 'open', 'false alert');
                                            $false_mip = total_amount($con, 'material_in_process', 'false alert');
                                            $false_material_req = total_amount($con, 'material_requirement', 'false alert');
                                            $false_mdispatch = total_amount($con, 'material_delivered', 'false alert');
                                            $false_prem = total_amount($con, 'permission_require', 'false alert');
                                            $false_schedule = total_amount($con, 'schedule', 'false alert');
                                            $false_mdelivered = total_amount($con, 'material_delivered', 'false alert');
                                            $false_close = total_amount($con, 'close', 'false alert');
                                            $false_MRS = total_amount($con, 'MRS', 'false alert');
                                            $false_service_center = total_amount($con, 'service_center', 'false alert');
                                            $false_cancelled = total_amount($con, 'cancelled', 'false alert');
                                            $false_fund_required = total_amount($con, 'fund required', 'false alert');

                                            /* cctv  */
                                            $cctv_open = total_amount($con, 'open', 'cctv footage');
                                            $cctv_mip = total_amount($con, 'material_in_process', 'cctv footage');
                                            $cctv_material_req = total_amount($con, 'material_requirement', 'cctv footage');
                                            $cctv_mdispatch = total_amount($con, 'material_delivered', 'cctv footage');
                                            $cctv_prem = total_amount($con, 'permission_require', 'cctv footage');
                                            $cctv_schedule = total_amount($con, 'schedule', 'cctv footage');
                                            $cctv_mdelivered = total_amount($con, 'material_delivered', 'cctv footage');
                                            $cctv_close = total_amount($con, 'close', 'cctv footage');
                                            $cctv_MRS = total_amount($con, 'MRS', 'cctv footage');
                                            $cctv_service_center = total_amount($con, 'service_center', 'cctv footage');
                                            $cctv_cancelled = total_amount($con, 'cancelled', 'cctv footage');
                                            $cctv_fund_required = total_amount($con, 'fund required', 'cctv footage');

                                            /* two way  */
                                            $two_way_open = total_amount($con, 'open', 'two way');
                                            $two_way_mip = total_amount($con, 'material_in_process', 'two way');
                                            $two_way_material_req = total_amount($con, 'material_requirement', 'two way');
                                            $two_way_mdispatch = total_amount($con, 'material_delivered', 'two way');
                                            $two_way_prem = total_amount($con, 'permission_require', 'two way');
                                            $two_way_schedule = total_amount($con, 'schedule', 'two way');
                                            $two_way_mdelivered = total_amount($con, 'material_delivered', 'two way');
                                            $two_way_close = total_amount($con, 'close', 'two way');
                                            $two_way_MRS = total_amount($con, 'MRS', 'two way');
                                            $two_way_service_center = total_amount($con, 'service_center', 'two way');
                                            $two_way_cancelled = total_amount($con, 'cancelled', 'two way');
                                            $two_way_fund_required = total_amount($con, 'fund required', 'two way');

                                            /* sensors  */
                                            $sensors_open = total_amount($con, 'open', 'sensors');
                                            $sensors_mip = total_amount($con, 'material_in_process', 'sensors');
                                            $sensors_material_req = total_amount($con, 'material_requirement', 'sensors');
                                            $sensors_mdispatch = total_amount($con, 'material_delivered', 'sensors');
                                            $sensors_prem = total_amount($con, 'permission_require', 'sensors');
                                            $sensors_schedule = total_amount($con, 'schedule', 'sensors');
                                            $sensors_mdelivered = total_amount($con, 'material_delivered', 'sensors');
                                            $sensors_close = total_amount($con, 'close', 'sensors');
                                            $sensors_MRS = total_amount($con, 'MRS', 'sensors');
                                            $sensors_service_center = total_amount($con, 'service_center', 'sensors');
                                            $sensors_cancelled = total_amount($con, 'cancelled', 'sensors');
                                            $sensors_fund_required = total_amount($con, 'fund required', 'sensors');

                                            /* router */
                                            $routers_open = total_amount($con, 'open', 'router');
                                            $routers_mip = total_amount($con, 'material_in_process', 'router');
                                            $routers_material_req = total_amount($con, 'material_requirement', 'router');
                                            $routers_mdispatch = total_amount($con, 'material_delivered', 'router');
                                            $routers_prem = total_amount($con, 'permission_require', 'router');
                                            $routers_schedule = total_amount($con, 'schedule', 'router');
                                            $routers_mdelivered = total_amount($con, 'material_delivered', 'router');
                                            $routers_close = total_amount($con, 'close', 'router');
                                            $routers_MRS = total_amount($con, 'MRS', 'routers');
                                            $routers_service_center = total_amount($con, 'service_center', 'routers');
                                            $routers_cancelled = total_amount($con, 'cancelled', 'routers');
                                            $routers_fund_required = total_amount($con, 'fund required', 'routers');

                                            /* relay */
                                            $relay_open = total_amount($con, 'open', 'relay');
                                            $relay_mip = total_amount($con, 'material_in_process', 'relay');
                                            $relay_material_req = total_amount($con, 'material_requirement', 'relay');
                                            $relay_mdispatch = total_amount($con, 'material_delivered', 'relay');
                                            $relay_prem = total_amount($con, 'permission_require', 'relay');
                                            $relay_schedule = total_amount($con, 'schedule', 'relay');
                                            $relay_mdelivered = total_amount($con, 'material_delivered', 'relay');
                                            $relay_close = total_amount($con, 'close', 'relay');
                                            $relay_MRS = total_amount($con, 'MRS', 'relay');
                                            $relay_service_center = total_amount($con, 'service_center', 'relay');
                                            $relay_cancelled = total_amount($con, 'cancelled', 'relay');
                                            $relay_fund_required = total_amount($con, 'fund required', 'relay');

                                            /* panic switch */
                                            $panic_switch_open = total_amount($con, 'open', 'panic switch');
                                            $panic_switch_mip = total_amount($con, 'material_in_process', 'panic switch');
                                            $panic_switch_material_req = total_amount($con, 'material_requirement', 'panic switch');
                                            $panic_switch_mdispatch = total_amount($con, 'material_delivered', 'panic switch');
                                            $panic_switch_prem = total_amount($con, 'permission_require', 'panic switch');
                                            $panic_switch_schedule = total_amount($con, 'schedule', 'panic switch');
                                            $panic_switch_mdelivered = total_amount($con, 'material_delivered', 'panic switch');
                                            $panic_switch_close = total_amount($con, 'close', 'panic switch');
                                            $panic_switch_MRS = total_amount($con, 'MRS', 'panic switch');
                                            $panic_switch_service_center = total_amount($con, 'service_center', 'panic switch');
                                            $panic_switch_cancelled = total_amount($con, 'cancelled', 'panic switch');
                                            $panic_switch_fund_required = total_amount($con, 'fund required', 'panic switch');

                                            /* panel */
                                            $panel_open = total_amount($con, 'open', 'panel');
                                            $panel_mip = total_amount($con, 'material_in_process', 'panel');
                                            $panel_material_req = total_amount($con, 'material_requirement', 'panel');
                                            $panel_mdispatch = total_amount($con, 'material_delivered', 'panel');
                                            $panel_prem = total_amount($con, 'permission_require', 'panel');
                                            $panel_schedule = total_amount($con, 'schedule', 'panel');
                                            $panel_mdelivered = total_amount($con, 'material_delivered', 'panel');
                                            $panel_close = total_amount($con, 'close', 'panel');
                                            $panel_MRS = total_amount($con, 'MRS', 'panel');
                                            $panel_service_center = total_amount($con, 'service_center', 'panel');
                                            $panel_cancelled = total_amount($con, 'cancelled', 'panel');
                                            $panel_fund_required = total_amount($con, 'fund required', 'panel');

                                            /* hooter & sireon */
                                            $hooter_siren_open = total_amount($con, 'open', 'hooter & sireon');
                                            $hooter_siren_mip = total_amount($con, 'material_in_process', 'hooter & sireon');
                                            $hooter_siren_material_req = total_amount($con, 'material_requirement', 'hooter & sireon');
                                            $hooter_siren_mdispatch = total_amount($con, 'material_delivered', 'hooter & sireon');
                                            $hooter_siren_prem = total_amount($con, 'permission_require', 'hooter & sireon');
                                            $hooter_siren_schedule = total_amount($con, 'schedule', 'hooter & sireon');
                                            $hooter_siren_mdelivered = total_amount($con, 'material_delivered', 'hooter & sireon');
                                            $hooter_siren_close = total_amount($con, 'close', 'hooter & sireon');
                                            $hooter_siren_MRS = total_amount($con, 'MRS', 'hooter & sireon');
                                            $hooter_siren_service_center = total_amount($con, 'service_center', 'hooter & sireon');
                                            $hooter_siren_cancelled = total_amount($con, 'cancelled', 'hooter & sireon');
                                            $hooter_siren_fund_required = total_amount($con, 'fund required', 'hooter & sireon');

                                            /* hdd */
                                            $hdd_open = total_amount($con, 'open', 'hdd');
                                            $hdd_mip = total_amount($con, 'material_in_process', 'hdd');
                                            $hdd_material_req = total_amount($con, 'material_requirement', 'hdd');
                                            $hdd_mdispatch = total_amount($con, 'material_delivered', 'hdd');
                                            $hdd_prem = total_amount($con, 'permission_require', 'hdd');
                                            $hdd_schedule = total_amount($con, 'schedule', 'hdd');
                                            $hdd_mdelivered = total_amount($con, 'material_delivered', 'hdd');
                                            $hdd_close = total_amount($con, 'close', 'hdd');
                                            $hdd_MRS = total_amount($con, 'MRS', 'hdd');
                                            $hdd_service_center = total_amount($con, 'service_center', 'hdd');
                                            $hdd_cancelled = total_amount($con, 'cancelled', 'hdd');
                                            $hdd_fund_required = total_amount($con, 'fund required', 'hdd');

                                            /* dvr */
                                            $dvr_open = total_amount($con, 'open', 'dvr');
                                            $dvr_mip = total_amount($con, 'material_in_process', 'dvr');
                                            $dvr_material_req = total_amount($con, 'material_requirement', 'dvr');
                                            $dvr_mdispatch = total_amount($con, 'material_delivered', 'dvr');
                                            $dvr_prem = total_amount($con, 'permission_require', 'dvr');
                                            $dvr_schedule = total_amount($con, 'schedule', 'dvr');
                                            $dvr_mdelivered = total_amount($con, 'material_delivered', 'dvr');
                                            $dvr_close = total_amount($con, 'close', 'dvr');
                                            $dvr_MRS = total_amount($con, 'MRS', 'dvr');
                                            $dvr_service_center = total_amount($con, 'service_center', 'dvr');
                                            $dvr_cancelled = total_amount($con, 'cancelled', 'dvr');
                                            $dvr_fund_required = total_amount($con, 'fund required', 'dvr');

                                            /* camera */
                                            $camera_open = total_amount($con, 'open', 'camera');
                                            $camera_mip = total_amount($con, 'material_in_process', 'camera');
                                            $camera_material_req = total_amount($con, 'material_requirement', 'camera');
                                            $camera_mdispatch = total_amount($con, 'material_delivered', 'camera');
                                            $camera_prem = total_amount($con, 'permission_require', 'camera');
                                            $camera_schedule = total_amount($con, 'schedule', 'camera');
                                            $camera_mdelivered = total_amount($con, 'material_delivered', 'camera');
                                            $camera_close = total_amount($con, 'close', 'camera');
                                            $camera_MRS = total_amount($con, 'MRS', 'camera');
                                            $camera_service_center = total_amount($con, 'service_center', 'camera');
                                            $camera_cancelled = total_amount($con, 'cancelled', 'camera');
                                            $camera_fund_required = total_amount($con, 'fund required', 'camera');

                                            /* backroom */
                                            $backroom_open = total_amount($con, 'open', 'backroom');
                                            $backroom_mip = total_amount($con, 'material_in_process', 'backroom');
                                            $backroom_material_req = total_amount($con, 'material_requirement', 'backroom');
                                            $backroom_mdispatch = total_amount($con, 'material_delivered', 'backroom');
                                            $backroom_prem = total_amount($con, 'permission_require', 'backroom');
                                            $backroom_schedule = total_amount($con, 'schedule', 'backroom');
                                            $backroom_mdelivered = total_amount($con, 'material_delivered', 'backroom');
                                            $backroom_close = total_amount($con, 'close', 'backroom');
                                            $backroom_MRS = total_amount($con, 'MRS', 'backroom');
                                            $backroom_service_center = total_amount($con, 'service_center', 'backroom');
                                            $backroom_cancelled = total_amount($con, 'cancelled', 'backroom');
                                            $backroom_fund_required = total_amount($con, 'fund required', 'backroom');

                                            /* network */
                                            $network_open = total_amount($con, 'open', 'network');
                                            $network_mip = total_amount($con, 'material_in_process', 'network');
                                            $network_material_req = total_amount($con, 'material_requirement', 'network');
                                            $network_mdispatch = total_amount($con, 'material_delivered', 'network');
                                            $network_prem = total_amount($con, 'permission_require', 'network');
                                            $network_schedule = total_amount($con, 'schedule', 'network');
                                            $network_mdelivered = total_amount($con, 'material_delivered', 'network');
                                            $network_close = total_amount($con, 'close', 'network');
                                            $network_MRS = total_amount($con, 'MRS', 'network');
                                            $network_service_center = total_amount($con, 'service_center', 'network');
                                            $network_cancelled = total_amount($con, 'cancelled', 'network');
                                            $network_fund_required = total_amount($con, 'fund required', 'network');

                                            // $open_grand_total = $open_east_amt + $open_north_amt + $open_south_amt + $open_west_amt; 
                                            // $mip_grand_total = $mip_east_amt + $mip_north_amt + $mip_south_amt + $mip_west_amt; 
                                            // $mr_grand_total = $mr_east_amt + $mr_north_amt + $mr_south_amt + $mr_west_amt; 
                                            // $mdis_grand_total = $mdis_east_amt + $mdis_north_amt + $mdis_south_amt + $mdis_west_amt;

                                            // $pr_grand_total = $pr_east_amt + $pr_north_amt + $pr_south_amt + $pr_west_amt; 
                                            // $sch_grand_total = $sch_east_amt + $sch_north_amt + $sch_south_amt + $sch_west_amt; 
                                            // $md_grand_total = $md_east_amt + $md_north_amt + $md_south_amt + $md_west_amt; 
                                            // $close_grand_total = $close_east_amt + $close_north_amt + $close_south_amt + $close_west_amt; 

                                            ?>
                                            <tr>
                                                <td>1</td>
                                                <td>switch</td>
                                                <td><? if ($switch_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "switch"; ?>"><?= $switch_open; } else { ?><?= $switch_open;} ?></a></td>
                                                <td><? if ($switch_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "switch"; ?>"><?= $switch_mip;} else { ?><?= $switch_mip; } ?></a></td>
                                                <td><? if ($switch_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "switch"; ?>"><?= $switch_material_req;
                                                                                                                                                                                    } else { ?><?= $switch_material_req;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($switch_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "switch"; ?>"><?= $switch_mdispatch;
                                                                                                                                                                                } else { ?><?= $switch_mdispatch;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($switch_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "switch"; ?>"><?= $switch_prem;
                                                                                                                                                                            } else { ?><?= $switch_prem;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($switch_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "switch"; ?>"><?= $switch_schedule;
                                                                                                                                                                                } else { ?><?= $switch_schedule;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($switch_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "switch"; ?>"><?= $switch_mdelivered;
                                                                                                                                                                                } else { ?><?= $switch_mdelivered;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($switch_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "switch"; ?>"><?= $switch_close;
                                                                                                                                                                            } else { ?><?= $switch_close;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($switch_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "switch"; ?>"><?= $switch_MRS; } else { ?><?= $switch_MRS; } ?></a></td>
                                                <td><? if ($switch_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "switch"; ?>"><?= $switch_service_center; } else { ?><?= $switch_service_center;  } ?></a></td>
                                                <td><? if ($switch_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "switch"; ?>"><?= $switch_cancelled;  } else { ?><?= $switch_cancelled; } ?></a></td>
                                                <td><? if ($switch_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "switch_fund_required"; ?>&component=<? echo "switch"; ?>"><?= $switch_fund_required;  } else { ?><?= $switch_fund_required; } ?></a></td>

                                            
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>POE Switch</td>
                                                <td><? if ($poe_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_open;
                                                                                                                                                                                } else { ?><?= $poe_open;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($poe_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_mip;
                                                                                                                                                                        } else { ?><?= $poe_mip;
                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($poe_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_material_req;
                                                                                                                                                                                } else { ?><?= $poe_material_req;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($poe_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_mdispatch;
                                                                                                                                                                            } else { ?><?= $poe_mdispatch;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($poe_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_prem;
                                                                                                                                                                        } else { ?><?= $poe_prem;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($poe_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_schedule;
                                                                                                                                                                            } else { ?><?= $poe_schedule;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($poe_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_mdelivered;
                                                                                                                                                                            } else { ?><?= $poe_mdelivered;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($poe_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_close;
                                                                                                                                                                        } else { ?><?= $poe_close;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($poe_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_MRS; } else { ?><?= $poe_MRS; } ?></a></td>
                                                <td><? if ($poe_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_service_center; } else { ?><?= $poe_service_center;  } ?></a></td>
                                                <td><? if ($poe_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_cancelled;  } else { ?><?= $poe_cancelled; } ?></a></td>
                                                <td><? if ($poe_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "poe switch"; ?>"><?= $poe_fund_required;  } else { ?><?= $poe_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>AI Device</td>
                                                <td><? if ($ai_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "ai device"; ?>"><?= $ai_open;
                                                                                                                                                                            } else { ?><?= $ai_open;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($ai_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "ai device"; ?>"><?= $ai_mip;
                                                                                                                                                                        } else { ?><?= $ai_mip;
                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($ai_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "ai device"; ?>"><?= $ai_material_req;
                                                                                                                                                                                } else { ?><?= $ai_material_req;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($ai_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "ai device"; ?>"><?= $ai_mdispatch;
                                                                                                                                                                            } else { ?><?= $ai_mdispatch;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($ai_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "ai device"; ?>"><?= $ai_prem;
                                                                                                                                                                        } else { ?><?= $ai_prem;
                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($ai_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "ai device"; ?>"><?= $ai_schedule;
                                                                                                                                                                            } else { ?><?= $ai_schedule;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($ai_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "ai device"; ?>"><?= $ai_mdelivered;
                                                                                                                                                                            } else { ?><?= $ai_mdelivered;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($ai_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "ai device"; ?>"><?= $ai_close;
                                                                                                                                                                        } else { ?><?= $ai_close;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($ai_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "ai device"; ?>"><?= $ai_MRS; } else { ?><?= $ai_MRS; } ?></a></td>
                                                <td><? if ($ai_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "ai device"; ?>"><?= $ai_service_center; } else { ?><?= $ai_service_center;  } ?></a></td>
                                                <td><? if ($ai_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "ai device"; ?>"><?= $ai_cancelled;  } else { ?><?= $ai_cancelled; } ?></a></td>
                                                <td><? if ($ai_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "ai device"; ?>"><?= $ai_fund_required;  } else { ?><?= $ai_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>SD Card</td>
                                                <td><? if ($sd_card_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_open;
                                                                                                                                                                                    } else { ?><?= $sd_card_open;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($sd_card_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_mip;
                                                                                                                                                                            } else { ?><?= $sd_card_mip;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($sd_card_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_material_req;
                                                                                                                                                                                    } else { ?><?= $sd_card_material_req;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($sd_card_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_mdispatch;
                                                                                                                                                                                } else { ?><?= $sd_card_mdispatch;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($sd_card_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_prem;
                                                                                                                                                                            } else { ?><?= $sd_card_prem;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($sd_card_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_schedule;
                                                                                                                                                                                } else { ?><?= $sd_card_schedule;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($sd_card_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_mdelivered;
                                                                                                                                                                                } else { ?><?= $sd_card_mdelivered;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($sd_card_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_close;
                                                                                                                                                                            } else { ?><?= $sd_card_close;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($sd_card_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_MRS; } else { ?><?= $sd_card_MRS; } ?></a></td>
                                                <td><? if ($sd_card_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_service_center; } else { ?><?= $sd_card_service_center;  } ?></a></td>
                                                <td><? if ($sd_card_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_cancelled;  } else { ?><?= $sd_card_cancelled; } ?></a></td>
                                                <td><? if ($sd_card_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "sd card"; ?>"><?= $sd_card_fund_required;  } else { ?><?= $sd_card_fund_required; } ?></a></td>


                                            </tr>

                                            <tr>
                                                <td>5</td>
                                                <td>FALSE ALERT</td>
                                                <td><? if ($false_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "false alert"; ?>"><?= $false_open;
                                                                                                                                                                                } else { ?><?= $false_open;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($false_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "false alert"; ?>"><?= $false_mip;
                                                                                                                                                                        } else { ?><?= $false_mip;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($false_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "false alert"; ?>"><?= $false_material_req;
                                                                                                                                                                                    } else { ?><?= $false_material_req;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($false_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "false alert"; ?>"><?= $false_mdispatch;
                                                                                                                                                                                } else { ?><?= $false_mdispatch;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($false_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "false alert"; ?>"><?= $false_prem;
                                                                                                                                                                        } else { ?><?= $false_prem;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($false_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "false alert"; ?>"><?= $false_schedule;
                                                                                                                                                                            } else { ?><?= $false_schedule;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($false_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "false alert"; ?>"><?= $false_mdelivered;
                                                                                                                                                                                } else { ?><?= $false_mdelivered;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($false_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "false alert"; ?>"><?= $false_close;
                                                                                                                                                                            } else { ?><?= $false_close;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($false_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "false alert"; ?>"><?= $false_MRS; } else { ?><?= $false_MRS; } ?></a></td>
                                                <td><? if ($false_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "false alert"; ?>"><?= $false_service_center; } else { ?><?= $false_service_center;  } ?></a></td>
                                                <td><? if ($false_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "false alert"; ?>"><?= $false_cancelled;  } else { ?><?= $false_cancelled; } ?></a></td>
                                                <td><? if ($false_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "false alert"; ?>"><?= $false_fund_required;  } else { ?><?= $false_fund_required; } ?></a></td>

                                            </tr>


                                            <tr>
                                                <td>6</td>
                                                <td>cctv footage</td>
                                                <td><? if ($cctv_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_open;
                                                                                                                                                                                } else { ?><?= $cctv_open;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($cctv_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_mip;
                                                                                                                                                                        } else { ?><?= $cctv_mip;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($cctv_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_material_req;
                                                                                                                                                                                } else { ?><?= $cctv_material_req;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($cctv_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_mdispatch;
                                                                                                                                                                            } else { ?><?= $cctv_mdispatch;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($cctv_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_prem;
                                                                                                                                                                        } else { ?><?= $cctv_prem;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($cctv_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_schedule;
                                                                                                                                                                            } else { ?><?= $cctv_schedule;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($cctv_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_mdelivered;
                                                                                                                                                                                } else { ?><?= $cctv_mdelivered;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($cctv_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_close;
                                                                                                                                                                        } else { ?><?= $cctv_close;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($cctv_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_MRS; } else { ?><?= $cctv_MRS; } ?></a></td>
                                                <td><? if ($cctv_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_service_center; } else { ?><?= $cctv_service_center;  } ?></a></td>
                                                <td><? if ($cctv_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_cancelled;  } else { ?><?= $cctv_cancelled; } ?></a></td>
                                                <td><? if ($cctv_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "cctv footage"; ?>"><?= $cctv_fund_required;  } else { ?><?= $cctv_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>two way</td>
                                                <td><? if ($two_way_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "two way"; ?>"><?= $two_way_open;
                                                                                                                                                                                    } else { ?><?= $two_way_open;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($two_way_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "two way"; ?>"><?= $two_way_mip;
                                                                                                                                                                            } else { ?><?= $two_way_mip;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($two_way_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "two way"; ?>"><?= $two_way_material_req;
                                                                                                                                                                                    } else { ?><?= $two_way_material_req;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($two_way_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "two way"; ?>"><?= $two_way_mdispatch;
                                                                                                                                                                                } else { ?><?= $two_way_mdispatch;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($two_way_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "two way"; ?>"><?= $two_way_prem;
                                                                                                                                                                            } else { ?><?= $two_way_prem;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($two_way_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "two way"; ?>"><?= $two_way_schedule;
                                                                                                                                                                                } else { ?><?= $two_way_schedule;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($two_way_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "two way"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                } else { ?><?= $two_way_mdelivered;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($two_way_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "two way"; ?>"><?= $two_way_close;
                                                                                                                                                                            } else { ?><?= $two_way_close;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($two_way_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "two way"; ?>"><?= $two_way_MRS; } else { ?><?= $two_way_MRS; } ?></a></td>
                                                <td><? if ($two_way_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "two way"; ?>"><?= $two_way_service_center; } else { ?><?= $two_way_service_center;  } ?></a></td>
                                                <td><? if ($two_way_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "two way"; ?>"><?= $two_way_cancelled;  } else { ?><?= $two_way_cancelled; } ?></a></td>
                                                <td><? if ($two_way_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "two way"; ?>"><?= $two_way_fund_required;  } else { ?><?= $two_way_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>sensors</td>
                                                <td><? if ($sensors_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_open;
                                                                                                                                                                                    } else { ?><?= $sensors_open;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($sensors_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_mip;
                                                                                                                                                                            } else { ?><?= $sensors_mip;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($sensors_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_material_req;
                                                                                                                                                                                    } else { ?><?= $sensors_material_req;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($sensors_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_mdispatch;
                                                                                                                                                                                } else { ?><?= $sensors_mdispatch;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($sensors_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_prem;
                                                                                                                                                                            } else { ?><?= $sensors_prem;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($sensors_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_schedule;
                                                                                                                                                                                } else { ?><?= $sensors_schedule;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($sensors_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "sensors"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                } else { ?><?= $sensors_mdelivered;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($sensors_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_close;
                                                                                                                                                                            } else { ?><?= $sensors_close;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($sensors_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_MRS; } else { ?><?= $sensors_MRS; } ?></a></td>
                                                <td><? if ($sensors_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_service_center; } else { ?><?= $sensors_service_center;  } ?></a></td>
                                                <td><? if ($sensors_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_cancelled;  } else { ?><?= $sensors_cancelled; } ?></a></td>
                                                <td><? if ($sensors_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "sensors"; ?>"><?= $sensors_fund_required;  } else { ?><?= $sensors_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td>routers</td>
                                                <td><? if ($routers_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "routers"; ?>"><?= $routers_open;
                                                                                                                                                                                    } else { ?><?= $routers_open;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($routers_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "routers"; ?>"><?= $routers_mip;
                                                                                                                                                                            } else { ?><?= $routers_mip;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($routers_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "routers"; ?>"><?= $routers_material_req;
                                                                                                                                                                                    } else { ?><?= $routers_material_req;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($routers_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "routers"; ?>"><?= $routers_mdispatch;
                                                                                                                                                                                } else { ?><?= $routers_mdispatch;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($routers_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "routers"; ?>"><?= $routers_prem;
                                                                                                                                                                            } else { ?><?= $routers_prem;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($routers_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "routers"; ?>"><?= $routers_schedule;
                                                                                                                                                                                } else { ?><?= $routers_schedule;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($routers_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "routers"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                } else { ?><?= $routers_mdelivered;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($routers_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "routers"; ?>"><?= $routers_close;  } else { ?><?= $routers_close; } ?></a></td>
                                                <td><? if ($routers_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "routers"; ?>"><?= $routers_MRS; } else { ?><?= $routers_MRS; } ?></a></td>
                                                <td><? if ($routers_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "routers"; ?>"><?= $routers_service_center; } else { ?><?= $routers_service_center;  } ?></a></td>
                                                <td><? if ($routers_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "routers"; ?>"><?= $routers_cancelled;  } else { ?><?= $routers_cancelled; } ?></a></td>
                                                <td><? if ($routers_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "routers"; ?>"><?= $routers_fund_required;  } else { ?><?= $routers_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td>relay</td>
                                                <td><? if ($relay_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "relay"; ?>"><?= $relay_open;
                                                                                                                                                                                } else { ?><?= $relay_open;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($relay_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "relay"; ?>"><?= $relay_mip; } else { ?><?= $relay_mip;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($relay_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "relay"; ?>"><?= $relay_material_req;
                                                                                                                                                                                    } else { ?><?= $relay_material_req;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($relay_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "relay"; ?>"><?= $relay_mdispatch;
                                                                                                                                                                                } else { ?><?= $relay_mdispatch;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($relay_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "relay"; ?>"><?= $relay_prem;
                                                                                                                                                                        } else { ?><?= $relay_prem;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($relay_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "relay"; ?>"><?= $relay_schedule;
                                                                                                                                                                            } else { ?><?= $relay_schedule;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($relay_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "relay"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                } else { ?><?= $relay_mdelivered;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($relay_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "relay"; ?>"><?= $relay_close;
                                                                                                                                                                            } else { ?><?= $relay_close;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($relay_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "relay"; ?>"><?= $relay_MRS; } else { ?><?= $relay_MRS; } ?></a></td>
                                                <td><? if ($relay_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "relay"; ?>"><?= $relay_service_center; } else { ?><?= $relay_service_center;  } ?></a></td>
                                                <td><? if ($relay_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "relay"; ?>"><?= $relay_cancelled;  } else { ?><?= $relay_cancelled; } ?></a></td>
                                                <td><? if ($relay_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "relay"; ?>"><?= $relay_fund_required;  } else { ?><?= $relay_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>11</td>
                                                <td>panic switch</td>
                                                <td><? if ($panic_switch_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_open;
                                                                                                                                                                                        } else { ?><?= $panic_switch_open;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($panic_switch_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_mip;
                                                                                                                                                                                } else { ?><?= $panic_switch_mip;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($panic_switch_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_material_req;
                                                                                                                                                                                        } else { ?><?= $panic_switch_material_req;
                                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($panic_switch_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_mdispatch;
                                                                                                                                                                                    } else { ?><?= $panic_switch_mdispatch;
                                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($panic_switch_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_prem;
                                                                                                                                                                                } else { ?><?= $panic_switch_prem;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($panic_switch_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_schedule;
                                                                                                                                                                                    } else { ?><?= $panic_switch_schedule;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($panic_switch_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "panic switch"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                        } else { ?><?= $panic_switch_mdelivered;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($panic_switch_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_close;
                                                                                                                                                                                } else { ?><?= $panic_switch_close;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($panic_switch_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_MRS; } else { ?><?= $panic_switch_MRS; } ?></a></td>
                                                <td><? if ($panic_switch_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_service_center; } else { ?><?= $panic_switch_service_center;  } ?></a></td>
                                                <td><? if ($panic_switch_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_cancelled;  } else { ?><?= $panic_switch_cancelled; } ?></a></td>
                                                <td><? if ($panic_switch_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "panic switch"; ?>"><?= $panic_switch_fund_required;  } else { ?><?= $panic_switch_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td>panel</td>
                                                <td><? if ($panel_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "panel"; ?>"><?= $panel_open;
                                                                                                                                                                                } else { ?><?= $panel_open;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($panel_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "panel"; ?>"><?= $panel_mip;
                                                                                                                                                                        } else { ?><?= $panel_mip;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($panel_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "panel"; ?>"><?= $panel_material_req;
                                                                                                                                                                                    } else { ?><?= $panel_material_req;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($panel_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "panel"; ?>"><?= $panel_mdispatch;
                                                                                                                                                                                } else { ?><?= $panel_mdispatch;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($panel_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "panel"; ?>"><?= $panel_prem;
                                                                                                                                                                        } else { ?><?= $panel_prem;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($panel_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "panel"; ?>"><?= $panel_schedule;
                                                                                                                                                                            } else { ?><?= $panel_schedule;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($panel_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "panel"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                } else { ?><?= $panel_mdelivered;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($panel_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "panel"; ?>"><?= $panel_close;
                                                                                                                                                                            } else { ?><?= $panel_close;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($panel_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "panel"; ?>"><?= $panel_MRS; } else { ?><?= $panel_MRS; } ?></a></td>
                                                <td><? if ($panel_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "panel"; ?>"><?= $panel_service_center; } else { ?><?= $panel_service_center;  } ?></a></td>
                                                <td><? if ($panel_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "panel"; ?>"><?= $panel_cancelled;  } else { ?><?= $panel_cancelled; } ?></a></td>
                                                <td><? if ($panel_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "panel"; ?>"><?= $panel_fund_required;  } else { ?><?= $panel_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>13</td>
                                                <td>hooter & sireon</td>
                                                <td><? if ($hooter_siren_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_open;
                                                                                                                                                                                        } else { ?><?= $hooter_siren_open;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($hooter_siren_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_mip;
                                                                                                                                                                                } else { ?><?= $hooter_siren_mip;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($hooter_siren_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_material_req;
                                                                                                                                                                                        } else { ?><?= $hooter_siren_material_req;
                                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($hooter_siren_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_mdispatch;
                                                                                                                                                                                    } else { ?><?= $hooter_siren_mdispatch;
                                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($hooter_siren_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_prem;
                                                                                                                                                                                } else { ?><?= $hooter_siren_prem;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($hooter_siren_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_schedule;
                                                                                                                                                                                    } else { ?><?= $hooter_siren_schedule;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($hooter_siren_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                        } else { ?><?= $hooter_siren_mdelivered;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($hooter_siren_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_close;
                                                                                                                                                                                } else { ?><?= $hooter_siren_close;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($hooter_siren_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_MRS; } else { ?><?= $hooter_siren_MRS; } ?></a></td>
                                                <td><? if ($hooter_siren_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_service_center; } else { ?><?= $hooter_siren_service_center;  } ?></a></td>
                                                <td><? if ($hooter_siren_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_cancelled;  } else { ?><?= $hooter_siren_cancelled; } ?></a></td>
                                                <td><? if ($hooter_siren_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "hooter & sireon"; ?>"><?= $hooter_siren_fund_required;  } else { ?><?= $hooter_siren_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>14</td>
                                                <td>hdd</td>
                                                <td><? if ($hdd_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_open;
                                                                                                                                                                                } else { ?><?= $hdd_open;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($hdd_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_mip;
                                                                                                                                                                        } else { ?><?= $hdd_mip;
                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($hdd_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_material_req;
                                                                                                                                                                                } else { ?><?= $hdd_material_req;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($hdd_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_mdispatch;
                                                                                                                                                                            } else { ?><?= $hdd_mdispatch;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($hdd_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_prem;
                                                                                                                                                                        } else { ?><?= $hdd_prem;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($hdd_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_schedule;
                                                                                                                                                                            } else { ?><?= $hdd_schedule;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($hdd_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "hdd"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                            } else { ?><?= $hdd_mdelivered;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($hdd_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_close;
                                                                                                                                                                        } else { ?><?= $hdd_close;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($hdd_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_MRS; } else { ?><?= $hdd_MRS; } ?></a></td>
                                                <td><? if ($hdd_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_service_center; } else { ?><?= $hdd_service_center;  } ?></a></td>
                                                <td><? if ($hdd_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_cancelled;  } else { ?><?= $hdd_cancelled; } ?></a></td>
                                                <td><? if ($hdd_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "hdd"; ?>"><?= $hdd_fund_required;  } else { ?><?= $hdd_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>15</td>
                                                <td>dvr</td>
                                                <td><? if ($dvr_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_open;
                                                                                                                                                                                } else { ?><?= $dvr_open;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($dvr_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_mip;
                                                                                                                                                                        } else { ?><?= $dvr_mip;
                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($dvr_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_material_req;
                                                                                                                                                                                } else { ?><?= $dvr_material_req;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($dvr_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_mdispatch;
                                                                                                                                                                            } else { ?><?= $dvr_mdispatch;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($dvr_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_prem;
                                                                                                                                                                        } else { ?><?= $dvr_prem;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($dvr_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_schedule;
                                                                                                                                                                            } else { ?><?= $dvr_schedule;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($dvr_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "dvr"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                            } else { ?><?= $dvr_mdelivered;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($dvr_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_close;
                                                                                                                                                                        } else { ?><?= $dvr_close;
                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($dvr_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_MRS; } else { ?><?= $dvr_MRS; } ?></a></td>
                                                <td><? if ($dvr_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_service_center; } else { ?><?= $dvr_service_center;  } ?></a></td>
                                                <td><? if ($dvr_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_cancelled;  } else { ?><?= $dvr_cancelled; } ?></a></td>
                                                <td><? if ($dvr_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "dvr"; ?>"><?= $dvr_fund_required;  } else { ?><?= $dvr_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>16</td>
                                                <td>camera</td>
                                                <td><? if ($camera_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "camera"; ?>"><?= $camera_open;
                                                                                                                                                                                } else { ?><?= $camera_open;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($camera_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "camera"; ?>"><?= $camera_mip;
                                                                                                                                                                            } else { ?><?= $camera_mip;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($camera_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "camera"; ?>"><?= $camera_material_req;
                                                                                                                                                                                    } else { ?><?= $camera_material_req;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($camera_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "camera"; ?>"><?= $camera_mdispatch;
                                                                                                                                                                                } else { ?><?= $camera_mdispatch;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($camera_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "camera"; ?>"><?= $camera_prem;
                                                                                                                                                                            } else { ?><?= $camera_prem;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($camera_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "camera"; ?>"><?= $camera_schedule;
                                                                                                                                                                                } else { ?><?= $camera_schedule;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($camera_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "camera"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                } else { ?><?= $camera_mdelivered;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($camera_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "camera"; ?>"><?= $camera_close;
                                                                                                                                                                            } else { ?><?= $camera_close;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($camera_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "camera"; ?>"><?= $camera_MRS; } else { ?><?= $camera_MRS; } ?></a></td>
                                                <td><? if ($camera_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "camera"; ?>"><?= $camera_service_center; } else { ?><?= $camera_service_center;  } ?></a></td>
                                                <td><? if ($camera_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "camera"; ?>"><?= $camera_cancelled;  } else { ?><?= $camera_cancelled; } ?></a></td>
                                                <td><? if ($camera_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "camera"; ?>"><?= $camera_fund_required;  } else { ?><?= $camera_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>17</td>
                                                <td>backroom</td>
                                                <td><? if ($backroom_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_open;
                                                                                                                                                                                    } else { ?><?= $backroom_open;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($backroom_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_mip;
                                                                                                                                                                            } else { ?><?= $backroom_mip;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($backroom_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_material_req;
                                                                                                                                                                                    } else { ?><?= $backroom_material_req;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($backroom_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_mdispatch;
                                                                                                                                                                                } else { ?><?= $backroom_mdispatch;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($backroom_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_prem;
                                                                                                                                                                            } else { ?><?= $backroom_prem;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($backroom_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_schedule;
                                                                                                                                                                                } else { ?><?= $backroom_schedule;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($backroom_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "backroom"; ?>"><?= $two_way_mdelivered;
                                                                                                                                                                                    } else { ?><?= $backroom_mdelivered;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($backroom_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_close;
                                                                                                                                                                            } else { ?><?= $backroom_close;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($backroom_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_MRS; } else { ?><?= $backroom_MRS; } ?></a></td>
                                                <td><? if ($backroom_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_service_center; } else { ?><?= $backroom_service_center;  } ?></a></td>
                                                <td><? if ($backroom_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_cancelled;  } else { ?><?= $backroom_cancelled; } ?></a></td>
                                                <td><? if ($backroom_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "backroom"; ?>"><?= $backroom_fund_required;  } else { ?><?= $backroom_fund_required; } ?></a></td>

                                            </tr>
                                            <tr>
                                                <td>18</td>
                                                <td>Network</td>
                                                <td><? if ($network_open != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "open"; ?>&component=<? echo "network"; ?>"><?= $network_open;
                                                                                                                                                                                    } else { ?><?= $network_open;
                                                                                                                                                                                                            } ?></a></td>
                                                <td><? if ($network_mip != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_in_process"; ?>&component=<? echo "network"; ?>"><?= $network_mip;
                                                                                                                                                                            } else { ?><?= $network_mip;
                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($network_material_req != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_requirement"; ?>&component=<? echo "network"; ?>"><?= $network_material_req;
                                                                                                                                                                                    } else { ?><?= $network_material_req;
                                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($network_mdispatch != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_dispatch"; ?>&component=<? echo "network"; ?>"><?= $network_mdispatch;
                                                                                                                                                                                } else { ?><?= $network_mdispatch;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($network_prem != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "permission_require"; ?>&component=<? echo "network"; ?>"><?= $network_prem;
                                                                                                                                                                            } else { ?><?= $network_prem;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($network_schedule != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "schedule"; ?>&component=<? echo "network"; ?>"><?= $network_schedule;
                                                                                                                                                                                } else { ?><?= $network_schedule;
                                                                                                                                                                                                                } ?></a></td>
                                                <td><? if ($network_mdelivered != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "material_delivered"; ?>&component=<? echo "network"; ?>"><?= $network_mdelivered;
                                                                                                                                                                                } else { ?><?= $network_mdelivered;
                                                                                                                                                                                                                    } ?></a></td>
                                                <td><? if ($network_close != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "close"; ?>&component=<? echo "network"; ?>"><?= $network_close;
                                                                                                                                                                            } else { ?><?= $network_close;
                                                                                                                                                                                                        } ?></a></td>
                                                <td><? if ($network_MRS != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "MRS"; ?>&component=<? echo "network"; ?>"><?= $network_MRS; } else { ?><?= $network_MRS; } ?></a></td>
                                                <td><? if ($network_service_center != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "service_center"; ?>&component=<? echo "network"; ?>"><?= $network_service_center; } else { ?><?= $network_service_center;  } ?></a></td>
                                                <td><? if ($network_cancelled != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "cancelled"; ?>&component=<? echo "network"; ?>"><?= $network_cancelled;  } else { ?><?= $network_cancelled; } ?></a></td>
                                                <td><? if ($network_fund_required != 0) { ?><a target="_blank" href="mis_call_detail.php?status=<? echo "fund_required"; ?>&component=<? echo "network"; ?>"><?= $network_fund_required;  } else { ?><?= $network_fund_required; } ?></a></td>

                                            </tr>

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
} else { ?>

    <script>
        window.location.href = "login.php";
    </script>
<? }
?>




<script>
jQuery(document).ready(function() {
    jQuery('#loading').fadeOut(3000);
});
</script>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>
</body>

</html>