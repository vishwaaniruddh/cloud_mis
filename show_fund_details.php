<? session_start();
include('config.php');
include('function.php');
$req_id = $_GET['req_id'];
?>
	<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
	<table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
		<thead>
			<tr>
				<th>S.No</th>
				<td>Requested Amount</td>
				<td>Approved Amount</td>
				<td>Approved By</td>
				<td>Created Date</td>
				<td>Transfer Date</td>
				<td>Status</td>
			</tr>
		</thead>
		<tbody>
			<?  $transfund_statement = "select status,current_status,req_amt,approved_amt,action_by,created_at,transferred_date from mis_fund_transfer where req_id=".$req_id." order by id desc" ;
                       $transfund_sql = mysqli_query($con,$transfund_statement);
                       $transferred_date = "-";
                       if(!empty($transfund_sql)){
                           $transfund_sql_result = mysqli_fetch_row($transfund_sql);
                           if($transfund_sql_result[0]==3){
                               
                               $trans_action="";
                               if($transfund_sql_result[1]==4){
                                   $trans_action = "Transfer fund to Beneficiary";
                                   $transferred_date = $transfund_sql_result[6];
                               }
                               if($transfund_sql_result[1]==0){
                                   $trans_action = "Transfer fund Rejected";
                               } 
                            if($trans_action!="") { 
                                $created_date = date('Y-m-d',strtotime($transfund_sql_result[5]));
                               ?>
				<tr>
					<td>
						<? echo ++$i; ?>
					</td>
					<td>
						<? echo $transfund_sql_result[2]; ?>
					</td>
					<td>
						<? echo $transfund_sql_result[3]; ?>
					</td>
					<td>
						<? echo get_member_name($transfund_sql_result[4]); ?>
					</td>
					<td>
						<? echo $created_date; ?>
					</td>
					<td>
						<? echo $transferred_date; ?>
					</td>
					<td>
						<? echo $trans_action; ?>
					</td>
				</tr>
				<?   }  }
                       }
    
    ?>
					<?  $statement = "select * from mis_fund_requests where req_id=".$req_id." order by id desc" ;
                $i = 0 ; 
                $sql = mysqli_query($con,$statement);
                while($sql_result = mysqli_fetch_assoc($sql)){  
                     $status = $sql_result['status'];
                     $_action = $sql_result['action'];
                       if($status==1){
                           $action = "Operation Level Approval Pending ";
                       }  
                       if($status==3){
                           
                           if($prevstatus==4){
                              $action = "Operation Level Approval Done ";
                           }else{
                               if($_action==0){
                                  $action = "Operation Level Rejected"; 
                               }else{
                                  $action = "Operation Level Approval Done & Manager Level Approval Pending ";
                               }
                           }
                       }  
                       if($status==4){
                           if($prevstatus==5){
                                $action = "Manager Level Approval Done ";
                           }else{
                               if($_action==0){
                                  $action = "Manager Level Rejected"; 
                               }else{
                                  $action = "Manager Level Approval Done & Director Level Approval Pending ";
                               }
                              
                           }
                       } 
                       if($status==5){
                           if($_action==0){
                               $action = "Director Level Rejected ";
                           }else{
                               $action = "Director Level Approval Done ";
                           }
                       } 
                       if($status==6){
                           $action = "Process Start In Account Section"; 
                       }
                       
                       
                    $prevstatus = $status;
            ?>
						<tr>
							<td>
								<? echo ++$i; ?>
							</td>
							<td>
								<? echo $sql_result['req_amt']; ?>
							</td>
							<td>
								<? echo $sql_result['approved_amt']; ?>
							</td>
							<td>
								<? echo get_member_name($sql_result['created_by']); ?>
							</td>
							<td>
								<? echo $sql_result['created_date']; ?>
							</td>
							<td>
								<? echo $transferred_date; ?>
							</td>
							<td>
								<? echo $action; ?>
							</td>
						</tr>
						<? } ?>
		</tbody>
	</table>
