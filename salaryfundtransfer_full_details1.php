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
                                                    <td>status_remark</td>
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?
                                                $trans_id = $_GET['id'];
                                                $trans_statement = "select * from mis_salary_fund_transfer where trans_id=".$trans_id ; 
                                                $trans_sql = mysqli_query($con,$trans_statement);
                                                $_totalrequestedamt = 0;
                                                while($trans_sql_result = mysqli_fetch_assoc($trans_sql)){ 
                                                   
                                                $req_id=$trans_sql_result['req_id'];
                                                
                                                $statement = "select * from mis_staff_salary where id=".$req_id." order by id desc" ;  
                                                
                                                
                                                $i = 0 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                $id=$sql_result['id'];
                                                
                                                $_sql="select * from mis_salary_fund_requests where status=6 and req_id='".$id."'";
                                                $_table=mysqli_query($con,$_sql);    
                                                
                                                $rowcount=mysqli_num_rows($_table);
                                                
                                                $_view = 0;
                                                
                                                if($rowcount){
                                                    $approved_amt_data = mysqli_fetch_row($_table);
                                                    $approved_actual_amt = $approved_amt_data[2];
                                                
                                                    $_approveview = 0;
                                                    $_view = 1;
                                                 /*   if($_SESSION['userid']==$sql_result['created_by']){
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
                                                    } */
                                                }
                                                $_view = 1;
                                                $approved_actual_amt = $trans_sql_result['amount'];
                                                $i++;
                                                ?>
                                                 <?php if($_view==1){
                                                          $_totalrequestedamt = $_totalrequestedamt + $approved_actual_amt; 
                                                 ?>
                                                    <tr>
                                                        <td><input type='checkbox' id="checkbox_<? echo $i; ?>" name='mydata' value="<? echo $i; ?>" onclick="deductamt(this.value)"></td>
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
                                                        <td><? echo $trans_sql_result['remarks']; ?></td>
                                                        
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