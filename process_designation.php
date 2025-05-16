<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
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
                                        $name = $_POST['name'];
                                        $uname = $_POST['uname'];
                                        $pwd = $_POST['pwd'];
                                        $contact = $_POST['contact'];
                                        $designation = $_POST['desgn'];
                                        $sql= "update mis_loginusers set designation='".$designation."' where id='".$id."' ";
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('User Updated Successfully');
                                                 window.location.href="add_user.php";
                                             </script>
                                         <? }else{ ?>
                                             <script>
                                                 alert('User Update Error');
                                                 window.location.href="add_user.php";
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