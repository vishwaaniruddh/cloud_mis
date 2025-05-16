<? session_start();

date_default_timezone_set('Asia/Kolkata');
include('config.php');

if($_SESSION['username']){ 

include('header.php');
 

?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


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
                           
                           
<!--                             <div class="card" id="filter">-->
<!--      <div class="card-block">-->
<!--<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">-->


 
<!--  <div class="col" style="display:flex;justify-content:center;">-->
<!--     <input type="submit" name="submit" value="Filter" class="btn btn-primary">-->
<!-- </div>-->



<!--</form>-->
    
    <!--Filter End -->
<!--    <hr>-->
          
<!--      </div>-->
<!--    </div>-->
    
    
    
   
                           
                                <div class="card">
                                    <div class="card-block" style="overflow: auto;">
                                        
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td>Sn No.</td>
                                                    <td>Engineer Name</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?
                                                $i=1;
                                                
                                                $csql = mysqli_query($con,"SELECT * from mis_loginusers where  designation = 4 order by name ASC");
                                                $csql_rows = mysqli_num_rows($csql); 
                                                if($csql_rows!='') {
                                                while ($csql_result = mysqli_fetch_assoc($csql)) {
                                                $eng_id = $csql_result['id'];
                                                $eng_name = $csql_result['name'];
                                                
                                                ?>



                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    <td><? echo $eng_name; ?></td>
                                                    
                                                    <td><a href="view_engProfile.php?id=<? echo $eng_id;?>"><button type="submit" class="btn btn-warning" name="submit">View</button></a></td>
                                                    
                                                </tr>


    
<? $i++; } } ?>
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



</body>

</html>