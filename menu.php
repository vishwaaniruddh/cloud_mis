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
                                        
                                        <!--Menu-->
                                        <?
                                        if(isset($_POST['menu_submit'])){
                                            $menu = $_POST['menu'];
                                            
                                            $sql = "insert into main_menu(name,status) values('".$menu."','1')";
                                            
                                            if(mysqli_query($con,$sql)){ ?>
                                                <script>
                                                    alert('Menu Added');
                                                </script>
                                            <? }else{
                                              ?>
                                                <script>
                                                    alert('Menu Added Error !');
                                                </script>
                                            <?  
                                            } }
                                        
                                        
                                        ?>
                                        <!--End Menu-->
                                        
                                        
                                        
                                        
                                        <!--Sub Menu-->
                                        
                                        <?
                                        if(isset($_POST['submenu_submit'])){
                                            $menu = $_POST['menu'];
                                            $submenu = $_POST['submenu'];
                                            $page = $_POST['page'];
                                            $sql = "insert into sub_menu(main_menu,sub_menu,page,status) values('".$menu."','".$submenu."','".$page."','1')";
                                            
                                            if(mysqli_query($con,$sql)){ ?>
                                                <script>
                                                    alert('SubMenu Added');
                                                </script>
                                            <? }else{
                                                echo mysqli_error($con);
                                              ?>
                                                <script>
                                                    alert('Sub Menu Added Error !');
                                                </script>
                                            <?  
                                            } }
                                        
                                        
                                        ?>
                                        
                                        
                                        <!--End Sub Menu-->                                        
                                        
                                        
                                        
                                        
                                        <form action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">
                                            <div class="row">
                                               <div class="col-sm-12">
                                                   <label>Create Menu</label>
                                                   <input type="text" name="menu" class="form-control">
                                               </div>
                                                 <div class="col-sm-12">
                                                   <br>
                                                   <input type="submit" name="menu_submit" class="btn btn-danger">
                                               </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="card">
                                    <div class="card-block">
                                        

                                        
                                <form action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Select Under</label>
                                                    <select name="menu" class="form-control" id="main_menu" required>
                                                        <option>Select</option>
                                                        <?
                                                        $main_sql = mysqli_query($con,"select * from main_menu where status=1");
                                                        while($main_sql_result = mysqli_fetch_assoc($main_sql)){ ?>
                                                            <option value="<? echo $main_sql_result['id'];?>"><? echo $main_sql_result['name'];?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <label>Submenu</label>
                                                    <input type="text" name="submenu" class="form-control" required>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label>Page</label>
                                                    <input type="text" name="page" class="form-control" placeholder="like index.php" required>
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <br>
                                                    <input type="submit" name="submenu_submit" class="btn btn-danger">
                                                </div>
                                                
                                                
                                            </div>    
                                    </form>
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