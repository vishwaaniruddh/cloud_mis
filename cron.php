<?
include('config.php');

        function total_amount($status,$zone){
            global $con; 
            
            $close_east_query = mysqli_query($con,"SELECT COUNT(id) FROM `mis_details` WHERE status='".$status."' AND zone='".$zone."'");
            $close_east_query_res = mysqli_fetch_row($close_east_query); 
            $close_east_amt = $close_east_query_res[0];
            return $close_east_amt;
        }


                $user_id = $_SESSION['userid'];  
                $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
                $user_sql = mysqli_query($con,$user_statement);
                $user_rowresult = mysqli_fetch_row($user_sql);
                //echo '<pre>';print_r($user_rowresult);echo '</pre>';die;
                $_userlevel = $user_rowresult[0];



                                                        $close_east_amt = total_amount('close','east');    
                                                        $close_west_amt = total_amount('close','west');
                                                        $close_north_amt = total_amount('close','north');
                                                        $close_south_amt = total_amount('close','south');
                                                        
                                                        $md_east_amt = total_amount('material_delivered','east');
                                                        $md_west_amt = total_amount('material_delivered','west');
                                                        $md_north_amt = total_amount('material_delivered','north');
                                                        $md_south_amt = total_amount('material_delivered','south');
                                                        
                                                        $mdis_east_amt = total_amount('material_dispatch','east');
                                                        $mdis_west_amt = total_amount('material_dispatch','west');
                                                        $mdis_north_amt = total_amount('material_dispatch','north');
                                                        $mdis_south_amt = total_amount('material_dispatch','south');
                                                        
                                                        $mip_east_amt = total_amount('material_in_process','east');
                                                        $mip_west_amt = total_amount('material_in_process','west');
                                                        $mip_north_amt = total_amount('material_in_process','north');
                                                        $mip_south_amt = total_amount('material_in_process','south');
                                                        
                                                        $mr_east_amt = total_amount('material_requirement','east');
                                                        $mr_west_amt = total_amount('material_requirement','west');
                                                        $mr_north_amt = total_amount('material_requirement','north');
                                                        $mr_south_amt = total_amount('material_requirement','south');
                                                        
                                                        $open_east_amt = total_amount('open','east');
                                                        $open_west_amt = total_amount('open','west');
                                                        $open_north_amt = total_amount('open','north');
                                                        $open_south_amt = total_amount('open','south');
                                                        
                                                        $pr_east_amt = total_amount('permission_require','east');
                                                        $pr_west_amt = total_amount('permission_require','west');
                                                        $pr_north_amt = total_amount('permission_require','north');
                                                        $pr_south_amt = total_amount('permission_require','south');
                                                        
                                                        $sch_east_amt = total_amount('schedule','east');
                                                        $sch_west_amt = total_amount('schedule','west');
                                                        $sch_north_amt = total_amount('schedule','north');
                                                        $sch_south_amt = total_amount('schedule','south');
                                                        
                                                        $open_grand_total = $open_east_amt + $open_north_amt + $open_south_amt + $open_west_amt; 
                                                        $mip_grand_total = $mip_east_amt + $mip_north_amt + $mip_south_amt + $mip_west_amt; 
                                                        $mr_grand_total = $mr_east_amt + $mr_north_amt + $mr_south_amt + $mr_west_amt; 
                                                        $mdis_grand_total = $mdis_east_amt + $mdis_north_amt + $mdis_south_amt + $mdis_west_amt;
                                                        
                                                        $pr_grand_total = $pr_east_amt + $pr_north_amt + $pr_south_amt + $pr_west_amt; 
                                                        $sch_grand_total = $sch_east_amt + $sch_north_amt + $sch_south_amt + $sch_west_amt; 
                                                        $md_grand_total = $md_east_amt + $md_north_amt + $md_south_amt + $md_west_amt; 
                                                        $close_grand_total = $close_east_amt + $close_north_amt + $close_south_amt + $close_west_amt; 
                                                        
                                                        $total_east = $open_east_amt + $mip_east_amt + $mr_east_amt + $mdis_east_amt + $pr_east_amt + $sch_east_amt + $md_east_amt + $close_east_amt;
                                                        $total_west = $open_west_amt + $mip_west_amt + $mr_west_amt + $mdis_west_amt + $pr_west_amt + $sch_west_amt + $md_west_amt + $close_west_amt;
                                                        $total_south = $open_south_amt + $mip_south_amt + $mr_south_amt + $mdis_south_amt + $pr_south_amt + $sch_south_amt + $md_south_amt + $close_south_amt;
                                                        $total_north = $open_north_amt + $mip_north_amt + $mr_north_amt + $mdis_north_amt + $pr_north_amt + $sch_north_amt + $md_north_amt + $close_north_amt;
                                                        $total_grand_total = $open_grand_total + $mip_grand_total + $mr_grand_total + $mdis_grand_total + $pr_grand_total + $sch_grand_total + $md_grand_total + $close_grand_total;
                                                      
                                                      


