<? session_start();
include('config.php');

if($_SESSION['username']){

include('header.php');

$pid = $_GET['id'];

$sqlapp = "select * from newcheckquality where id = '".$pid."'  ";
?>
	<!--<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!--<script>-->
<!--    function disapprove(id){-->

<!--        Swal.fire({-->
<!--              title: 'Are you sure?',-->
<!--              text: "Think twice to revert this!",-->
<!--              icon: 'warning',-->
<!--              showCancelButton: true,-->
<!--              confirmButtonColor: '#3085d6',-->
<!--              cancelButtonColor: '#d33',-->
<!--              confirmButtonText: 'Yes, Proceed it!'-->
<!--            }).then((result) => {-->
<!--              if (result.isConfirmed) {-->
                
<!--                   jQuery.ajax({-->
<!--                            type: "POST",-->
<!--                            url: 'checkqualityremark.php',-->
<!--                           data: 'id='+id,-->
<!--                                success:function(msg) {-->
                                    
<!--                                    if(msg==1){-->
<!--                                            Swal.fire(-->
<!--                                              'Updated!',-->
<!--                                              'Status has been changed.',-->
<!--                                              'success'-->
<!--                                            );-->
                                            
<!--                                            setTimeout(function(){ -->
<!--                                        window.location.reload();-->
<!--                                    }, 2000);-->
                                    
<!--                                    }else if(msg==0 || msg==2){-->
                                        
<!--                                        Swal.fire(-->
<!--                                         'Cancelled',-->
<!--                                          'Your imaginary file is safe :)',-->
<!--                                          'error'-->
<!--                                            );-->
<!--                                    }-->
<!--                                }-->
<!--                   });-->
<!--              }-->
<!--            })-->
<!--    }-->
<!--</script>-->
<script>
    function manage(txt) {
        var bt = document.getElementById('submit');
        var ele = document.getElementsByTagName('input'); 

        // Loop through each element.
        for (i = 0; i < ele.length; i++) {

            // Check the element type.
            if (ele[i].type == 'text' && ele[i].value != '') {
                bt.disabled = false;    // Disable the button.
               
            }
          
        }
    }
</script>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<form action="checkqualityremark.php" method="post" enctype="multipart/form-data" >
						    
						<div class="card" id="example1">
							<div class="card-block" style="overflow: auto;">
								
							    <!--<form>-->
							    
							        <h5><u>List 1</u></h5><br/>
                                    <?php
                                    $key_cnt = 0;
                                        
                                        $sql_app = mysqli_query($con,$sqlapp);
                                        // print_r($sql_app);
                                        while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                            $visit_id = $sql_result_app['visit_id'];
                                            // echo $visit_id;
                                            $list_head = $sql_result_app['question_list'];
                                            $status = $sql_result_app['status'];
                                            $datajson =json_decode($list_head);
                                            if($list_head!=''){
                                                foreach($datajson as $data){
                                                   echo "<b>"."$data->key"."</b>".' : '."$data->value"."<br/>";
                                                }
                                            }
                                        }
                                    ?>
                                    <br>
                                    <?php if($status!=3) {?>
                                    <div class="row">
                                        <div class="col-md-12">
                                             <input type="hidden" name="cid" id="cid" value="<?php echo $pid;?>" />
                                            <label for="remark1"><b> Disapprove Remark</b></label>
                                            <textarea class="form-control" name="remark1"  id="remark1" placeholder = "IF EMPTY USE - or null" onkeyup="manage(this)"></textarea>
                                        </div>
                                    </div>
                                    <?php } ?>
							    <!--</form>-->
							    
							</div>
						</div>
						<div class="card" id="example2">
							<div class="card-block" style="overflow: auto;">
								
							    <!--<form>-->
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
                                    <br>
                                    <?php if($status!=3) {?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="remark2"><b> Disapprove Remark</b></label>
                                            <!--<input type="text" class="form-control" name="remark2" id="remark2" >        -->
                                            <textarea class="form-control" name="remark2"  id="remark2" placeholder = "IF EMPTY USE - or null" onkeyup="manage(this)" ></textarea>
                                        </div>
                                    </div>
							    <?php } ?>
							    
							</div>
						</div>
						<div class="card" id="example3">
							<div class="card-block" style="overflow: auto;">
								
							    <!--<form>-->
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
                                    <br>
                                    <?php if($status!=3) {?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="remark3"><b> Disapprove Remark</b></label>
                                            <!--<input type="text" class="form-control" name="remark3" id="remark3" >   -->
                                            <textarea class="form-control" name="remark3"  id="remark3" placeholder = "IF EMPTY USE - or null" onkeyup="manage(this)" ></textarea>
                                        </div>
                                    </div>
							    <?php } ?>
							    
							</div>
						</div>
						<div class="card" id="example4">
							<div class="card-block" style="overflow: auto;">
								
							    <!--<form>-->
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
                                    <br>
                                    <?php if($status!=3) {?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="remark4"><b> Disapprove Remark</b></label>
                                            <!--<input type="text" class="form-control" name="remark4" id="remark4" >        -->
                                            <textarea class="form-control" name="remark4"  id="remark4" placeholder = "IF EMPTY USE - or null" onkeyup="manage(this)" ></textarea>
                                        </div>
                                    </div>
							    <?php } ?>
							    
							</div>
						</div>
						<div class="card" id="example5">
							<div class="card-block" style="overflow: auto;">
								
							    <!--<form>-->
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
                                    <br>
                                    <?php if($status!=3) {?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="remark5"><b> Disapprove Remark</b></label>
                                            <!--<input type="text" class="form-control" name="remark5" id="remark5" >    -->
                                            <textarea class="form-control" name="remark5"  id="remark5" placeholder = "IF EMPTY USE - or null" onkeyup="manage(this)" ></textarea>
                                        </div>
                                    </div>
							    <?php } ?>
							    
							</div>
						</div>
						<div class="card" id="example6">
							<div class="card-block" style="overflow: auto;">
								
							    <!--<form>-->
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
                                    <br>
                                    <?php if($status!=3) {?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="remark6"><b> Disapprove Remark</b></label>
                                            <!--<input type="text" class="form-control" name="remark6" id="remark6">  -->
                                            <textarea class="form-control" name="remark6" id="remark6" placeholder = "IF EMPTY USE - or null" onkeyup="manage(this)" ></textarea>
                                        </div>
                                    </div>
							    <?php } ?>
							    
							</div>
						</div>
						<div class="card" id="example7">
							<div class="card-block" style="overflow: auto;">
								
							    <!--<form>-->
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
                                    <br>
                                    <?php if($status!=3) {?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="remark7"><b> Disapprove Remark</b></label>
                                            <!--<input type="text" class="form-control" name="remark7"  id="remark7">   -->
                                            <textarea class="form-control" name="remark7"  id="remark7" placeholder = "IF EMPTY USE - or null" onkeyup="manage(this)" ></textarea>
                                        </div>
                                    </div>
							    <?php } ?>
							    
							</div>
						</div>
						   
						    <input type="submit" id="submit" name="submit" class="btn btn-warning" value="Submit Review"  >
					    </form>
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
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
 <script type="text/javascript">
    $(function () {
        $("#remark").keyup(function () {
            var btnSubmit = $("#submit");
            if ($(this).val().trim() != "") {
                btnSubmit.removeAttr("disabled");
                // alert(1);
            } else {
                btnSubmit.attr("disabled", "disabled");
            }
        });
    });
</script> 

			<!--<script src="../datatable/jquery.dataTables.js"></script>-->
			<!--<script src="../datatable/dataTables.bootstrap.js"></script>-->
			<!--<script src="../datatable/dataTables.buttons.min.js"></script>-->
			<!--<script src="../datatable/buttons.flash.min.js"></script>-->
			<!--<script src="../datatable/jszip.min.js"></script>-->
			<!--<script src="../datatable/pdfmake.min.js"></script>-->
			<!--<script src="../datatable/vfs_fonts.js"></script>-->
			<!--<script src="../datatable/buttons.html5.min.js"></script>-->
			<!--<script src="../datatable/buttons.print.min.js"></script>-->
			<!--<script src="../datatable/jquery-datatable.js"></script>-->
			
			</body>

			</html>
