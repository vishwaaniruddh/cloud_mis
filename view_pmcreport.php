<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');


?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
	<style>
		th.address,
		td.address {
			white-space: inherit;
		}

	</style>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
					    
					    
					   
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
									<thead>
										<tr>
											<th>SR</th>
											<th>Images</th>
											<th>ATM ID</th>
											<?php $key_cnt = 0; 
											$sqllist = mysqli_query($con,"select * from pmc_report ");
                                            while($sql_result_app_head = mysqli_fetch_assoc($sqllist)){
                                               $list_head= $sql_result_app_head['question_list'];
                                                $data_heading =json_decode($list_head);
                                                // print_r($data_heading);
                                                if($key_cnt==0){
                                                   foreach($data_heading as $newdatahead => $key ){
                                                      if($key->key !='atm_id'  && $key->key !='eng_id' && $key->key !='form_start_time' ){
                                                       echo '<th>'.str_replace("_", " ", $key->key).'</th>';
                                                       
                                                    //   str_replace("_", " ", $key->key);
                                                  } 
                                                   }
                                                }
                                                $key_cnt++;
                                            } ?>
											<th>Form Start Time</th>
											<th>Form End Time</th>
											<!--<th>Created at</th>-->
											<th>Created by</th>
											<!--<th>Sim Operator</th>-->
											<!--<th>Atm Address</th>-->
											<!--<th>Panel Make</th>-->
											<!--<th>Backroom Sensor</th>-->
											<!--<th>KeyPad Status</th>-->
											<!--<th>Siren Status</th>-->
											<!--<th>Hooter Status</th>-->
											<!--<th>Panic Switch Status</th>-->
											<!--<th>Panic Switch Connected To Hooter</th>-->
											<!--<th>ATM Hood door sensor</th>-->
											<!--<th>atm chestdoor sensor</th>-->
											<!--<th>atm vibraation sensor</th>-->
											<!--<th>atm thermal sensor</th>-->
											<!--<th>atm removal sensor</th>-->
											<!--<th>lobby temperature</th>-->
											<!--<th>lobby pir motion</th>-->
											<!--<th>atm main door shutter</th>-->
											<!--<th>glass break</th>-->
											<!--<th>panel temper switch</th>-->
											<!--<th>ups fails alert</th>-->
											<!--<th>ac mains fails</th>-->
											<!--<th>ups battery removal</th>-->
											<!--<th>smoke detector</th>-->
											<!--<th>cctv 1,2 & 3 removal</th>-->
											<!--<th>1 ac removal sensor</th>-->
											<!--<th>2 ac removal sensor</th>-->
											<!--<th>Speaker & Mic/two-way devices </th>-->
											<!--<th>Panel battery count</th>-->
											<!--<th>panel battery backup</th>-->
											<!--<th>all wire cover by pvc pipe or not</th>-->
											<!--<th>relay box</th>-->
											<!--<th>ac connected to relay</th>-->
											<!--<th>signage,lollipop,lobby light connected to relay timing</th>-->
											<!--<th>dvr name</th>-->
											<!--<th>camera 1</th>-->
											<!--<th>camera 2</th>-->
											<!--<th>camera 3</th>-->
											<!--<th>camera 4</th>-->
											<!--<th>ip camera</th>-->
											<!--<th>all camera allignment as per requirement</th>-->
											<!--<th>hdd capacity</th>-->
											<!--<th>hdd status</th>-->
											<!--<th>start</th>-->
											<!--<th>end</th>-->
											<!--<th>other remark</th>-->
											<!--<th>site tester by</th>-->
											<!--<th>Created by</th>-->
                                            
                                        </tr>
									</thead>
									<tbody>
								
										<?php
                                            $i=1;
                                            
                                                $sqlapp = "select * from pmc_report ";
                                                $sql_app = mysqli_query($con,$sqlapp);
                                                while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                                    $id = $sql_result_app['id'];
                                                    $created_by = $sql_result_app['created_by'];
                                                    $user_sql = mysqli_query($con,"select name from mis_loginusers where id='".$created_by."'");
                                                    $created_name = "";
                                                    if(mysqli_num_rows($user_sql)>0){
                                                        $user_name_row = mysqli_fetch_row($user_sql);
                                                        $created_name = $user_name_row[0];
                                                    }
                                                    $sql = mysqli_query($con,"select * from pmcreport_images_app where visitid='".$id."'");
                                                    $_view_img = 1;
                                                    if(mysqli_num_rows($sql)==0){
                                                        $_view_img = 0;
                                                    }
                                                    
                                                    ?>
                                                    	<tr>
                                                    <td><?=$i ?></td>
                                                   <td>
                                                       <? if($_view_img==1) { ?>
                                                        <form action="view_pmcreportApp.php" method="POST">
                                                            <input type="hidden" name="id" value="<? echo $id; ?>">
                                                            <input type="submit" name="download" value="Download" class="btn btn-primary">
                                                        </form>
                                                        <br/>
                                                        <a href="view_pmcreport_app.php?id=<? echo $id; ?>" target="_blank">View Images</a>
                                                        <? } else { echo "no images" ; ?><? } ?>
                                                    </td>
                                                    
                                                    <td><?=$sql_result_app['atmid'] ?></td>
                                                    <?php
                                                    
                                                    $list= $sql_result_app['question_list'];
                                                    $data=json_decode($list);
                                                    foreach($data as $newdata){
                                                        
                                                        if($newdata->key !='atm_id'  && $newdata->key !='eng_id' && $newdata->key !='form_start_time' ){
                                                        
                                                         $routerstatus =  str_replace("_", " ", $newdata->value);
                                                        
                                                        ?>
                                                        <td><?=$routerstatus ?></td>
                                                        <?php
                                                    } }
                                                    ?>
                                                    <td><?=$sql_result_app['form_start_time'] ?></td>
                                                    <td><?=$sql_result_app['form_end_time'] ?></td>
                                                    <!--<td><?=$sql_result_app['created_at'] ?></td>-->
                                                    <td><?=$created_name ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            
                                        ?>
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
	<? include('footer.php');
    }
else{ ?>
		<script>
			window.location.href = "login.php";

		</script>
		<? }
    ?>
    
    <script>
	   // function change(val)
	   // {
	   //     if(val=="RMS")
	   //     {
	   //         $("#example").show();
	   //         $("#cloud").hide();
	   //     }
	   //     else if(val=="Cloud")
	   //     {
	   //         $("#example").hide();
	   //         $("#cloud").show();
	   //     }
	   //     else{
	   //         $("#example").hide();
	   //         $("#cloud").hide();
	   //     }
	   // }
	</script>
<script>
    
// $(function () 
// {
//     $('#submit').click(function () 
//     {
//         $(this).attr("disabled", true);
//         $(this).val('Submitted');
//         alert("You already Clicked!! wait!!");
//     };

// };
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
			
			</body>

			</html>
