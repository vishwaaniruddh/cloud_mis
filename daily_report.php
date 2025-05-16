<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');


?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
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
											<label>report type</label>
											<!--<input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>"> -->
											<select name="report_type" class="form-control" id="report_type">
                                                <option value=""> Select Report Type</option>
                                                <? $ac_sql = mysqli_query($con, "SELECT distinct(report_type) from daily_report_app order by report_type ASC");
                                                while ($ac_sql_result = mysqli_fetch_assoc($ac_sql)) { 
                                                ?>
                                                
                                                    <option value="<? echo $ac_sql_result['report_type']; ?>" <? if (isset($_POST['report_type']) && $_POST['report_type'] == $ac_sql_result['report_type']) { echo 'selected';} ?>>
                                                        <? echo $ac_sql_result['report_type']; ?>
                                                    </option>
                                                <? } ?>
                                            </select>
										</div>
										
										
										<div class="col-md-3">
    										<label>report Date</label>
    										<input type="date" name="redt" class="form-control" value="<? if($_POST['redt']){ echo  $_POST['redt']; }else{ echo date('Y-m-d') ; } ?>"> 
										</div>
											
										
									</div>
									<div class="col" style="display:flex;justify-content:center;">
										<input type="submit" id="submit" name="submit" value="Filter" class="btn btn-primary"> </div>
								</form>
								<!--Filter End -->
								<hr> </div>
						</div>
					    
					   <?php 
					   
					   if($_POST['submit']){
					       
					       $sqlapp = "select * from daily_report_app";
					       
					       if(isset($_POST['redt']) && $_POST['redt']!='' )
                            {
                                $date = $_POST['redt'];
                                $sqlapp .="  where CAST(created_at AS DATE) >= '".$date."' ";
                            }
                           
                            if(isset($_POST['report_type']) && $_POST['report_type']!=''){
					           $sqlapp .= " and report_type = '".$_POST['report_type']."'";
					        }
					   //   echo $sqlapp;die;
					   ?>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
					            <form action="dailyreportexcl.php" method="POST">
                                    <input type="hidden" name="report_type" value="<? echo $_POST['report_type']; ?>">
                                    <input type="hidden" name="date1" value="<? echo $date; ?>">
                                    
                                 <input type="submit" class="btn btn-secondary" value="Excel" >
                                </form> 
							    <!--<a href="pmcexcl.php"><button class="btn btn-primary" name="excel">Excel</button></a>-->
								<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
									<thead>
										<tr>
											<th>SR</th>
											<th>report type</th>
											<th>report date</th>
											<th>created at</th>
											<th>created by</th>
										<?php if($_POST['report_type']!='Service') { ?>
											<th>Action</th>
										<?php } ?>
                                        </tr>
									</thead>
									<tbody>
								
										<?php
                                            $i=1;
                                            
                                                
                                                $sql_app = mysqli_query($con,$sqlapp);
                                                $num_rows = mysqli_num_rows($sql_app);
                                                // echo $num_rows;
                                                while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                                    $id = $sql_result_app['id'];
                                                    $report_type = $sql_result_app['report_type'];
                                                    $report_dt = $sql_result_app['report_date'];
                                                    $engid = $sql_result_app['created_by'];
                                                    $created_at = $sql_result_app['created_at'];
                                                    
                                                    
                                                    
                                                    $user_sql = mysqli_query($con,"select name from mis_loginusers where id = '".$engid."'");
                                                    $name_res = mysqli_fetch_assoc($user_sql);
                                                    
                                                    
                                                    ?>
                                                    	<tr>
                                                    <td><?=$i ?></td>
                                                    
                                                    <td><?=$report_type ?></td>
                                                    <td><?=$report_dt ?></td>
                                                    <td><?=$created_at ?></td>
                                                    <td><?=$name_res['name'] ?></td>
                                                    
                                                    <td>
                                                        <?php if($report_type!='Service') { ?>
                                                            <a href="daily_report_details.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-warning" ><i class="fa fa-eye"> View More</i></button></a>
                                                        <?php } else { }?>
                                                    </td>
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
			<!--<script src="../datatable/dataTables.buttons.min.js"></script>-->
			<script src="../datatable/buttons.flash.min.js"></script>
			<!--<script src="../datatable/jszip.min.js"></script>-->
			<!--<script src="../datatable/pdfmake.min.js"></script>-->
			<script src="../datatable/vfs_fonts.js"></script>
			<script src="../datatable/buttons.html5.min.js"></script>
			<script src="../datatable/buttons.print.min.js"></script>
			<script src="../datatable/jquery-datatable.js"></script>
			
			</body>

			</html>
