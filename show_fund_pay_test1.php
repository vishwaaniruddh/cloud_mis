<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    $app=$_POST['apps'];
    $trans_id = $_POST['trans_id'];
    $current_status = $_POST['current_status'];
    $transferred_date = $_POST['transferred_date'];
    include('config.php');
?>
<link href="sweetalert/sweetalert.css" rel="stylesheet">
<script src="sweetalert/sweetalert.min.js"></script>
<link href="datepicker/jquery-ui.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                         <form action="cmsexp_test.php" method="POST">
                                             <? for($x=0;$x<count($app);$x++){ ?>
                                             <input type="hidden" name="apps[]" value="<? echo $app[$x]; ?>">
                                             <? } ?>
                                             <input type="hidden" name="trans_id" value="<? echo $trans_id; ?>">
                                             <input type="submit" value="Excel">
                                         </form> 
                                         <form action="showfundtransferaction1.php" method="POST" id="form">
                                             <table id="showfundtransfer" class="table table-bordered table-striped table-hover dataTable showfundtransfer no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Beneficiary Name</th>
                                                    <td>Account Number</td>
                                                    <td>IFSC Code</td>
                                                    <td>Amount</td>
                                                    
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?  $req_ids = array();
                                                    $accountno_array = array();
                                                    $fundDetail_array = array();
                                                    $total=0;$i = 0 ; 
                                                	for($x=0;$x<count($app);$x++){  
                                                	    array_push($req_ids,$app[$x]);
                                                	    $_customer_total_amt = 0;
                                                    	$sql="select * from rnm_fund where id='".$app[$x]."'";
                                                	    $view = 0; 
                                                        $table=mysqli_query($con,$sql);    
                                                        $row=mysqli_fetch_row($table);
                                                        $combinevalue = $row[20]."_".$row[18];
                                                        if(!in_array($row[20],$accountno_array)){
                                                            if(!in_array($row[18],$fundDetail_array)){
                                                           $accs=mysqli_query($con,"select * from rnm_fund where account_number='".$row[20]."' and fundDetails='".$row[18]."'"); 
                                                           
                                                           while($accr=mysqli_fetch_array($accs)){
                                                               if(in_array($accr[0],$app)){
                                                                   $req_amt_data=mysqli_query($con,"select approved_amt from mis_fund_requests where req_id=".$accr[0]." order by id desc");
                                                                   $req_row_amt = mysqli_fetch_row($req_amt_data);
                                                                     $_customer_total_amt = $_customer_total_amt + $req_row_amt[0];
                                                             //  $_customer_total_amt = $_customer_total_amt + $accr[19];
                                                               }
                                                           }
                                                           array_push($fundDetail_array,$row[18]);
                                                           $view = 1;
                                                            }
                                                            array_push($accountno_array,$row[20]);
                                                        }
                                                        
                                                       $currentsql="select current_status from mis_fund_transfer where req_id='".$app[$x]."'";  
                                                       $currenttable=mysqli_query($con,$currentsql);    
                                                        $currentrow=mysqli_fetch_row($currenttable);
                                                        $_currentstatus = $currentrow[0];
                                                        
                                                       // echo '<pre>';print_r($row);echo '</pre>';die;
                                                       $total = $total + $_customer_total_amt;
                                                       if($view==1){ $i++;
                                                        ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                         <td><? echo $row[21] ?></td>  
                                                         <td><? echo $row[20] ?></td>  
                                                         <td><? echo $row[22] ?></td>  
                                                         <td><? echo $_customer_total_amt ?></td>  
                                                        <? if($_currentstatus==2){ ?>
                                                           <td>
                                                            
                                                            <a id="reject_<? echo $i; ?>" data-toggle="modal" data-reqid="<? echo $app[$x]; ?>" data-checkboxid="<? echo $i; ?>" data-req_amt="<? echo $_customer_total_amt; ?>" data-id="<? echo $trans_id; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Reject</a>
                                                            </td>
                                                        <? } ?>   
                                                        <? if($_currentstatus==0){ ?>
                                                           <td class="btn btn-danger">Rejected</td>
                                                        <? } ?> 
                                                         <? if($_currentstatus==3){ ?>
                                                           <td>
                                                            
                                                            <a id="transfer_<? echo $i; ?>" data-toggle="modal" data-reqid="<? echo $app[$x]; ?>" data-checkboxid="<? echo $i; ?>" data-req_amt="<? echo $_customer_total_amt; ?>" data-id="<? echo $trans_id; ?>" class="open-AddTransDialog btn btn-primary" href="#transModal">Transfer Date</a>
                                                            </td>
                                                        <? } ?>
                                                        <? if($_currentstatus==4){ ?>
                                                           <td class="btn btn-danger"><? echo $transferred_date; ?></td>
                                                        <? } ?>
                                                    </tr>         
                                                <?  } 	}
                                                ?>
                                                </tbody>
                                                <tbody>
