<? include('function.php');

$atmid = $_REQUEST['atmid'];


$sql1 = mysqli_query($con,"select * from mis_details where atmid = '".$atmid."'");
        $i = 1;
        if(mysqli_fetch_assoc($sql1)){ 
        
        
        function cust_datetime($date){
    if($date){
        return date('d M, Y H:i:s', strtotime($date));        
    }else{
        return ;
    }
    
}



        
        ?>
            

<div class="card">
    <div class="card-block">
        <div style="overflow-x:auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Sn</th>
                    <th>Ticket ID</th>
                    <th>Component</th>
                    <th>Sub Component</th>

                    <th>Call Receive From</th>

                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Closing Date</th>
                    <th>Attachment 1</th>
                    <th>Attachment 2</th>
                </tr>
            </thead>
            <tbody>
                
                
        <?

        $sql = mysqli_query($con,"select * from mis_details where atmid = '".$atmid."' order by id desc");
        $i = 1; 
            while($sql_result = mysqli_fetch_assoc($sql)){ 
            
            $mis_id  = $sql_result['id'] ; 
            $sql1 = mysqli_query($con,"select * from mis where id='".$sql_result['mis_id']."'");
            $sql1_result = mysqli_fetch_assoc($sql1);
            $created_by = $sql1_result['created_by'];
            
            $created_at = $sql1_result['created_at'];
            $created_at = cust_date($created_at);
            
            $user_sql = mysqli_query($con,"select * from mis_loginusers where id='".$created_by."'");
            $user_sql_result = mysqli_fetch_assoc($user_sql);
            $created_by = $user_sql_result['name'];
            
            


            
            $his_sql = mysqli_query($con,"select * from mis_history where mis_id='".$sql_result['id']."' and type='close' order by id desc");
            $his_sql_result = mysqli_fetch_assoc($his_sql);
            $close_time = $his_sql_result['created_at'];
            $attachment = $his_sql_result['attachment'];
            $attachment2 = $his_sql_result['attachment2'];
            
            
            ?>
            
            <tr>
                <td><? echo $i; ?></td>
                <td>
                    <a target="_blank" href="mis_details.php?id=<? echo $mis_id; ?>">
                        <? echo $sql_result['ticket_id']; ?>
                    </a>
                    </td>
                <td><? echo $sql_result['component']; ?></td>
                <td><? echo $sql_result['subcomponent']; ?></td>
                <td><? echo $sql1_result['call_receive_from']; ?></td>

                <td><? echo $sql_result['remarks']; ?></td>
                <td><? echo $sql_result['status']; ?></td>
                <td><? echo $created_by; ?></td>
                <td><? echo $created_at; ?></td>
                <td><? echo cust_datetime($close_time); ?></td>
                <td>
                    <?
                    if($attachment){ ?>
                        <a href="<? echo $attachment ; ?>" class="btn btn-success" target="_blank">View Attachment 1</a>    
                    <? } ?>
                    </td>
                                    <td>
                    <?
                    if($attachment2){ ?>
                        <a href="<? echo $attachment2 ; ?>" class="btn btn-success" target="_blank">View Attachment 2</a>    
                    <? } ?>
                    </td>
                    
                    
                
            </tr>
            
            <? $i++ ; } ?>  
        
            </tbody>
        </table>
        </div>
    </div>
</div>

        <? } else{ 
            
            echo 'No History Found !' ;
        }
        ?>