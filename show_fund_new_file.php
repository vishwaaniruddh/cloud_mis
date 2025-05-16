<? session_start();
include('config.php');
if($_SESSION['username']){ 
    $user_id = $_SESSION['userid'];  
    $user_statement = "select level,cust_id from mis_loginusers where id=".$user_id ;
    $user_sql = mysqli_query($con,$user_statement);
    $user_rowresult = mysqli_fetch_row($user_sql);
                //echo '<pre>';print_r($user_rowresult);echo '</pre>';die;
    $_userlevel = $user_rowresult[0];
    include('header.php');
    
?>


<style>
    a:not([href]) { padding: 5px; }
    .btn-group{ border: 1px solid #cccccc; }
    ul.dropdown-menu{ transform: translate3d(0px, 2%, 0px) !important;overflow: scroll !important;max-height:250px;}
    label{ font-weight: 900;font-size: 16px; }
</style>
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <table id="post_list" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" width="100%" cellspacing="0">
                            	<thead>
                            		<tr>
                            			<th>ID</th>
                            			<th>ATMID</th>
                            			<th>Customer</th>
                            		</tr>
                            	</thead>
                            
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
    
    <!-- DataTable Script -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    

<script>

    $('#post_list').dataTable({
    	"bProcessing": true,
     	"serverSide": true,
     	"ajax":{
            url :"show_fund_list.php",
            type: "POST",
            error: function(){
              $("#post_list_processing").css("display","none");
            }
      	}
    });

</script>
</body>
</html>