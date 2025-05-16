<? session_start();
include('config.php');

if($_SESSION['username']){ 


                $user_id = $_SESSION['userid'];  
                $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
                $user_sql = mysqli_query($con,$user_statement);
                $user_rowresult = mysqli_fetch_row($user_sql);
                //echo '<pre>';print_r($user_rowresult);echo '</pre>';die;
                $_userlevel = $user_rowresult[0];
               
include('header.php');
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<style>
              a:not([href]) {
                  padding: 5px;
              }
              .btn-group{
                      border: 1px solid #cccccc;
              }
              
              
              
              ul.dropdown-menu{
                  transform: translate3d(0px, 2%, 0px) !important;
                      overflow: scroll !important;
                      max-height:250px;
              }
          label{
                  font-weight: 900;
    font-size: 16px;
          }
          </style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                         
                                         <?
                                           $statement = "SELECT *,id as req_id FROM `mis_staff_salary`" ; 
                                         ?>
         
         <style>
             .indication{
                 display:flex;
                 background:#404e67;
             }
             .indication span{
                 width:15px;
                 height:15px;
                 border:1px solid white;
                 border-radius:25px;
                 margin: 10px;
             }
             .open{
                 background:white;
             }
             .close{
                 background:#e29a9a;
             }
             .schedule{
                 background:#d09f45;
             }
   
   th.address, td.address {
    white-space: inherit;
}

         </style>
    <div style="display:flex;justify-content:space-around;">
        <h5 style="text-align:center;"></h5>
       
        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
    </div>     
        <hr>
                                   <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                     
                                      <!--  <table id="example" class="table table-bordered table-striped table-hover no-footer" style="width:100%"> -->
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
                                                    <th>type</th>
                                                    <th>subtype</th>
                                                    <th>atmid</th>
                                                    <th>bank</th>
                                                    <th>customer</th>
                                                    <th>zone</th>
                                                    <th>city</th>
                                                    <th>state</th>
                                                    <th>location</th>
                                                    
                                                    <th>attach</th>
                                                    <th>remark</th>
                                                    <th>created_by</th>
                                                    <!--<td>status</td>-->
                                                    <th>created_at</th>
                                                    <!--<td>added_pos</td>-->
                                                    <th>payee_type</th>
                                                    <th>fundDetails</th>
                                                    <th>approval_amount</th>
                                                    <th>required_amount</th>
                                                    <th>approved_amount / transferred amount</th>
                                                    <th>transferred date</th>
                                                    <th>batch number</th>
                                                    <th>Status</th>
                                                    <th>account_number</th>
                                                    <th>beneficiary_name</th>
                                                    <th>ifsc_code</th>
                                                    
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                               
                                                $total_amount = 0;
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['req_id'];
                                                $_view = 0;
                                                $_approveview = 0;
                                                
                                                $userfundaction = "select action,status,amount from mis_salary_fund_requests where req_id=".$id." order by id desc limit 1" ;
                                                $userfundactionsql = mysqli_query($con,$userfundaction);
                                                $userfundaction_rowresult = mysqli_fetch_assoc($userfundactionsql);
                                                
                                                $approved_amt = $userfundaction_rowresult['amount'];
                                                $_recent_status = "";$_transfer_date="";$_batch_no="";
                                                if($userfundaction_rowresult['action']==0){
                                                    $_recent_status = "Rejected";
                                                }else{
                                                    if($userfundaction_rowresult['status']<=5){
                                                        $_recent_status = "Pending";  
                                                    }
                                                    if($userfundaction_rowresult['status']>5){
                                                        $userfundtransaction = "select current_status,status,amount,transferred_date,batch_no from mis_salary_fund_transfer where req_id=".$id." order by id desc limit 1" ;
                                                        $userfundtransactionsql = mysqli_query($con,$userfundtransaction);
                                                        $userfundtransaction_rowresult = mysqli_fetch_assoc($userfundtransactionsql);
                                                        $approved_amt = $userfundtransaction_rowresult['amount'];
                                                        if($userfundtransaction_rowresult['current_status']==0){
                                                            $_recent_status = "Rejected";
                                                        }else{
                                                            if($userfundtransaction_rowresult['status']==3 && $userfundtransaction_rowresult['current_status']==4){
                                                                $_recent_status = "Transferred"; 
                                                                $_transfer_date = $userfundtransaction_rowresult['transferred_date'];
                                                                $_batch_no = $userfundtransaction_rowresult['batch_no'];
                                                            }else{
                                                                $_recent_status = "Pending"; 
                                                            }
                                                        }
                                                    }
                                                }
                                                
                                                    $userid = $_SESSION['userid'];
                                                    $userstatement = "select level,cust_id from mis_loginusers where id=".$userid ;
                                                    $usersql = mysqli_query($con,$userstatement);
                                                    $sql_rowresult = mysqli_fetch_row($usersql);
                                                    $level = $sql_rowresult[0];
                                                    $cust_id = $sql_rowresult[1];
                                                    if($level==1){
                                                        if($_SESSION['userid']==$sql_result['created_by']){
                                                            $_view = 1;
                                                        }
                                                    }
                                                    
                                                    
                                                    if($level==2){
                                                        $_custarray = explode(",",$cust_id);
                                                        $_customer = $sql_result['customer'];
                                                        if (in_array($_customer, $_custarray)){
                                                          if(!empty($userfundaction_rowresult)){ 
                                                              if($userfundaction_rowresult[1]==1){
                                                                 $_approveview = 1;
                                                                 $_view = 1;
                                                              }else{
                                                                  $_view = 1;
                                                              }
                                                          }
                                                        }
                                                        $_requestedamt = $userfundaction_rowresult[2];
                                                        $_status = 3;
                                                    }
                                                    if($level==3){
                                                        if(!empty($userfundaction_rowresult)){ 
                                                              if($userfundaction_rowresult[1]==3){
                                                                  if($userfundaction_rowresult[0]==1){
                                                                    $_approveview = 1;
                                                                    $_view = 1;
                                                                  }
                                                                 
                                                              }else{
                                                                  if($userfundaction_rowresult[1]>3){
                                                                     $_view = 1;
                                                                  }
                                                              }
                                                          }
                                                          $_status = 4;
                                                           $_requestedamt = $userfundaction_rowresult[2];
                                                    }
                                                    if($level==4){
                                                        if(!empty($userfundaction_rowresult)){ 
                                                              if($userfundaction_rowresult[1]==4){
                                                                 if($userfundaction_rowresult[0]==1){
                                                                    $_approveview = 1;
                                                                    $_view = 1;
                                                                  }
                                                                 
                                                              }else{
                                                                  if($userfundaction_rowresult[1]>4){
                                                                    $_view = 1;
                                                                  }
                                                              }
                                                          }
                                                          $_status = 5;
                                                           $_requestedamt = $userfundaction_rowresult[2];
                                                    }
                                                $total_amount = $total_amount + $approved_amt;
                                              //  $total_amount = $total_amount + $sql_result['amount']; 
                                                ?>
                                                 
                                                    <tr>
                                                        <td><? echo ++$i; ?></td>
                                                        <td><? echo $sql_result['type']; ?> </td>
                                                        <td><? echo $sql_result['subtype']; ?> </td>
                                                        <td><? echo $sql_result['atmid']; ?> </td>
                                                        <td><? echo $sql_result['bank']; ?> </td>
                                                        <td><? echo $sql_result['customer']; ?> </td>
                                                        <td><? echo $sql_result['zone']; ?> </td>
                                                        <td><? echo $sql_result['city']; ?> </td>
                                                        <td><? echo $sql_result['state']; ?> </td>
                                                        <td><? echo $sql_result['location']; ?> </td>
                                                        
                                                        <td>
                                                            <? if($sql_result['attach']!=""){ ?>
                                                            <a href="<? echo $sql_result['attach']; ?>" target="_blank">View</a> 
                                                            <a href="<? echo $sql_result['attach']; ?>" download>Download</a>
                                                            <? }else{ ?>
                                                            No File Attach
                                                            <? } ?>
                                                        </td>
                                                        <td><? echo $sql_result['remark']; ?> </td>
                                                        <td><? echo get_member_name($sql_result['created_by']); ?> </td>
                                                       <!-- <td><? //echo $sql_result['status']; ?> </td> -->
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        <!--<td><? //echo $sql_result['added_pos']; ?> </td>-->
                                                        <td><? echo $sql_result['payee_type']; ?> </td>
                                                        <td><? echo $sql_result['fundDetails']; ?> </td>
                                                        <td><? echo $sql_result['approval_amount']; ?> </td>
                                                        <td><? echo $sql_result['required_amount']; ?> </td>
                                                        <td><? echo $approved_amt; ?></td>
                                                        <td><? echo $_transfer_date; ?></td>
                                                        <td><? echo $_batch_no; ?></td>
                                                        <td><? echo $_recent_status; ?></td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['ifsc_code']; ?> </td>

                                                    </tr>
                                                    
                                                <?  } ?>
                                                    
                                                    
                                            </tbody>
                                            <tfooter>
                                                <tr>
                                                      <td>Total</td>    
                                                      <td><? echo $total_amount;?></td>
                                                    </tr>
                                            </tfooter>
                                            </table>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>



