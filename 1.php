<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<style>
    table{ width: 75%; }
tr {border: 2px solid #AEAEAE;}


</style>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
Click on a row for more info:
<table>
    <tr>
        <td>
        <p>Name</p>
        </td>
        <td>
        <p>Age</p>
        </td>
        <td>
        <p>Info</p>
        </td>
        </tr>
    <tr>
    <td colspan="3">
    <p>Blah blah blah blah blah blah blah blah blah blah blah
        blah blah blah blah blah blah blah blah blah blah blah blah blah blah
        blah blah blah blah blah blah blah blah blah blah blah blah blah blah.</p>
    </td>
    </tr>

    <tr>
    <td>
    <p>Name</p>
    </td>
    <td>
    <p>Age</p>
    </td>
    <td>
    <p>Info</p>
    </td>
    </tr>
    <tr>
    <td colspan="3">
    <p>Blah blah blah blah blah blah blah blah blah blah blah
        blah blah blah blah blah blah blah blah blah blah blah blah blah blah
        blah blah blah blah blah blah blah blah blah blah blah blah blah blah.</p>
    </td>
    </tr>
    
    <tr>
    <td>
    <p>Name</p>
    </td>
    <td>
    <p>Age</p>
    </td>
    <td>
    <p>Info</p>
    </td>
    </tr>
    <tr>
    <td colspan="3">
    <p>Blah blah blah blah blah blah blah blah blah blah blah
        blah blah blah blah blah blah blah blah blah blah blah blah blah blah
        blah blah blah blah blah blah blah blah blah blah blah blah blah blah.</p>
    </td>
    </tr>    
</table>



                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
             
             
             <script>
                 $(function() {
    $("td[colspan=3]").find("p").hide();
    $("table").click(function(event) {
        event.stopPropagation();
        var $target = $(event.target);
        if ( $target.closest("td").attr("colspan") > 1 ) {
            $target.slideUp();
        } else {
            $target.closest("tr").next().find("p").slideToggle();
        }                    
    });
});
             </script>       
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="=login.php";
    </script>
<? }
    ?>
    
        <script src="../datatable/jquery.dataTables.js">
        </script>
<script src="../datatable/dataTables.bootstrap.js">
</script>
<script src="../datatable/dataTables.buttons.min.js">
</script>
<script src="../datatable/buttons.flash.min.js">
</script>
<script src="../datatable/jszip.min.js">
</script>




<script src="../datatable/pdfmake.min.js">
</script>
<script src="../datatable/vfs_fonts.js">
</script>
<script src="../datatable/buttons.html5.min.js">
</script>
<script src="../datatable/buttons.print.min.js">
</script>
<script src="../datatable/jquery-datatable.js">
</script>



</body>

</html>