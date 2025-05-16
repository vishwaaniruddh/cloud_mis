<? session_start();
date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<style>
    html{
        /*text-transform: inherit !important;*/
    }
    .onlist_list{
            border: 1px solid gray;
            padding: 10px;
    }

.online{
    height:15px;
    width:15px;
    border-radius:50px;
    background:green;
    border:1px solid green;
}

.offline{
        height:15px;
    width:15px;
    border-radius:50px;
    background:red;
    border:1px solid red;
}
.card{
    margin-bottom:10px;
}
</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card" style="padding:15px;">
                                    <div class="card-block">
                                        <div id="result"></div>
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
    
    
                            $.ajax({
                        type: "POST",
                        url: 'onlineajax.php',
                        data: 'page='+1,
                        success:function(msg) {

                            $("#result").html(msg);

                        }
                    });
                    
                    
    setInterval(function(){ 


                            $.ajax({
                        type: "POST",
                        url: 'onlineajax.php',
                        data: 'page='+1,
                        success:function(msg) {

                            $("#result").html(msg);

                        }
                    });
                    
        }, 10000);


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