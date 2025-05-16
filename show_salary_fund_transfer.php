<? session_start();
include('config.php');

if($_SESSION['username']){ 
$_resultdata = 0;
include('header.php');
if(isset($_POST['apps'])){ 
    if(!empty($_POST['apps'])){
        $app=$_POST['apps'];
        if(!empty($app)){
            // echo '<pre>';print_r($app);echo '</pre>';die;
             for($x=0;$x<count($app);$x++){  
                $req_id = $app[$x];
                $action = 1;
                $status = 5;
                $created_date = date('Y-m-d');
                $created_by = $_SESSION['userid'];
                
                
                $requestedusersql="select amount from mis_staff_salary where id='".$app[$x]."'";
                $_table=mysqli_query($con,$requestedusersql);    
                $_row=mysqli_fetch_row($_table);
                
                $remarks = "";
                $amount = $_row[0];
                
                
                $insertsql = "insert into mis_salary_fund_requests(req_id,amount,created_by,action,remarks,created_date,status) 
                        values('".$req_id."','".$amount."','".$created_by."','".$action."','".$remarks."','".$created_date."','".$status."')";
                mysqli_query($con,$insertsql);
                
                $updatesql = "update mis_staff_salary SET status= '".$status."' WHERE id = ".$req_id; 
                mysqli_query($con,$updatesql);
                
                $_resultdata = 1;
             }
        }
    }
}
$postview = 0;
if(isset($_POST['SelectDept'])){
    if($_POST['SelectDept']=='Search'){
        $department = $_POST['department'];
        $particulars = $_POST['particulars'];
        if($particulars!=""){
        $statement = "select * from mis_staff_salary where status=1 and department='".$department."' and particulars='".$particulars."' order by id desc" ;  
        }else{
           $statement = "select * from mis_staff_salary where status=1 and department='".$department."' order by id desc" ;   
        }
        $postview = 1;
    }
    
}


            $total_data = "select sum(amount),department from mis_staff_salary where status=1 group by department order by id desc" ;  
            $totsql = mysqli_query($con,$total_data);
            $tot_team_sql = mysqli_query($con,$total_data);
            
            $total_particulardata = "select sum(amount),particulars from mis_staff_salary where status=1 and particulars!='' group by particulars order by id desc" ;  
            $totparticularsql = mysqli_query($con,$total_particulardata);
            $tot_particular_sql = mysqli_query($con,$total_particulardata);

?>
<link href="sweetalert/sweetalert.css" rel="stylesheet">
<script src="sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet" />


     
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->

 
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                               <!-- <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                        <div class="row">
                                            <? while($tot_sql_result = mysqli_fetch_array($totsql)){  ?>
                                            <div class="col-md-4">
                                                <? echo $tot_sql_result[1];?> (<? echo $tot_sql_result[0];?>)
                                            </div>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                        
                                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <div class="col-sm-4">
                        						    <label class="label_label">Department</label>
                            						<select name="department" class="form-control" required>
                        						        <option value="">Select</option>
                        						        <? while($tot_team_sql_result = mysqli_fetch_array($tot_team_sql)){  ?>
                                                        <option value="<? echo $tot_team_sql_result[1];?>" <? if(isset($_POST['department'])){ if($_POST['department']==$tot_team_sql_result[1]){ echo 'selected'; } }?> ><? echo $tot_team_sql_result[1];?></option>
                                                        <? } ?>
                                                    </select>    
            
                        					</div>
                        					<div class="col-sm-4">
                        						    <label class="label_label">Particulars</label>
                            						<select name="particulars" class="form-control">
                        						        <option value="">Select</option>
                        						        <? while($tot_particular_sql_result = mysqli_fetch_array($tot_particular_sql)){  ?>
                                                        <option value="<? echo $tot_particular_sql_result[1];?>" <? if(isset($_POST['particulars'])){ if($_POST['particulars']==$tot_particular_sql_result[1]){ echo 'selected'; } }?> ><? echo $tot_particular_sql_result[1];?></option>
                                                        <? } ?>
                                                    </select>    
            
                        					</div>
                        					<div class="col-sm-4">
                                                <br>
                                                <input type="submit" name="SelectDept" value="Search" class="btn btn-success">
                                            </div>
                                        </form>
                                        
                                        <form id="form" action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <table id="myTable" class="table table-bordered table-striped table-hover dataTable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="check"><input type="checkbox" id="flowcheckall" value="" />&nbsp;All</th>
                                                    <td>account_number</td>
                                                    <td>ifsc_code</td>
                                                    <td>amount</td>
                                                    <td>company</td>
                                                    <td>categories</td>
                                                    <td>staff_type</td>
                                                    <td>payee_name</td>
                                                    <td>customer</td>
                                                    
                                                    <td>emp_code</td>
                                                    <td>beneficiary_name</td>
                                                    <td>beneficiary_name_fencer</td>
                                                    
                                                    <td>department</td>
                                                    <!--<td>status</td>-->
                                                    <td>email_body</td>
                                                    <!--<td>added_pos</td>-->
                                                    <td>state</td>
                                                    <td>branch_location</td>
                                                    <td>sup_name</td>
                                                    <td>bank</td>
                                                    <td>atm_id</td>
                                                    <td>month</td>
                                                    <td>salary_date</td>
                                                    <td>required_by</td>
                                                    <td>created_date</td>
                                                    <td>remark</td>
                                                    <td>uan</td>
                                                    <td>esic</td>
                                                    <th>Action</th>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                if($postview==0){
                                                   $statement = "select * from mis_staff_salary where status=1 order by id desc" ;  
                                                }
                                                $_totalrequestedamt = 0;
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                    $id=$sql_result['id'];
                                                    $approved_actual_amt = $sql_result['amount'];
                                                    $i++;
                                                    $_totalrequestedamt = $_totalrequestedamt + $approved_actual_amt;
                                                     ?>
                                                    <tr>
                                                        <td>
                                                            
                                                            <input type='checkbox' id="checkbox_<? echo $i; ?>" name='apps[]' value="<? echo $id; ?>" onclick="deductamt(<? echo $i; ?>)">
                                                           
                                                        </td>
                                                        
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['ifsc']; ?> </td>
                                                        
                                                        <td id="req_amt_<? echo $i; ?>"><? echo $approved_actual_amt; ?> </td>
                                                        <td><? echo $sql_result['company']; ?> </td>
                                                        <td><? echo $sql_result['categories']; ?> </td>
                                                        <td><? echo $sql_result['staff_type']; ?> </td>
                                                        <td><? echo $sql_result['payee_name']; ?> </td>
                                                        <td><? echo $sql_result['customer']; ?> </td>
                                                        <td><? echo $sql_result['emp_code']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name_fencer']; ?> </td>
                                                        
                                                        <td><? echo $sql_result['department']; ?> </td>
                                                        <td><? echo $sql_result['email_body']; ?> </td>
                                                        <td><? echo $sql_result['state']; ?> </td>
                                                        <td><? echo $sql_result['branch_location']; ?> </td>
                                                        <td><? echo $sql_result['sup_name']; ?> </td>
                                                        <td><? echo $sql_result['bank']; ?></td>
                                                        <td><? echo $sql_result['atm_id']; ?> </td>
                                                        <td><? echo $sql_result['month']; ?> </td>
                                                        <td><? echo $sql_result['salary_date']; ?> </td>
                                                        <td><? echo $sql_result['required_by']; ?> </td>
                                                        
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        
                                                        <td><? echo $sql_result['remark']; ?> </td>
                                                        <td><? echo $sql_result['uan']; ?> </td>
                                                        <td><? echo $sql_result['esic']; ?> </td>
                                                        
                                                        
                                                       <!-- <td id="remarks_<? //echo $i; ?>"><? //echo $sql_result['remark']; ?> </td> -->
                                                        
                                                        <td><!--<a id="reject_<? echo $i; ?>" data-toggle="modal" data-reqid="<? echo $sql_result['id']; ?>" data-checkboxid="<? echo $i; ?>" data-req_amt="<? echo $approved_actual_amt; ?>" data-id="<? echo $sql_result['id']; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Reject</a>--></td>
 <!--<td><a data-toggle="modal"  data-checkboxid="<? echo $i; ?>" data-req_amt="<? echo $approved_actual_amt; ?>" data-id="<? echo $sql_result['id']; ?>" class="open-AddBookDialog btn btn-danger" href="#myModal">Update Remarks</a></td>-->
                                                        
                                                    </tr>
                                                <?  } ?>
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
                                                          <!-- <input style="cursor:pointer;" class="btn btn-primary" type="submit" name="submit" value="Payments">-->
                                                           <button onclick="checkButton()" style="cursor:pointer;" class="btn btn-primary" type="button" value="Confirm">Done</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                         </form>  
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
                            <label>Rejected Remarks</label>
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
            url: 'process_fund_reject.php',
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