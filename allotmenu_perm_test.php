<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('headertest.php');

date_default_timezone_set('Asia/Kolkata');
?>

<style>
    .showsubmenu{
        margin: 0.4% 3%;        
    }

</style>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <?
                                        
                                        
                                        
                                        $updated_at = date("Y-m-d H:i:s");
                                        $updated_by = $_SESSION['userid'];

                                        $user_role = $_GET['id'];  
                                       /* $usersql = mysqli_query($con,"select * from mis_loginusers_test where id='".$userid."'");
                                        $usersql_result = mysqli_fetch_assoc($usersql);
                                        $user_role = $usersql_result['role'];
                                        echo $user_role;die; */
                                        $role_permission = mysqli_query($con,"select * from role_permission where role_id='".$user_role."' ");
                                        if(mysqli_num_rows($role_permission)>0){
                                            $rolesql_result = mysqli_fetch_assoc($role_permission);
                                            $role_id = $rolesql_result['role_id'];
                                            
                                            $user_permission = $rolesql_result['permission'];
                                            $user_permission = explode (",", $user_permission);
                                            
                                            $_cust = $rolesql_result['cust_id'];
                                            $_cust = explode (",", $_cust);
                                            
                                            $_branch = $rolesql_result['branch_id'];
                                            $_branch = explode (",", $_branch);
                                            
                                            $is_insert = 0;
                                        }else{
                                            $user_permission = [];
                                            $is_insert = 1;
                                        }
                                        
                                        // print_r($user_permission); die;
                                        
                                        if(isset($_POST['submit'])){
                                            
                                        
                                        $role_id = $_POST['role_id'];
                                        $will_insert = $_POST['is_insert'];
                                        
                                        $permission =$_POST['sub_menu'];
                                        $permission = implode(',',$permission);
                                        
                                        //  print_r($permission); 
                                        //  echo $role_id;
                                        //  die;
                                        
                                        $customer = $_POST['cust_id'];
                                        $customer = implode(',',$customer);
                                        
                                        $branch = $_POST['branch_id'];
                                        $branch = implode(',',$branch);
                                        
                                        // echo $will_insert;die;
                                        if($will_insert==0) {
                                            $sql = "update role_permission set permission='".$permission."' , cust_id = '".$customer."' , branch_id = '".$branch."' , updated_at = '".$updated_at."', updated_by = '".$updated_by."' where role_id='".$role_id."' ";
                                        }
                                        else {
                                            $sql = "insert into role_permission (role_id,permission,cust_id,branch_id,updated_at,updated_by) values ('".$role_id."','".$permission."','".$customer."','".$branch."','".$updated_at."','".$updated_by."')";
                                        }
                                        
                                        // echo $sql; die;

                                          
                                         
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('Updated !');
                                                 window.location.href="add_role.php";
                                             </script>
                                        <?      }else{ ?>
                                           <script>
                                                 alert('Error ! ');
                                                 window.location.href="allotmenu_perm_test.php?id=<?php echo $role_id; ?>";
                                             </script> 
                                        <? }
                                            }
                                        ?>
                                        <form action="<? echo $_SERVER['PHP_SELF'];?>?id=<? echo $user_role;?>" method="POST">
                                            <input type="hidden" value="<?php echo $user_role;?>" name="role_id">
                                            <input type="hidden" value="<?php echo $is_insert;?>" name="is_insert">
                                            <ul>
                                            <?
                                            
                                            $mainsql = mysqli_query($con,"select * from main_menu where status=1");
                                            while($mainsql_result = mysqli_fetch_assoc($mainsql)){
                                            $main_id = $mainsql_result['id'];
                                            ?>
                                                
                                              
                                                  <li>
                                                     <input type="checkbox" class="main_menu" value="<? echo $main_id;?>"> <? echo $mainsql_result['name'];?>   
                                                  
                                              
                                                <!--<br>-->
                                                
                                                <ul class="showsubmenu">
                                                        
                                                        <? $sub_sql = mysqli_query($con,"select * from sub_menu where main_menu='".$main_id."'");
                                                        while($sub_sql_result = mysqli_fetch_assoc($sub_sql)){
                                                        $sub_id = $sub_sql_result['id'];
                                                        ?>
                                                            
                                                    <li>
                                                            <input class="submenu" type="checkbox" data-main_id="<? echo $main_id?>" name="sub_menu[]" value="<? echo $sub_id; ?>" <? if(in_array($sub_id,$user_permission)){ echo 'checked' ; } ?> > <? echo $sub_sql_result['sub_menu'];?>
                                                    </li>
                                                            
                                                            <!--<br>-->
                                                        <? } ?>
                                                </ul>
                                                </li>
                                            <? } ?>
                                            </ul>
                                            
                                            <hr>
											<h6>Select Customer For Permissions</h6>
											<ul class="showsubmenu">
											    <?php $sql = mysqli_query($con,"select customer from mis_newsite where status=1 and customer!='' group by customer");
                                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                                        $cust_id = $sql_result['customer'];
														if($cust_id!=''){
                                                        ?>
                                                            
                                                    <li>
                                                            <input class="submenu" type="checkbox"  name="cust_id[]" value="<?php echo $cust_id; ?>" <?php if(in_array($cust_id,$_cust)){ echo 'checked' ; } ?> > <?php echo $sql_result['customer'];?>
                                                    </li>
                                                            
                                                            <!--<br>-->
                                                        <?php } }?>
											</ul>
											
											<hr>
											<h6>Select Branch For Permissions</h6>
											<ul class="showsubmenu">
											    <?php 
											        $sql = mysqli_query($con,"select branch from newbranch where status=1 group by branch asc");
                                                    //   $sql = mysqli_query($con,"select location as branch from cssbranch where status=1 group by location asc");
                                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                                        $branch_id = $sql_result['branch'];
														if($branch_id!=''){
                                                        ?>
                                                            
                                                    <li>
                                                            <input class="submenu" type="checkbox"  name="branch_id[]" value="<?php echo $branch_id; ?>" <?php if(in_array($branch_id,$_branch)){ echo 'checked' ; } ?> > <?php echo $sql_result['branch'];?>
                                                    </li>
                                                            
                                                            <!--<br>-->
                                                        <?php } }?>
											</ul>
											
											
											<hr>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-danger">                                                    
                                                </div>

                                                
                                            </div>
                                        </form>
                                        
                                        
                                        <div>
                                            
                                        </div>
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




<script>


// $(function() {
//   $(".main_menu").click(function () {
      
      
//   alert(this.value);
//     $(this).siblings('.showshubmenu')
//           .find("input[type='checkbox']")
//           .prop('checked', this.checked);
//   });
// });


$(function () {
    $("input[type='checkbox']").change(function () {
        $(this).siblings('ul')
            .find("input[type='checkbox']")
            .prop('checked', this.checked);
    });
});



// $(".main_menu").on('click',function(){
   
//   alert(this.value);
   
//   alert(('.submenu').attr("data-main_id"));
// });

// $(".submenu").on('click',function(){


//   alert(this.value);
//   alert($(this).attr("data-main_id"));
   
// });

</script>

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