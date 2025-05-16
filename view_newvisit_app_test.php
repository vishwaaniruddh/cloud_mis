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
										<div class="col-md-2" >
											<label>Activity</label>
											<select name="activity" id="activity" onchange="change(this.value)" class="form-control">
												<option value=""> Select Activity</option>
												<? $ac_sql = mysqli_query($con,"select distinct(activity) as activity from mis_newsite where status=1");
                                                    while($ac_sql_result = mysqli_fetch_assoc($ac_sql)){ ?>
    													<option value="<? echo $ac_sql_result['activity'];?>" <? if(isset($_POST[ 'activity']) && $_POST[ 'activity']==$ac_sql_result[ 'activity'] ){ echo 'selected'; } ?>>
    														<? echo $ac_sql_result['activity'];?>
    													</option>
    													<? } ?>
    													<option value="All" <? if(isset($_POST[ 'activity']) && $_POST[ 'activity']=="All" ){ echo 'selected'; } ?>>All</option>
											</select>
										</div>
										<div class="col-md-2">
											<label>ATMID</label>
											<input type="text" name="atmid" id = "atmid" class="form-control" value="<? echo $_POST['atmid']; ?>"> </div>
										<div class="col-md-3">
											<label>From Visit Date</label>
											<input type="date" name="fromdt" id="fromdt" class="form-control" value="<? if($_POST['fromdt']){ echo  $_POST['fromdt']; }else{ echo '2022-09-01' ; } ?>"> </div>
										<div class="col-md-3">
											<label>To Visit Date</label>
											<input type="date" name="todt" id="todt" class="form-control" value="<? if($_POST['todt']){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>"> </div>
									</div>
									<div class="col" style="display:flex;justify-content:center;">
										<input type="submit" id="submit" name="submit" value="Filter" class="btn btn-primary"> </div>
								</form>
								<!--Filter End -->
								<hr> </div>
						</div>
					

    
							<? if($_POST['activity']=="RMS" || $_POST['activity']=="All"){
							    $_activity = "RMS";
                           ?>
								<div class="card" id="example" >
									<div class="card-block" style="overflow: auto;">
										<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
											<thead>
													<tr>
													<td>Sn No.</td>
													<td>Images</td>
													<td>Activity</td>
													<td>ATMID</td>
													<td>router status</td>
                                                    <td>dvr status</td>
                                                    <td>cam1</td>
                                                    <td>cam2</td>
                                                    <td>cam3</td>
                                                    <td>cam4</td>
                                                    <td>ip camera</td>
                                                    <td>hdd status</td>
                                                    <td>recording from</td>
                                                    <td>recording to</td>
                                                    <td>panel status</td>
                                                    <td>backroom lock status</td>
                                                    <td>panic</td>
                                                    <td>two way</td>
                                                    <td>hooter</td>
                                                    <td>machine sensor</td>
                                                    <td>shutter</td>
                                                    <td>glass breack sensor</td>
                                                    <td>pir</td>
                                                    <td>ac main connected</td>
                                                    <td>relay status</td>
                                                    <td>relay connection to light Ac</td>
                                                    <td>counter panel battery</td>
                                                    <td>panel battery status</td>
                                                    <td>remark</td>
                                                    <td>Visit Created Time</td>                                                                                                               												
                                                    <td>Created By</td>
                                                    </tr>
											</thead>
											
										</table>
									    </div>
								</div>
								
								<?php
							    
							}
					//	echo	$_POST['activity'];
						
							if($_POST['activity']=='Cloud' || $_POST['activity']=="All"){
                                $_activity = "Cloud";
    ?>
<div class="card" >
    <div class="card-block" style="overflow: auto;">
        <table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" id="cloud" style="width:100%;">
            <thead>
                <tr>
                    <td>Sn No.</td>
                <td>Images</td>
                <td>Activity</td>
                <td>ATM ID</td>
                <td>router status</td>
                <td>router id</td>
                <td>dvr status</td>
                <td>cam1</td>
                <td>cam2</td>
                <td>ip camera</td>
                <td>hdd status</td>
                <td>recording from</td>
                <td>recording to</td>
                <td>site tested by</td>
                <th>created by</th>
                <td>remark</td>
            </tr>
            </thead>
           
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
    
    if ( $('#filter').length > 0 ) {
        $('#filter').on('submit', function(e) { 
            e.preventDefault();
            var activity = $('#activity').val();
            var atmid = $('#atmid').val();
            var fromdt = $('#fromdt').val();
            var todt = $('#todt').val();
            
            alert(fromdt);
            alert(todt);
            var form = $(this);
            
            
            $('#cloud').dataTable({
             "Processing": true,
             "serverSide": true,
             "ajax":{
                    url :"post_list.php&activity="+activity+"&atmid="+atmid+"&fromdt="+fromdt+"&todt="+todt,
                    type: "POST",
                    error: function(){
                      $("#post_list_processing").css("display","none");
                    }
              	}
            });

        });
    }
        
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
