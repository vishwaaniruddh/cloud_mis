<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
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

                                        $userid = $_GET['id']; 
                                        $usersql = mysqli_query($con,"select * from mis_loginusers where id='".$userid."'");
                                        $usersql_result = mysqli_fetch_assoc($usersql);
                                        $user_permission = $usersql_result['permission'];
                                        $user_permission = explode (",", $user_permission);
                                        
                                        if(isset($_POST['submit'])){
                                            
                                        

                                        
                                        $permission =$_POST['sub_menu'];
                                        $permission = implode(',',$permission);

                                        

                                         $sql = "update mis_loginusers set permission='".$permission."' where id='".$userid."'"; 
                                         
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('Updated !');
                                                 window.location.href="allotmenu_perm.php?id=<? echo $userid;?>";
                                             </script>
                                        <?      }else{ ?>
                                           <script>
                                                 alert('Error ! ');
                                                 window.location.href="allotmenu_perm.php?id=<? echo $userid;?>";
                                             </script> 
                                        <? }
                                            }
                                        ?>
                                        <form action="<? echo $_SERVER['PHP_SELF'];?>?id=<? echo $userid?>" method="POST">
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