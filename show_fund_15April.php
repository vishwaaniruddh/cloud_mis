<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
                                                    <td>type</td>
                                                    <td>subtype</td>
                                                    <td>atmid</td>
                                                    <td>bank</td>
                                                    <td>customer</td>
                                                    <td>zone</td>
                                                    <td>city</td>
                                                    <td>state</td>
                                                    <td>location</td>
                                                    
                                                    <td>attach</td>
                                                    <td>remark</td>
                                                    <td>created_by</td>
                                                    <!--<td>status</td>-->
                                                    <td>created_at</td>
                                                    <!--<td>added_pos</td>-->
                                                    <td>payee_type</td>
                                                    <td>fundDetails</td>
                                                    <td>approval_amount</td>
                                                    <td>required_amount</td>
                                                    <td>account_number</td>
                                                    <td>beneficiary_name</td>
                                                    <td>ifsc_code</td>
                                                    <td>Action</td>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                
                                                if($_SESSION['position']==6 || $_SESSION['position']==5){
                                                    $statement = "select * from rnm_fund order by id desc" ;    
                                                }elseif($_SESSION['position']==2){
                                                    $statement = "select * from rnm_fund where added_pos=1 order by id desc" ;
                                                }elseif($_SESSION['position']==3){
                                                    $statement = "select * from rnm_fund where added_pos=2 order by id desc" ;
                                                }elseif($_SESSION['position']==4){
                                                    $statement = "select * from rnm_fund where added_pos=3 order by id desc" ;
                                                }elseif($_SESSION['position']==5){
                                                    $statement = "select * from rnm_fund where added_pos=4 order by id desc" ;
                                                }else{
                                                    $statement = "select * from rnm_fund order by id desc" ;
                                                }
                                                
                                                
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['id'];
                                                $_view = 0;
                                                $_approveview = 0;
                                                if($_SESSION['userid']==$sql_result['created_by']){
                                                    $_view = 1;
                                                }else{
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
                                                    $userfundaction = "select action,status,req_amt,approved_amt from mis_fund_requests where req_id=".$id." order by id desc" ;
                                                    $userfundactionsql = mysqli_query($con,$userfundaction);
                                                    $userfundaction_rowresult = mysqli_fetch_row($userfundactionsql);
                                                  //  echo '<pre>';print_r($userfundaction_rowresult);echo '</pre>';die;
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
                                                                  //   $_view = 1;
                                                                  }
                                                              }
                                                          }
                                                          $_status = 4;
                                                           $_requestedamt = $userfundaction_rowresult[3];
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
                                                                    //$_view = 1;
                                                                  }
                                                              }
                                                          }
                                                          $_status = 5;
                                                           $_requestedamt = $userfundaction_rowresult[3];
                                                    }
                                                }
                                                ?>
                                                 <?php if($_view==1){?>
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
                                                        
                                                        <td><a href="<? echo $sql_result['attach']; ?>" target="_blank">View</a> 
                                                        <a href="<? echo $sql_result['attach']; ?>" download>Download</a></td>
                                                        <td><? echo $sql_result['remark']; ?> </td>
                                                        <td><? echo get_member_name($sql_result['created_by']); ?> </td>
                                                       <!-- <td><? //echo $sql_result['status']; ?> </td> -->
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        <!--<td><? //echo $sql_result['added_pos']; ?> </td>-->
                                                        <td><? echo $sql_result['payee_type']; ?> </td>
                                                        <td><? echo $sql_result['fundDetails']; ?> </td>
                                                        <td><? echo $sql_result['approval_amount']; ?> </td>
                                                        <td><? echo $sql_result['required_amount']; ?> </td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['ifsc_code']; ?> </td>

                                                        <th>
                                                            <?php if($_SESSION['userid']!=$sql_result['created_by']){ 
                                                                    if($_approveview==1){
                                                                    ?>
                                                           <!-- <a data-toggle="modal" class="btn btn-danger" href="approve_rnmFund.php?id=<? echo $id; ?>">Approve</a>-->
                                                           <a id="approve_<? echo $id; ?>" data-toggle="modal" data-status="<? echo $_status; ?>" data-req_amt="<? echo $_requestedamt; ?>" data-id="<? echo $id; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Approve</a>
                                                            <?php }else{ ?>
                                                               <a data-toggle="modal" data-status="<? echo $userfundaction_rowresult[1]; ?>" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">
                                                                  <? if($userfundaction_rowresult[0]==1){ ?>
                                                                   Details
                                                                  <? } else { ?>
                                                                   Rejected Details
                                                                  <? } ?>
                                                                   </a>
                                                           <?php } 
                                                           }else{ ?>    
                                                            <a data-toggle="modal" data-status="<? echo $userfundaction_rowresult[1]; ?>" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModalDetail">Details</a>
                                                            <?php } ?>
                                                        </th>
                                                    </tr>
                                                <? } } ?>
                                            </tbody>
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
</script>
</body>
</html>