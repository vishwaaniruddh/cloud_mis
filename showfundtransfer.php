<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    
    include('config.php');
    if(isset($_POST['reqs'])){  
        if(!empty($_POST['reqs'])){
             $app=json_decode($_POST['reqs']); 
            // echo '<pre>';print_r($app);echo '</pre>';die;
             $result=mysqli_query($con,"select trans_id from mis_fund_transfer order by id desc"); 
             $rowcount=mysqli_num_rows($result);
             if($rowcount==0){
                 $tid = 1;
             }else{
                 $trans=mysqli_fetch_row($result);
                 $tid = $trans[0];
                 $tid++;
             }
             for($x=0;$x<count($app);$x++){  
                $req_id = $app[$x];
                $action = 2;
                $status = 6;
                $created_date = date('Y-m-d');
                $created_by = $_SESSION['userid'];
                
                $sql="select req_amt,approved_amt from mis_fund_requests where status=5 and action=1 and req_id='".$app[$x]."'";
        	    $table=mysqli_query($con,$sql);    
                $row=mysqli_fetch_row($table);
                
                $req_amt = $row[0];
                $approved_amt = $row[1];
                
                
                
                $requestedusersql="select beneficiary_name,account_number,ifsc_code from rnm_fund where id='".$app[$x]."'";
                $_table=mysqli_query($con,$requestedusersql);    
                $_row=mysqli_fetch_row($_table);
                
                $beneficiary_name = $_row[0];
                $account_number = $_row[1];
                $ifsc_code = $_row[2];
                
                $insert_sql = "insert into mis_fund_transfer(trans_id,req_id,req_amt,approved_amt,status,beneficiary_name,account_number,ifsc_code) 
                        values('".$tid."','".$req_id."','".$req_amt."','".$approved_amt."','".$action."','".$beneficiary_name."','".$account_number."','".$ifsc_code."')";
                mysqli_query($con,$insert_sql);
                
                $insertsql = "insert into mis_fund_requests(req_id,req_amt,approved_amt,created_by,action,remarks,created_date,status) 
                        values('".$req_id."','".$req_amt."','".$approved_amt."','".$created_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
                mysqli_query($con,$insertsql);
                
                $updatesql = "update rnm_fund SET status= '".$status."' WHERE id = ".$req_id; 
                mysqli_query($con,$updatesql);
             }
             
        }
    }
    
?>
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
                                         <table id="showfundtransfer" class="table table-bordered table-striped table-hover dataTable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Id</th>
                                                    <th>Transferred Date</th>
                                                    <th>Amount</th>
                                                    <th>View</th>
                                                    <th>Edit</th>
                                                    <th>View Bank</th>
                                                    <th>Export</th>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                  
                                                    $accountno_array = array();
                                                    $_customer_total_amt = 0;
                                                	$sql="select sum(approved_amt),trans_id,chq_no,id from mis_fund_transfer where status!=0 group by trans_id order by trans_id ASC";
                                            	    $view = 0; 
                                                    $table=mysqli_query($con,$sql);   
                                                    
                                                    while($row=mysqli_fetch_array($table)){
                                                      /*  if(!in_array($row[8],$accountno_array)){
                                                           $accs=mysqli_query($con,"select * from mis_fund_transfer where account_number=".$row[8]); 
                                                           while($accr=mysqli_fetch_array($accs)){
                                                               
                                                               $_customer_total_amt = $_customer_total_amt + $accr[4];
                                                              
                                                           }
                                                           array_push($accountno_array,$row[8]);
                                                           $view = 1;
                                                        } */
                                                         $id = $row[3];
                                                         $req=mysqli_query($con,"select transferred_date from mis_fund_transfer where chq_no='".$row[2]."' and trans_id='".$row[1]."'");
				                                         $reqro=mysqli_fetch_row($req);
                                                         $i++;
                                                            ?>
                                                        <tr>
                                                            <td><? echo $row[1] ?></td>
                                                             <td><?php if($reqro[0]!='0000-00-00'){ echo date('d-m-Y',strtotime($reqro[0])); } ?></td>
                                                             <td><? echo $row[0] ?></td>  
                                                             <td><a href="show_fund_pay_transfer.php?id=<?php echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="view"  value="View Details" /></a></td>
                                                              <td>
                                                                 <a href="edit_fundtransfer_detail.php?id=<? echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="edit"  value="Edit Details" /></a>
                                                                <!--  <a id="approve_<? echo $id; ?>" data-toggle="modal" data-transamt="<? echo $row[0]; ?>" data-transid="<? echo $row[1]; ?>"  data-id="<? echo $id; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Edit</a>-->
                                                              </td>
                                                               <td><a href="viewbanktrans.php?transid=<?php echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="view"  value="View Bank Statement" /></a></td>
                                                              <td>
                                                                 <a href="fundtransfer_full_details.php?id=<? echo $row[1]; ?>" target="_blank"><input type='button' class="form-control" name="fulldetails_det"  value="Full Details" /></a>
                                                                <!--  <a id="approve_<? echo $id; ?>" data-toggle="modal" data-transamt="<? echo $row[0]; ?>" data-transid="<? echo $row[1]; ?>"  data-id="<? echo $id; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Edit</a>-->
                                                              </td>
                                                        </tr>         
                                                    <?  	}
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