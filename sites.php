<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

function get_misbranch($id){
    global $con;
    
    $sql = mysqli_query($con,"select * from mis_city where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    
    return $sql_result['city'];
}

?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
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
                                                     <label>Status</label>
                                                     <select id="multiselect_status" class="form-control" name="status">
                                                         <option value="">Select</option>
                                                         <option value="all" <? if(isset($_POST['status'])) { if($_POST['status']=='all'){ echo 'selected' ;  }} ?>>All</option>
                                                         <option value="0" <? if(isset($_POST['status'])) { if($_POST['status']=='0'){ echo 'selected' ;  } } ?>>Engineer Allocated</option>
                                                         <option value="1" <? if(isset($_POST['status'])) { if($_POST['status']=='1'){ echo 'selected' ;  } } ?>>Engineer Not Allocated</option>
                                                         
                                                     </select>
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


                                
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">

                                <?
                                
                                $userid = $_SESSION['userid'];
                                
                                $sql = mysqli_query($con,"select * from mis_loginusers where id='".$userid."'");
                                $sql_result = mysqli_fetch_assoc($sql);
                                
                                $zone = $sql_result['zone'];
                                $branch = $sql_result['branch'];
                                
                                if($zone && $zone!=0){
                                    $zone = explode(',',$zone) ; 
                                    $zone=json_encode($zone);
                                    $zone=str_replace( array('[',']','"') , ''  , $zone);
                                    $zone=explode(',',$zone);
                                    $zone = "'" . implode ( "', '", $zone )."'";
                                    
                                    $zone = " and zone in($zone)" ;
                                }else{
                                    $zone ='' ; 
                                }

                                
                                if($branch && $branch!=0){
                                    $branch = explode(',',$branch) ;
                                    $branch = array_unique($branch);
                                    $city  = [];
                                    
                                        foreach($branch as $key=>$val){
                                            $city[] = get_misbranch($val) ;
                                        }
                                        
                                    $branch=json_encode($city);
                                    $branch=str_replace( array('[',']','"') , ''  , $branch);
                                    $branch=explode(',',$branch);
                                    $branch = "'" . implode ( "', '", $branch )."'";
                                    $branch = " and branch in($branch)"; 
                                }else{
                                    $branch = "";
                                }

                                
                                
                                
                                ?>
                                
                                

                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Activity</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>
                                                    <th>ATMID</th>
                                                    <th>Tracker No</th>
                                                    <th>Address</th>
                                                    <th>city</th>
                                                    <th>State</th>
                                                    <th>Zone</th>
                                                    <th>Branch</th>
                                                    <th>CSS BM Name</th>
                                                    <th>CSS BM Number</th>
                                                    <th>Engineer Name</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? $i = 1 ;
                                                if(isset($_POST['submit'])){
                                                    if($_POST['status']=="all"){
                                                        $atm_sql = "select * from mis_newsite where status= 1 $zone $branch";
                                                        // echo $atm_sql;
                                                    }
                                                    else if($_POST['status']=="1"){
                                                        $atm_sql = "select * from mis_newsite where (engineer_user_id='' || engineer_user_id IS null)  and status= 1 $zone $branch";
                                                    }
                                                    else{
                                                        $atm_sql = "select * from mis_newsite where engineer_user_id!='' and status= 1 $zone $branch";
                                                    }
                                                }else{
                                                    $atm_sql = "select * from mis_newsite where status= 1 $zone $branch";
                                                }
                                                
                                                $atm_sql = mysqli_query($con,$atm_sql);
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql)){
                                                     $engg_user_id = $atm_sql_result['engineer_user_id'];
                                                     if(is_null($engg_user_id) || $engg_user_id==''){
                                                        $eng_name = "-";
                                                     } else {
                                                        //  $eng_name = $engg_user_id;
                                                         $user_sql = mysqli_query($con,"select * from mis_loginusers where id='".$engg_user_id."'");
                                                         if(mysqli_num_rows($user_sql)==0){
                                                             $eng_name = "-";
                                                         }
                                                         else{
                                                           $user_sql_result = mysqli_fetch_assoc($user_sql);
                                                            $eng_name = $user_sql_result['name'];
                                                         }
                                                     }
                                                ?>
                                                 <tr>
                                                     <td><? echo $i; ?></td>
                                                     <td><? echo $atm_sql_result['activity']; ?></td>
                                                     <td><? echo $atm_sql_result['customer']; ?></td>
                                                     <td><? echo $atm_sql_result['bank']; ?></td>
                                                     <td><? echo $atm_sql_result['atmid']; ?></td>
                                                     <td><? echo $atm_sql_result['trackerno']; ?></td>
                                                     
                                                     
                                                     <td><? echo $atm_sql_result['address']; ?></td>
                                                     <td><? echo $atm_sql_result['city']; ?></td>
                                                     <td><? echo $atm_sql_result['state']; ?></td>
                                                     <td><? echo $atm_sql_result['zone']; ?></td>
                                                     <td><? echo $atm_sql_result['branch']; ?></td>
                                                     <td><? echo $atm_sql_result['bm_name']; ?></td>
                                                     <td><? echo $atm_sql_result['bm_number']; ?></td> 
                                                     <td><? echo $eng_name;?></td>
                                                     <td><a href="edit_atm.php?id=<? echo $atm_sql_result['id']; ?>">Edit</a></td>
                                                 </tr>
                                                <? $i++; 
                                                }?>
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