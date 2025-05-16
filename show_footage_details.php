<? session_start();
include('config.php');
include('function.php');
$id = $_GET['id'];
?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
	<table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
		<thead>
			<tr>
				<th>S.No</th>
				<td>Status</td>
				<td>Details</td>
				<td>Created By</td>
				<td>Created Date</td>
				
			</tr>
		</thead>
		<tbody>
			<?  $statement = "select * from eng_footage_request_history where footage_id='".$id."' order by id desc" ;
                $i = 0 ; 
                $sql = mysqli_query($con,$statement);
                while($sql_result = mysqli_fetch_assoc($sql)){  
                   /* $created_by = $sql_result['created_by'];
                    $userstatement = "select name from mis_loginusers where id='".$created_by."'" ;
                    $usersql = mysqli_query($con,$userstatement);
                    $sql_rowresult = mysqli_fetch_row($usersql);
                    $name = $sql_rowresult[0]; */
            ?>
						<tr>
							<td>
								<? echo ++$i; ?>
							</td>
							<td>
								<? echo $sql_result['update_status']; ?>
							</td>
							<td>
								<? echo $sql_result['update_details']; ?>
							</td>
							<td>
								<? echo get_member_name($sql_result['created_by']); ?>
							</td>
							<td>
								<? echo $sql_result['created_at']; ?>
							</td>
							
						</tr>
						<? } ?>
		</tbody>
	</table>
