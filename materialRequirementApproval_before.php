






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
                                        
                                        
    if(isset($_REQUEST['id'])){
        $approveID = $_REQUEST['id'];
        $action = $_REQUEST['action'];
        
        if($action=="approve"){
                
                $getsql = mysqli_query($con,"select * from pre_material_inventory where id='".$approveID."'");
                $getsql_result = mysqli_fetch_assoc($getsql);
                
                $mis_id = $getsql_result['mis_id'];
                $material = $getsql_result['material'];
                $material_condition = $getsql_result['material_condition'];
                $remark = $getsql_result['remark'];
                $status = $getsql_result['status'];
                $created_at = $getsql_result['created_at'];
                $created_by = $getsql_result['created_by'];
                $delivery_address = $getsql_result['delivery_address'];
                $cancel_remarks = $getsql_result['cancel_remarks'];
                        
                $sql = "insert into material_inventory(mis_id,material,material_condition,remark,status,created_at,created_by,delivery_address,cancel_remarks) 
                values('".$mis_id."','".$material."','".$material_condition."','".$remark."','".$status."','".$created_at."','".$created_by."','".$delivery_address."','".$cancel_remarks."')";
                
                if(mysqli_query($con,$sql)){
                    mysqli_query($con,"update pre_material_inventory set is_approved=1 where id='".$approveID."'")
                    ?>
                    <script>
                        alert('Approved');
                        window.location = 'materialRequirementApproval.php';
                    </script>
                    <?
                }
        }else{
            
            $getsql = mysqli_query($con,"select * from pre_material_inventory where id='".$approveID."'");
            $getsql_result = mysqli_fetch_assoc($getsql);
            
            $mis_id = $getsql_result['mis_id'];
            $material = $getsql_result['material'];
            $material_condition = $getsql_result['material_condition'];
            $remark = $getsql_result['remark'];
            $status = $getsql_result['status'];
            $created_at = $getsql_result['created_at'];
            $created_by = $getsql_result['created_by'];
            $delivery_address = $getsql_result['delivery_address'];
            $cancel_remarks = $getsql_result['cancel_remarks'];
                    
            $sql = "insert into material_inventory(mis_id,material,material_condition,remark,status,created_at,created_by,delivery_address,cancel_remarks) 
            values('".$mis_id."','".$material."','".$material_condition."','".$remark."','".$status."','".$created_at."','".$created_by."','".$delivery_address."','".$cancel_remarks."')";
            
            if(mysqli_query($con,$sql)){
                mysqli_query($con,"update pre_material_inventory set is_approved=2 where id='".$approveID."'")
                ?>
                <script>
                    alert('Reject !');
                    window.location = 'materialRequirementApproval.php';
                </script>
                <?
            }
        }
        
        
    }
                                        
                                        
                                        
                                        
                                        $sqlappCount = "select count(1) as total from pre_material_inventory a INNER JOIN mis_details b ON a.mis_id = b.id LEFT JOIN mis_newsite c ON b.atmid = c.atmid
                                        where a.is_approved=0" ; 
                                        
                                        $statement = "select a.id,a.material,a.material_condition,a.remark,a.created_at,a.created_by,a.delivery_address,a.cancel_remarks,b.atmid,
                                        c.address from pre_material_inventory a INNER JOIN mis_details b ON a.mis_id = b.id LEFT JOIN mis_newsite c ON b.atmid = c.atmid
                                        where a.is_approved=0 order by id desc"; 
                                        
                                        $result = mysqli_query($con, $sqlappCount);
                                        $row = mysqli_fetch_assoc($result);
                                        $total_records = $row['total'];
                                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        
                                        $page_size = 10;
                                        
                                        $offset = ($current_page - 1) * $page_size;
                                        
                                        
                                        $total_pages = ceil($total_records / $page_size);
                                        
                                        $window_size = 10;
                                        
                                        $start_window = max(1, $current_page - floor($window_size / 2));
                                        $end_window = min($start_window + $window_size - 1, $total_pages);
                                        
                                        
                                        
                                        
                                        // Query to retrieve the records for the current page
                                        $sql_query = "$statement LIMIT $offset, $page_size";
                                        
                                        ?>
                                        <div class="custom_table_content">
                                            

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>SR NO</th>
                                                    <th>Action</th>
                                                    <th>ATMID</th>
                                                    <th>Material</th>
                                                    <th>Material Condition</th>

                                                    <th>Remark</th>
                                                    <th>Date</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                

                                        
<?
                                        $i = 0;
                                        $counter = ($current_page - 1) * $page_size + 1;
                                        $sql_app = mysqli_query($con, $sql_query);
                                        while ($sql_result = mysqli_fetch_assoc($sql_app)) { 
                                            $id = $sql_result['id'];
                                            ?>
                                            <tr>
                                                    <td><? echo $counter; ?></td>
                                                    <td>
                                                        <a href="?id=<? echo $id; ?>&action=approve" class="approve_btn">Approve</a> | 
                                                        <a href="?id=<? echo $id; ?>&action=reject" class="reject">Reject</a> |
                                                        <a href="materialRequirementApprovalHistory.php?id=<? echo $id; ?>" class="history">History</a>
                                                    </td>
                                                    <td><? echo $sql_result['atmid'];?></td>
                                                    <td><? echo $sql_result['material']; ?></td>
                                                    <td><? echo $sql_result['material_condition']; ?></td>

                                                    <td><? echo $sql_result['remark']; ?></td>
                                                    <td><? echo $sql_result['created_at']; ?></td>
                                                    <td><? echo get_member_name($sql_result['created_by']); ?></td>
                                                </tr>
                                                
                                            <?
                                        $counter++;
                                            
                                        }
                                        
?>
                                            </tbody>
                                        </table>
                                    </div>
                                        <?
                                        
                                        
                                        
    echo '<div class="pagination"><ul>';
            if ($start_window > 1) {
            
                echo "<li><a href='?page=1'>First</a></li>";
                echo '<li><a href="?page=' . ($start_window - 1) . '">Prev</a></li>';
            }
            
            for ($i = $start_window; $i <= $end_window; $i++) {
            ?>
                <li class="<? if ($i == $current_page) { echo 'active'; }?>" >
                    <a href="?page=<? echo $i; ?>">
                        <? echo $i;  ?>
                    </a>        
                </li>
            
             <? }
            
            if ($end_window < $total_pages) {
            
                echo '<li><a href="?page=' . ($end_window + 1) .'">Next</a></li>';
                echo '<li><a href="?page=' . $total_pages . '">Last</a></li>';
            }
    echo '</ul>
    </div>';
										
										
										?>



										
										
									<style>
.pagination {
  display: flex;
    margin: 10px 0;
    padding: 0;
    justify-content: center;
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