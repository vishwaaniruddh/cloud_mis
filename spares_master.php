<?php 
session_start();
include('config.php');

if($_SESSION['username']) { 
    include('header.php'); 
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <h5>Spares Management</h5>
                            <button class="btn btn-success float-end" data-toggle="modal" data-target="#addSpareModal">Add Spare</button>
                        </div>
                        <div class="card-block">
                            <table id="sparesTable" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Spare Name</th>
                                        <th>Components</th>
                                        <th>Cost</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($con, "SELECT * FROM sparesComponent WHERE status = 1");
                                    $srno = 1;
                                    while ($component = mysqli_fetch_assoc($query)) {
                                        echo "<tr>";
                                        echo "<td>$srno</td>";
                                        echo "<td>{$component['spareid']}</td>";
                                        echo "<td>{$component['spareComponentName']}</td>";
                                        echo "<td>₹{$component['cost']}</td>";
echo "<td>
    <button class='btn btn-primary btn-sm editSpareBtn' 
        data-id='{$component['id']}' 
        data-spareid='{$component['spareid']}' 
        data-component='{$component['spareComponentName']}' 
        data-cost='{$component['cost']}'
        data-toggle='modal' 
        data-target='#editSpareModal'>Edit</button>

    <button class='btn btn-danger btn-sm deleteSpareBtn' 
        data-id='{$component['id']}'>Delete</button>
</td>";


                                        echo "</tr>";
                                        $srno++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

<!-- Add Spare Modal -->
<div class="modal fade" id="addSpareModal" tabindex="-1" aria-labelledby="addSpareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Spare</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveSpareForm" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Spare Name</label>
                        <select name="spareName" class="form-control" required>
                            <option value="">Select Spare</option>
                            <?php
                            $spareQuery = mysqli_query($con, "SELECT id, spareName FROM spares WHERE status = 1");
                            while ($spare = mysqli_fetch_assoc($spareQuery)) {
                                echo "<option value='{$spare['id']}'>{$spare['spareName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="componentsSection">
                        <label class="form-label">Components</label>
                        <div class="input-group mb-2">
                            <input type="text" name="spareComponentName[]" class="form-control" placeholder="Component Name">
                            <input type="number" name="cost[]" class="form-control" placeholder="Cost">
                        </div>
                        <button type="button" class="btn btn-sm btn-success" id="addComponentField">+ Add More</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="saveSpare" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Spare Modal -->
<div class="modal fade" id="editSpareModal" tabindex="-1" aria-labelledby="editSpareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Spare</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateSpareForm" method="POST">
    <div class="modal-body">
        <input type="hidden" name="spareId" id="editSpareId">
        <div class="mb-3">
            <label class="form-label">Spare Name</label>
            <input type="text" name="spareName" id="editSpareName" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Component Name</label>
            <input type="text" name="componentName" id="editComponentName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Cost</label>
            <input type="number" name="cost" id="editCost" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
        </div>
    </div>
</div>

<script>
    
    $(document).on("click", ".deleteSpareBtn", function() {
    let spareId = $(this).data("id"); // Get spare ID from button attribute

    if (confirm("Are you sure you want to delete this spare component?")) {
        $.ajax({
            url: "delete_spare.php",
            type: "POST",
            data: { spare_id: spareId },
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    alert(response.message);
                    location.reload(); // Reload to update the list
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("An error occurred while deleting the spare component.");
            }
        });
    }
});


$(document).ready(function() {
    $("#saveSpareForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        
        let formData = $(this).serialize() + "&saveSpare=1"; // Append saveSpare flag

        $.ajax({
            url: "save_spare.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    alert(response.message);
                    location.reload(); // Reload page or update UI dynamically
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("An error occurred while saving the spare.");
            }
        });
    });
});


    
$(document).ready(function() {
    $('#addComponentField').click(function() {
        $('#componentsSection').append('<div class="input-group mb-2">' +
            '<input type="text" name="spareComponentName[]" class="form-control" placeholder="Component Name">' +
            '<input type="number" name="cost[]" class="form-control" placeholder="Cost">' +
            '<button type="button" class="btn btn-sm btn-danger removeComponentField">-</button>' +
        '</div>');
    });

    $(document).on('click', '.removeComponentField', function() {
        $(this).parent().remove();
    });

    // Fetch spare data when clicking edit
    $('.editSpareBtn').click(function() {
        var spareId = $(this).data('id');

        $.ajax({
            url: 'fetch_spare.php',
            type: 'POST',
            data: { spareId: spareId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#editSpareId').val(response.data.id);
                    $('#editSpareName').val(response.data.spareid);
                    $('#editComponentName').val(response.data.spareComponentName);
                    $('#editCost').val(response.data.cost);
                } else {
                    alert("Failed to fetch spare data.");
                }
            }
        });
    });

    // AJAX request to update spare details
    $('#updateSpareForm').submit(function(e) {
        e.preventDefault(); 

        $.ajax({
            url: 'update_spare.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Spare updated successfully!');
                    location.reload();
                } else {
                    alert('Failed to update spare.');
                }
            }
        });
    });
});



</script>
<?php include('footer.php'); } else { ?>


<script>
    window.location.href = "login.php";
</script>
<?php } ?>



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

