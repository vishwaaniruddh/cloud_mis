<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('headertest.php');
date_default_timezone_set('Asia/Kolkata');

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
                                        
                                        $created_at = date("Y-m-d H:i:s");
                                        $created_by = $_SESSION['userid'];
                                        
                                        $role = $_POST['addrole'];
                                        $sql= "insert into role(role_name,created_at,created_by) values('".$role."','".$created_at."','".$created_by."')";
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('Role Created Successfully');
                                                 window.location.href="add_role.php";
                                             </script>
                                         <? }else{ ?>
                                             <script>
                                                 alert('Role Created Error');
                                                 window.location.href="add_role.php";
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