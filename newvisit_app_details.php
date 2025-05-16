<? session_start();
include('config.php');

if($_SESSION['username']){

include('header.php');

$id = $_GET['id'];

$sqlapp = "select * from mis_newvisit_app where id = '".$id."'  ";
?>
	<!--<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">-->
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
						
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								
								<a href="pdf/pdfreport.php?id=<? echo $id; ?>" target="_blank"> GET PDF</a>
							    <form>
							        <h5>Details of ID:<b><? echo $id;?></b></h5><br/>
                                    
                                    <table border="1">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Name</th>  
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        
                                    <?
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);

                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $list_head = $sql_result_app['checklist_json'];
                                            $datajson = json_decode($list_head);
                                            if($list_head!=''){
                                                for($i=0;$i<count($datajson);$i++){
                                                    $counter = 1 ; 
                                                    $key = str_replace("_"," ",$datajson[$i]->k);
                                                    $value = str_replace("_"," ",$datajson[$i]->v);
                                                    ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $key ; ?></td>
                                                        <td><? echo $value; ?></td>
                                                    </tr>
                                                    <?
                                                }
                                            }
                                        }
                                    ?>
                                    
                                        </tbody>
                                    </table>
							    </form>
							    
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
			window.location.href = "login.php";

		</script>
		<? }
    ?>

    
			<!--<script src="../datatable/jquery.dataTables.js"></script>-->
			<!--<script src="../datatable/dataTables.bootstrap.js"></script>-->
			<!--<script src="../datatable/dataTables.buttons.min.js"></script>-->
			<script src="../datatable/buttons.flash.min.js"></script>
			<script src="../datatable/jszip.min.js"></script>
			<!--<script src="../datatable/pdfmake.min.js"></script>-->
			<!--<script src="../datatable/vfs_fonts.js"></script>-->
			<!--<script src="../datatable/buttons.html5.min.js"></script>-->
			<!--<script src="../datatable/buttons.print.min.js"></script>-->
			<!--<script src="../datatable/jquery-datatable.js"></script>-->
			
			</body>

			</html>
