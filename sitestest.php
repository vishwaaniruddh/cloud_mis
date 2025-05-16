<?php session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

function get_misstate($id){
    global $con;
    $sql = mysqli_query($con,"select * from mis_newsite where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['state'];
}
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
 <style>
    .select2-container .select2-selection--single{height: auto !important; }
    .select2-selection__choice {background-color:cyan; }
}
 </style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                            <div class="row">
                                                 
                                                <div class="col-md-3">
                                                    <label>Status</label>
                                                    <select id="multiselect_status" class="form-control" name="status">
                                                        <option value=""> Select </option>
                                                        <option value="all" <?php if(isset($_POST['status'])) { if($_POST['status']=='all'){ echo 'selected' ;  }} ?>>All</option>
                                                        <option value="0" <?php if(isset($_POST['status'])) { if($_POST['status']=='0'){ echo 'selected' ;  } } ?>>Engineer Allocated</option>
                                                        <option value="1" <?php if(isset($_POST['status'])) { if($_POST['status']=='1'){ echo 'selected' ;  } } ?>>Engineer Not Allocated</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>ATMID</label>
                                                    <input type="text" id="atmid" class="form-control" list="atmidOptions" name="atmid" value="<?= $_REQUEST['atmid'];?>">
                                                    <datalist id="atmidOptions"></datalist>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>Customer</label>
                                                    <select name="cust" class="form-control mdb-select md-form" searchable="Search here..">
                                                        <!--<option value="">Select</option>-->
                                                        <option value="" selected>Choose Customer</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $custlist= mysqli_query($con,"SELECT id,customer from mis_newsite where customer!='' group by customer ");
    											        while($fetch_data = mysqli_fetch_assoc($custlist)){
    											     ?>
											        <option value="<?php echo $fetch_data['customer'] ?>" <?php if($_POST['cust']== $fetch_data['customer']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['customer'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>engineer</label>
                                                    <select name="engineer" class="form-control js-example-basic-single" searchable="Search here..">
                                                        <!--<option value="">Select</option>-->
                                                        <option value=""  selected>Choose Engineer</option>
                                                        <?php 
                                                        // $i = 0;
                                                        $englist= mysqli_query($con,"SELECT engineer_user_id from mis_newsite where engineer_user_id !='' and engineer_user_id != '0' group by engineer_user_id ");
    											        while($fetch_data = mysqli_fetch_assoc($englist)){
    											            if(mysqli_num_rows($englist)>0){
    											            $engid = $fetch_data['engineer_user_id'];
    											            
											            $engname = mysqli_query($con,"select id,name from mis_loginusers where id = '".$engid."' ");
											            $fetch_eng = mysqli_fetch_assoc($engname);
											            
    											            
    											            
    											     ?>
											        <option value="<?php echo $fetch_eng['id'] ?>" <?php if($_POST['engineer']== $fetch_eng['id']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_eng['name'];?>
											         </option>
											         <?php } } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>BM</label>
                                                    <select name="bm" class="form-control js-example-basic-single" searchable="Search here..">
                                                        <!--<option value="">Select</option>-->
                                                        <option value=""  selected>Choose BM</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $bmlist= mysqli_query($con,"SELECT id,bm_name from mis_newsite where bm_name!='' and bm_name!='-' group by bm_name ");
    											        while($fetch_data = mysqli_fetch_assoc($bmlist)){
    											     ?>
											        <option value="<?php echo $fetch_data['bm_name'] ?>" <?php if($_POST['bm'] == $fetch_data['bm_name']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['bm_name'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>state</label>
                                                    <select name="state" class="form-control js-example-basic-single" searchable="Search here..">
                                                        <!--<option value="">Select</option>-->
                                                        <option value=""  selected>Choose State</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $statelist= mysqli_query($con,"SELECT id,state from mis_newsite where state!='' group by state ");
    											        while($fetch_data = mysqli_fetch_assoc($statelist)){
    											     ?>
											        <option value="<?php echo $fetch_data['state'] ?>" <?php if($_POST['state'] == $fetch_data['state']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['state'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>zone</label>
                                                    <select name="zone" class="form-control mdb-select md-form" searchable="Search here..">
                                                        <!--<option value="">Select</option>-->
                                                        <option value=""  selected>Choose Zone</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $zonelist= mysqli_query($con,"SELECT id,zone from mis_newsite where zone!='' and zone!='select' group by zone ");
    											        while($fetch_data = mysqli_fetch_assoc($zonelist)){
    											     ?>
											        <option value="<?php echo $fetch_data['zone'] ?>" <?php if($_POST['zone'] == $fetch_data['zone']) { echo 'selected'; }  ?>>
											         <?php echo $fetch_data['zone'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>Site Status</label>
                                                    <select id="multiselect_status" class="form-control" name="site_status">
                                                        <option value=""> Select </option>
                                                        <option value="1" <?php if(isset($_POST['site_status'])) { if($_POST['site_status']=='1'){ echo 'selected' ;  }} ?>>Active</option>
                                                        <option value="0" <?php if(isset($_POST['site_status'])) { if($_POST['site_status']=='0'){ echo 'selected' ;  } } ?>>In-Active</option>
                                                    </select>
                                                </div>
                                                 
                                            </div>
                                            <br>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>
                                    
                                    <!--Filter End -->
                                    <hr>
                                          
                                      </div>
                                    </div>


                            <?php if($_POST['submit']) {
                                   
                                if($_POST['status']=="all"){
                                    // echo 'all';
                                    $atm_sql = "select serviceExecutive,id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,pincode,live_date from mis_newsite where 1 ";
                                }
                                else if($_POST['status']=="1"){
                                    // echo 1;
                                    $atm_sql = "select serviceExecutive,id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,pincode,live_date from mis_newsite where (engineer_user_id='' || engineer_user_id IS null) ";
                                }else if($_POST['status']==""){
                                    $atm_sql = "select serviceExecutive,id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,pincode,live_date from mis_newsite where 1 ";
                                }
                                
                                //     else if(isset($_POST['atmid']) && $_POST['atmid']!=''){
                                //     $atmid = $_POST['atmid'];
                                    
                                //     $atmid = json_encode($atmid);
                                //     $atmid = str_replace(array('[', ']', '"'), '', $atmid);
                                //     $arr_atmid = explode(',', $atmid);
                                //     $atmid = "'" . implode("', '", $arr_atmid) . "'";
                                    
                                //     // echo 111; 
                                //     // print_r($atmid);
                                //     // $atm_sql = "select id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status from mis_newsite where id in ($atmid)  and status= 1 ";
                                //     $atm_sql .= "and id in (".$atmid.")" ;
                                // }
                                
                                else{
                                    // echo "else";
                                    $atm_sql = "select serviceExecutive,id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,pincode,live_date from mis_newsite where engineer_user_id!=''  ";
                                }
                            }else{
                                // echo "another";
                                $atm_sql = "select serviceExecutive,id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status,pincode,live_date from mis_newsite where status= 1 ";
                            } 
                            
                            
                            if(isset($_POST['atmid']) && $_POST['atmid']!=''){
                                $atmid = $_POST['atmid'];
                                
                                $atmid = json_encode($atmid);
                                $atmid = str_replace(array('[', ']', '"'), '', $atmid);
                                $arr_atmid = explode(',', $atmid);
                                $atmid = "'" . implode("', '", $arr_atmid) . "'";
                                
                                // echo 111; 
                                // $atm_sql = "select id,engineer_user_id,activity,customer,bank,atmid,trackerno,address,city,state,zone,branch,bm_name,bm_number,status from mis_newsite where id in ($atmid)  and status= 1 ";
                                $atm_sql .= "and atmid in (".$atmid.")" ;
                            }
                            
                            if(isset($_POST['cust']) && $_POST['cust']!='')
                            {
                                $atm_sql .=  "and customer = '".$_POST['cust']."' ";
                            }
                               
                            if(isset($_POST['zone']) && $_POST['zone']!='')
                            {
                                $atm_sql .=  "and zone = '".$_POST['zone']."' ";
                            }
                            
                            if(isset($_POST['state']) && $_POST['state']!='')
                            {
                                $atm_sql .=  "and state= '".$_POST['state']."' ";
                            }
                            
                            if(isset($_POST['bm']) && $_POST['bm']!='')
                            {
                                $atm_sql .=  "and bm_name = '".$_POST['bm']."' ";
                            }
                            
                            if(isset($_POST['engineer']) && $_POST['engineer']!='')
                            {
                                $atm_sql .=  "and engineer_user_id = '".$_POST['engineer']."' ";
                            }
                            
                            if(isset($_POST['site_status']) && $_POST['site_status']!='')
                            {
                                $atm_sql .=  "and status = '".$_POST['site_status']."' ";
                            }
                               
                               
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                        function getBranchName($id){
                            global $con ;
                            $sql = mysqli_query($con,"select * from mis_city where id='".$id."'");
                            $sql_result = mysqli_fetch_assoc($sql);
                            
                            return $sql_result['city'];
                        }
                        
                        
                        $userid = $_SESSION['userid'];
                        
                        $branch = $_SESSION['branch'];
                        
                        $branch=json_encode($branch);
                        $branch=str_replace( array('[',']','"') , ''  , $branch);
                        $arr=explode(',',$branch);
                        
                        
                        foreach($arr as $arrkey=>$arrvalue){
                            
                            $branch = getBranchName($arrvalue) ;
                            $branchar[] = $branch;
                        }
                        
                        $branch = "'" . implode ( "', '", $branchar )."'";
                        
                        $zone = "'" . implode ( "', '", $arr )."'";
                        $zone = $_SESSION['zone'];
                        $zone=json_encode($zone);
                        $zone=str_replace( array('[',']','"') , ''  , $zone);
                        $arr=explode(',',$zone);
                        $zone = "'" . implode ( "', '", $arr )."'";
                        
                        
                        $cust_id = $_SESSION['cust_id'];
                        $cust_id=json_encode($cust_id);
                        $cust_id=str_replace( array('[',']','"') , ''  , $cust_id);
                        $arr=explode(',',$cust_id);
                        $cust_id = "'" . implode ( "', '", $arr )."'";
                            
                            
                        $atm_sql .=  "and customer in($cust_id) and branch in($branch) and zone in($zone) and status=1";
                            
                            
                            
                            
                            
                                // $atm_sql .= "order by id desc";
                               
                              echo $atm_sql;
                               
                               ?>
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Activity</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>
                                                    <th>Comfort ID</th>
                                                    <th>ATMID</th>
                                                    <th>Tracker No</th>
                                                    <th>Address</th>
                                                    <th>city</th>
                                                    <th>State</th>
                                                    <th>Zone</th>
                                                    <th>Branch</th>
                                                    <th>pincode</th>
                                                    <th>live date</th>
                                                    <th>CSS BM Name</th>
                                                    <th>CSS BM Number</th>
                                                    <th>Service Executive</th>
                                                    <th>Engineer Name</th>
                                                    <th>Status</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ;
                                                if(isset($_POST['submit'])){
                                                    
                                                // echo $atmid; die;
                                                $atm_sql_res = mysqli_query($con,$atm_sql);
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
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
                                                     
                                                     if($atm_sql_result['status']== 1 ){
                                                         $status = "Active";
                                                     } else{ $status = "In-Active"; }
                                                
                                                $customer = $atm_sql_result['customer'];
                                                $bank = $atm_sql_result['bank'];
                                                $id = $atm_sql_result['id'];
                                                
                                                $serviceExecutive = $atm_sql_result['serviceExecutive'] ; 
                                                $serviceExecutiveName = get_member_name($serviceExecutive);
                                                $resultatmid = $atm_sql_result['atmid'] ; 
                                                
                                                $atmcodesql  = mysqli_query($con,"select * from unique_atm_codes where atmid='".$resultatmid."'");
                                                $atmcodesql_result = mysqli_fetch_assoc($atmcodesql);
                                                $atmcode = $atmcodesql_result['unique_code'];
                                                
                                                ?>
                                                
                                                 <tr>
                                                     <td><?php echo $i; ?></td>
                                                     <td><?php echo $atm_sql_result['activity']; ?></td>
                                                     <td><?php echo $atm_sql_result['customer']; ?></td>
                                                     <td><?php echo $atm_sql_result['bank']; ?></td>
                                                     <td><?php echo $atmcode; ?></td>
                                                     
                                                     <td><?php echo $resultatmid ; ?></td>
                                                     <td><?php echo $atm_sql_result['trackerno']; ?></td>
                                                     
                                                     
                                                     <td><?php echo $atm_sql_result['address']; ?></td>
                                                     <td><?php echo $atm_sql_result['city']; ?></td>
                                                     <td><?php echo $atm_sql_result['state']; ?></td>
                                                     <td><?php echo $atm_sql_result['zone']; ?></td>
                                                     <td><?php echo $atm_sql_result['branch']; ?></td>
                                                     <td><?php echo $atm_sql_result['pincode'];?></td>
                                                     <td><?php echo $atm_sql_result['live_date'];?></td>
                                                     <td><?php echo $atm_sql_result['bm_name']; ?></td>
                                                     <td><?php echo $atm_sql_result['bm_number']; ?></td> 
                                                     <td><?php echo $serviceExecutiveName; ?></td>
                                                     <td><?php echo $eng_name;?></td>
                                                     <td>
                                                         <? if($status=='Active'){ ?>
                                                         <a href="inactiveSites.php?id=<? echo $id; ?>&&customer=<? echo $customer; ?>&bank=<? echo $bank; ?>">
                                                             <?php echo $status; ?>
                                                             </a>
                                                         <? }else{ ?>
                                                         <?php echo $status; ?>
                                                         <? } ?>
                                                         
                                                         </td>

                                                     <td><a href="edit_atm_test.php?id=<?php echo $atm_sql_result['id']; ?>">Edit</a></td>
                                                 </tr>
                                                <?php $i++; 
                                                }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <?php include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<?php }
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
     $(document).ready(function() {
        $('.js-example-basic-single').select2();
        // $('.js-example-basic-single').find(':selected');
        // maximumSelectionLength: 100
    });
    
    
    
    
    
    
            $("#atmid").on('input', function () {
            var input = $(this).val();

            $.ajax({
                type: "POST",
                url: 'get_atmidsuggestions.php',
                data: {
                    input: input
                },
                success: function (response) {
                    console.log(response)
                    var datalist = $("#atmidOptions");
                    datalist.empty();

                    var suggestions = JSON.parse(response);

                    suggestions.forEach(function (suggestion) {
                        datalist.append($("<option>").attr('value', suggestion).text(suggestion));
                    });
                }
            });
        });



    
    
</script>


</body>

</html>