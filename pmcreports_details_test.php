<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

$pid = $_GET['id'];


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
											<th>ATM ID</th>
											<?php 
											$key_cnt = 0; 
											$sqllist = mysqli_query($con,"select * from pmc_report where id = '".$pid."'");
                                            while($sql_result_app_head = mysqli_fetch_assoc($sqllist)){
                                               $list_head= $sql_result_app_head['question_list'];
                                                $data_heading =json_decode($list_head);
                                                $count_h = count($data_heading);
                                                // print_r($data_heading);
                                                if($key_cnt==0){
                                                   foreach($data_heading as $newdatahead => $key ){
                                                      if($key->key !='atm_id'  && $key->key !='eng_id' && $key->key !='form_start_time'  && $key->key !='mac_id' && $key->key !='longitude' && $key->key !='latitude' && $key->key !='location'){
                                                       echo '<th>'.str_replace("_", " ", $key->key).'</th>';
                                                       
                                                    //   str_replace("_", " ", $key->key);
                                                  } 
                                                   }
                                                }
                                                $key_cnt++;
                                            } ?>
                                            
                                            <th>Location</th>
                                            <th>mac id</th>
                                            <th>longitude</th>
                                            <th>latitude</th>
											<th>Form Start Time</th>
											<th>Form End Time</th>
											<th>Created by</th>
											
                                        </tr>
									</thead>
									<tbody>
								
										<?php
                                            $i=1;
                                            
                                                $sqlapp = "select * from pmc_report where id = '".$pid."'  ";
                                                $sql_app = mysqli_query($con,$sqlapp);
                                                while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                                    $id = $sql_result_app['id'];
                                                    // $id = 124;
                                                    $created_by = $sql_result_app['created_by'];
                                                    $user_sql = mysqli_query($con,"select name from mis_loginusers where id='".$created_by."'");
                                                    $created_name = "";
                                                    if(mysqli_num_rows($user_sql)>0){
                                                        $user_name_row = mysqli_fetch_row($user_sql);
                                                        $created_name = $user_name_row[0];
                                                    }
                                                    
                                                    
                                                    ?>
                                                    	<tr>
                                                    <td><?=$i ?></td>
                                                    <td><?=$sql_result_app['atmid'] ?></td>
                                                    <?php
                                                    
                                                    $list= $sql_result_app['question_list'];
                                                    $data=json_decode($list);
                                                    
                                                    // echo "<pre>";print_r($data);echo "</pre>";
                                                    for($j = 0; $j<count($data);$j++){
                                                        if($data[$j]->key !='atm_id'  && $data[$j]->key !='eng_id' && $data[$j]->key !='form_start_time' ){
                                                        
                                                          $routerstatus =  str_replace("_", " ", $data[$j]->value);
                                                        
                                                        ?>
                                                        <td><?=$routerstatus ?></td>
                                                        <?php
                                                    }
                                                    
                                                        
                                                    }
                                                    
                                                    ?>
                                                    <td><?=$sql_result_app['form_start_time'] ?></td>
                                                    <td><?=$sql_result_app['form_end_time'] ?></td>
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
			<!--<script src="../datatable/dataTables.buttons.min.js"></script>-->
			<script src="../datatable/buttons.flash.min.js"></script>
			<script src="../datatable/jszip.min.js"></script>
			<!--<script src="../datatable/pdfmake.min.js"></script>-->
			<!--<script src="../datatable/vfs_fonts.js"></script>-->
			<script src="../datatable/buttons.html5.min.js"></script>
			<script src="../datatable/buttons.print.min.js"></script>
			<script src="../datatable/jquery-datatable.js"></script>
			
			</body>

			</html>