$html = <<<END

                                          <div>
                                              <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable" style="width:100%">
                                                  <thead>
                                                      <th>S.No.</th>
                                                      <th>Current Status</th>
                                                      <th>EAST</th>
                                                      <th>NORTH</th>
                                                      <th>SOUTH</th>
                                                      <th>WEST</th>
                                                      <th>GRAND TOTAL</th>
                                                  </thead>
                                                  <tbody>
                                                      <?php
                                                        
                                                      ?>
                                                      <tr>
                                                          <td>1</td>
                                                          <td>OPEN</td>
                                                          <td> { if $open_east_amt!=0 }  { <a target="_blank" href="mis_call_detail.php?status=open&zone=easts">  $open_east_amt  } else { $open_east_amt; } </a> </td>
                                                          <td><?php if($open_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "open"; ?>&zone=<?php echo "north";?>"><?= $open_north_amt; }else{?><?=$open_north_amt; }?></a></td>
                                                          <td><?php if($open_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "open"; ?>&zone=<?php echo "south";?>"><?= $open_south_amt; }else{?><?=$open_south_amt; }?></a></td>
                                                          <td><?php if($open_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "open"; ?>&zone=<?php echo "west";?>"><?= $open_west_amt; }else{?><?=$open_west_amt; }?></a></td>
                                                          <td><?= $open_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>2</td>
                                                          <td>Material In Process</td>
                                                          <td><?php if($mip_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_in_process"; ?>&zone=<?php echo "east";?>"><?= $mip_east_amt; }else{?><?=$mip_east_amt; }?></a></td>
                                                          <td><?php if($mip_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_in_process"; ?>&zone=<?php echo "north";?>"><?= $mip_north_amt; }else{?><?=$mip_north_amt; }?></a></td>
                                                          <td><?php if($mip_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_in_process"; ?>&zone=<?php echo "south";?>"><?= $mip_south_amt; }else{?><?=$mip_south_amt; }?></a></td>
                                                          <td><?php if($mip_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_in_process"; ?>&zone=<?php echo "west";?>"><?= $mip_west_amt; }else{?><?=$mip_west_amt; }?></a></td>
                                                          <td><?= $mip_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>3</td>
                                                          <td>Material Requirement</td>
                                                          <td><?php if($mr_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_requirement"; ?>&zone=<?php echo "east";?>"><?= $mr_east_amt; }else{?><?=$mr_east_amt; }?></a></td>
                                                          <td><?php if($mr_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_requirement"; ?>&zone=<?php echo "north";?>"><?= $mr_north_amt; }else{?><?=$mr_north_amt; }?></a></td>
                                                          <td><?php if($mr_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_requirement"; ?>&zone=<?php echo "south";?>"><?= $mr_south_amt; }else{?><?=$mr_south_amt; }?></a></td>
                                                          <td><?php if($mr_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_requirement"; ?>&zone=<?php echo "west";?>"><?= $mr_west_amt; }else{?><?=$mr_west_amt; }?></a></td>
                                                          <td><?= $mr_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>4</td>
                                                          <td>Material Dispatch</td>
                                                          <td><?php if($mdis_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_dispatch"; ?>&zone=<?php echo "east";?>"><?= $mdis_east_amt; }else{?><?=$mdis_east_amt; }?></a></td>
                                                          <td><?php if($mdis_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_dispatch"; ?>&zone=<?php echo "north";?>"><?= $mdis_north_amt; }else{?><?=$mdis_north_amt; }?></a></td>
                                                          <td><?php if($mdis_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_dispatch"; ?>&zone=<?php echo "south";?>"><?= $mdis_south_amt; }else{?><?=$mdis_south_amt; }?></a></td>
                                                          <td><?php if($mdis_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_dispatch"; ?>&zone=<?php echo "west";?>"><?= $mdis_west_amt; }else{?><?=$mdis_west_amt; }?></a></td>
                                                          <td><?= $mdis_grand_total?></td>
                                                      </tr>
                                                      
                                                       <tr>
                                                           <td>5</td>
                                                          <td>Permission Require</td>
                                                          <td><?php if($pr_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "permission_require"; ?>&zone=<?php echo "east";?>"><?= $pr_east_amt; }else{?><?=$pr_east_amt; }?></a></td>
                                                          <td><?php if($pr_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "permission_require"; ?>&zone=<?php echo "north";?>"><?= $pr_north_amt; }else{?><?=$pr_north_amt; }?></a></td>
                                                          <td><?php if($pr_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "permission_require"; ?>&zone=<?php echo "south";?>"><?= $pr_south_amt; }else{?><?=$pr_south_amt; }?></a></td>
                                                          <td><?php if($pr_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "permission_require"; ?>&zone=<?php echo "west";?>"><?= $pr_west_amt; }else{?><?=$pr_west_amt; }?></a></td>
                                                          <td><?= $pr_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>6</td>
                                                          <td>Schedule</td>
                                                          <td><?php if($sch_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "schedule"; ?>&zone=<?php echo "east";?>"><?= $sch_east_amt; }else{?><?=$sch_east_amt; }?></a></td>
                                                          <td><?php if($sch_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "schedule"; ?>&zone=<?php echo "north";?>"><?= $sch_north_amt; }else{?><?=$sch_north_amt; }?></a></td>
                                                          <td><?php if($sch_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "schedule"; ?>&zone=<?php echo "south";?>"><?= $sch_south_amt; }else{?><?=$sch_south_amt; }?></a></td>
                                                          <td><?php if($sch_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "schedule"; ?>&zone=<?php echo "west";?>"><?= $sch_west_amt; }else{?><?=$sch_west_amt; }?></a></td>
                                                          <td><?= $sch_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>7</td>
                                                          <td>Material Delivered</td>
                                                          <td><?php if($md_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_delivered"; ?>&zone=<?php echo "east";?>"><?= $md_east_amt; }else{?><?=$md_east_amt; }?></a></td>
                                                          <td><?php if($md_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_delivered"; ?>&zone=<?php echo "north";?>"><?= $md_north_amt; }else{?><?=$md_north_amt; }?></a></td>
                                                          <td><?php if($md_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "material_delivered"; ?>&zone=<?php echo "south";?>"><?= $md_south_amt; }else{?><?=$md_south_amt; }?></a></td>
                                                          <td><?php if($md_west_amt!=0) {?><a href="mis_call_detail.php?status=<?php echo "material_delivered"; ?>&zone=<?php echo "west";?>"><?= $md_west_amt; }else{?><?=$md_west_amt; }?></a></td>
                                                          <td><?= $md_grand_total?></td>
                                                      </tr>
                                                      <tr>
                                                          <td>8</td>
                                                          <td>Close</td>
                                                          <td><?php if($close_east_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "close"; ?>&zone=<?php echo "east";?>"><?= $close_east_amt; }else{?><?=$close_east_amt; }?></a></td>
                                                          <td><?php if($close_north_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "close"; ?>&zone=<?php echo "north";?>"><?= $close_north_amt; }else{?><?=$close_north_amt; }?></a></td>
                                                          <td><?php if($close_south_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "close"; ?>&zone=<?php echo "south";?>"><?= $close_south_amt; }else{?><?=$close_south_amt; }?></a></td>
                                                          <td><?php if($close_west_amt!=0) {?><a target="_blank" href="mis_call_detail.php?status=<?php echo "close"; ?>&zone=<?php echo "west";?>"><?= $close_west_amt; }else{?><?=$close_west_amt; }?></a></td>
                                                          <td><?= $close_grand_total?></td>
                                                      </tr>
                                                       <tr>
                                                          <td>9</td> 
                                                          <td>Grand Total</td>
                                                          <td><?= $total_east?></td>
                                                          <td><?= $total_north?></td>
                                                          <td><?= $total_south?></td>
                                                          <td><?= $total_west?></td>
                                                          <td><?= $total_grand_total?></td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
END;


                                          
                                          
                                          