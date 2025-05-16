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
											<label>ATMID</label>
											<input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>"> </div>
										<div class="col-md-3">
											<label>From Visit Date</label>
											<input type="date" name="fromdt" class="form-control" value="<? if($_POST['fromdt']){ echo  $_POST['fromdt']; }else{ echo '2022-12-12' ; } ?>"> </div>
										
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
					       
					       $sqlapp = "select * from pmc_report_test";
					       
					       if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
                            {
                                $date1 = $_POST['fromdt']; 
                                $date2 = $_POST['todt'];
                               // $sqlapp .=" and CAST(form_start_time AS DATE) >= '".$date1."' and CAST(form_end_time AS DATE) <= '".$date2."' ";
                                $sqlapp .="  where CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' ";
                            }
                           
                            if(isset($_POST['atmid']) && $_POST['atmid']!=''){
					          // $sqlapp .= " and atmid like '%".$_POST['atmid']."%'";
					           $sqlapp .= " and atmid = '".$_POST['atmid']."'";
					        }
					      //echo $sqlapp;die;
					   ?>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
					            <form action="pmcexcel_copy_1.php" method="POST">
                                    <input type="hidden" name="atmid" value="<? echo $_POST['atmid']; ?>">
                                    <input type="hidden" name="date1" value="<? echo $date1; ?>">
                                    <input type="hidden" name="date2" value="<? echo $date2; ?>">
                                 <input type="submit" class="btn btn-secondary" value="Excel" >
                                </form> 
							    <!--<a href="pmcexcl.php"><button class="btn btn-primary" name="excel">Excel</button></a>-->
								<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
									<thead>
										<tr>
											<th>SR</th>
											<th>Image/Video Download</th>
											<th>Images</th>
											<th>Videos</th>
											<th>ATM ID</th>
											<th>customer</th>
                                            <th>bank</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>state</th>
                                            <th>zone</th>
                                            <th>branch</th>
                                            <th>bm name</th>
											<th>Engineer Name</th>
											<th>Completion Date</th>
											<th>Action</th>
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
                                                    $atmid = $sql_result_app['atmid'];
                                                    
                                                    // $mis_newsite_detail = $sql_result_app['mis_newsite_details'];
                                                    // $mis_detail = explode("_",$mis_newsite_detail);
                                                    // $mis_atmid = $mis_detail[0];
                                                    // $mis_customer = $mis_detail[1];
                                                    // $mis_bank = $mis_detail[2];
                                                    // $mis_address = $mis_detail[3];
                                                    // $mis_city = $mis_detail[4];
                                                    // $mis_state = $mis_detail[5];
                                                    // $mis_zone = $mis_detail[6];
                                                    // $mis_branch = $mis_detail[7];
                                                    // $mis_bm = $mis_detail[8];
                                                    // $mis_engid = $mis_detail[9];
                                                    
                                                    $details_sql = mysqli_query($con,"select * from mis_newsite where atmid='".$atmid."'");
                                                    $detail_sql_res = mysqli_fetch_assoc($details_sql);
                                                    $engid = $detail_sql_res['engineer_user_id'];
                                                    
                                                    $user_sql = mysqli_query($con,"select name from mis_loginusers where id = '".$engid."'");
                                                    $name_res = mysqli_fetch_assoc($user_sql);
                                                    
                                                    
                                                    $imagesql = mysqli_query($con,"select * from pmcreport_images_app_test where visitid='".$id."'");
                                                    $_view_img = 1;
                                                    if(mysqli_num_rows($imagesql)==0){
                                                        $_view_img = 0;
                                                    }
                                                    
                                                    $videosql = mysqli_query($con,"select * from pmcreport_videos_app where visitid='".$id."'");
                                                    $_view_vid = 1;
                                                    if(mysqli_num_rows($videosql)==0){
                                                        $_view_vid = 0;
                                                    }
                                                    
                                                    ?>
                                                    	<tr>
                                                    <td><?=$i ?></td>
                                                   
                                            
                                                   
                                                   <td>
                                                       <? if($_view_img==1 || $_view_vid==1) { ?>
                                                        <form action="view_pmcreportApp.php" method="POST">
                                                            <input type="hidden" name="id" value="<? echo $id; ?>">
                                                            <input type="hidden" name="atmid" value="<? echo $atmid; ?>">
                                                            <button type="submit" name="download" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true">  Download</i></button>
                                                        </form>
                                                        <? } else { echo "No Images/Videos" ; ?><? } ?>
                                                    </td>
                                                   
                                                   <td>
                                                       <? if($_view_img==1) { ?>
                                                        <a href="view_pmcreport_app_test.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-warning"><i class="fa fa-image"> Images</i></button></a>
                                                        <? } else { echo "no images" ; ?><? } ?>
                                                    </td>
                                                    
                                                    <td>
                                                       <? if($_view_vid==1) { ?>
                                                        <a href="view_pmcreport_videos.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-success"><i class="fa fa-video-camera"> Videos</i></button></a>
                                                        <? } else { echo "no images" ; ?><? } ?>
                                                    </td>
                                                    
                                                    <td><?=$detail_sql_res['atmid'] ?></td>
                                                    <td><?=$detail_sql_res['customer'] ?></td>
                                                    <td><?=$detail_sql_res['bank'] ?></td>
                                                    <td><?=$detail_sql_res['address'] ?></td>
                                                    <td><?=$detail_sql_res['city'] ?></td>
                                                    <td><?=$detail_sql_res['state'] ?></td>
                                                    <td><?=$detail_sql_res['zone'] ?></td>
                                                    <td><?=$detail_sql_res['branch'] ?></td>
                                                    <td><?=$detail_sql_res['bm_name'] ?></td>
                                                    <td><?=$name_res['name'] ?></td>
                                                    <td><?=$detail_sql_res['created_at'] ?></td>
                                                    <td>
                                                        <a href="pmcreports_details_1.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-warning" ><i class="fa fa-eye"> View More</i></button></a>
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
