<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
if(isset($_POST)){
    if($_POST['submit']=='Payments'){
        echo '1';
    }
}
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" />


     
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->

 <form action="show_fundaccount_detail1.php" method="POST">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                        <table id="myTable" class="table table-bordered table-striped table-hover dataTable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="check"><input type="checkbox" id="flowcheckall" value="" />&nbsp;All</th>
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
                                                    <!--<td>approval_amount</td>-->
                                                    <td>required_amount</td>
                                                    <td>account_number</td>
                                                    <td>beneficiary_name</td>
                                                    <td>ifsc_code</td>
                                                    <th>Action</th>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                $statement = "select * from rnm_fund_test where status=5 order by id desc" ;  
                                                $_totalrequestedamt = 0;
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['id'];
                                                
                                                $_sql="select * from mis_fund_requests_test where status=5 and action=1 and req_id='".$id."'";
                                                $_table=mysqli_query($con,$_sql);    
                                                
                                                $rowcount=mysqli_num_rows($_table);
                                                 $_view = 0;
                                                if($rowcount){
                                                    $approved_amt_data = mysqli_fetch_row($_table);
                                                    $approved_actual_amt = $approved_amt_data[3];
                                                   
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
                                                        
                                                        if($level==6){
                                                             $_view = 1;
                                                        }
                                                    }
                                                }
                                                    $i++;
                                                    ?>
                                                     <?php if($_view==1){
                                                            //  $_totalrequestedamt = $_totalrequestedamt + $sql_result['required_amount']; 
                                                               $_totalrequestedamt = $_totalrequestedamt + $approved_actual_amt;
                                                     ?>
                                                    <tr>
                                                        <td><input type='checkbox' id="checkbox_<? echo $i; ?>" name='apps[]' value="<? echo $id; ?>" onclick="deductamt(<? echo $i; ?>)"></td>
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
                                                        <td id="remarks_<? echo $i; ?>"><? echo $sql_result['remark']; ?> </td>
                                                        <td><? echo get_member_name($sql_result['created_by']); ?> </td>
                                                       <!-- <td><? //echo $sql_result['status']; ?> </td> -->
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        <!--<td><? //echo $sql_result['added_pos']; ?> </td>-->
                                                        <td><? echo $sql_result['payee_type']; ?> </td>
                                                        <td><? echo $sql_result['fundDetails']; ?> </td>
                                                        <!--<td><?// echo $sql_result['approval_amount']; ?> </td>-->
                                                        <td id="req_amt_<? echo $i; ?>"><? echo $approved_actual_amt; ?> </td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['ifsc_code']; ?> </td>
 <td><a data-toggle="modal"  data-checkboxid="<? echo $i; ?>" data-req_amt="<? echo $approved_actual_amt; ?>" data-id="<? echo $sql_result['id']; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Update Remarks</a></td>
                                                        
                                                    </tr>
                                                <? } } ?>
                                            </tbody>
                                            </table>
                                            <br>
                                            <hr>
                                           
                                            <table>
                                                <thead>
                                                
                                                    
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Total Requested Amount</td>
                                                        <td>
                                                            <input type="hidden" id="total_requested_amt" value="<? echo $_totalrequestedamt; ?>">
                                                            <input class="form-control" style="text-align:center;" id="total_req_amt" type="text" readonly value="<? echo $_totalrequestedamt; ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                       <td>
                                                           <input style="cursor:pointer;" class="btn btn-primary" type="submit" value="Payments">
                                                           
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                           
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

     </form>
         
                
<!-- large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Update Remarks</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Update RNM Fund Remarks</h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="checkboxid" name="checkboxid">
                        
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
                               
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script>
var oTableStaticFlow;
  $(document).ready(function() {
   oTableStaticFlow = $('#myTable').DataTable( {
        columnDefs: [ {
            orderable: false,
            
        } ],
        
        order: [[ 1, 'asc' ]],
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
    
   $("#flowcheckall").click(function () { debugger;
       var total_req_amt = $("#total_requested_amt").val();
       
        //$('#flow-table tbody input[type="checkbox"]').prop('checked', this.checked);
        var cols = oTableStaticFlow.column(0).nodes(),
            state = this.checked;
            
        if(state==true){
            
              $("#total_req_amt").val(total_req_amt);
        }else{
              $("#total_req_amt").val(0);
        }    
        
        for (var i = 0; i < cols.length; i += 1) {
        	cols[i].querySelector("input[type='checkbox']").checked = state;
        	
        }
        
    });
    
    $("#flowcheckall").click();
    
} );

function deductamt(key){ debugger;
    var total_req_amt = $("#total_req_amt").val();
    var less_req_amt = $("#req_amt_"+key).html();
    var checked_or_not = $('#checkbox_'+key).prop("checked");
    var new_req_amt = parseFloat(total_req_amt) - parseFloat(less_req_amt);
    if(checked_or_not){
      new_req_amt = parseFloat(total_req_amt) + parseFloat(less_req_amt);
    }
    $("#total_req_amt").val(new_req_amt);
}

$(document).on("click", ".open-AddBookDialog", function () {
     var id = $(this).data('id');
     var req_amt = $(this).data('req_amt');
     var checkboxid = $(this).data('checkboxid');
     
     $(".modal-body #id").val( id );
    
     $(".modal-body #req_amt").val( req_amt );
     $(".modal-body #checkboxid").val( checkboxid );
});

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'update_rnmfund.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_"); 
            textmsg = res[0];
           // $('#remarks_'+res[0]).prop('href','#');
            $('#remarks_'+res[1]).html(textmsg);
            
           // rejectdeductamt(res[1]);
           // $('#checkbox_'+res[1]).css('display','none');
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
            }
          });

        });


</script>




</body>
</html>