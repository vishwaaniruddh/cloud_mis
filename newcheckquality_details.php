<? session_start();
include('config.php');

if($_SESSION['username']){

include('header.php');

$pid = $_GET['id'];

$sqlapp = "select * from newcheckquality where id = '".$pid."'  ";
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
								
							    <form>
							        <h5><u>List 1</u></h5><br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list'];
                                            $datajson =json_decode($list_head);
                                            // print_r($datajson);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
							    </form>
							    
							</div>
						</div>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								
							    <form>
							        <h5><u>List 2</u></h5><br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list_2'];
                                            $datajson =json_decode($list_head);
                                            // print_r($datajson);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
							    </form>
							    
							</div>
						</div>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								
							    <form>
							        <h5><u>List 3</u></h5><br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list_3'];
                                            $datajson =json_decode($list_head);
                                            // print_r($datajson);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
							    </form>
							    
							</div>
						</div>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								
							    <form>
							        <h5><u>List 4</u></h5><br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list_4'];
                                            $datajson =json_decode($list_head);
                                            // print_r($datajson);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
							    </form>
							    
							</div>
						</div>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								
							    <form>
							        <h5><u>List 5</u></h5><br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list_5'];
                                            $datajson =json_decode($list_head);
                                            // print_r($datajson);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
							    </form>
							    
							</div>
						</div>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								
							    <form>
							        <h5><u>List 6</u></h5> <br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list_6'];
                                            $datajson =json_decode($list_head);
                                            // print_r($datajson);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
							    </form>
							    
							</div>
						</div>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								
							    <form>
							        <h5><u>List 7</u></h5> <br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list_7'];
                                            $datajson =json_decode($list_head);
                                            // print_r($datajson);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
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
