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
                            url: 'userstatuschange.php',
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
    <input type="hidden" value="<?php if(isset($_POST['customer'])){ echo $_POST['customer'];}else{ echo "";}?>" id="post_cust">
    <input type="hidden" value="<?php if(isset($_POST['activity'])){ echo $_POST['activity'];}else{ echo "";}?>" id="post_bank">
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
											<label>Customer</label>
											<select name="customer" id="customer" onchange="getBank(this.value)" class="form-control">
												
											</select>
										</div>
									    
										<div class="col-md-2" >
											<label>Bank</label>
											<select name="activity" id="activity" class="form-control">
												<option value="">Select Bank</option>
											</select>
										</div>
										
									</div>
									<div class="col" style="display:flex;justify-content:center;">
										<input type="submit" id="submit" name="submit" value="Filter" class="btn btn-primary"> </div>
								</form>
								<!--Filter End -->
								<hr> </div>
						</div>
					    
					    <?
					    
					    
					    if($_POST['activity']=="PNB" && $_POST['activity']!='') {
                           ?>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
									<thead>
										<tr>
											<th>Sn No.</th>
                                            <td>Images</td>
                                            <td>Approve/Disapprove</td>
                                            <td>Status</td>
                                            <td>Customer</td>
                                            <td>bank</td>
                                            <?php $key_cnt = 0; 
											$sqllist = mysqli_query($con,"select * from checkquality where bank='PNB' ");
                                            while($sql_result_app_head = mysqli_fetch_assoc($sqllist)){
                                               $list_head= $sql_result_app_head['question_list'];
                                                $data_heading =json_decode($list_head);
                                                // print_r($data_heading);
                                                if($key_cnt==0){
                                                   foreach($data_heading as $newdatahead => $key ){
                                                      if($key->key !='atm_id'  && $key->key !='eng_id' && $key->key !='bank' && $key->key !='customer'){
                                                       echo '<th>'.str_replace("_", " ", $key->key).'</th>';
                                                       
                                                    //   str_replace("_", " ", $key->key);
                                                  } 
                                                   }
                                                }
                                                $key_cnt++;
                                            } ?>
                                            
                                            <td>created at</td>
                                            <td>created by</td>
                                            
                                        </tr>
									</thead>
									<tbody>
								
										<?php
                                            $i=1;
                                            if($_POST['submit']){
                                                $bank = $_POST['activity'];
                                                
                                                $sqlapp = "select * from checkquality where bank='".$bank."' order by id asc";
                                                $sql_app = mysqli_query($con,$sqlapp);
                                                while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                                    $id = $sql_result_app['id'];
                                                    $created_by = $sql_result_app['created_by'];
                                                    $status = $sql_result_app['status'];
                                                        if($status==0)
                                                        {
                                                          $user_status = 'Dis Approved';
                                                          $makeuser_status = 'Make Approve';
                                                          $status_class = 'text-danger';
                                                        }else{
                                                          $user_status = 'Approved';
                                                          $makeuser_status = 'Make DisApprove';
                                                          $status_class = 'text-success';
                                                        }
                                                    
                                                    
                                                    $user_sql = mysqli_query($con,"select name from mis_loginusers where id='".$created_by."'");
                                                    $created_name = "";
                                                    if(mysqli_num_rows($user_sql)>0){
                                                        $user_name_row = mysqli_fetch_row($user_sql);
                                                        $created_name = $user_name_row[0];
                                                    }
                                                    $sql = mysqli_query($con,"select * from checkquality_images_app where visitid='".$id."'");
                                                    $_view_img = 1;
                                                    if(mysqli_num_rows($sql)==0){
                                                        $_view_img = 0;
                                                    }
                                                    
                                                    ?>
                                                    	<tr>
                                                    <td><?=$i ?></td>
                                                   <td>
                                                       <? if($_view_img==1) { ?>
                                                        <form action="view_checkqualityApp.php" method="POST">
                                                            <input type="hidden" name="id" value="<? echo $id; ?>">
                                                            <input type="submit" name="download" value="Download" class="btn btn-primary">
                                                            <!--<input type="submit" name="videos" value="Videos" class="btn btn-primary">-->
                                                        </form>
                                                        <br/>
                                                        <a href="view_checkquality_app.php?id=<? echo $id; ?>" target="_blank">View Images</a>
                                                        <? } else { echo "no images" ; ?><? } ?>
                                                    </td>
                                                    
                                                    <td><a href="#" class="btn btn-danger" onclick="disable(<? echo $id; ?>)"><? echo $makeuser_status;?></a></td>
                                                    <td><? echo $user_status; ?></td>
                                                    
                                                    <td><?=$sql_result_app['customer'];?></td>
                                                    <td><?=$sql_result_app['bank'] ?></td>
                                                    <?php
                                                    
                                                    $list= $sql_result_app['question_list'];
                                                    $data=json_decode($list);
                                                        
                                                    foreach($data as $newdata){
                                                        $keyhead = $newdata->key;
                                                        $valuedata = $newdata->value;
                                                        
                                                        $str = explode("_",$valuedata);
                                                        
                                                        if($keyhead !='atm_id' && $keyhead !='bank' && $keyhead !='eng_id' && $keyhead !='customer' ){
                                                        
                                                            if(count($str)>1) {
                                                                if(count($str)==4)
                                                                {
                                                                    if ($str[4] == 'null') {
                                                                        $value = "No value.";
                                                                    } else {
                                                                        $value = $str[3];
                                                                    }    
                                                                        
                                                                    $valuedata = $str[0] . " : " . $value . "</br>";
                                                                    if ($str[2] == 'null') {
                                                                        $remark_value = "No Remarks.";
                                                                    } else {
                                                                        $remark_value = $str[2];
                                                                    }
                                                                    $valuedata .= $str[1] . " : " . $remark_value;
                                                                }
                                                                else {
                                                                    $valuedata = $str[0] ;
                                                                    if ($str[2] == 'null') {
                                                                        $remark_value = "No Remarks";
                                                                    } else {

                                                                        $remark_value = $str[1];
                                                                    }
                                                                    $valuedata .= " : " . $remark_value;
                                                                }
                                                            }
                                                            else {
                                                                $valuedata;
                                                            }
                                                         $routerstatus =  str_replace("_", " : ", $valuedata);
                                                        
                                                        ?>
                                                        <td><?=$routerstatus ?></td>
                                                        <?php
                                                    } }
                                                    ?>
                                                    
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
						<?php } 
						if($_POST['activity']!="PNB" && $_POST['activity']!=''){
						?>
						<div class="card" id="example">
							<div class="card-block" style="overflow: auto;">
								<table  class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%;" >
									<thead>
										<tr>
											<td>Sn No.</td>
                                            <td>Images</td>
                                            <td>Approve/Disapprove</td>
                                            <td>Status</td>
                                            <td>customer</td>
                                            <td>bank</td>
                                            <?php $key_cnt = 0; 
											$sqllist = mysqli_query($con,"select * from checkquality where bank!='PNB' ");
                                            while($sql_result_app_head = mysqli_fetch_assoc($sqllist)){
                                               $list_head= $sql_result_app_head['question_list'];
                                                $data_heading =json_decode($list_head);
                                                // print_r($data_heading);
                                                if($key_cnt==0){
                                                   foreach($data_heading as $newdatahead => $key ){
                                                      if($key->key !='atm_id'  && $key->key !='eng_id' && $key->key !='bank' && $key->key !='customer'){
                                                       echo '<th>'.str_replace("_", " ", $key->key).'</th>';
                                                       
                                                    //   str_replace("_", " ", $key->key);
                                                  } 
                                                   }
                                                }
                                                $key_cnt++;
                                            } ?>
                                            
                                            <td>created at</td>
                                            <td>created by</td>
                                            
                                        </tr>
									</thead>
									<tbody>
								
										<?php
										
										
                                            $i=1;
                                            if($_POST['submit']){
                                                $bank = $_POST['activity'];
                                                
                                                $sqlapp = "select * from checkquality where bank = '".$bank."' order by id asc";
                                                $sql_app = mysqli_query($con,$sqlapp);
                                                while($sql_result_app = mysqli_fetch_assoc($sql_app)){
                                                    $id = $sql_result_app['id'];
                                                    $created_by = $sql_result_app['created_by'];
                                                    $status = $sql_result_app['status'];
                                                        if($status==0)
                                                        {
                                                          $user_status = 'Dis Approved';
                                                          $makeuser_status = 'Make Approve';
                                                          $status_class = 'text-danger';
                                                        }else{
                                                          $user_status = 'Approved';
                                                          $makeuser_status = 'Make DisApprove';
                                                          $status_class = 'text-success';
                                                        }
                                                    
                                                    
                                                    $user_sql = mysqli_query($con,"select name from mis_loginusers where id='".$created_by."'");
                                                    $created_name = "";
                                                    if(mysqli_num_rows($user_sql)>0){
                                                        $user_name_row = mysqli_fetch_row($user_sql);
                                                        $created_name = $user_name_row[0];
                                                    }
                                                    $sql = mysqli_query($con,"select * from checkquality_images_app where visitid='".$id."'");
                                                    $_view_img = 1;
                                                    if(mysqli_num_rows($sql)==0){
                                                        $_view_img = 0;
                                                    }
                                                    
                                                    ?>
                                                    	<tr>
                                                    <td><?=$i ?></td>
                                                   <td>
                                                       <? if($_view_img==1) { ?>
                                                        <form action="view_checkqualityApp.php" method="POST">
                                                            <input type="hidden" name="id" value="<? echo $id; ?>">
                                                            <input type="submit" name="download" value="Download" class="btn btn-primary">
                                                        </form>
                                                        <br/>
                                                        <a href="view_checkquality_app.php?id=<? echo $id; ?>" target="_blank">View Images</a>
                                                        <? } else { echo "no images" ; ?><? } ?>
                                                    </td>
                                                    
                                                    <td><a href="#" class="btn btn-danger" onclick="disable(<? echo $id; ?>)"><? echo $makeuser_status;?></a></td>
                                                    <td><? echo $user_status; ?></td>
                                                    
                                                    <td><?=$sql_result_app['customer'] ?></td>
                                                    <td><?=$sql_result_app['bank'] ?></td>
                                                    <?php
                                                    
                                                    $list= $sql_result_app['question_list'];
                                                    $data=json_decode($list);
                                                    foreach($data as $newdata){
                                                        $keyhead = $newdata->key;
                                                        $valuedata = $newdata->value;
                                                        
                                                        $str = explode("_",$valuedata);
                                                        
                                                        if($keyhead !='atm_id' && $keyhead !='bank' && $keyhead !='eng_id' && $keyhead !='customer' ){
                                                        
                                                            if(count($str)>1) {
                                                                if(count($str)==4)
                                                                {
                                                                    if ($str[4] == 'null') {
                                                                        $value = "No value.";
                                                                    } else {
                                                                        $value = $str[3];
                                                                    }    
                                                                        
                                                                    $valuedata = $str[0] . " : " . $value . "</br>";
                                                                    if ($str[2] == 'null') {
                                                                        $remark_value = "No Remarks.";
                                                                    } else {
                                                                        $remark_value = $str[2];
                                                                    }
                                                                    $valuedata .= $str[1] . " : " . $remark_value;
                                                                }
                                                                else {
                                                                    $valuedata = $str[0] ;
                                                                    if ($str[2] == 'null') {
                                                                        $remark_value = "No Remarks";
                                                                    } else {

                                                                        $remark_value = $str[1];
                                                                    }
                                                                    $valuedata .= " : " . $remark_value;
                                                                }
                                                            }
                                                            else {
                                                                $valuedata;
                                                            }
                                                         $routerstatus =  str_replace("_", " : ", $valuedata);
                                                        
                                                        ?>
                                                        <td><?=$routerstatus ?></td>
                                                        <?php
                                                    } }
                                                    ?>
                                                    
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
   onload();
    function onload() {
         var selected_cust = $('#post_cust').val();
         $.ajax({    //create an ajax request to display.php
            type: "GET",
            url: "api/all_site_customer.php",             
            dataType: "json",   //expect html to be returned                
            success: function(response){ 
                console.log(response[0]);
                var res = response[0];
                var newhtml = '<option value="">Select Customer</option>';
                if(res.code==200){
                    var customer_list = res.customer_list;
                    for(var i=0;i<customer_list.length;i++){
                        if(customer_list[i].value==selected_cust){
                         newhtml += '<option value="'+customer_list[i].value+'" selected>'+customer_list[i].label+'</option>';   
                        }else{
                        newhtml += '<option value="'+customer_list[i].value+'">'+customer_list[i].label+'</option>';
                        }
                    }
                }
               // var obj = JSON.parse(response);
                //console.log(obj);
                $("#customer").html(newhtml);
                //alert(response);
                if(selected_cust!=''){
                    getBank(selected_cust);
                }
            }
         });
        
    }
    
    function getBank(cust){
        var selected_bank = $('#post_bank').val();
        var customer = cust;
       // alert(customer)
        $.ajax({    //create an ajax request to display.php
        type: "POST",
        url: "api/all_site_bank_by_customer.php",  
        data : {customer:customer},
        dataType: "json",   //expect html to be returned                
        success: function(response){              
            console.log(response[0]);
            var res = response[0];
                var newhtml = '<option value="">Select Bank</option>';
                if(res.code==200){
                    var bank_list = res.bank_list;
                    for(var i=0;i<bank_list.length;i++){
                        if(bank_list[i].value==selected_bank){
                          newhtml += '<option value="'+bank_list[i].value+'" selected>'+bank_list[i].label+'</option>';   
                        }else{
                          newhtml += '<option value="'+bank_list[i].value+'">'+bank_list[i].label+'</option>';
                        }
                    }
                }
              
                $("#activity").html(newhtml);
                // $("#activity").val(newhtml).change();
            // alert(response);
        }
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
