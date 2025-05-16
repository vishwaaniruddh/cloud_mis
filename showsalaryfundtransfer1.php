<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    
    include('config.php');
    
   /* if(isset($_POST['reqs'])){
        $app = json_decode($_POST['reqs']);
        $trans_id = $_POST['trans_id'];
        $batch_no = "";
        $action_by = $_SESSION['userid'];
        $chexcelsql="select filename from mis_fund_transfer_excel_test where trans_id=".$trans_id;
        $filerow = 0;
        if($chexceltable=mysqli_query($con,$chexcelsql)){
            $filerow =  mysqli_num_rows($chexceltable);
        }
        if($filerow>0){
            $batchrow = mysqli_fetch_row($chexceltable);
            $batch_no = $batchrow[0]; 
        }else{
            $excelsql="select id from mis_fund_transfer_excel_test order by id desc";
            $exceltable=mysqli_query($con,$excelsql); 
            if(mysqli_num_rows($exceltable)>0){
              $excelrowdata=mysqli_fetch_row($exceltable);
              $n = $excelrowdata[0];
            }else{
              $n = 1;
            }
            
            $joindate = date('dmY');
            $filename = "C".$n.$joindate;  
            
            $insertexcelsql = "insert into mis_fund_transfer_excel_test(filename,trans_id) 
                    values('".$filename."','".$trans_id."')";
            mysqli_query($con,$insertexcelsql);
            
           
            $batch_no = $filename;
        }
        
        
        for($x=0;$x<count($app);$x++){ 
            $req_id = $app[$x];
            $currentstatus_sql="select current_status from mis_fund_transfer_test WHERE req_id = ".$req_id;
            $currentstatustable=mysqli_query($con,$currentstatus_sql); 
            $currentstatusrow = mysqli_fetch_row($currentstatustable);
            $_currentstatus = $currentstatusrow[0];
            if($_currentstatus==1){
              $updatesql = "update mis_fund_transfer_test SET current_status = 2, batch_no= '".$batch_no."',action_by= '".$action_by."' WHERE req_id = ".$req_id; 
            }
            if($_currentstatus==2){
              $updatesql = "update mis_fund_transfer_test SET current_status = 3,action_by= '".$action_by."' WHERE req_id = ".$req_id;   
            }
            if($_currentstatus==3){
              $updatesql = "update mis_fund_transfer_test SET current_status = 4,action_by= '".$action_by."' WHERE req_id = ".$req_id;   
            }
            mysqli_query($con,$updatesql); 
        }
        
        
    } */
    
    
    $postview = 0;
    $selectedstatus = 3;
    $sql="select sum(amount),trans_id,batch_no,id from mis_salary_fund_transfer where status=3 and current_status in (1,2,3) group by trans_id order by trans_id ASC";
if(isset($_POST['SelectStatus'])){
    if($_POST['SelectStatus']=='Search'){
        $status = $_POST['current_status'];
        if($status=='4'){
            $sql="select sum(amount),trans_id,batch_no,id from mis_salary_fund_transfer where status=3 and current_status=4 group by trans_id order by trans_id ASC";
            $selectedstatus = 4;
        }
        if($status=='3'){
            $sql="select sum(amount),trans_id,batch_no,id from mis_salary_fund_transfer where status=3 and current_status in (1,2,3) group by trans_id order by trans_id ASC";
            $selectedstatus = 3;
        }
        if($status=='2'){
            $sql="select sum(amount),trans_id,batch_no,id from mis_salary_fund_transfer where status=3 and current_status>0 group by trans_id order by trans_id ASC";
             $selectedstatus = 2;
        }
        
        
        $postview = 1;
    }
    
}

    
?>
<style>
  .green{color:green;}
  .red{color:red;}