<!-- large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Approve / Reject</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Approve / Reject RNM Fund </h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="reqId" name="req_id">
                        <input type="hidden" id="reqStatus" name="status">
                        <div class="col-sm-4">
                            <label>Select Action</label>
                            <select name="action" class="form-control" id="action" onchange="selectAction(this.value)">
                                <option value="1">Approve</option>
                                <option value="0">Reject</option>
                            </select>    
                        </div>
                        <div class="col-sm-4">
                            <label>Requested Amount</label>
                            <input type="text" readonly name="req_amt" id="req_amt" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label>Approve Requested Amount</label>
                            <input type="number" name="approved_amt" class="form-control" id="approved_amt" value="0" min="1">
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
<div class="modal fade" id="myModalDetail" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">History Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>RNM Fund Request and Approve Details</h6>
          <div class="card">
            <div class="card-block" id="result_status" style=" overflow: auto;">
              
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

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'process_rnmfund_action.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_");
            var textmsg = "Approval Done";
            if(res[1]==0){
                textmsg = "Rejected Done";
            }
            $('#approve_'+res[0]).prop('href','#');
            $('#approve_'+res[0]).html(textmsg);
            
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
            }
          });

        });

$(document).on("click", ".open-AddBookDialog", function () {
     var reqId = $(this).data('id');
     var req_amt = $(this).data('req_amt');
     var reqStatus = $(this).data('status');
     $(".modal-body #reqId").val( reqId );
     $(".modal-body #req_amt").val( req_amt );
     $(".modal-body #approved_amt").prop('max',req_amt );
     $(".modal-body #reqStatus").val( reqStatus );
});
$(document).on("click", ".open-DetailDialog", function () {
     var reqId = $(this).data('id');
     var reqStatus = $(this).data('status');
     $.ajax({    //create an ajax request to display.php
        type: "GET",
        url: "show_fund_details.php?req_id="+reqId,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $(".modal-body #result_status").html(response); 
            //alert(response);
        }
     });
    // $(".modal-body #result_status").val( reqStatus );
});
function selectAction(val){
    if(val==0){
        $("#approved_amt").prop('required',false);
        $("#approved_amt").prop('readonly',true);
        $("#remarks").prop('required',true);
        $("#approved_amt").prop('min',0);
    }else{
        $("#approved_amt").prop('required',true);
        $("#approved_amt").prop('readonly',false);
        $("#remarks").prop('required',false);
        $("#approved_amt").prop('min',1);
    }
}



    	$(document).ready(function() {
              $('#multiselect').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                $('#multiselect_bm').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                  $('#multiselect_status').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
                $('#multiselect_zone').multiselect({
                buttonWidth : '100%',
                includeSelectAllOption : true,
            		nonSelectedText: 'Select an Option'
              });
              
              
              
        });
                
    
        $("#show_filter").css('display','none');
    
        $("#hide_filter").on('click',function(){
           $("#filter").css('display','none');
           $("#show_filter").css('display','block');
        });
        $("#show_filter").on('click',function(){
          $("#filter").css('display','block');
           $("#show_filter").css('display','none');
        });
        
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>
</body>
</html>