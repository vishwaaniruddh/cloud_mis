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
					    	<div class="card" id="filter">
							<div class="card-block">
								<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
									<div class="row">
										
										<div class="col-md-2">
											<label>ATMID</label>
											<input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>"> </div>
										<div class="col-md-3">
											<label>From Visit Date</label>
											<input type="date" name="fromdt" class="form-control" value="<? if($_POST['fromdt']){ echo  $_POST['fromdt']; }else{ echo '2022-09-01' ; } ?>"> </div>
										
											<div class="col-md-3">
											<label>To Visit Date</label>
											<input type="date" name="todt" class="form-control" value="<? if($_POST['todt']){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>"> </div>
											
										
									</div>
									<div class="col" style="display:flex;justify-content:center;">
										<input type="submit" id="submit" name="submit" value="Filter" class="btn btn-primary"> </div>
								</form>
								<!--Filter End -->
								<hr> </div>
						</div>
					    
					   <?php 
					   
					   if($_POST['submit']){
					       
					       $sqlapp = "select * from pmc_report where status = 0  ";
					       
					       if(isset($_POST['atmid']) && $_POST['atmid']!=''){
					           $sqlapp .= " and atmid like '%".$_POST['atmid']."%'";
					       }
					       
					       if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
                            {
                                $date1 = $_POST['fromdt'] ; 
                                $date2 = $_POST['todt'] ;
                                $sqlapp .=" and CAST(form_start_time AS DATE) >= '".$date1."' and CAST(form_end_time AS DATE) <= '".$date2."'";
                            }
					   
					   ?>
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
                                                $count_h = count($data_heading);
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
                                            <!--<th>count</th>-->
											<th>Form Start Time</th>
											<th>Form End Time</th>
											<th>Created by</th>
											
                                        </tr>
									</thead>
									<tbody>
								
										<?php
                                            $i=1;
                                            
                                                
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
                                                    // var_dump($list); echo "<br>";
                                                    $data=json_decode($list,true);
                                                    var_dump($data); echo "<br>";
                                                    echo $count = count($data);
                                                    
                                                    echo "<pre>";print_r($data); echo "</pre>";
                                                    // die;
                                                    for($j = 0; $j<=count($data);$j++){
                                                        // echo $i."  ".$data[$i]->key."    "."<br>";
                                                        
                                                        // var_dump($data[$i]); echo "<br>";
                                                        if($data[$j]->key !='atm_id'  && $data[$j]->key !='eng_id' && $data[$j]->key !='form_start_time' ){
                                                        
                                                          $routerstatus =  str_replace("_", " ", $data[$j]->value);
                                                        
                                                        ?>
                                                        <td><?=$routerstatus ?></td>
                                                        <?php
                                                    }
                                                    
                                                        
                                                    }
                                                    die;
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
						<?php } ?>
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
