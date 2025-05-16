<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');

if($_SESSION['username']){ 

include('header.php');
 

?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

	 <style>
    .select2-container .select2-selection--single{height: auto !important;}
 </style>

<style>
    
   th.address, td.address {
    white-space: inherit;
}
</style>

<script>
    function lastcommunicationdiff($datetime2){
	    date_default_timezone_set('Asia/Kolkata');
		$datetime1 = new DateTime();
	    $datetime2 = new DateTime($datetime2);
		$interval = $datetime1->diff($datetime2);
		
		$elapsedyear = $interval->format('%y');
		$elapsedmon = $interval->format('%m');
		$elapsed_day = $interval->format('%a');
		$elapsedhr = $interval->format('%h');
		$elapsedmin = $interval->format('%i');
		$not = 0;
		if($elapsedyear>0){$not=$not+1;}
		if($elapsedmon>0){$not=$not+1;}
		if($elapsed_day>0){$not=$not+1;}
		//if($elapsedhr>0){$not=$not+1;}
		$min = $elapsedmin;
		$hour = $elapsedhr;
		if($not>0){
			$return = "Offline";
		}else{
			if($hour <=1){
				$return = "Online";
			}else{
				$return = "Offline";
			}
		}
				
		return $return;	   
  }
    
    
</script>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                           
                              <div class="card" id="filter">
    							<div class="card-block">
    								<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
    									<div class="row">
    										<!--<div class="col-md-2">-->
    										<!--	<label>ATMID</label>-->
    										<!--	<input type="text" name="atmid" class="form-control" value="<? echo $_POST['atmid']; ?>"> -->
    										<!--</div>-->
    										
    										
    										<div class="col-md-3">
    											<label>Date</label>
    											<input type="date" name="todt" class="form-control" value="<? if($_POST['todt']){ echo  $_POST['todt']; }else{ echo date('Y-m-d') ; } ?>"> </div>
    										
    										<div class="col-md-3">
    											<label>Engineer</label>
    											<select name = "engineer" id = "engineer" class="form-control js-example-basic-single w-100" >
    											    <option value = "" >Select</option>
    											    <?php $engineer= mysqli_query($con,"SELECT * from mis_loginusers where designation=4 order by name ASC"); 
    											        //$engineer = mysqli_query($con,"select * from mis_loginusers");
    											        while($fetch_data = mysqli_fetch_assoc($engineer)){
    											     ?>
    											     <option value="<? echo $fetch_data['id'] ?>" <? if($_POST['engineer']==$fetch_data['id']){ echo 'selected'; }  ?>>
    											         <?php echo ucwords($fetch_data['name']);?>
    											         
    											     </option>
    											     <? } ?>
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
						    
						  //  if(isset($_POST['atmid']) && $_POST['atmid']!='' ){
						  //      $atmid = $_POST['atmid'];
						        
						  //  }
						    
						    if(isset($_POST['todt']) && $_POST['todt']!='')
						    {
						        $date2 = $_POST['todt'];
                            }
						  
						   
						   if(isset($_POST['engineer']) && $_POST['engineer'])
						   {
						       $engineerid = $_POST['engineer'];
						       
						   }
						   
						  
						   
						   
						  // var_dump($sqlcheck); 
						   /*
						   
						   if($_POST['isvalid']=='' && $_POST['atmid']=='' &&  $_POST['type']=='' )
						   {
						       $sqlcheck = "select * from eng_attendance_app ";
						   } */
						}
						
						?>
                             
                           <? if(isset($_POST['submit'])){ ?>
                                <div class="card">
                                    <div class="card-block" style="overflow: auto;">
                                        
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td>Sn No.</td>
                                                    <td>Engineer Name</td>
                                                    <td>ATMID List</td>
                                                    <td>PMC Report Submitted</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?
                                                $i=1;
                                                
                                                if($engineerid==''){
                                                   $csql = mysqli_query($con,"SELECT * from mis_loginusers where designation = 4 order by name ASC");
                                                }else{
                                                   $csql = mysqli_query($con,"SELECT * from mis_loginusers where id='".$engineerid."' AND designation = 4 order by name ASC"); 
                                                }
                                                $csql_rows = mysqli_num_rows($csql); 
                                                if($csql_rows!='') {
                                                while ($csql_result = mysqli_fetch_assoc($csql)) {
                                                $eng_id = $csql_result['id'];
                                                $eng_name = $csql_result['name'];
                                                
                                                if($engineerid!='' && $date2!=''){
                                                $_pmc_sql = mysqli_query($con,"SELECT GROUP_CONCAT(p.atmid SEPARATOR ', ') AS site_atmid,COUNT(p.atmid) AS pmc_count,p.created_by FROM `pmc_report_test` p WHERE created_by='".$engineerid."' AND CAST(p.created_at AS DATE)='".$date2."' GROUP BY p.created_by");
                                                }else{
                                                
                                                    if($date2!=''){
                                                    $_pmc_sql = mysqli_query($con,"SELECT GROUP_CONCAT(p.atmid SEPARATOR ', ') AS site_atmid,COUNT(p.atmid) AS pmc_count,p.created_by FROM `pmc_report_test` p WHERE created_by='".$eng_id."' AND CAST(p.created_at AS DATE)='".$date2."' GROUP BY p.created_by");
                                                    }
                                                }
                                                
                                               
                                                $pmcsql_result = mysqli_fetch_assoc($_pmc_sql);
                                                $atm_list = $pmcsql_result['site_atmid'];
                                                $pmc_count = $pmcsql_result['pmc_count'];
                                                ?>



                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $eng_name; ?></td>
                                                    <td><? echo $atm_list; ?></td>
                                                    <td><? echo $pmc_count; ?></td>
                                                    <!--<td><a href="view_engProfile.php?id=<? echo $eng_id;?>"><button type="submit" class="btn btn-warning" name="submit">View</button></a></td>-->
                                                    
                                                </tr>


    
<? $i++; } } ?>
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
        window.location.href="login.php";
    </script>
<? }
    ?>
    
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

<script>
			     $(document).ready(function() {
                    $('.js-example-basic-single').select2();
                });
                
			</script>



</body>

</html>