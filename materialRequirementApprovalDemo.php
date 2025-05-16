<?php
session_start();
include('config.php');

if($_SESSION['username']){ 
    include('header.php');
?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    
                    
<div class="card">
    <div class="card-body">
        <form id="filterForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
                <div class="col-sm-4">
                    <label for="atmid">ATM ID</label>
                    <input type="text" class="form-control" id="atmid" name="atmid" value="<?php echo isset($_REQUEST['atmid']) ? $_REQUEST['atmid'] : ''; ?>" placeholder="Enter ATM ID">    
                </div>
                <div class="col-sm-4">
                    <label for="ticket_id">Ticket ID</label>
                    <input type="text" class="form-control" id="ticket_id" name="ticket_id" value="<?php echo isset($_REQUEST['ticket_id']) ? $_REQUEST['ticket_id'] : ''; ?>" placeholder="Enter Ticket ID">
                </div>
                <div class="col-sm-4">
                    <label for="status">Approval Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="0" <?php echo (isset($_REQUEST['status']) && $_REQUEST['status'] === '0') ? 'selected' : ''; ?>>Pending</option>
                        <option value="1" <?php echo (isset($_REQUEST['status']) && $_REQUEST['status'] === '1') ? 'selected' : ''; ?>>Approved</option>
                        <option value="2" <?php echo (isset($_REQUEST['status']) && $_REQUEST['status'] === '2') ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
        </form>
    </div>
</div>



 <?php
                            
                            // var_dump($_REQUEST);
                            
                             // Get filter values from GET parameters
    $atmid = isset($_REQUEST['atmid']) ? $_REQUEST['atmid'] : '';
    $ticket_id = isset($_REQUEST['ticket_id']) ? $_REQUEST['ticket_id'] : '';
    $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';

    // Build the base SQL query for counting total records
    $sqlappCount = "SELECT COUNT(1) as total FROM pre_material_inventory a 
                    INNER JOIN mis_details b ON a.mis_id = b.id 
                    LEFT JOIN mis_newsite c ON b.atmid = c.atmid
                    WHERE 1";

    // Build the base SQL query for fetching data
    $statement = "SELECT a.id, a.material, a.material_condition, a.remark, a.created_at, a.created_by, 
                  a.delivery_address, a.cancel_remarks, a.mis_id, b.atmid, c.address, b.ticket_id, 
                  b.status, a.is_approved,a.actionDate 
                  FROM pre_material_inventory a 
                  INNER JOIN mis_details b ON a.mis_id = b.id 
                  LEFT JOIN mis_newsite c ON b.atmid = c.atmid 
                  WHERE 1";

    // Add filters if provided
    if (!empty($atmid)) {
        $sqlappCount .= " AND b.atmid LIKE '%" . $atmid . "%'";
        $statement .= " AND b.atmid LIKE '%" . $atmid . "%'";
    }

    if (!empty($ticket_id)) {
        $sqlappCount .= " AND b.ticket_id LIKE '%" . $ticket_id . "%'";
        $statement .= " AND b.ticket_id LIKE '%" . $ticket_id . "%'";
    }

    if (($status==0 || $status==1 || $status==2) && $status!='') {
        $sqlappCount .= " AND a.is_approved = '" . $status . "'";
        $statement .= " AND a.is_approved = '" . $status . "'";
    }
 
                                          
                                          

                            $result = mysqli_query($con, $sqlappCount);
                            $row = mysqli_fetch_assoc($result);
                            $total_records = $row['total'];

                            $current_page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
                            $page_size = 20; // Updated to 20 records per page
                            $offset = ($current_page - 1) * $page_size;

                            $total_pages = ceil($total_records / $page_size);
                            $window_size = 10;
                            $start_window = max(1, $current_page - floor($window_size / 2));
                            $end_window = min($start_window + $window_size - 1, $total_pages);

                            $sql_query = "$statement LIMIT $offset, $page_size";

                            
                            
                            ?>
                    
                    <div class="card">
                        <div class="card-header" style="overflow: auto;">
                            <h4>
                            <?php 
                            
                            echo 'Total Records: ' . $total_records; 
                            ?>
                            </h4>
                        </div>
                        <div class="card-body" style="overflow: auto;">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr No</th>
                                        <th>ATMID</th>
                                        <th>Ticket Id</th>
                                        <th>Current Status</th>
                                        <th>MATERIAL</th>
                                        <th>MATERIAL CONDITION</th>
                                        <th>ATTACHMENT</th>
                                        <th>Approval Status</th>
                                        <th>Created Date</th>
                                        <th>Action Date</th>
                                        <th>Created By</th>
                                        <th>REMARK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $counter = ($current_page - 1) * $page_size + 1;
                                    $sql_app = mysqli_query($con, $sql_query);
                                    while ($sql_result = mysqli_fetch_assoc($sql_app)) { 
                                        $approvalStatus = '';
                                        $is_approved = '';
                                        
                                        
                                        $id = $sql_result['id'];
                                        $atmid = $sql_result['atmid']; 
                                        $mis_id = $sql_result['mis_id'];
                                        $ticket_id = $sql_result['ticket_id'];
                                        $current_status = $sql_result['status'];
                                        $is_approved = $sql_result['is_approved'];
                                        $actionDate = $sql_result['actionDate'];
                                        $history_sql = mysqli_query($con, "SELECT * FROM mis_history WHERE mis_id = '$mis_id' AND type = 'material_requirement' ORDER BY id DESC");
                                        $history_sql_result = mysqli_fetch_assoc($history_sql);

                                        $emailAttachment_MaterialRequirement = $history_sql_result['emailAttachment_MaterialRequirement'];
                                        $images_MaterialRequirement = $history_sql_result['images_MaterialRequirement'];
                                        
                                        
                                        if($is_approved==0){
                                            $approvalStatus = 'Pending'; 
                                        }else if($is_approved==1){
                                            $approvalStatus = 'Approved'; 
                                        }else if($is_approved==2){
                                            $approvalStatus = 'Rejected'; 
                                        }
                                        
                                        
                                    ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><a href="#" class="misid" data-toggle="modal" data-target="#myModal" data-misid="<?= $mis_id; ?>" data-id="<?= $id; ?>" data-atmid="<?= $atmid; ?>"><?= $atmid; ?></a></td>
                                        <td><?php echo $ticket_id; ?></td>
                                        <td><?php echo $current_status; ?></td>
                                        <td><?php echo $sql_result['material']; ?></td>
                                        <td><?php echo $sql_result['material_condition']; ?></td>
                                        <td><a href="./view_material_req_images.php?mis_id=<?= $mis_id; ?>">View attachment</a></td>
                                        <td><?php echo $approvalStatus; ?></td>

                                        <td><?php echo $sql_result['created_at']; ?></td>
                                        <td><?php echo $actionDate; ?></td>
                                        <td><?php echo get_member_name($sql_result['created_by']); ?></td>
                                        <td><?php echo $sql_result['remark']; ?></td>
                                    </tr>
                                    <?php
                                    $counter++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <ul class="pagination">
                                <?php if($current_page > 1): ?>
                                    <li><a href="?page=<?php echo $current_page - 1; ?>">Previous</a></li>
                                <?php endif; ?>

                                <?php for($i = $start_window; $i <= $end_window; $i++): ?>
                                    <li class="<?php if($i == $current_page) echo 'active'; ?>"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>

                                <?php if($current_page < $total_pages): ?>
                                    <li><a href="?page=<?php echo $current_page + 1; ?>">Next</a></li>
                                <?php endif; ?>
                            </ul>

                            <style>
                                .pagination {
                                    display: flex;
                                    margin: 10px 0;
                                    padding: 0;
                                    justify-content: center;
                                    list-style-type: none;
                                }

                                .pagination li {
                                    display: inline-block;
                                    margin: 0 5px;
                                    padding: 5px 10px;
                                    border: 1px solid #ccc;
                                    background-color: #fff;
                                    color: #555;
                                    text-decoration: none;
                                }

                                .pagination li.active {
                                    border: 1px solid #007bff;
                                    background-color: #007bff;
                                    color: #fff;
                                }

                                .pagination li:hover:not(.active) {
                                    background-color: #f5f5f5;
                                    border-color: #007bff;
                                    color: #007bff;
                                }
                            </style>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



 <script>


function showAlert(type, message) {
          Swal.fire({
            icon: type,
            title: type.charAt(0).toUpperCase() + type.slice(1),
            text: message,
            showConfirmButton: false,
            timer: 1500
          }).then(function () {
                window.location.href = "materialRequirementApproval.php";
            });
        }

$(document).ready(function(){
$('.misid').click(function(){
  var misid = $(this).data('misid');
    $("#misid").val(misid);
    $("#pre_material_inventoryID").val($(this).data("id"));

  $.ajax({
    type: 'GET',
    url: 'getMaterialData.php', 
    data: { 'misid': misid },
    success: function(data) {
      var materialData = JSON.parse(data);
      console.log(materialData);

      $('#materialName').val(materialData.material);
      $('#oldRemark').val(materialData.oldRemark);
    },
    error: function() {
      showAlert('error', 'Error fetching data');
    }
  });
});

$('#myModal form').submit(function(e) {
  e.preventDefault();
  var formData = $(this).serialize();
  
  $.ajax({
    type: 'POST',
    url: 'modifyMaterialRequestRequest.php',
    data: formData,
    success: function(response) {
      showAlert('success', 'Form submitted successfully!');
      $('#myModal').modal('hide');
    },
    error: function() {
      showAlert('error', 'Error submitting form');
    }
  });
});
});

$(document).on('click','.approveEntry',function(){
  var formData = $('#modifyMaterialForm').serialize();
      var misid = $('#misid').val(); 

  $.ajax({
    type: 'POST',
    url: 'modifyMaterialRequestRequest.php',
    data: {
        formData: formData,
        action: 'approve', 
        misid: misid
    },
    success: function(response) {
      showAlert('success', 'Entry approved!');
      $('#myModal').modal('hide');
    },
    error: function() {
      showAlert('error', 'Error submitting form');
    }
  });
})

$(document).on('click','.rejectEntry',function(){
    var formData = $('#modifyMaterialForm').serialize();
    var misid = $('#misid').val(); 
    
      $.ajax({
        type: 'POST',
        url: 'modifyMaterialRequestRequest.php',
        data: {
              formData: formData,
              action: 'reject',
              misid: misid
            },

        success: function(response) {
          showAlert('success', 'Entry rejected!');
          $('#myModal').modal('hide');
          
          
        },
        error: function() {
          showAlert('error', 'Error submitting form');
        }
      });
    });



</script>


<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Material Requirement Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="modifyMaterialForm"> <!-- Add an id to the form -->
            <input type="hidden" id="misid" name="misid">
            <input type="hidden" id="pre_material_inventoryID" name="pre_material_inventoryID">
            
            
          <div class="form-group">
            <label for="materialName">MATERIAL NAME:</label>
            <select class="form-control" id="materialName" name="material">
                <option value="">Select</option>
                <?php
                $mat_sql = mysqli_query($con, "select * from material where status=1 ");
                while ($mat_sql_result = mysqli_fetch_assoc($mat_sql)) {
                    ?>
                    <option value="<?php echo $mat_sql_result['material']; ?>">
                        <?php echo $mat_sql_result['material']; ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="oldRemark">OLD REMARK:</label>
            <input type="text" class="form-control" id="oldRemark" name="oldRemark" placeholder="Enter old remark">
          </div>
          <div class="form-group">
            <label for="newRemark">NEW REMARK:</label>
            <input type="text" class="form-control" id="newRemark" name="newRemark" required placeholder="Enter new remark">
          </div>
          <div class="form-group text-center">
            <button type="button" class="btn btn-success mr-2 approveEntry" >Approve</button>
            <button type="button" class="btn btn-danger rejectEntry">Wrong Entry</button>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
 .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 126vw;
    height: 116vh;
    background-color: #000;
}
</style>


<?php include('footer.php'); } else { ?>
<script>
    window.location.href = "login.php";
</script>
<?php } ?>

