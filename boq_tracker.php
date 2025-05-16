<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
     
     
     <script>
         $(document).ready(function() {
             $('#example').DataTable( {
        	    "order": [],
        		"processing": true,
        		"serverSide": true,
        		"ajax": "json/get_boq.php",
        		"columnDefs": [
        		    {
        		        "render": createManageBtn,
        		        "data": 5,
        		        "targets": [0]
        		    }
        		    ],
        	});
         });

        function createManageBtn() {
            return '<button id="manageBtn" type="button" class="btn btn-success btn-xs"> Action </button>';
        }
        
        var table;
$(document).ready( function () {
 table  = $('#example').DataTable();
} );


$('body').on('click', '#manageBtn', function(){
        var row  = $(this).parents('tr')[0];
        let data =  table.row( row ).data() 
        var id = data[1];   
        // window.location.href="edit_supplier_bill_entry.php?id="+id ; 
});



     </script>
     
     
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style="overflow: scroll;">
                                        <h5>BOQ TRACKER</h5>
                                        <hr>
                                            <table id="example" class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <td>Actions</td>
                                                        <td>Sr.No</td>
                                                        <td>ATMID</td>
                                                        <td>ATMID2</td>
                                                        <td>ATMID3</td>
                                                        <td>Serial Number</td>
                                                        <td>Bank</td>
                                                        <td>Customer</td>
                                                        <td>Address</td>
                                                        <td>City</td>
                                                        <td>State</td>
                                                        <td>Pincode</td>
                                                        <td>Engineer Name</td>
                                                        <td>Engineer Number</td>
                                                        <td>BM</td>
                                                        <td>Selection Type</td>
                                                        <td>Created AT</td>
                                                        
                                                    </tr>
                                                </thead>
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



</body>

</html>