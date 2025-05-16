<?php session_start();
if($_SESSION['username']){ 
    include('header.php');
    $app=$_POST['apps'];
    include('config.php');
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style=" overflow: auto;">
                                         
                                             <table id="showfundtransfer" class="table table-bordered table-striped table-hover dataTable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Beneficiary Name</th>
                                                    <td>Account Name/Account No./Bank Name</td>
                                                    <td>IFSC Code</td>
                                                    <td>Amount</td>
                                                    
                                                </tr>
                                                    
                                            </thead>
                                            <tbody>
                                                <?  
                                                $total = 0;
                                                    $trans_id = $_GET['id'];
                                                    $sql="select beneficiary_name,account_number,ifsc_code,amount from mis_salary_fund_transfer where trans_id=".$trans_id;
                                            	    $table=mysqli_query($con,$sql);
                                                    while($row=mysqli_fetch_array($table)){    
                                                        $i++;
                                                        $total = $total + $row[3];
                                                        ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                         <td><? echo $row[0] ?></td>  
                                                         <td><? echo $row[1] ?></td>  
                                                         <td><? echo $row[2] ?></td>  
                                                         <td><? echo $row[3] ?></td>  
                                                        
                                                    </tr>         
                                                <?  } 	
                                                ?>
                                                </tbody>
                                                <tbody>
<tr><td colspan=4 align='right' >TOTAL AMOUNT</td><td align='CENTER' ><?php echo $total; ?></td></tr>

</table></center>


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
  $(document).ready(function(){
       $('#showfundtransfer').DataTable( {
        "bPaginate":   false,
        "dom": 'Bfrtip',
        "responsive": true,
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "info": false
        
    } ); 
  });
</script>
