<style>
    .icon-wrapper span {
        width: 100%;
        padding: 10px;
    }

    #detail_dashoard_part1 .widget-chart .widget-subheading{
opacity: 1;
    }
    #detail_dashoard_part1 .widget-chart {
        padding: 5px;
    }

    #detail_dashoard_part1 .widget-chart:hover {
        background: transparent;
    }

    #detail_dashoard_part1 .widget-chart .widget-numbers {
        font-size: 1.5rem
    }

    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
        opacity: 1;
        width: 100%;
        text-align: center;
        border: 1px solid;
        color: white;
        background: orange;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        /* width: 120px; */
        background-color: black;
        color: #fff;
        text-align: left;
        border-radius: 6px;
        padding: 17px;
        position: absolute;
        z-index: 1;
        left: 0;
        top: 0;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
    }

    .tooltiptext li {
        font-size: 10px;
    }
</style>



<?php

$detail_sql = "SELECT 
    SUM(CASE WHEN login_status = 0 THEN 1 ELSE 0 END) AS dvr_online_count,
    SUM(CASE WHEN login_status = 1 THEN 1 ELSE 0 END) AS dvr_offline_count,
    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS network_online_count,
    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS network_offline_count,
    SUM(CASE WHEN LOWER(hdd) = '1' OR LOWER(hdd) = 'ok' OR hdd='' THEN 1 ELSE 0 END) AS harddisk_working,
    SUM(CASE WHEN LOWER(hdd) not in (1, 'ok','') THEN 1 ELSE 0 END) AS harddisk_notworking,


SUM(
        CASE 
            WHEN TRIM(LOWER(cam1)) = 'working' 
            AND login_status = 0 
            AND status = 1
            THEN 1 ELSE 0 
        END
    ) AS cam1_working,

    SUM(
        CASE 
            WHEN TRIM(LOWER(cam1)) IN ('not working', '') AND NOT (login_status = 0 AND status = 1) THEN 1  
            WHEN TRIM(LOWER(cam1)) NOT IN ('working','idle') AND (login_status = 0 AND status = 1) THEN 1
            WHEN TRIM(LOWER(cam1)) = 'working' AND NOT (login_status = 0 AND status = 1) THEN 1
            ELSE 0 
        END
    ) AS cam1_not_working,
    SUM(
        CASE 
            WHEN TRIM(LOWER(cam1)) NOT IN ('working', 'not working', '') 
                 OR cam1 IS NULL
            THEN 1 ELSE 0 
        END
    ) AS cam1_others,



SUM(
        CASE 
            WHEN TRIM(LOWER(cam2)) = 'working' 
            AND login_status = 0 
            AND status = 1
            THEN 1 ELSE 0 
        END
    ) AS cam2_working,

    SUM(
        CASE 
            WHEN TRIM(LOWER(cam2)) IN ('not working', '') AND NOT (login_status = 0 AND status = 1) THEN 1  
            WHEN TRIM(LOWER(cam2)) NOT IN ('working','idle') AND (login_status = 0 AND status = 1) THEN 1
            WHEN TRIM(LOWER(cam2)) = 'working' AND NOT (login_status = 0 AND status = 1) THEN 1
            ELSE 0 
        END
    ) AS cam2_not_working,
    SUM(
        CASE 
            WHEN TRIM(LOWER(cam2)) NOT IN ('working', 'not working', '') 
                 OR cam2 IS NULL
            THEN 1 ELSE 0 
        END
    ) AS cam2_others,

    SUM(
        CASE 
            WHEN TRIM(LOWER(cam2)) = 'working' 
            AND login_status = 0 
            AND status = 1
            THEN 1 ELSE 0 
        END
    ) AS cam3_working,

    SUM(
        CASE 
            WHEN TRIM(LOWER(cam3)) IN ('not working', '') AND NOT (login_status = 0 AND status = 1) THEN 1  
            WHEN TRIM(LOWER(cam3)) NOT IN ('working','idle') AND (login_status = 0 AND status = 1) THEN 1
            WHEN TRIM(LOWER(cam3)) = 'working' AND NOT (login_status = 0 AND status = 1) THEN 1
            ELSE 0 
        END
    ) AS cam3_not_working,
    SUM(
        CASE 
            WHEN TRIM(LOWER(cam3)) NOT IN ('working', 'not working', '') 
                 OR cam3 IS NULL
            THEN 1 ELSE 0 
        END
    ) AS cam3_others,


