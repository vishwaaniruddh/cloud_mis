<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    $user_id = $_SESSION['userid'];  
    $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
    $user_sql = mysqli_query($con,$user_statement);
    $user_rowresult = mysqli_fetch_row($user_sql);
    $_userlevel = $user_rowresult[0];
  /*  $app=$_POST['apps'];
    $trans_id = $_POST['trans_id'];
    $current_status = $_POST['current_status'];
    $transferred_date = $_POST['transferred_date']; */
    include('config.php');
    $app = array();  $_checklevel = 0;
    $mainsql="select req_id from mis_fund_transfer where";
    if(isset($_POST['submit'])){
        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
        {
        
        $date1 = $_POST['fromdt'] ; 
        $date2 = $_POST['todt'] ;
        }
        if(isset($_POST['current_status']) && $_POST['current_status'] != ''){
            if($_POST['current_status']=="4"){
                $mainsql .= " current_status='4' and transferred_date!='0000-00-00'";
            }
            if($_POST['current_status']=="3"){
                $mainsql .= " current_status!=0 and current_status!=4";
            }
            if($_POST['current_status']=="0"){
                $mainsql .= " current_status='0'";
            }
            if($_POST['current_status']=="2"){
                
                
                $_userlevel = $_POST['level_wise'];
                $userlev = 0;
                $req_id_arr = array();
                if($_userlevel<6){
                    $userlev = $_userlevel;
                $_pendingapprovesql = "select approved_amt,status,req_id from mis_fund_requests where status='".$_userlevel."' and action!=0 
                                       and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
                }else{
                    if($_userlevel==6){
                        $userlev = 2;
                        $_pendingapprovesql = "select approved_amt,status,req_id from mis_fund_transfer where status='2' and current_status!=0 and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
                    }
                    if($_userlevel==7){
                        $userlev = 3;
                        $_pendingapprovesql = "select approved_amt,status,req_id from mis_fund_transfer where status='3' and current_status!=0 and current_status!=4 and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."' order by id desc";
                    }
                } 
   
                $_pendingapprovetable=mysqli_query($con,$_pendingapprovesql);   
                $pendingapproverowcount=mysqli_num_rows($_pendingapprovetable);
                if($pendingapproverowcount>0){
                  while($pendingapprovesql_result = mysqli_fetch_array($_pendingapprovetable)){
                      if($_userlevel<6){
                        $check_statement = "select id,status,action from mis_fund_requests where req_id='".$pendingapprovesql_result[2]."' order by id desc limit 1" ;
                      }else{
                        $check_statement = "select id,status,current_status from mis_fund_transfer where req_id='".$pendingapprovesql_result[2]."' order by id desc limit 1" ;  
                      }
                        $check_sql = mysqli_query($con,$check_statement);
                        $check_rowresult = mysqli_fetch_row($check_sql);
                       // $_userlevel = $check_rowresult[0];
                      
                      if($check_rowresult[1]==$userlev){
                          if($check_rowresult[2]!='0'){
                        array_push($req_id_arr,$check_rowresult[0]);
                          }
                      }
                  }
                } 
                $array_data = implode(',',$req_id_arr);
                //echo '<pre>';print_r($req_id_arr);echo '</pre>';
                 if($_userlevel<6){
                $mainsql = "select req_id from mis_fund_requests where id in (".$array_data.")";
                 }else{
                $mainsql = "select req_id from mis_fund_transfer where id in (".$array_data.")";     
                 }
                $_checklevel = 1;
               // echo $mainsql;
            }
        }
        if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
        {
        
       
        $mainsql .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
       // $mainsql .=" and CAST(a.created_at AS DATE) >= '".$date1."' and CAST(a.created_at AS DATE) <= '".$date2."'";
        }
        if($_checklevel==1){
            $mainsql .=" group by req_id";
        }
    }
    $maintable=mysqli_query($con,$mainsql);  
    if(mysqli_num_rows($maintable)>0){
    while($maintabledata=mysqli_fetch_array($maintable)){
        array_push($app,$maintabledata[0]);
    }
    }
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
                                         <a href="account_dashboard.php">Back Dashboard</a>
                                         <form action="showfundtransferaction1.php" method="POST" id="form">
                                             <table id="showfundtransfer" class="table table-bordered table-striped table-hover dataTable showfundtransfer no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Beneficiary Name</th>
                                                    <td>Account Number</td>
                                                    <td>IFSC Code</td>
                                                    <td>Transferred Amount</td>
                                                    <td>Rejected Amount</td>
                                                    <td>Status</td>
                                                    <td>Transfer Date</td>
                                                    <td>Trans ID</td>
                                                    <td>Batch No</td>
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
                                                    <td>created_at</td>
                                                    <td>payee_type</td>
                                                    <td>fundDetails</td>
                                                    
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?  
                                                   
                                                    $req_ids = array();
                                                    $accountno_array = array();
                                                    $total=0;$i = 0 ; $totalrejected=0;
                                                	for($x=0;$x<count($app);$x++){  
                                                	    $checkrnmsql="select * from rnm_fund where id='".$app[$x]."'";
                                                    	$rnmtable=mysqli_query($con,$checkrnmsql);    
                                                        $countrnm=mysqli_num_rows($rnmtable);
                                                	   if($countrnm>0){ 
                                                	    $view = 1; 
                                                	    array_push($req_ids,$app[$x]);
                                                	    $_customer_total_amt = 0;
                                                    	if($_userlevel>5){
                                                        	$sql="select * from mis_fund_transfer where req_id='".$app[$x]."'";
                                                    	    
                                                            $table=mysqli_query($con,$sql);    
                                                            $row=mysqli_fetch_row($table);
                                                            $trans_id = $row[1];
                                                           
                                                            
                                                            $_customer_total_amt = $row[4];
                                                            
                                                            $currentsql="select current_status,transferred_date from mis_fund_transfer where req_id='".$app[$x]."'";  
                                                            $currenttable=mysqli_query($con,$currentsql);    
                                                            $currentrow=mysqli_fetch_row($currenttable);
                                                            $_currentstatus = $currentrow[0];
                                                            $transferred_date = $currentrow[1];
                                                           if($_currentstatus!=0){
                                                            $total = $total + $_customer_total_amt;
                                                           }else{
                                                            $totalrejected = $totalrejected + $_customer_total_amt;
                                                           }
                                                    	}else{
                                                    	    $sql = "select id,status,req_id,req_amt,approved_amt from mis_fund_requests where req_id='".$app[$x]."' order by id desc limit 1" ;
                                                            $table = mysqli_query($con,$sql);
                                                            $row = mysqli_fetch_row($table);
                                                            $_customer_total_amt = $row[4];
                                                            $total = $total + $_customer_total_amt;
                                                            $totalrejected = 0;
                                                            $_currentstatus = 3;
                                                    
                                                    	    
                                                    	}
                                                     /*  if($transferred_date=='0000-00-00'){
                                                           if($_currentstatus==0){
                                                               $view = 0;
                                                           }
                                                       } */
                                                       if($view==1){ $i++;
                                                           $req_id = $app[$x];
                                                           $statement = "select * from rnm_fund where id=".$req_id." order by id desc" ;  
                                                           $rnm_fundsql = mysqli_query($con,$statement);
                                                           while($sql_result = mysqli_fetch_assoc($rnm_fundsql)){ 
                                                       
                                                        ?>
                                                    <tr>
                                                         <td><? echo $i; ?></td>
                                                         <td><? echo $sql_result['beneficiary_name'] ?></td>  
                                                         <td><? echo $sql_result['account_number'] ?></td>  
                                                         <td><? echo $sql_result['ifsc_code'] ?></td>  
                                                         <td><? if($_currentstatus!=0){echo $_customer_total_amt;} ?></td>  
                                                         <td><? if($_currentstatus==0){echo $_customer_total_amt;} ?></td> 
                                                         <td><? if($_currentstatus==0){ echo 'Rejected';}
                                                                if($_currentstatus==3){ echo 'In Process';}
                                                                if($_currentstatus==4){ 
                                                                    if($transferred_date!='0000-00-00')
                                                                        echo 'Transferred';
                                                                    else
                                                                        echo 'Transferred but Transfer Date missing';
                                                                }
                                                                //echo ' Trans:'.$trans_id;
                                                             ?> 
                                                         </td>     
                                                         <td><? if($_currentstatus==4 && $transferred_date!='0000-00-00'){ echo $transferred_date;} ?></td>
                                                         <td><? echo $trans_id; ?></td>
                                                        <td><? echo $row[6]; ?></td>
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
                                                        <td><? echo date('d M Y',strtotime($sql_result['created_at']));?></td>
                                                        <td><? echo $sql_result['payee_type']; ?> </td>
                                                        <td><? echo $sql_result['fundDetails']; ?> </td>
                                                        
                                                    </tr>         
                                                <? } } 
                                                }}
                                                ?>
                                                </tbody>
                                                <tbody>
<tr><td colspan=4 align='right' >TOTAL AMOUNT</td><td><?php echo $total; ?></td><td><?php echo $totalrejected; ?></td></tr>

</table>
<center>
    
    <input type='hidden' name='reqs' value='<?php echo json_encode($req_ids); ?>' />
    <input type="hidden" name="trans_id" value="<? echo $trans_id; ?>">
  
    
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

   /*
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
            
            var res = msg.split("_");
            textmsg = "Rejected Done";
            $('#reject_'+res[1]).prop('href','#');
            $('#reject_'+res[1]).html(textmsg);
            
         
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
            
            var res = msg.split("_");
            textmsg = "Transfer Date Done";
            $('#transfer_'+res[1]).prop('href','#');
            $('#transfer_'+res[1]).html(textmsg);
            
          
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
  */
</script>


