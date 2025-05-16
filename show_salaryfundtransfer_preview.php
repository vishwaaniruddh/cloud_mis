<? session_start();
include('config.php');

if($_SESSION['username']){ 
$_resultdata = 0;
include('header.php');
if(isset($_POST['apps'])){ 
    if(!empty($_POST['apps'])){
        $app=$_POST['apps'];
        //echo '<pre>';print_r($app);echo '</pre>';die;
    }
}
?>
<link href="sweetalert/sweetalert.css" rel="stylesheet">
<script src="sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" />


     
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->

 <form id="form" action="show_salaryfundtransfer_detail.php" method="POST">
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
                                                    <!--<th class="check"><input type="checkbox" id="flowcheckall" value="" />&nbsp;All</th>-->
                                                    <th>S.No.</th>
                                                    <th>Beneficiary Name</th>
                                                    <th>Account Number</th>
                                                    <th>IFSC Code</th>
                                                    <th>Amount</th>
                                                   <!-- <th>Remarks</th>
                                                    <th>Action</th>-->
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?  
                                                    $total = 0;
                                                    
                                                        if(!empty($app)){
                                                            for($x=0;$x<count($app);$x++){  
                                                                $_id = $app[$x];
                                                                
                                                               
                                                                $sql = "select beneficiary_name, account_number, ifsc_code, amount, fundDetails, id, fund_remark,trans_id
                                                                       from mis_salary_fund_transfer where id=".$_id." order by id desc";
                                                                $table=mysqli_query($con,$sql);
                                                        	    $row=mysqli_fetch_row($table);
                                                           
                                                                $id = $row[5];
                                                                
                                                                $_acno = $row[1];           
                                                                $_fd = $row[4];      
                                                                $_transid = $row[7];
                                                               /* $_sqlamt = "select amount
                                                                       from mis_salary_fund_transfer where account_number='".$_acno."' and fundDetails='".$_fd."' order by id desc";   */
                                                                       
                                                                $_sqlamt = "select amount
                                                                       from mis_salary_fund_transfer where trans_id='".$_transid."' and account_number='".$_acno."' order by id desc";          
                                                                $_tableamt=mysqli_query($con,$_sqlamt);
                                                                
                                                                $i++;
                                                                $_rowtotalamt = 0;
                                                                 while($_rowamt=mysqli_fetch_array($_tableamt)){  
                                                                    $_rowtotalamt = $_rowtotalamt + $_rowamt[0]; 
                                                                 }
                                                                
                                                                $total = $total + $_rowtotalamt;
                                                        ?>
                                                    <tr>
                                                         <td><input type="hidden" name='apps[]' value="<? echo $id; ?>"><? echo $i ?></td>
                                                        <!--<td><input type='checkbox' readonly id="checkbox_<? echo $i; ?>" name='apps[]' value="<? echo $id; ?>" onclick="deductamt(<? echo $i; ?>)"></td>-->
                                                         <td><? echo $row[0] ?></td>  
                                                         <td><? echo $row[1] ?></td>  
                                                         <td><? echo $row[2] ?></td>  
                                                         <td id="req_amt_<? echo $i; ?>"><? echo $_rowtotalamt ?></td>  
                                                        <!-- <td id="remarks_<? echo $i; ?>"><? echo $row[6] ?></td> 
                                                        <td id="result_<? echo $i; ?>"><a data-toggle="modal" data-req_acc_no="<? echo $row[1]; ?>" data-checkboxid="<? echo $i; ?>" data-req_fund_details="<? echo $row[4]; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Update Remarks</a></td>-->
                                                    </tr>         
                                                <?  } 	}
                                                ?>
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
                                                            <input type="hidden" id="total_requested_amt" value="<? echo $total; ?>">
                                                            <input class="form-control" style="text-align:center;" id="total_req_amt" type="text" readonly value="<? echo $total; ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                       <td>
                                                           <!--<input style="cursor:pointer;" class="btn btn-primary" type="submit" name="submit" value="Done">-->
                                                           <button onclick="checkButton()" style="cursor:pointer;" class="btn btn-primary" type="button" value="Confirm">Done</button>
                                                        
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
         
      <button class="btn btn-danger"><a href="show_salaryfundtransfer_detail.php">Cancel</a></button>          
            
<!-- large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Update</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Update Remarks </h6>
          <div class="card">
            <div class="card-block">
               
                <form>
                    <div class="row">
                        <input type="hidden" id="req_acc_no" name="req_acc_no">
                        <input type="hidden" id="checkboxid" name="checkboxid">
                        <input type="hidden" id="fund_details" name="fund_details">
                        
                        <div class="col-sm-4">
                            <label>Account Number</label>
                            <input type="text" readonly id="acc_no" class="form-control">
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


function rejectdeductamt(key){ debugger;
    var total_req_amt = $("#total_req_amt").val();
    var less_req_amt = $("#req_amt_"+key).html();
   // var checked_or_not = $('#checkbox_'+key).prop("checked");
    var new_req_amt = parseFloat(total_req_amt) - parseFloat(less_req_amt);
    
    $("#total_req_amt").val(new_req_amt);
}


$(document).on("click", ".open-AddBookDialog", function () {
     
     var req_fund_details = $(this).data('req_fund_details'); 
     var checkboxid = $(this).data('checkboxid');
     var req_acc_no = $(this).data('req_acc_no');
     $(".modal-body #acc_no").val( req_acc_no );
     $(".modal-body #req_acc_no").val( req_acc_no );
     $(".modal-body #remarks").val( req_fund_details );
     $(".modal-body #checkboxid").val( checkboxid );
     $(".modal-body #fund_details").val( req_fund_details );
});

$('#myModal form').on('submit', function (e) {

          e.preventDefault();
          $("#myModal .btn-success").hide();
          $.ajax({
            type: 'post',
            url: 'update_rnmfund_remarks.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_");
            textmsg = "Remarks Updated Done";
           // $('#reject_'+res[0]).prop('href','#');
            $('#result_'+res[1]).html(textmsg);
            $('#remarks_'+res[1]).html(res[0]);
          //  rejectdeductamt(res[1]);
          //  $('#checkbox_'+res[1]).css('display','none');
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
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

var isalertmsg = <? echo $_resultdata ?>;
if(isalertmsg==1){
    swal("Good job!", "Selected Person Payments Added For Further Process!", "success");  
}
      

</script>




</body>
</html>