SUM(
        CASE 
            WHEN TRIM(LOWER(cam4)) = 'working' 
            AND login_status = 0 
            AND status = 1
            THEN 1 ELSE 0 
        END
    ) AS cam4_working,

    SUM(
        CASE 
            WHEN TRIM(LOWER(cam4)) IN ('not working', '') AND NOT (login_status = 0 AND status = 1) THEN 1  
            WHEN TRIM(LOWER(cam4)) NOT IN ('working','idle') AND (login_status = 0 AND status = 1) THEN 1
            WHEN TRIM(LOWER(cam4)) = 'working' AND NOT (login_status = 0 AND status = 1) THEN 1
            ELSE 0 
        END
    ) AS cam4_not_working,
    SUM(
        CASE 
            WHEN TRIM(LOWER(cam4)) NOT IN ('working', 'not working', '') 
                 OR cam4 IS NULL
            THEN 1 ELSE 0 
        END
    ) AS cam4_others






from all_dvr_live where LOWER(live)='y'";

$detail_query = mysqli_query($con, $detail_sql);
$detail_result = mysqli_fetch_assoc($detail_query);

$dvr_online_count = $detail_result['dvr_online_count'];
$dvr_offline_count = $detail_result['dvr_offline_count'];

$network_online_count = $detail_result['network_online_count'];
$network_offline_count = $detail_result['network_offline_count'];

$harddisk_working = $detail_result['harddisk_working'];
$harddisk_notworking = $detail_result['harddisk_notworking'];

$cam1_working = $detail_result['cam1_working'];
$cam1_not_working = $detail_result['cam1_not_working'];
$cam1_other = $detail_result['cam1_others'];

$cam2_working = $detail_result['cam2_working'];
$cam2_not_working = $detail_result['cam2_not_working'];
$cam2_other = $detail_result['cam2_others'];


$cam3_working = $detail_result['cam3_working'];
$cam3_not_working = $detail_result['cam3_not_working'];
$cam3_other = $detail_result['cam3_others'];


$cam4_working = $detail_result['cam4_working'];
$cam4_not_working = $detail_result['cam4_not_working'];
$cam4_other = $detail_result['cam4_others'];



?>


<div class="row" id="detail_dashoard_part1">

    <div class="col-lg-12 col-xl-12">
        <div class="main-card mb-3 card">
            <div class="grid-menu grid-menu-2col">
                <div class="no-gutters row">

                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">Router (Network)</div>
                            <br>

                            <div class="widget-subheading">Up : <?php echo $network_online_count; ?></div>
                            <!-- status=1 -->

                            <hr />
                            <div class="widget-subheading">Down : <?php echo $network_offline_count; ?></div>
                            <!-- status=0 -->

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">DVR</div>
                            <br>
                            <div class="widget-subheading">Success : <span><?php echo  $dvr_online_count; ?></span></div>
                            <!-- login_status=0 -->
                            <hr>
                            <div class="widget-subheading">Can't Login : <span><?php echo $dvr_offline_count; ?></span></div>
                            <!-- login_status=1 -->

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">Can't Login</div>
                            <br>
                            <div class="widget-subheading">Success : <span>
                                    <?php echo  $network_online_count - $dvr_online_count; ?></span></div>


                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">Harddisk</div>
                            <br>

                            <div class="widget-subheading">Working : <?php echo $dvr_online_count - $harddisk_notworking; ?></div>
                            <hr>
                            <div class="widget-subheading">Not Working : <?php echo $harddisk_notworking; ?> </div>
                            <hr>
                            <div class="tooltip">View Details
                                <span class="tooltiptext">

                                    <ul>
                                        <?php

                                        $hdd_sql = mysqli_query($con, "select hdd,count(1) as total from all_dvr_live where LOWER(live)='y' group by hdd");
                                        while ($hdd_sql_result = mysqli_fetch_assoc($hdd_sql)) {

                                            $hdd_status = $hdd_sql_result['hdd'];
                                            if ($hdd_status == '') {
                                                $hdd_status = '(Blank)';
                                            }
                                            $total = $hdd_sql_result['total'];

                                        ?>

                                            <li> <?php echo $hdd_status . ' - ' . $total; ?></li>
                                        <?php
                                        }

                                        ?>

                                    </ul>


                                </span>
                            </div>


                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">Camera 1</div>
                            <br>
                            <div class="widget-subheading">Working : <span><?php echo $cam1_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Not Working : <span><?php echo $cam1_not_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Others : <span><?php echo $cam1_other; ?></span></div>

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">Camera 2</div>
                            <br>
                            <div class="widget-subheading">Working : <span><?php echo $cam2_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Not Working : <span><?php echo $cam2_not_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Others : <span><?php echo $cam2_other; ?></span></div>

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">Camera 3</div>
                            <br>
                            <div class="widget-subheading">Working : <span><?php echo $cam3_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Not Working : <span><?php echo $cam3_not_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Others : <span><?php echo $cam3_other; ?></span></div>



                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="widget-chart ">

                            <div class="widget-numbers">Camera 4</div>
                            <br>
                            <div class="widget-subheading">Working : <span><?php echo $cam4_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Not Working : <span><?php echo $cam4_not_working; ?></span></div>
                            <hr>
                            <div class="widget-subheading">Others : <span><?php echo $cam4_other; ?></span></div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>