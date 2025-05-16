<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    
    include('config.php');
    
   
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
                                                    
                                                    $accountno_array = array();
                                                    $_customer_total_amt = 0;
                                                	$sql="select sum(amount),trans_id,batch_no,id from mis_salary_fund_transfer where status=3 and current_status>0 group by trans_id order by trans_id ASC";
                                            	    $view = 0; 
                                                    $table=mysqli_query($con,$sql);   
                                                    if(!empty($table)){
                                                    while($row=mysqli_fetch_array($table)){
                                                      
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
                                                         
                                                         	$req_no_sql="select req_id from mis_salary_fund_transfer where trans_id=".$row[1];
                                                            $req_no_table=mysqli_query($con,$req_no_sql); 
                                                            
                                                            $rejsql="select sum(amount) from mis_salary_fund_transfer where status=3 and current_status=0 and trans_id='".$row[1]."'";
                                                            $req_query=mysqli_query($con,$rejsql);
                                                            if(!empty($req_query)){
                                                            $req_query_data = mysqli_fetch_row($req_query); 
                                                            $rejected_amt = $req_query_data[0];
                                                            }
                                                            $approved_amt = $row[0] - $rejected_amt;
                                                            $totalapproved_amt = $totalapproved_amt + $approved_amt;
                                                            $totalrejected_amt = $totalrejected_amt + $rejected_amt;
                                                            
                                                            
                                                            ?>
                                                        <tr>
                                                            <td><? echo $row[1] ?></td>
                                                             <td><?php if($_transferred_date!='0000-00-00'){ echo date('d-m-Y',strtotime($_transferred_date)); } ?></td>
                                                             <td><? echo $approved_amt; ?></td>
                                                             <td><? echo $rejected_amt; ?></td>
                                                             <td><? echo $row[0] ?></td>  
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
                                                                    <input type='submit' class="form-control" name="edit"  value="<? if($_current_status!=4){ echo 'Edit Details';}else{ echo 'Show Details';} ?>" />    
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