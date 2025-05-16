<?php session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');


?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function disable(id){

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
                            url: 'update_checkqualitystatus.php',
                           data: 'id='+id,
                                success:function(msg) {
                                    
                                    if(msg==1){
                                            Swal.fire(
                                              'Updated!',
                                              'Status has been changed.',
                                              'success'
                                            );
                                            
                                            setTimeout(function(){ 
                                        window.location.reload();
                                    }, 2000);
                                    
                                    }else if(msg==0 || msg==2){
                                        
                                        Swal.fire(
                                         'Cancelled',
                                          'Your imaginary file is safe :)',
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
										<div class="col-md-2">
											<label>ATMID</label>
											<input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>">
										</div>
										<div class="col-md-2">
											<label>Status</label>
											<!--<input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>">-->
											<select name="status" class="form-control" >
											    <option value="">Select</option>
											    <option value="0" <? if(isset($_POST['status'])) { if($_POST['status']=='0'){ echo 'selected' ;  }} ?>>Incomplete</option>
											    <option value="1" <? if(isset($_POST['status'])) { if($_POST['status']=='1'){ echo 'selected' ;  }} ?>>Complete</option>
											    <option value="2" <? if(isset($_POST['status'])) { if($_POST['status']=='2'){ echo 'selected' ;  }} ?>>Approved</option>
											</select>
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
					       
					       $sqlapp = "select * from newcheckquality";
					       
					       $where = '';
					       
					       if(isset($_POST['atmid']) && $_POST['atmid']!=''){
					           $where .= " atmid like '%".$_POST['atmid']."%'";
					       }
					       
					       if(isset($_POST['status']) && $_POST['status']!='')
                            {
                                if($where!=''){
                                    $where .=" and status = '".$_POST['status']."' ";
                                }else{
                                    $where .=" status = '".$_POST['status']."' ";
                                }
                                
                            }
                            if($where !='')
                            {
                                $where =" where".$where;
                                $sqlapp = $sqlapp.$where;
                                // echo $sqlapp;
                            }
					      
					   ?>
					   
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
									<thead>
										<tr>
										    <th>Sno</th>
											<th>ATMID</th>
											<th>Bank</th>
											<th>Customer</th>
											<th>created Time</th>
											<th>Status</th>
											<th>Action</th>
											<th>Images</th>
											<th>Videos</th>
                                            
                                        </tr>
									</thead>
									<tbody>
								
										<?php
                                            $i=1;
                                            
                                                
                                                $sql_app = mysqli_query($con,$sqlapp);
                                                while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                                    $id = $sql_result_app['id'];
                                                    $customer = $sql_result_app['customer'];
                                                    $bank = $sql_result_app['bank'];
                                                    $atmid = $sql_result_app['atmid'];
                                                     $created_at = $sql_result_app['created_at'];
                                                    
                                                    if($sql_result_app['status']==1){
                                                      $user_status = 'Not Approved';
                                                      $makeuser_status = 'Make Approved';
                                                      $status_class = 'text-danger';
                                                      $_status = 1;
                                                    }
                                                    
                                                    $sqlimages = mysqli_query($con,"select * from newcheckquality_images_app where visitid='".$id."'");
                                                    $_view_img = 1;
                                                    if(mysqli_num_rows($sqlimages)==0){
                                                        $_view_img = 0;
                                                    }
                                                    
                                                    $sqlvideos = mysqli_query($con,"select * from newcheckquality_videos_app where visitid='".$id."'");
                                                    $_view_vid = 1;
                                                    if(mysqli_num_rows($sqlvideos)==0){
                                                        $_view_vid = 0;
                                                    }
                                                  
                                                    ?>
                                                    <tr>
                                                    <td><?=$i ?></td>
                                                    <td><?=$atmid ?></td>
                                                    <td><?=$bank ?></td>
                                                    <td><?=$customer ?></td>
                                                    <td><?=$created_at ?></td>
                                                    <td>
                                                        <?php if($sql_result_app['status']==0) {
                                                            echo "Incomplete";
                                                        } else if($sql_result_app['status']==1) {
                                                        ?>
                                                            <a href="#" class="btn btn-warning" onclick="disable(<? echo $id; ?>)"><? echo $makeuser_status;?></a>
                                                        <?} else { echo "Approved ";} ?>
                                                    <td>
                                                        <a href="newcheckquality_details.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-warning" >View More</button></a>
                                                    </td>
                                                    <td>
                                                        <? if($_view_img==1) { ?>
                                                            <form action="view_newcheckqualityimagedownload.php" method="POST">
                                                                
                                                                <input type="hidden" name="id" value="<? echo $id; ?>">
                                                                <input type="hidden" name="atmid" value="<? echo $atmid; ?>">
                                                                <button type="submit" name="download" class="btn btn-warning"><i class="fa fa-download" aria-hidden="true">  Download</i></button>
                                                            </form>
                                                        <br>
                                                            <a href="newcheckquality_images.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-primary"><i class="fa fa-image"> Images</i></button></a>
                                                        <? } else { echo "No Images"; }?>
                                                    </td>
                                                    <td>
                                                        <? if($_view_vid==1) { ?>
                                                            <form action="view_newcheckqualityvideosdownload.php" method="POST">
                                                                
                                                                <input type="hidden" name="id" value="<? echo $id; ?>">
                                                                <input type="hidden" name="atmid" value="<? echo $atmid; ?>">
                                                                <button type="submit" name="download" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true">  Download</i></button>
                                                               
                                                            </form>
                                                        <br>
                                                            
                                                            <a href="newcheckquality_videos.php?id=<? echo $id; ?>" target="_blank"><button type="submit" class="btn btn-success"><i class="fa fa-video-camera"> Videos</i></button></a>
                                                        <?php } else { echo "No Videos"; }   ?>
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