<tr><td colspan=4 align='right' >TOTAL AMOUNT</td><td align='CENTER' ><?php echo $total; ?></td></tr>

</table>
<center>
    
    <input type='hidden' name='reqs' value='<?php echo json_encode($req_ids); ?>' />
    <input type="hidden" name="trans_id" value="<? echo $trans_id; ?>">
  <!-- <input type="hidden" name="submit" value="Done">-->
    <? if($current_status!=4){ ?>
    <button onclick="checkButton()" style="cursor:pointer;" class="btn btn-primary" type="button" value="Confirm">Done</button>
    <button class="btn btn-danger"><a href="showfundtransfer1.php">Cancel</a></button>
    <? } ?>
</center>
 </form>
</div></div></div></div></div></div></div>

            
<!-- large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Reject</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Reject RNM Fund </h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="checkboxid" name="checkboxid">
                        <input type="hidden" id="reqid" name="reqid">
                        <div class="col-sm-4">
                            <label>Requested Amount</label>
                            <input type="text" readonly name="req_amt" id="req_amt" class="form-control">
                        </div>
                        
                        
                        <div class="col-sm-12">
                            <br>
                            <label>Remarks</label>
                            <input type="text" name="remarks" class="form-control" id="remarks">
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


<!-- large modal -->
<div class="modal fade" id="transModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Transfer Date</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Transfer RNM Fund </h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="checkboxid" name="checkboxid">
                        <input type="hidden" id="reqid" name="reqid">
                        <div class="col-sm-4">
                            <label>Requested Amount</label>
                            <input type="text" readonly name="req_amt" id="req_amt" class="form-control">
                        </div>
                        
                        
                        <div class="col-sm-12">
                            <br>
                            <label>Transferred Date</label>
                            <input type="text" name="transferred_date" class="form-control datepicker" id="transferred_date" data-toggle="datepicker">
                            <!--<div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" id="transferred_date" name="transferred_date">
                              </div>-->
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

   
$(document).on("click", ".open-AddBookDialog", function () {
     var id = $(this).data('id');
     var req_amt = $(this).data('req_amt');
     var checkboxid = $(this).data('checkboxid');
     var req_id = $(this).data('reqid');
     $(".modal-body #id").val( id );
     $(".modal-body #reqid").val( req_id );
     $(".modal-body #req_amt").val( req_amt );
     $(".modal-body #checkboxid").val( checkboxid );
});

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'process_fundtransfer_action1.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_");
            textmsg = "Rejected Done";
            $('#reject_'+res[1]).prop('href','#');
            $('#reject_'+res[1]).html(textmsg);
            
          //  rejectdeductamt(res[1]);
          //  $('#checkbox_'+res[1]).css('display','none');
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
            }
          });

        });


 
$(document).on("click", ".open-AddTransDialog", function () {
     var id = $(this).data('id');
     var req_amt = $(this).data('req_amt');
     var checkboxid = $(this).data('checkboxid');
     var req_id = $(this).data('reqid');
     $(".modal-body #id").val( id );
     $(".modal-body #reqid").val( req_id );
     $(".modal-body #req_amt").val( req_amt );
     $(".modal-body #checkboxid").val( checkboxid );
});

$('#transModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'process_fundtransferdate_action1.php',
            data: $('#transModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_");
            textmsg = "Transfer Date Done";
            $('#transfer_'+res[1]).prop('href','#');
            $('#transfer_'+res[1]).html(textmsg);
            
          //  rejectdeductamt(res[1]);
          //  $('#checkbox_'+res[1]).css('display','none');
            $("#transModal .btn-success").show();
            $('#transModal').modal('toggle'); 
            }
          });

        });


  function checkButton(){

        swal({
            title: "Are you sure?",
            text: "Once done, you cannot revert back so be sure before proceed !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!"
         }).then(function(value) {
				if (value) {
			         $("#form").submit();
				}else {
                    swal("Cancelled", "You cancel it :)", "error"); 
                    return false;
                }
			});

}
       
$('#transferred_date').datepicker({
    dateFormat: 'dd-mm-yy',
    });            
  
</script>


