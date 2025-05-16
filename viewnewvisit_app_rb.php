<?php
session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
// echo $path = $_SERVER['DOCUMENT_ROOT'];

?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
	
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function disable(id){
    // alert(id);
        Swal.fire({
              title: 'Are you sure?',
              text: "Think twice to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Proceed it!'
            }).then((result) => {
              if (result.isConfirmed) {
                
                   jQuery.ajax({
                            type: "POST",
                            url: 'disable_appdetail.php',
                           data: 'id='+id,
                                success:function(msg) { //alert(msg);
                                    
                                    if(msg==1){
                                            Swal.fire(
                                              'Updated!',
                                              'Data Deleted Successfully.',
                                              'success'
                                            );
                                            
                                            setTimeout(function(){ 
                                        window.location.reload();
                                    }, 2000);
                                    
                                    }else if(msg==0 || msg==2){
                                        
                                        Swal.fire(
                                         'Cancelled',
                                          'Your data is safe :)',
                                          'error'
                                            );
                                            
                                            
            
                                    }
                                    
                                }
                   });
            
            
              }
            })

    }
</script>
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
										<div class="col-md-2" >
											<label>Activity</label>
											<select name="activity" id="activity" class="form-control" required>
												<option value=""> Select Activity</option>
												<? $ac_sql = mysqli_query($con,"select distinct(activity) as activity from mis_newsite where status=1");
                                                    while($ac_sql_result = mysqli_fetch_assoc($ac_sql)){ ?>
    													<option value="<? echo $ac_sql_result['activity'];?>" <? if(isset($_POST[ 'activity']) && $_POST[ 'activity']==$ac_sql_result[ 'activity'] ){ echo 'selected'; } ?>>
    														<? echo $ac_sql_result['activity'];?>
    													</option>
    													<? } ?>
    													<!--<option value="All" <? if(isset($_POST[ 'activity']) && $_POST[ 'activity']=="All" ){ echo 'selected'; } ?>>All</option>-->
											</select>
										</div>
										<div class="col-md-2">
											<label>ATMID</label>
											<input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>"> </div>
										<div class="col-md-3">
											<label>From Visit Date</label>
											<input type="date" name="fromdt" class="form-control" value="<? if($_POST['fromdt']){ echo  $_POST['fromdt']; }else{ echo '2023-02-01' ; } ?>"> </div>
										
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
							<? if(isset($_POST['submit'])) {
							$_activity = $_POST['activity'];
							$date1 = $_POST['fromdt'] ; 
                            $date2 = $_POST['todt'] ;
                          //  $sqlapp = "select a.id,a.atmid,a.call_type,a.activity_type,a.remark,a.status,a.location,a.created_at,a.created_by,case when a.status = 0 then 'In-valid' ELSE 'Valid' END as stats ,(SELECT CONCAT(name) from mis_loginusers WHERE id= a.created_by) as eng_name,(select concat(city,'_',state) from mis_newsite where atmid = a.atmid) as mis_visit_details from mis_newvisit_app a where a.activity_type='".$_activity."' and (CAST(a.created_at AS DATE) >= '".$date1."' and CAST(a.created_at AS DATE) <= '".$date2."') ";
                            
                            $sqlapp = "select a.id,a.atmid,a.call_type,a.activity_type,a.remark,a.status,a.location,a.created_at,a.created_by,case when a.status = 0 then 'In-valid' ELSE 'Valid' END as stats ,(SELECT CONCAT(name) from mis_loginusers WHERE id= a.created_by) as eng_name from mis_newvisit_app a where a.activity_type='".$_activity."' and (CAST(a.created_at AS DATE) >= '".$date1."' and CAST(a.created_at AS DATE) <= '".$date2."') ";
                            
                            
                            
                            if(isset($_POST['atmid']) && $_POST['atmid']!='')
                            {
                                $sqlapp .= " and a.atmid like '%".$_POST['atmid']."%'";
                            }
                            
                            // if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
                            // {
                            //     $date1 = $_POST['fromdt'] ; 
                            //     $date2 = $_POST['todt'] ;
                            //     $sqlapp .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
                            // }
                            
                            $sqlapp .=" order by a.id desc";
                            
                            // echo $sqlapp."<br>";
                            // echo mysqli_num_rows($sqlapp);
                            // die; 
							
							?>
								<div class="card" id="example" >
									<div class="card-block" style="overflow: auto;">
									     <form action="newvisitexcl.php" method="POST">
                                            <input type="hidden" name="activity" value="<? echo $_activity; ?>">
                                            <input type="hidden" name="atmid" value="<? echo $_POST['atmid']; ?>">
                                            <input type="hidden" name="date1" value="<? echo $date1; ?>">
                                            <input type="hidden" name="date2" value="<? echo $date2; ?>">
                                         <input type="submit" class="btn btn-secondary" value="Excel" target="_blank">
                                        </form>
										<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
											<thead>
												<tr>
													<th>Sn No.</th>
													<!--<th>Delete</th>-->
													<th>Images</th>
													<th>Status</th>
													<th>Activity</th>
													<th>ATMID</th>
													<th>City</th>
													<th>State</th>
													<!--<th>bm name</th>-->
                                                    <th>call type</th>
                                                    <th>address</th>
                                                    <th>Visit Created Time</th>                                                                                                               												
                                                    <th>Created By</th>
                                                    <th>action</th>
                                                </tr>
											</thead>
											<tbody>
										
												<?php
                                                    $i=1;
                                                    $sql_app = mysqli_query($con,$sqlapp);
                                                    // echo mysqli_num_rows($sql_app);die;
                                                    while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                                    $atmid = $sql_result_app['atmid'];
                                                    
                                                    $id = $sql_result_app['id'];
                                                    $created_by = $sql_result_app['created_by'];
                                                    $remark = $sql_result_app['remark'];
                                                    $remark = str_replace("_", " ", $remark);
                                                    
                                                    $sql = mysqli_query($con,"select * from misvisit_images_app where misvisitid='".$id."'");
                                                    $_view_img = 1;
                                                    if(mysqli_num_rows($sql)==0){
                                                        $_view_img = 0;
                                                    }
                                                    
                                                    $newsite = mysqli_query($con,"select bm_name,city,state from mis_newsite where atmid = '".$atmid."'");
                                                    $newsite_res = mysqli_fetch_assoc($newsite);
                                                    $city = $newsite_res['city'];
                                                    $state = $newsite_res['state'];
                                                    
                                                    // $mis_visit_details = $sql_result_app['mis_visit_details'];
                                                    // if($mis_visit_details==''){
                                                    //     $city = "";
                                                    //     $state = "";    
                                                    // }else{
                                                    //     $mis_details = explode('_',$mis_visit_details);
                                                    //     $city = $mis_details[1];
                                                    //     $state = $mis_details[2];
                                                    // }
                                                    
                                                        
                                                ?>
                                                            
                                                            
                                                            
                                                <tr>
                                                    <td><?=$i ?></td>
                                                    <!--<td><a href="#" class="btn btn-danger" onclick="disable(<? echo $id; ?>)">Delete</a></td>-->
                                                   <td>
                                                       <? if($_view_img==1) { ?>
                                                        <form action="view_newvisitdownloadApp.php" method="POST">
                                                            <input type="hidden" name="id" value="<? echo $id; ?>">
                                                            <input type="submit" name="download" value="Images" class="btn btn-primary">
                                                        </form>
                                                        
                                                        
                                                        <br/>
                                                        <a href="view_newvisitimages_app.php?id=<? echo $id; ?>" target="_blank">View Images</a>
                                                        <? } else { echo "no images" ; ?><? } ?>
                                                    </td>
                                                    <!--<td><?=$validity; ?></td>-->
                                                    <td><?=$sql_result_app['stats']?></td>
                                                    <td><?=$sql_result_app['activity_type'] ?></td>
                                                    <td><?=$sql_result_app['atmid'] ?></td>
                                                    <td><?=$city ?></td>
                                                    <td><?=$state ?></td>
                                                    <!--<td><?=$bm_name ?></td>-->
                                                    <td><?=$sql_result_app['call_type'] ?></td>
                                                    <!--<td><?=$remark ?></td>-->
                                                        <td><?=$sql_result_app['location'] ?></td>
                                                    <td><?=$sql_result_app['created_at'] ?></td>
                                                    <!--<td><?=$created_name ?></td>-->
                                                    <td><?=$sql_result_app['eng_name']; ?></td>
                                                    <td>
                                                        <a href="newvisit_app_details.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-primary"><i class="fa fa-eye">View More</i></button></a>
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
 /*   
$(document).ready(function() {
  $('.address').materialSelect();
}); */
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
