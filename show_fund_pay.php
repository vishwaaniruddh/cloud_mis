<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    $app=$_POST['apps'];
    include('config.php');
?>
<link href="sweetalert/sweetalert.css" rel="stylesheet">
<script src="sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
function Validate(form)
{
with(form)
{
if(chqname=='')
{
alert("Please provide Chq name");
chqname.focus();
return false;
}
if(chqno=='')
{
alert("Please provide Chq number");
chqno.focus();
return false;
}
}
return true;
}
</script>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                         <form action="cmsexp.php" method="POST">
                                             <? for($x=0;$x<count($app);$x++){ ?>
                                             <input type="hidden" name="apps[]" value="<? echo $app[$x]; ?>">
                                             <? } ?>
                                             <input type="submit" value="Excel">
                                         </form> 
                                         <form action="showfundtransfer.php" method="POST" id="form">
                                             <table id="showfundtransfer" class="table table-bordered table-striped table-hover dataTable showfundtransfer no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Beneficiary Name</th>
                                                    <td>Account Number</td>
                                                    <td>IFSC Code</td>
                                                    <td>Amount</td>
                                                    
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?  $req_ids = array();
                                                    $accountno_array = array();
                                                    $total=0;$i = 0 ; 
                                                	for($x=0;$x<count($app);$x++){  
                                                	    array_push($req_ids,$app[$x]);
                                                	    $_customer_total_amt = 0;
                                                    	$sql="select * from rnm_fund where id='".$app[$x]."'";
                                                	    $view = 0; 
                                                        $table=mysqli_query($con,$sql);    
                                                        $row=mysqli_fetch_row($table);
                                                        if(!in_array($row[20],$accountno_array)){
                                                           $accs=mysqli_query($con,"select * from rnm_fund where account_number=".$row[20]); 
                                                           while($accr=mysqli_fetch_array($accs)){
                                                               if(in_array($accr[0],$app)){
                                                                   $req_amt_data=mysqli_query($con,"select approved_amt from mis_fund_requests where req_id=".$accr[0]." order by id desc");
                                                                   $req_row_amt = mysqli_fetch_row($req_amt_data);
                                                                     $_customer_total_amt = $_customer_total_amt + $req_row_amt[0];
                                                             //  $_customer_total_amt = $_customer_total_amt + $accr[19];
                                                               }
                                                           }
                                                           array_push($accountno_array,$row[20]);
                                                           $view = 1;
                                                        }
                                                        
                                                       // echo '<pre>';print_r($row);echo '</pre>';die;
                                                       $total = $total + $_customer_total_amt;
                                                       if($view==1){ $i++;
                                                        ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                         <td><? echo $row[21] ?></td>  
                                                         <td><? echo $row[20] ?></td>  
                                                         <td><? echo $row[22] ?></td>  
                                                         <td><? echo $_customer_total_amt ?></td>  
                                                        
                                                    </tr>         
                                                <?  } 	}
                                                ?>
                                                </tbody>
                                                <tbody>
<tr><td colspan=4 align='right' >TOTAL AMOUNT</td><td align='CENTER' ><?php echo $total; ?></td></tr>

</table>
<center>
    
    <input type='hidden' name='reqs' value='<?php echo json_encode($req_ids); ?>' />
    
  <!-- <input type="hidden" name="submit" value="Done">-->
    <button onclick="checkButton()" style="cursor:pointer;" class="btn btn-primary" type="button" value="Confirm">Done</button>
<!--<input class="btn btn-primary" name="submit" type="submit" value="Done">--><button class="btn btn-danger"><a href="show_fundaccount_detail.php">Cancel</a></button>
</center>
 </form>
</div></div></div></div></div></div></div>
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
            
  
</script>


