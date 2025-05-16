<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" />
     
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->


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
                                                    
                                                    <th>S.No.</th>
                                                    <th>Beneficiary Name</th>
                                                    <th>Account Number</th>
                                                    <th>IFSC Code</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                   
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?  
                                                $total = 0;
                                                    $trans_id = $_GET['id'];
                                                    $sql="select beneficiary_name,account_number,ifsc_code,approved_amt,id,req_id from mis_fund_transfer where trans_id=".$trans_id;
                                            	    $table=mysqli_query($con,$sql);
                                                    while($row=mysqli_fetch_array($table)){    
                                                        $i++;
                                                        $total = $total + $row[3];
                                                        ?>
                                                    <tr>
                                                        <td><input type='checkbox' id="checkbox_<? echo $i; ?>" name='mydata' value="<? echo $i; ?>" onclick="deductamt(this.value)"></td>
                                                        
                                                        <td><? echo $i; ?></td>
                                                         <td><? echo $row[0] ?></td>  
                                                         <td><? echo $row[1] ?></td>  
                                                         <td><? echo $row[2] ?></td>  
                                                         <td id="req_amt_<? echo $i; ?>"><? echo $row[3] ?></td>  
                                                        <td><a id="reject_<? echo $row[4]; ?>" data-toggle="modal" data-reqid="<? echo $row[4]; ?>" data-checkboxid="<? echo $i; ?>" data-req_amt="<? echo $row[3]; ?>" data-id="<? echo $row[4]; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Reject</a></td>
                                                    </tr>         
                                                <?  } 	
                                                ?>
                                            </tbody>
                                            </table>
                                            <br>
                                            <hr>
                                            <table>
                                                <thead>
                                                
                                                    <th>Total Requested Amount</th>
                                                    <td>
                                                        <input type="hidden" id="total_requested_amt" value="<? echo $total; ?>">
                                                        <input id="total_req_amt" type="text" readonly value="<? echo $total; ?>">
                                                    </td>
                                                
                                                </thead>
                                                <tbody>
                                                    
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
    
   $("#flowcheckall").click(function () {
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
            url: 'process_fundtransfer_action.php',
            data: $('#myModal form').serialize(),
            success: function (msg) { debugger;
            //  alert('form was submitted');
            var res = msg.split("_");
            textmsg = "Rejected Done";
            $('#reject_'+res[0]).prop('href','#');
            $('#reject_'+res[0]).html(textmsg);
            
            rejectdeductamt(res[1]);
            $('#checkbox_'+res[1]).css('display','none');
            $("#myModal .btn-success").show();
            $('#myModal').modal('toggle'); 
            }
          });

        });


</script>




</body>
</html>