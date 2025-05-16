<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');


?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">


<style>
    
   th.address, td.address {
    white-space: inherit;
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
 <div class="col-md-4">
     <label>Engineer</label>
     <select name="engid" class="form-control">
         <option value=""> Select Engineer </option>
         <? $ac_sql = mysqli_query($con,"SELECT * FROM `mis_loginusers` where designation = 4 order by name asc");
         while($ac_sql_result = mysqli_fetch_assoc($ac_sql)){ ?>
             <option value="<? echo $ac_sql_result['id'];?>" <? if(isset($_POST['name']) && $_POST['name']==$ac_sql_result['name'] ){ echo 'selected'; } ?>>
                 <? echo $ac_sql_result['name'];?>
             </option>
         <? } ?>
     </select>
    </div>
</div>
 
  <div class="col" style="display:flex;justify-content:center;">
     <input type="submit" name="submit" value="Filter" class="btn btn-primary">
 </div>


</form>
    
    <!--Filter End -->
    <hr>
          
      </div>
    </div>
                           <? if($_POST['submit'] && $_POST['engid']){
                                
                           ?>
                               
                           
                                <div class="card">
                                    <div class="card-block" style="overflow: auto;">
                                        
<table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td>Sn No.</td>
                                                    <td>Full Name</td>
                                                    <td>Date of Birth</td>
                                                    <td>Qualification</td>
                                                    <td>Email</td>
                                                    <td>Mobile No</td>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i=1;
                                                $userid = $_POST['engid'];
                               
                                                $statement = mysqli_query($con,"select * from profile_details where user_id = '".$userid."' ");
                                                
                                                while($sql_result = mysqli_fetch_assoc($statement)){
                                                    
                                                $name = $sql_result['name'];
                                                $dob = $sql_result['dob'];
                                                $qualification = $sql_result['qualification'];
                                                $email = $sql_result['email'];
                                                $mob = $sql_result['contact'];
                                                
                                                ?>

                                                <tr>
                                                    <td><? echo $i; ?></td>
                                                    
                                                    <td><? echo $name;?></td>
                                                    <td><? echo $dob; ?> </td>
                                                    <td><? echo $qualification; ?> </td>
                                                    <td><? echo $email; ?> </td>
                                                    <td><? echo $mob; ?> </td>
                                                    
                                                </tr>


    
<? $i++; } ?>
                                            </tbody>
                                        </table>

                                        
                                        
                                    </div>
                                </div>
                                
                            <? } ?>
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