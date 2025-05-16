<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');



?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
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
											<label>From Call Login Date</label>
											<input type="date" name="fromdt" class="form-control" value="<? if($_POST['fromdt']){ echo  $_POST['fromdt']; }else{ echo '2022-05-25' ; } ?>"> </div>
										
										<div class="col-md-3">
											<label>To Call Login Date</label>
											<input type="date" name="todt" class="form-control" value="<? if($_POST['todt']){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>"> </div>
										
										<div class="col-md-2">
											<label>Attendance Type</label>
											
											<select name = "type" id = "type" class="form-control">
											    
											    <option value="">Select</option>
											    <option value = "1">IN</option>
											    <option value = "0">OUT</option>
											</select>
										</div>
										
										<div class="col-md-2">
											<label>IS VALID</label>
											
											<select name = "is_valid" id = "is_valid" class="form-control">
											    <option value = "">Select</option>
											    <option value = "0">Invalid</option>
											    <option value = "1">Valid</option>
											</select>
										</div>
										
									</div>
									<div class="col" style="display:flex;justify-content:center;">
										<input type="submit" name="submit" value="Filter" class="btn btn-primary"> <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a> </div>
								</form>
								<!--Filter End -->
								<hr> </div>
						</div>
						
						
						<?php 
						
						if(isset($_POST['submit'])){
						    if(isset($_POST['atmid']) && $_POST['atmid']!='' ){
						        $atmid = $_POST['atmid'];
						        $sqlcheck = "select * from eng_attendance_app where atmid like '%".$atmid."%'";
						    }
						    
						    if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
						    {
						        $date1 = $_POST['fromdt'] ; 
                                $date2 = $_POST['todt'] ;
						        $sqlcheck .= " and CAST(att_date AS DATE) >= '".$date1."' and CAST(att_date AS DATE) <= '".$date2."'";
						    }
						    else
						    {
						        
						    }
						   
						   if(isset($_POST['type']) && $_POST['type']!='')
						   {
						       $type = $_POST['type'];
						       $sqlcheck .= "and att_type = '".$type."' ";
						   }
						   
						   if(isset($_POST['is_valid']) && $_POST['is_valid']!='')
						   {
						       $is_valid = $_POST['is_valid'];
						       $sqlcheck .= "and is_valid = '".$is_valid."' ";
						   }
						   
						   
						   
						   
						   if($_POST['is_valid']=='' && $_POST['atmid']=='' &&  $_POST['type']=='' )
						   {
						       $sqlcheck = "select * from eng_attendance_app ";
						   }
						}
						
						?>
						<? if(isset($_POST['submit'])){ ?>
						<div class="card">
							<div class="card-body" style="overflow:auto;">
								<!--<h6><b>Engineer Attendance Table</b></h6>-->
								
								
								<div style="display:flex;justify-content:space-around;">
        <h5 style="text-align:center;">Engineer Attendance Report</h5>

        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
    </div>     
        <hr>
								<?
                                
                                $userid = $_SESSION['userid'];
                                ?>
                                
                                
									<table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
										<thead>
											<tr>
												<th>#</th>
												<th>ATMID</th>
												<th>Engineer Name</th>
												<th>Engineer ID</th>
												<th>Attendance Date</th>
												<th>Attendance Type</th>
												<th>attendance time</th>
												<th>is valid</th>
												<th>location</th>
											</tr>
										</thead>
										<tbody>
											<?php
                                                    $i = 1;
                                                    $app_sql = mysqli_query($con,$sqlcheck);
                                                    while($app_sql_result = mysqli_fetch_assoc($app_sql)){
                                                        $att_type = $app_sql_result['att_type'];
                                                        if($att_type == 0){
                                                            $att_type = "Out";
                                                        }
                                                        else 
                                                        {
                                                            $att_type = "In";
                                                        }
                                                
                                                        $is_valid = $app_sql_result['created_at'];
                                                        if($is_valid == 0){
                                                            $is_valid = "Invalid";
                                                        }
                                                        else{
                                                            $is_valid = "Valid";
                                                        }
                                                        $sql = mysqli_query($con,"select * from mis_loginusers where id='".$app_sql_result['eng_user_id']."'");
                                                        $sql_result = mysqli_fetch_assoc($sql);
                                                        $eng_name = $sql_result['name'];
                                          
                                                ?>
												<tr>
													<td>
														<? echo $i; ?>
													</td>
													<td>
														<? echo $app_sql_result['atmid']; ?>
													</td>
													<td>
														<? echo $eng_name; ?>
													</td>
													<td>
														<? echo $app_sql_result['eng_user_id']; ?>
													</td>
													<td>
														<? echo $app_sql_result['att_date']; ?>
													</td>
													<td>
														<? echo $att_type; ?>
													</td>
													<td>
														<? echo $app_sql_result['created_at']; ?>
													</td>
													<td>
														<? echo $is_valid; ?>
													</td>
													<td>
														<? echo $app_sql_result['location'];?>
													</td>
												</tr>
												<? $i++; 
                                                }?>
										</tbody>
									</table>
							</div>
						</div>
						<? } ?>
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
         $("#show_filter").css('display','none');
    
        $("#hide_filter").on('click',function(){
           $("#filter").css('display','none');
           $("#show_filter").css('display','block');
        });
        $("#show_filter").on('click',function(){
          $("#filter").css('display','block');
           $("#show_filter").css('display','none');
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
			</body>

			</html>
