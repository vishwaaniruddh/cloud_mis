<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('headertest.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <?
                                        $id = $_POST['id'];
                                        
                                        $role = $_POST['role'];
                                        $sql= "update mis_loginusers_test set role='".$role."' where id='".$id."' ";
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('User Updated Successfully');
                                                 window.location.href="add_user_test.php";
                                             </script>
                                         <? }else{ ?>
                                             <script>
                                                 alert('User Update Error');
                                                 window.location.href="add_user_test.php";
                                             </script>
                                         <? } ?>
                                        

                                        
                                        
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


</body>

</html>