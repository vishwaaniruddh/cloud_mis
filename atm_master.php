<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
  
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <script>

        

    function disable(id){

        Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    
       jQuery.ajax({
                type: "POST",
                url: 'disable_site.php',
               data: 'id='+id,
                    success:function(msg) {
                        
                        if(msg==1){
                                Swal.fire(
                                  'Deleted!',
                                  'SITE has been deleted.',
                                  'success'
                                );
                                
                                setTimeout(function(){ 
                            window.location.reload();
                        }, 2000);
                        
                        }else if(msg==0 || msg==2){
                            
                            Swal.fire(
                             'Cancelled',
                              'Your imaginary file is safe :)',
                              'error'
                                );
                                
                                

                        }
                        
                    }
       });


  }
})

    }


    	
function setAttValue()

{

// Sets the title to 'Test'

Xrm.Page.getAttribute("title").setValue("Test");

}


    $(document).ready(function(){
      // disable(id);
      // setAttValue();
    });
    
    
    
    </script>



   
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">

                                
                                
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        <a href="add_site.php" style="color:blue; text-decoration:underline;">Add Site +</a>
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Activity</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>
                                                    <th>ATMID1</th>
                                                    <th>ATMID2</th>
                                                    <th>ATMID3</th>
                                                    <th>Tracker No</th>
                                                    
                                                    <th>Address</th>
                                                    <th>city</th>
                                                    <th>State</th>
                                                    <th>Zone</th>
                                                    <th>Branch</th>
                                                    <th>CSS BM Name</th>
                                                    <th>CSS BM Number</th>
                                                    <th>Edit</th>
                                                    <th>Disable Site</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? $i = 1 ;
                                                $atm_sql = mysqli_query($con,"select * from mis_newsite where status=1");
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql)){ ?>
                                                 <tr>
                                                     <td><? echo $i; ?></td>
                                                     <td><? echo $atm_sql_result['activity']; ?></td>
                                                     <td><? echo $atm_sql_result['customer']; ?></td>
                                                     <td><? echo $atm_sql_result['bank']; ?></td>
                                                     <td><? echo $atm_sql_result['atmid']; ?></td>
                                                     <td><? echo $atm_sql_result['atmid2']; ?></td>
                                                     <td><? echo $atm_sql_result['atmid3']; ?></td>
                                                     
                                                     <td><? echo $atm_sql_result['trackerno']; ?></td>
                                                     <td><? echo $atm_sql_result['address']; ?></td>
                                                     <td><? echo $atm_sql_result['city']; ?></td>
                                                     <td><? echo $atm_sql_result['state']; ?></td>
                                                     <td><? echo $atm_sql_result['zone']; ?></td>
                                                     <td><? echo $atm_sql_result['branch']; ?></td>
                                                     <td><? echo $atm_sql_result['bm_name']; ?></td>
                                                     <td><? echo $atm_sql_result['bm_number']; ?></td> 
                                                     <td><a href="edit_atm.php?id=<? echo $atm_sql_result['id']; ?>">Edit</a></td>
                                                     <th><a href="#" onclick="disable(<? echo $atm_sql_result['id']; ?>)">Disable</a></th>
                                                 </tr>
                                                <? $i++;}?>
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