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
                                        
                                        if(isset($_POST['submit']) && isset($_POST['subcomponent']) && isset($_POST['component'])){
                                            
                                            $component = $_POST['component'];
                                            $name = $_POST['subcomponent'];
                                            $date = date('Y-m-d');
                                            
                                            $statement = "insert into mis_subcomponent(component_id,name,status,created_at) values('".$component."','".$name."','1','".$date."')" ;
                                            
                                            if(mysqli_query($con,$statement)){ ?>
                                            
                                            <script>
                                                alert('Sub Component Added');
                                                window.location.href="add_subcomponent.php";
                                            </script>
                                                
                                                

                                            <? }
                                            else{
                                                echo mysqli_error($con);
                                            }
                                        }
                                        
                                        ?>
                                        <form action="<? echo $_SERVER['PHP_SELF'] ;?>" method="POST">
                                            <h3>Add Component</h3>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <select name="component" class="form-control">
                                                        <option value=""> Select </option>
                                                        <?
                                                        $com_sql = mysqli_query($con,"select * from mis_component where status=1");
                                                        while($com_sql_result = mysqli_fetch_assoc($com_sql)){ ?>
                                                            <option value="<? echo $com_sql_result['name'];?>"><? echo $com_sql_result['name']; ?></option>
                                                        <? }  ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="subcomponent" class="form-control" placeholder="">
                                                </div>
                                                <div class="col-sm-2">

                                                    <input type="submit" name="submit" value="Add" class="btn btn-success">
                                                </div>
                                            </div>    
                                        </form>
                                    </div>
                                </div>
                                
                                
                                
                                
                                <div class="card">
                                    <div class="card-block">
                                           <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th>SR</th>
                                                        <th>Component</th>
                                                        <th>Sub Component</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody> 
                                                    <? 
                                                    $sql = mysqli_query($con,"select * from mis_subcomponent where status=1 order by id desc");
                                                    $i=0;
                                                    while($sql_result = mysqli_fetch_assoc($sql)){ ?>
                                                        <tr>
                                                            <th><? echo ++$i; ?></th>
                                                            <th><? echo $sql_result['component_id']; ?></th>
                                                            <th><? echo $sql_result['name']; ?></th>
                                                            <th>
                                                                <button class="btn btn-warning btn-edit" data-id="<?= $sql_result['id']; ?>" data-name="<?= $sql_result['name']; ?>">Edit</button>
                                                                |
                                                                <button class="btn btn-danger btn-delete" data-id="<?= $sql_result['id']; ?>">Delete</button>
                                                            </th>

                                                        </tr>    
                                                    <? }  ?>
                                                    
                                                </tbody>

                                           </table>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            
            
            <script>
$(document).ready(function() {

    // Delete
    $(".btn-delete").click(function() {
        let id = $(this).data("id");
        if (confirm("Are you sure you want to delete this item?")) {
            $.post("subcomponent_actions.php", {
                action: "delete",
                id: id
            }, function(response) {
                if (response.trim() === "deleted") {
                    alert("Deleted successfully.");
                    location.reload(); // or remove row via JS
                }
            });
        }
    });

    // Update
    $(".btn-edit").click(function() {
        let id = $(this).data("id");
        let currentName = $(this).data("name");
        let newName = prompt("Update Sub Component Name:", currentName);
        if (newName && newName !== currentName) {
            $.post("subcomponent_actions.php", {
                action: "update",
                id: id,
                name: newName
            }, function(response) {
                if (response.trim() === "updated") {
                    alert("Updated successfully.");
                    location.reload(); // or update row via JS
                }
            });
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