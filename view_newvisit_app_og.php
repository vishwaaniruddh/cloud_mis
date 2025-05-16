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
											</select>
										</div>
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
					

    
							<? if($_POST['activity']=="RMS"){
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
											<tbody>
										
												<?php
                                                    $i=1;
                                                    if($_POST['submit']){
                                                        $activity = $_POST['activity'];
                                                        // echo $activity;
                                                        
                                                        $sqlapp = "select * from mis_newvisit_app where activity_type='".$activity."' ";
                                                        
                                                        if(isset($_POST['atmid']) && $_POST['atmid']!='')
                                                        {
                                                            $sqlapp .= " and atmid like '%".$_POST['atmid']."%'";
                                                        }
                                                        
                                                        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
                                                        {
                                                            $date1 = $_POST['fromdt'] ; 
                                                            $date2 = $_POST['todt'] ;
                                                            $sqlapp .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
                                                        }
                                                        
                                                        $sqlapp .=" order by id desc";
                                                        
                                                        
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
                                                            $sql = mysqli_query($con,"select * from misvisit_images_app where misvisitid='".$id."'");
                                                            $_view_img = 1;
                                                            if(mysqli_num_rows($sql)==0){
                                                                $_view_img = 0;
                                                            }
                                                            
                                                            ?>
                                                            	<tr>
                                                            <td><?=$i ?></td>
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
                                                            <td><?=$sql_result_app['activity_type'] ?></td>
                                                            <td><?=$sql_result_app['atmid'] ?></td>
                                                            <?php
                                                            
                                                            $list= $sql_result_app['checklist_json'];
                                                            $data=json_decode($list);
                                                            foreach($data as $newdata){
                                                                 $routerstatus =  str_replace("_", " ", $newdata->v);
                                                                ?>
                                                                <td><?=$routerstatus ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                            <td><?=$sql_result_app['remark'] ?></td>
                                                            <td><?=$sql_result_app['created_at'] ?></td>
                                                            <td><?=$created_name ?></td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                ?>
                                                </tr>
											</tbody>
										</table>
									    </div>
								</div>
								
								<?php
							    
							}
					//	echo	$_POST['activity'];
						
							if($_POST['activity']=='Cloud'){
   
    ?>
<div class="card" >
    <div class="card-block" style="overflow: auto;">
        <table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;">
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
            <tbody>
                 <?php
                    $i=1;
                    if($_POST['submit']){
                        $activity = $_POST['activity'];
                        // echo $activity;
                        $sqlapp = "select * from mis_newvisit_app where activity_type='".$activity."' ";
                        
                        if(isset($_POST['atmid']) && $_POST['atmid']!='')
                        {
                            $sqlapp .= " and atmid like '%".$_POST['atmid']."%'";
                        }
                        
                        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
                        {
                            $date1 = $_POST['fromdt'] ; 
                            $date2 = $_POST['todt'] ;
                            $sqlapp .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
                        }
                         $sqlapp .=" order by id desc";
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
                            
                            $sql = mysqli_query($con,"select * from misvisit_images_app where misvisitid='".$id."'");
                            $_view_img = 1;
                            if(mysqli_num_rows($sql)==0){
                                $_view_img = 0;
                            }
                            ?>
                            <tr>
                                <td><?=$i?></td>
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
                                <td><?=$sql_result_app['activity_type'] ?></td>
                            <td><?=$sql_result_app['atmid'] ?></td>
                            <?php
                            
                            $list= $sql_result_app['checklist_json'];
                            $data=json_decode($list);
                            
                        //   var_dump($data);
                            foreach($data as $newdata){
                                 $routerstatus =  $newdata->v;
                                ?>
                                <td><?=$routerstatus ?></td>
                                <?php
                            }
                            ?>
                            <td><?=$created_name ?></td>
                            <td><?=$sql_result_app['remark'] ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                ?>
               
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
