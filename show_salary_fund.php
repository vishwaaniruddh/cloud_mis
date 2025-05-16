<? session_start();
include('config.php');

if($_SESSION['username']){ 


                $user_id = $_SESSION['userid'];  
                $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
                $user_sql = mysqli_query($con,$user_statement);
                $user_rowresult = mysqli_fetch_row($user_sql);
                //echo '<pre>';print_r($user_rowresult);echo '</pre>';die;
                $_userlevel = $user_rowresult[0];
                
               if(isset($_POST['submit'])){
                   $month = $_POST['month'];
                   $monthno = date('m',strtotime($month));
                   
                   $year = $_POST['year'];
                   $firstday = $year."-".$monthno."-01";
                   $lastday = date('Y-m-t',strtotime($firstday));
                   $statement = "select * from mis_staff_salary where created_by='".$user_id."' and month='".$month."' 
                                 and salary_date>='".$firstday."' and salary_date<='".$lastday."'";
               }else{
                
                   $statement = "select * from mis_staff_salary where created_by='".$user_id."'";
               }
               
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
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <div class="row">
                                                 
                                                 <div class="col-sm-4">
                        						    <label class="label_label">Month</label>
                            						<select name="month" class="form-control" required>
                        						        <option value="">Select</option>
                                                        <option value="Jan" <? if(isset($_POST['month'])) { if($_POST['month']=='Jan'){ echo 'selected';} }?> >JANUARY</option>
                                                        <option value="Feb" <? if(isset($_POST['month'])) { if($_POST['month']=='Feb'){ echo 'selected';} }?> >FEBRUARY</option>
                                                        <option value="Mar" <? if(isset($_POST['month'])) { if($_POST['month']=='Mar'){ echo 'selected';} }?> >MARCH</option>
                                                        <option value="Apr" <? if(isset($_POST['month'])) { if($_POST['month']=='Apr'){ echo 'selected';} }?> >APRIL</option>
                                                        <option value="May" <? if(isset($_POST['month'])) { if($_POST['month']=='May'){ echo 'selected';} }?> >MAY</option>
                                                        <option value="Jun" <? if(isset($_POST['month'])) { if($_POST['month']=='Jun'){ echo 'selected';} }?> >JUNE</option>
                                                        <option value="Jul" <? if(isset($_POST['month'])) { if($_POST['month']=='Jul'){ echo 'selected';} }?> >JULY</option>
                                                        <option value="Aug" <? if(isset($_POST['month'])) { if($_POST['month']=='Aug'){ echo 'selected';} }?> >AUGUST</option>
                                                        <option value="Sep" <? if(isset($_POST['month'])) { if($_POST['month']=='Sep'){ echo 'selected';} }?> >SEPTEMBER</option>
                                                        <option value="Oct" <? if(isset($_POST['month'])) { if($_POST['month']=='Oct'){ echo 'selected';} }?> >OCTOBER</option>
                                                        <option value="Nov" <? if(isset($_POST['month'])) { if($_POST['month']=='Nov'){ echo 'selected';} }?> >NOVEMBER</option>
                                                        <option value="Dec" <? if(isset($_POST['month'])) { if($_POST['month']=='Dec'){ echo 'selected';} }?> >DECEMBER</option>
                                                    </select>
        
        <br>    
                        						</div>
                        						
                        						<div class="col-sm-4">
                        						    <label class="label_label">Year</label>
                            						<select name="year" class="form-control" required>
                        						        <option value="">Select</option>
                                                        <option value="2020" <? if(isset($_POST['year'])) { if($_POST['year']=='2020'){ echo 'selected';} }?> >2020</option>
                                                        <option value="2021" <? if(isset($_POST['year'])) { if($_POST['year']=='2021'){ echo 'selected';} }?> >2021</option>
                                                        <option value="2022" <? if(isset($_POST['year'])) { if($_POST['year']=='2022'){ echo 'selected';} }?> >2022</option>
                                                    </select>    
            <br>
                        						</div>
                                            </div>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>
                                    
                                    <!--Filter End -->
                                    <hr>
                                          
                                      </div>
                                    </div>
                                <!--Filter Start -->
                                
                                
                                
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                         
         
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
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
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
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                    <?
                                                   
                                                    $i = 0 ; 
                                                    $sql = mysqli_query($con,$statement);
                                                    if(!empty($sql)){
                                                    while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                    $id=$sql_result['id'];
                                                    $_view = 0;
                                                    $_approveview = 0;
                                                    
                                                    ?>
                                                 
                                                    <tr>
                                                        <td><? echo ++$i; ?></td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['ifsc']; ?> </td>
                                                        <td><? echo $sql_result['amount']; ?> </td>
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
                                                        <!--<td><? //echo get_member_name($sql_result['created_by']); ?> </td>-->
                                                        
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        
                                                        <td><? echo $sql_result['remark']; ?> </td>
                                                        <td><? echo $sql_result['uan']; ?> </td>
                                                        <td><? echo $sql_result['esic']; ?> </td>
                                                        

                                                        
                                                    </tr>
                                                <?  }} ?>
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