</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<link href="datepicker/date_css.css" rel="stylesheet" type="text/css" />
<script src="datepicker/datepick_js.js" type="text/javascript"></script>
<div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <div class="col-sm-4">
                        						    <label class="label_label">Select Search Details</label>
                            						<select name="current_status" class="form-control" required>
                        						        <option value="3" <?php if($selectedstatus=='3'){ echo 'selected';}?>>Edit Details</option>
                        						        <option value="4" <?php if($selectedstatus=='4'){ echo 'selected';}?>>Show Details</option>
                        						        <option value="2" <?php if($selectedstatus=='2'){ echo 'selected';}?>>Both Edit & Show Details</option>
                                                    </select>    
                                             <br>
                        					</div>
                        					<div class="col-sm-4">
                                                <br>
                                                <input type="submit" name="SelectStatus" value="Search" class="btn btn-success">
                                            </div>
                                        </form>
                                    </div>    
                                    <div class="card-block" style=" overflow: auto;">
                                         <table id="showfundtransfer" class="table table-bordered table-striped table-hover dataTable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Id</th>
                                                    <th>Transferred Date</th>
                                                    <th>Transfer Amount</th>
                                                    <th>Rejected Amount</th>
                                                    <th>Total Amount</th>
                                                    <th>View</th>
                                                    <th>Edit</th>
                                                   <!-- <th>View Bank</th>-->
                                                    <th>Export</th>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                    $totalapproved_amt = 0;
                                                    $totalrejected_amt = 0;
                                                    $total_amt = 0;
                                                    $accountno_array = array();
                                                    $_customer_total_amt = 0;
                                                	
                                            	    $view = 0; 
                                                    $table=mysqli_query($con,$sql);   
                                                    if(!empty($table)){
                                                    while($row=mysqli_fetch_array($table)){
                                                      /*  if(!in_array($row[8],$accountno_array)){
                                                           $accs=mysqli_query($con,"select * from mis_fund_transfer where account_number=".$row[8]); 
                                                           while($accr=mysqli_fetch_array($accs)){
                                                               
                                                               $_customer_total_amt = $_customer_total_amt + $accr[4];
                                                              
                                                           }
                                                           array_push($accountno_array,$row[8]);
                                                           $view = 1;
                                                        } */
                                                       // echo '<pre>';print_r($row);echo '</pre>';die;
                                                         $id = $row[3];
                                                         $req=mysqli_query($con,"select transferred_date,current_status from mis_salary_fund_transfer where batch_no='".$row[2]."' and trans_id='".$row[1]."'");
				                                        // $reqro=mysqli_fetch_array($req);
				                                         
				                                         while($reqro=mysqli_fetch_array($req)){
				                                             
				                                             if($reqro[1]>'0'){ 
				                                                $_transferred_date = $reqro[0];
				                                                $_current_status = $reqro[1];
				                                             }
				                                         }
				                                         
                                                         $i++;
                                                         
                                                         	$req_no_sql="select req_id from mis_salary_fund_transfer where trans_id=".$row[1]." and current_status>0" ;
                                                            $req_no_table=mysqli_query($con,$req_no_sql); 
                                                            
                                                            $rejsql="select sum(amount) from mis_salary_fund_transfer where status=3 and current_status=0 and trans_id='".$row[1]."'";
                                                            $req_query=mysqli_query($con,$rejsql);
                                                            $req_query_data = mysqli_fetch_row($req_query); 
                                                            $rejected_amt = $req_query_data[0];
                                                            if($selectedstatus==2){
                                                                $approved_amt = $row[0] - $rejected_amt;
                                                            }else{
                                                                $approved_amt = $row[0];
                                                            }
                                                            $tot = $rejected_amt + $approved_amt;
                                                            
                                                          //  $approved_amt = $row[0] - $rejected_amt;
                                                            $totalapproved_amt = $totalapproved_amt + $approved_amt;
                                                            $totalrejected_amt = $totalrejected_amt + $rejected_amt;
                                                            
                                                            ?>
                                                        <tr>
                                                            <td><? echo $row[1] ?></td>
                                                             <td><?php if($_transferred_date!='0000-00-00'){ echo date('d-m-Y',strtotime($_transferred_date)); } ?></td>
                                                             <td><? echo $approved_amt; ?></td>
                                                             <td><? echo $rejected_amt; ?></td>
                                                             <td><? echo $tot; ?></td>  
                                                             <td><a href="show_salary_fund_pay_transfer1.php?id=<?php echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="view"  value="View Details" /></a></td>
                                                              <td>
                                                                 <!--<a href="edit_fundtransfer_detail.php?id=<? echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="edit"  value="Edit Details" /></a>-->
                                                                <? //if($_current_status!=4){ ?>
                                                                <form action="show_salary_fund_pay_test.php" method="POST">
                                                                    <?
                                                                      while($req_no_row=mysqli_fetch_array($req_no_table)){
                                                                          
                                                                    ?>
                                                                    <input type='hidden'  name='apps[]' value="<? echo $req_no_row[0]; ?>">
                                                                    <? 
                                                                    } 
                                                                    ?>
                                                                    <input type="hidden" name="trans_id" value="<? echo $row[1]; ?>">
                                                                    <input type="hidden" name="current_status" value="<? echo $_current_status; ?>">
                                                                    <input type="hidden" name="transferred_date" value="<? if($_transferred_date!='0000-00-00'){ echo date('d-m-Y',strtotime($_transferred_date)); }else{ echo '';} ?>">
                                                                    <input type='submit' class="form-control <? if($_current_status!=4){ echo 'red';}else{ echo 'green';}?>" name="edit"  value="<? if($_current_status!=4){ echo 'Edit Details';}else{ echo 'Show Details';} ?>" />    
                                                                </form> 
                                                                <? //} ?>
                                                              </td>
                                                              <!-- <td><a href="viewbanktrans.php?transid=<?php echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="view"  value="View Bank Statement" /></a></td>-->
                                                              <td>
                                                                 <a href="salaryfundtransfer_full_details1.php?id=<? echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="fulldetails_det"  value="Full Details" /></a>
                                                                <!--  <a id="approve_<? echo $id; ?>" data-toggle="modal" data-transamt="<? echo $row[0]; ?>" data-transid="<? echo $row[1]; ?>"  data-id="<? echo $id; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Edit</a>-->
                                                              </td>
                                                        </tr>         
                                                    <?  	}  
                                                        $total_amt = $totalapproved_amt + $totalrejected_amt;
                                                    ?>
                                                        <tr>
                                                            <td colspan=2>Total</td>
                                                            <td><? echo $totalapproved_amt;?></td>
                                                            <td><? echo $totalrejected_amt;?></td>
                                                            <td><? echo $total_amt;?></td>
                                                        </tr>     
                                                        
                                                <?    }
                                                ?>
                                                
                                            </tbody>
                                    </div></div></div></div></div></div></div>
                                    
                                    
                                    <!-- large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Confirm</h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="trans_id" name="trans_id">
                        
                        <div class="col-sm-12">
                            <label>Cheque No.</label>
                            <input type="text" name="chq_no" id="chq_no" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <label>Transferred Date</label>
                            <input type="text" name="transferred_date" class="form-control datepicker" id="transferred_date" onclick="displayDatePicker('transferred_date')" >
                        </div>
                        
                        <div class="col-sm-6">
                            <br>
                            <label>Amount</label>
                            <input type="text" readonly class="form-control" id="trans_amt">
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <input type="submit" name="submit" class="btn btn-success">
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
                                    
<?php
}
?>
 <? include('footer.php'); ?>
 <script>
    $(document).on("click", ".open-AddBookDialog", function () {
     var trans_id = $(this).data('transid');
     var trans_amt = $(this).data('transamt');
     
     $(".modal-body #trans_id").val( trans_id );
     $(".modal-body #trans_amt").val( trans_amt );
    
});

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'process_fund_transfer.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            if(msg==1)
             alert('Update Successfully');
            else
             alert('Something Went Wrong');
            
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
            }
          });

        });
 </script>