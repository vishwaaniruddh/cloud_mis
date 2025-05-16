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
                                        $zone = $_POST['zone'];
                                        $state = $_POST['state'];
                                        $city = $_POST['city'];
                                        
                                        $sql= "insert into mis_city(city,zone_id,state_id) values('".$city."','".$zone."','".$state."')";
                                         if(mysqli_query($con,$sql)){ ?>
                                             <script>
                                                 alert('City Created Successfully');
                                                 window.location.href="view_mis_city.php";
                                             </script>
                                         <? }else{ ?>
                                             <script>
                                                 alert(' Error Creating City!! ');
                                                 window.location.href="view_mis_city.php";
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