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
                                                   <!-- <td>approval_amount</td> -->
                                                    <td>required_amount</td>
                                                    <td>account_number</td>
                                                    <td>beneficiary_name</td>
                                                    <td>ifsc_code</td>
                                                   
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                $trans_id = $_GET['id'];
                                                $trans_statement = "select * from mis_fund_transfer where trans_id=".$trans_id ; 
                                                $trans_sql = mysqli_query($con,$trans_statement);
                                                
                                                while($trans_sql_result = mysqli_fetch_assoc($trans_sql)){ 
                                                $req_id=$trans_sql_result['req_id'];
                                                
                                                $statement = "select * from rnm_fund where id=".$req_id." order by id desc" ;  
                                                $_totalrequestedamt = 0;
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['id'];
                                                
                                                $_sql="select * from mis_fund_requests where status=5 and action=1 and req_id='".$id."'";
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
                                                        
                                                        if($level==5){
                                                             $_view = 1;
                                                        }
                                                    }
                                                }
                                                $i++;
                                                ?>
                                                 <?php if($_view==1){
                                                          $_totalrequestedamt = $_totalrequestedamt + $approved_actual_amt; 
                                                 ?>
                                                    <tr>
                                                        <td><input type='checkbox' id="checkbox_<? echo $i; ?>" name='mydata' value="<? echo $i; ?>" onclick="deductamt(this.value)"></td>
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
                                                        <!--<td><? //echo $sql_result['approval_amount']; ?> </td>-->
                                                        <td id="req_amt_<? echo $i; ?>"><? echo $approved_actual_amt; ?> </td>
                                                        <td><? echo $sql_result['account_number']; ?> </td>
                                                        <td><? echo $sql_result['beneficiary_name']; ?> </td>
                                                        <td><? echo $sql_result['ifsc_code']; ?> </td>

                                                        
                                                    </tr>
                                                <? } } }?>
                                            </tbody>
                                            </table>
                                            <br>
                                            <hr>
                                            <table>
                                                <thead>
                                                
                                                    <th>Total Requested Amount</th><td><input id="total_req_amt" type="text" readonly value="<? echo $_totalrequestedamt; ?>"></td>
                                                
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
        //$('#flow-table tbody input[type="checkbox"]').prop('checked', this.checked);
        var cols = oTableStaticFlow.column(0).nodes(),
            state = this.checked;
        
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



</script>




</body>
</html>