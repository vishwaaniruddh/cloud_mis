<?php 
include('config.php');
if ($_SESSION['username']) {
    include('header.php');

    $designation = $_SESSION['designation'];
    $bm_id = $_SESSION['bm_id'];

    // error_reporting(1);

    function get_mis_history($parameter, $type, $id)
    {
        global $con;
        $sql = mysqli_query($con, "select $parameter from mis_history where type='" . $type . "' and mis_id='" . $id . "'");
        $sql_result = mysqli_fetch_assoc($sql);
        return $sql_result[$parameter];
    }
    
    // $userid = 275;
    $username = $_SESSION['username'];
    
    
    $usersql = mysqli_query($con,"select cust_id,zone from mis_loginusers where name='".$username."'");
	$userdata = mysqli_fetch_assoc($usersql);
	$_cust_ids = $userdata['cust_id'];
    $assigned_customers = explode(",",$_cust_ids);
    
    $bankPermission = $_SESSION['bankPermission'];
    $bankPermission_AR = explode(',',$bankPermission);



?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <style>
        
    html{
        /*text-transform: inherit !important;*/
    }
    
    td a { color: #01a9ac;text-decoration: none;}
    td a:focus, td a:hover { text-decoration: none;color: chartreuse;}
    a:not([href]) { padding: 5px;}
    .btn-group { border: 1px solid #cccccc; }
    ul.dropdown-menu { transform: translate3d(0px, 2%, 0px) !important;overflow: scroll !important;max-height: 250px;}
    label { font-weight: 900;font-size: 16px; }
    </style>

    <?php

        $userid  = $_SESSION['userid'];
        // echo $userid;
        $call_type = $_REQUEST['call_type'];
        $call_receive = $_REQUEST['call_receive'];
        $ticket_id = $_REQUEST['ticket_id'];
        $engineer = $_REQUEST['engineer'];
        $sql = mysqli_query($con, "select * from mis_loginusers where id='" . $userid . "' and branch!='null' and zone!='null' ");
        $sql_result = mysqli_fetch_assoc($sql);

        $branch_result = $sql_result['branch'];
        $branch = explode(',', $branch_result);
        
        // var_dump($branch);
        echo '<br>';
        
        foreach($branch as $branchkey => $branchvalue){
            $miscitysql = mysqli_query($con,"select * from mis_city where id='".$branchvalue."'");
            $miscitysql_result = mysqli_fetch_assoc($miscitysql);
            
            $miscity[] = $miscitysql_result['city'];
            
        }


        
        
        
        $branch = json_encode($miscity);
        $branch = str_replace(array('[', ']', '"'), '', $branch);
        $branch = explode(',', $branch);
        $branch = "'" . implode("', '", $branch) . "'";
        
        if ($branch_result) {
            $branch_query = " and b.branch in($branch)";
        } else {
            $branch_query = " ";
        }
        
        $zone_result = $sql_result['zone'];
        $zone = explode(',',$zone_result);
        
        $zone=json_encode($zone);
        $zone=str_replace( array('[',']','"') , ''  , $zone);
        $zone=explode(',',$zone);
        $zone = "'" . implode ( "', '", $zone )."'";
        
        if($zone_result){
            $zone_query = " and b.zone in($zone)";
        }else{
            $zone_query =" ";
        }




$callTypePermission = $_SESSION['callTypePermission'];
$callTypePermission_AR = explode(',',$callTypePermission) ;

foreach($callTypePermission_AR as $callTypePermission_key=>$callTypePermission_val){
    $calltypesql = mysqli_query($con,"select * from callType where id='".$callTypePermission_val."'");    
    if($calltypesql_result = mysqli_fetch_assoc($calltypesql)){
        $callPermission[] = $calltypesql_result['call_type'];
    }
}




$callPermission=json_encode($callPermission);
$callPermission=str_replace( array('[',']','"') , ''  , $callPermission);
$callPermission=explode(',',$callPermission);
$callPermission = "'" . implode ( "', '", $callPermission )."'";

if($callTypePermission){
            $callTypeQuery = " and b.call_type in($callPermission)";
        }else{
            $callTypeQuery =" ";
        }

$bankPermission = $_SESSION['bankPermission'];
$bankPermission_AR = explode(',',$bankPermission);
$bankStrPermission=json_encode($bankPermission_AR);
$bankStrPermission=str_replace( array('[',']','"') , ''  , $bankStrPermission);
$bankStrPermission=explode(',',$bankStrPermission);
$bankStrPermission = "'" . implode ( "', '", $bankStrPermission )."'";

if($callTypePermission){
            $bankQuery = " and a.bank in($bankStrPermission)";
        }else{
            $bankQuery =" ";
        }








        // print_r($branch);

        if (isset($_REQUEST['submit']) || isset($_GET['page'])) { 
                
                $statement = "select a.remarks,a.id,a.bank,a.customer,a.location,a.zone,a.state,a.city,a.branch,a.created_by,a.bm,b.id,b.mis_id,b.atmid,
                b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date,b.call_type,b.case_type ,
                
                (SELECT CONCAT(name) from mis_loginusers WHERE id= b.engineer) AS eng_name,
                (SELECT CONCAT(contact) from mis_loginusers WHERE id= b.engineer) AS eng_contact,
                
                IF(b.footage_date = '0000-00-00 00:00:00', '', DATE_FORMAT(b.footage_date, '%Y-%m-%d')) AS footage_date,b.fromtime,b.totime,
                (SELECT name from mis_loginusers WHERE id= a.created_by) AS createdBy,
                cc.type,cc.schedule_date,cc.material,cc.material_condition,cc.courier_agency,cc.pod,cc.serial_number,cc.dispatch_date,cc.status_remark,
                cc.material_req_remark,
                cc.material_dispatch_remark,cc.close_remark,cc.last_action_by,cc.created_date
                
                from mis a
                    INNER JOIN mis_details b ON b.mis_id = a.id 
                    LEFT JOIN (select c.mis_id as cmisid,c.type,c.schedule_date,c.material,c.material_condition,c.courier_agency,c.pod,c.serial_number,c.dispatch_date,c.remark as status_remark,
                    IF(c.type='material_requirement',c.remark,'') as material_req_remark,
                    IF(c.type='material_dispatch',c.remark,'') as material_dispatch_remark,
                    IF(c.type='close',c.remark,'') as close_remark,
                    c.created_by as last_action_by,
                    IF(c.type <> 'Open' , c.created_at , '' ) as created_date
                    
                    
                    from mis_history c group by c.mis_id
                    
                    ) AS cc  ON cc.cmisid = a.id 
                    
                    where 1 and 
                a.customer in($assigned_customer) and
                b.mis_id = a.id $branch_query $zone_query $callTypeQuery $bankQuery
                ";
                
                
                
                $sqlappCount = "select count(1) as total 
                from mis a
                    INNER JOIN mis_details b ON b.mis_id = a.id 
                    LEFT JOIN (select c.mis_id as cmisid,c.type,c.schedule_date,c.material,c.material_condition,c.courier_agency,c.pod,c.serial_number,c.dispatch_date,c.remark as status_remark,
                    IF(c.type='material_requirement',c.remark,'') as material_req_remark,
                    IF(c.type='material_dispatch',c.remark,'') as material_dispatch_remark,
                    IF(c.type='close',c.remark,'') as close_remark,
                    c.created_by as last_action_by,
                    c.created_at as created_date
                    
                    
                    from mis_history c  group by c.mis_id
                    
                    ) AS cc  ON cc.cmisid = a.id 
                    
                    where 1 and
                a.customer in($assigned_customer) and
                b.mis_id = a.id $branch_query $zone_query $callTypeQuery $bankQuery
                ";
                

                if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
                    $statement .= " and ( b.atmid = '" . $_REQUEST['atmid'] . "' or b.ticket_id = '".$_REQUEST['atmid']."') ";
                    $sqlappCount.= " and ( b.atmid = '" . $_REQUEST['atmid'] . "' or b.ticket_id = '".$_REQUEST['atmid']."') ";
                }
                
                 if (isset($_REQUEST['engineer']) && $_REQUEST['engineer'] != '') {
                    
                   
                    
                    $statement .= " and b.engineer = '".$engineer."'";
                    $sqlappCount .= " and b.engineer = '".$engineer."'";
                }
                
                
                if (isset($_REQUEST['local_branch']) && $_REQUEST['local_branch'] != '') {
                    $statement .= " and a.branch = '" . $_REQUEST['local_branch'] . "'";
                    $sqlappCount.= " and a.branch = '" . $_REQUEST['local_branch'] . "'";
                }
                
                if (isset($_REQUEST['fromdt']) && $_REQUEST['fromdt'] != '' && isset($_REQUEST['todt']) && $_REQUEST['todt'] != '') {

                    $date1 = $_REQUEST['fromdt'];
                    $date2 = $_REQUEST['todt'];
                    
                    if(count($_REQUEST['status'])>0){
                        if ($_REQUEST['status'][0]=='close' && count($_REQUEST['status']) == 1 ) {
                            $statement .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
                            $sqlappCount .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
                        }
                        else {
                            $statement .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
                            $sqlappCount .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
                        }
                    }
                    else {
                        $statement .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
                        $sqlappCount .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
                    }
                   
                }
                
                

                if (isset($_REQUEST['customer']) && $_REQUEST['customer'] != '') {

                    $cust = json_encode($_REQUEST['customer']);
                    $cust = str_replace(array('[', ']', '"'), '', $cust);
                    $arr = explode(',', $cust);
                    $cust = "'" . implode("', '", $arr) . "'";
                    $statement .= " and a.customer in($cust)";
                    $sqlappCount .= " and a.customer in($cust)";
                }

                if (isset($_REQUEST['status']) && $_REQUEST['status'] != '') {

                    $status = json_encode($_REQUEST['status']);
                    $status = str_replace(array('[', ']', '"'), '', $status);
                    $arr_status = explode(',', $status);
                    $status = "'" . implode("', '", $arr_status) . "'";
                    $statement .= " and b.status in($status)";
                    $sqlappCount.= " and b.status in($status)";
                } 
                
                else {
                    $statement .= " and b.status in('open','permission_require','dispatch','material_requirement','material_in_process','schedule','material_available_i','material_dispatch','cancelled','not_available','available','close','MRS','fund_required','service_center')";
                    $sqlappCount .= " and b.status in('open','permission_require','dispatch','material_requirement','material_in_process','schedule','material_available_i','material_dispatch','cancelled','not_available','available','close','MRS','fund_required','service_center')";
                }


                if (isset($_REQUEST['call_type']) && $_REQUEST['call_type'] != '') {
                    $statement .= " and b.call_type = '".$call_type."'";
                    $sqlappCount .= " and b.call_type = '".$call_type."'";
                }
                
                if (isset($_REQUEST['call_receive']) && $_REQUEST['call_receive'] != '') {
                    $statement .= " and b.case_type = '".$call_receive."'";
                    $sqlappCount .= " and b.case_type = '".$call_receive."'";
                }
             
               
             
                
                $statement .= " order by b.id desc";
                
                // echo $statement; 

                if ($_REQUEST['atmid'] == '' && $_REQUEST['customer'] == ''  &&  $_REQUEST['call_type']=='' && $_REQUEST['engineer']=='') { 
                    
                    $date1 = $_REQUEST['fromdt'];
                    $date2 = $_REQUEST['todt'];
                    
                    $statement = "select a.remarks,a.id AS misid,a.bank,a.customer,a.location,a.zone,a.state,a.city,a.branch,a.created_by,a.bm,b.id,b.mis_id,
                    b.atmid,b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date,b.call_type,b.case_type ,
                    
                    (SELECT CONCAT(name) from mis_loginusers WHERE id= b.engineer) AS eng_name,
                    (SELECT CONCAT(contact) from mis_loginusers WHERE id= b.engineer) AS eng_contact,

                    
                    IF(b.footage_date = '0000-00-00 00:00:00', '', DATE_FORMAT(b.footage_date, '%Y-%m-%d')) AS footage_date, b.fromtime,b.totime,
                    (SELECT name from mis_loginusers WHERE id= a.created_by) AS createdBy,

                    cc.type,cc.schedule_date,cc.material,cc.material_condition,cc.courier_agency,cc.pod,cc.serial_number,cc.dispatch_date,cc.status_remark,
                    cc.material_req_remark,
                    cc.material_dispatch_remark,cc.close_remark,cc.last_action_by,cc.created_date
                
                    from mis a
                    INNER JOIN mis_details b ON b.mis_id = a.id 
                    LEFT JOIN (select c.mis_id as cmisid,c.type,c.schedule_date,c.material,c.material_condition,c.courier_agency,c.pod,c.serial_number,c.dispatch_date,c.remark as status_remark,
                    IF(c.type='material_requirement',c.remark,'') as material_req_remark,
                    IF(c.type='material_dispatch',c.remark,'') as material_dispatch_remark,
                    IF(c.type='close',c.remark,'') as close_remark,
                    c.created_by as last_action_by,
                    c.created_at as created_date
                    
                    
                    from mis_history c  group by c.mis_id
                    
                    ) AS cc  ON cc.cmisid = a.id 
                    
                    where 1 and

                        a.customer in($assigned_customer) and
                        b.mis_id = a.id $branch_query $zone_query $callTypeQuery $bankQuery and
                        b.status in($status) ";
                        
                $sqlappCount= "select count(1) as total from
                    mis a
                    INNER JOIN mis_details b ON b.mis_id = a.id 
                    LEFT JOIN (select c.mis_id as cmisid,c.type,c.schedule_date,c.material,c.material_condition,c.courier_agency,c.pod,c.serial_number,c.dispatch_date,c.remark as status_remark,
                    IF(c.type='material_requirement',c.remark,'') as material_req_remark,
                    IF(c.type='material_dispatch',c.remark,'') as material_dispatch_remark,
                    IF(c.type='close',c.remark,'') as close_remark,
                    c.created_by as last_action_by,
                    c.created_at as created_date
                    
                    
                    from mis_history c  group by c.mis_id
                    
                    ) AS cc  ON cc.cmisid = a.id 
                    
                    where 1 and
                        a.customer in($assigned_customer) and
                        b.mis_id = a.id $branch_query $zone_query $callTypeQuery $bankQuery and
                        b.status in($status) ";
                        
                        
                    if ($_REQUEST['status'][0]=='close' && count($_REQUEST['status']) == 1 ) {
                        $statement .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
                        $sqlappCount  .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
                    }else{
                    $statement .= "and CAST(b.created_at AS DATE) >= '" . $date1 . "' 
                                  and CAST(b.created_at AS DATE) <= '" . $date2 . "'" ;
                                  
                      $sqlappCount .= "and CAST(b.created_at AS DATE) >= '" . $date1 . "' 
                          and CAST(b.created_at AS DATE) <= '" . $date2 . "'" ;
                    }
                    
                    if (isset($_REQUEST['ticket_id']) && $_REQUEST['ticket_id'] != '') {
                    $statement .= " and b.ticket_id = '".$ticket_id."'";
                    $sqlappCount .= " and b.ticket_id = '".$ticket_id."'";
                }
                
                        
                        
                    $statement .= " order by b.id desc";
                        
                        
                }
            
            
            // echo $statement ; 
            
// Query to get the total number of records

// echo $sqlappCount ; 

$result = mysqli_query($con, $sqlappCount);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
			
$page_size = 20;

$offset = ($current_page - 1) * $page_size;

				
$total_pages = ceil($total_records / $page_size);

$window_size = 20;

$start_window = max(1, $current_page - floor($window_size / 2));
$end_window = min($start_window + $window_size - 1, $total_pages);




    // Query to retrieve the records for the current page
      $sql_query = "$statement LIMIT $offset, $page_size";
    }
            
            // return ; 
            
    ?>

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        
                        
                        <div class="card" id="filter">
                            <div class="card-block">
                                
                                <?
                                
                        // echo $statement;                                
                        // echo  $sql_query ; 
                                                
                                ?>
                                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>ATMID / Ticket ID</label>
                                            <input type="text" name="atmid" class="form-control" value="<? echo $_REQUEST['atmid']; ?>">
                                        </div>
                                        
                                        
                                        <div class="col-md-3">
                                            <label> Engineer </label>
                                            <select name="engineer" class="form-control">
                                                <option value=""> -- Select -- </option>
                                                <? $eng_sql = mysqli_query($con,"select * from mis_loginusers where designation=4 and user_status=1");
                                                while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?> 
                                                <option value="<? echo $eng_sql_result['id'];?>" <? if($_REQUEST['engineer']==$eng_sql_result['id']){ echo 'selected';} ?>>
                                                    <? echo $eng_sql_result['name'];?>
                                                </option>
                                                <? } ?>
                                            </select>
                                        </div>
                                        
                                        
                                        
                                        <div class="col-md-3">
                                            <label>Customer</label>
                                            <select id="multiselect" class="form-control" name="customer[]" multiple="multiple">
                                                <?  
                                                $i = 0;
                                                $con_sql = mysqli_query($con, "select contact_first from contacts where type='c' ");
                                                while ($con_sql_result = mysqli_fetch_assoc($con_sql)) { 
                                                  if(in_array($con_sql_result['contact_first'],$assigned_customers)){
                                                ?>
                                                    <option value="<? echo $con_sql_result['contact_first']; ?>" <? if ($_REQUEST['customer'][$i] ==  $con_sql_result['contact_first']) { echo 'selected'; }  ?>>
                                                        <? echo $con_sql_result['contact_first']; ?>
                                                    </option>
                                                <?
                                                    $i++;
                                                } } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label>From Call Login Date</label>
                                            <input type="date" name="fromdt" class="form-control" value="<? if ($_REQUEST['fromdt']) { echo  $_REQUEST['fromdt']; } else { echo '2023-01-01'; } ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label>To Call Login Date</label>
                                            <input type="date" name="todt" class="form-control" value="<? if ($_REQUEST['todt']) { echo  $_REQUEST['todt']; } else { echo date('Y-m-d'); } ?>">
                                        </div>

                                        
                                         <div class="col-sm-3">
                                            <label>Call Type</label>
                                            <select name="call_type" id="call_type" class="form-control">
                                                <option value="">-- Select --</option>
                                                
                                                <?
                                                $callTypesql = mysqli_query($con,"Select * from callType where status=1");
                                                while($callTypesql_result = mysqli_fetch_assoc($callTypesql)){
                                                    
                                                    $callTypeId = $callTypesql_result['id'];
                                                    $call_type_val = $callTypesql_result['call_type'];
                                                    
                                                     if(in_array($callTypeId,$callTypePermission_AR)){ ?>
                                                            <option value="<?php echo $call_type_val ;?>" >
                                                                <?php echo $call_type_val ;?>
                                                            
                                                            </option>
                                                    <?php }
                                                }
                                                
                                                ?>
            
                                            </select>
                                        </div>
                                        
                                        
                                        <script>
                                            $(document).on('change','#call_type',function(){
                                               call_type= $(this).val();
                                               
                                               if(call_type=='Project'){
                                                   option = `
                                                        <option value="">Select</option>
                                                   `; 
                                               }else if(call_type=='Service'){
                                                option = `
                                                <option value="">Select</option>
                                                <option value="Customer / Bank">Customer / Bank</option>
                                                <option value="Internal">Internal</option>
                                                `;

                                               }else if(call_type=='Footage'){
                                                option = `
                                                    <option value=""> -- Select --</option>
                                                    <option>Transaction</option>
                                                    <option>Audit Case</option>
                                                    <option>BO Case </option>
                                                    <option>Chargeback</option>
                                                    <option>Fraud / Skimming / CRM Case</option>
                                                    <option>Cyber Crime</option>
                                                    <option>Dispute</option>
                                                    <option>Customer Request</option>
                                                    <option>Police Case</option>
                                                    <option>Shutter Assembly / Pre Arbitration</option>
                                                    `;
                                               }
                                               
                                               $("#call_receive").html(option);
                                            });
                                        </script>
                                        
                            
                                        <!--<div class="col-sm-3">-->
                                        <!--    <label>Call Receive From </label>-->
                                        <!--    <select name="call_receive" id="call_receive" class="form-control"></select>-->
                                        <!--</div>-->
                                        
                                        
                                        
                                        <div class="col-sm-3">
                                            <label>Banks</label>
                                            
                                              <select id="multiselect_banks" class="form-control" name="bank[]" multiple="multiple">
                                                <?
                                                $i = 0;
                                                $bank_sql = mysqli_query($con, "select distinct(bank) as bank from mis_newsite where status='1'");
                                                while ($bank_sql_result = mysqli_fetch_assoc($bank_sql)) { 
                                                  
                                                  $bankName = $bank_sql_result['bank'] ; 
                                         if(in_array($bankName,$bankPermission_AR)){ ?>
                                                  
                                                ?>
                                                    <option value="<? echo $bankName; ?>" <?  if(isset($_REQUEST['bank'])) { 
                                                    
                                                    if(in_array($bankName,$_REQUEST['bank'])){
                                                        echo 'selected';
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    >
                                                        <? echo $bankName; ?>
                                                    </option>
                                                <?
                                                    $i++;
                                         }
                                                } ?>
                                            </select>
                                            
                                        </div>
                            


                                        <div class="col-md-3">
                                            <label>Status</label>
                                            <select id="multiselect_status" class="form-control" name="status[]" multiple="multiple">
                                                <?
                                                $i = 0;
                                                $status_sql = mysqli_query($con, "select status_code,status_name from mis_status where status='1'");
                                                while ($status_sql_result = mysqli_fetch_assoc($status_sql)) { 
                                                    if($status_sql_result['status_code']=="material_pending"){ 
                                                        $status_sql_result['status_code'] = "MRS";
                                                    }
                                                ?>
                                                    <option value="<? echo $status_sql_result['status_code']; ?>" <?  if(isset($_REQUEST['status'])) { 
                                                    
                                                    if(in_array($status_sql_result['status_code'],$_REQUEST['status'])){
                                                        echo 'selected'; 
                                                        
                                                    }
                                                    }else{
                                                        if($status_sql_result['status_name']!='Closed'){
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    >
                                                        <? echo $status_sql_result['status_name']; ?>
                                                    </option>
                                                <?
                                                    $i++;
                                                } ?>
                                            </select>
                                        </div>


                                        
                                        
                                        
                                    </div>
                                    <br><br>
                                    <div class="col" style="display:flex;justify-content:center;">
                                        <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                        <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                    </div>

                                </form>

                                <hr>

                            </div>
                        </div>

                        <style>
                            .indication {
                                display: flex;
                                background: #404e67;
                            }

                            .indication span {
                                width: 15px;
                                height: 15px;
                                border: 1px solid white;
                                border-radius: 25px;
                                margin: 10px;
                            }

                            .open {
                                background: white;
                            }

                            .close {
                                background: #e29a9a;
                            }

                            .schedule {
                                background: #d09f45;
                            }

                            th.address,
                            td.address {
                                white-space: inherit;
                            }
                        </style>


                        <? if (isset($_REQUEST['submit']) || isset($_GET['page'])) { ?>

                            <div class="card">
                                <div class="card-block">
                                    <div style="display:flex;justify-content:space-around;">
                                        <h5 style="text-align:center;">MIS Detailed Report - <p>Total Records- <? echo $total_records ;  ?></p></h5>

                                        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    </div>
                                    
                                    
                                        <form action="exportMis.php" method="POST">
                                            <input type="hidden" name="exportSql" value="<? echo $statement; ?>">
                                            <input type="submit" name="exportMis" class="btn btn-primary" value="Export">
                                        </form>
                                        
                                        
                                    <hr>
                                    
                                    <h5 style="text-align:right;" id="row_count"></h5>
                                    <div class="custom_table_content">
                                        <table class="table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>SR</th>
                                                    <th>TicketId</th>
                                                    <th>Customer</th>
                                                    <th>Bank</th>
                                                    <th>Atmid</th>
                                                    <th>Atm Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Branch</th>
                                                    <th>Call Type</th>
                                                    <th>Call Receive From</th>
                                                    <th>Component</th>
                                                    <th>Sub Component</th>
                                                    <th>Current Status</th>
                                                    <th>Current Status Remarks</th>
                                                    <th>Schedule Date</th>
                                                    <th>Schedule Remark</th>
                                                    <th>Material Condition</th>
                                                    <th>Required Material Name</th>
                                                    <th>Material Remark</th>
                                                    <th>Courier Agency (Material Dispatch)</th>
                                                    <th>POD (Material Dispatch)</th>
                                                    <th>Serial Number</th>
                                                    <th>Material dispatch date </th>
                                                    <th>Material Dispatch Remark</th>
                                                    
                                                    <th>Old Material Details</th>
                                                    
                                                    <th> DOCKET NO</th>
                                                    <th> REQUEST FOOTAGE DATE</th>
                                                    <th> Time From</th>
                                                    <th> Time To</th>
                                                    <th>Attachment (Close)</th>
                                                    <th>Close Type</th>
                                                    <th>Close Remark</th>
                                                    <th>Last Action By</th>
                                                    <th>Last Action Date</th>
                                                    <th>Call Log Date</th>
                                                    <th>Call Log By</th>
                                                    <th>BM</th>
                                                    <th>Aging</th>
                                                    <th>Call Log Remark</th>
                                                    <th>Engineer Name</th>
                                                    <th>Engineer Contact Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $date = date('Y-m-d');
                                                    $date1 = date_create($date);
    
                                                    $i = 0;
                                                    
                                                    $counter = ($current_page - 1) * $page_size + 1;
                                                    $sql_app = mysqli_query($con, $sql_query);
                                                    
                                                    while ($sql_result = mysqli_fetch_assoc($sql_app)) {
                                                        $id = $sql_result['id'];
                                                        $createdBy = $sql_result['createdBy'];
                                                        $site_eng_contact = $sql_result['eng_name_contact'];
                                                        if($site_eng_contact==''){
                                                            $site_engineer = "";
                                                            $site_engineer_contact = "";
                                                        }else{
                                                            $site_engcontact = explode("_",$site_eng_contact);
                                                            $site_engineer = $site_engcontact[0];
                                                            $site_engineer_contact = $site_engcontact[1];
                                                        }
                                                        
                                                        $mis_id = $sql_result['mis_id'];
                                                        // echo $mis_id;
                                                        
                                                        $historydate = mysqli_query($con,"select created_at from mis_history where mis_id='".$id."' order by id desc limit 1");
                                                        $created_date_result = mysqli_fetch_row($historydate);
                                                        $created_date = $created_date_result[0];

                                                        $customer = $sql_result['customer'];
                                                        $closed_date = $sql_result['close_date'];
    
                                                        if ($closed_date != '0000-00-00') {
                                                            $date1 = date_create($closed_date);
                                                        }
    
                                                        $date2 = $sql_result['created_at'];
                                                        $cust_date2 = date('Y-m-d', strtotime($date2));
    
                                                        $cust_date2 = date_create($cust_date2);
                                                        $diff = date_diff($date1, $cust_date2);
                                                        $atmid = $sql_result['atmid'];
    
                                                        $bm_name = $sql_result['bm'];
    
                                                        $status = $sql_result['status'];
                                                        $created_by = $sql_result['created_by'];
                                                        $aging_day = $diff->format("%a");
                                                        
                                                        $mis_his_key = 0;
                                                        // echo "select type,created_by,remark,schedule_date,material,material_condition,courier_agency,pod,serial_number,dispatch_date,(SELECT name FROM mis_loginusers WHERE id=mis_history.created_by) AS last_action_by from mis_history where mis_id='" . $id . "' order by id desc";
                                                        $lastactionsql = mysqli_query($con, "select type,created_by,remark,schedule_date,material,material_condition,courier_agency,pod,serial_number,dispatch_date,(SELECT name FROM mis_loginusers WHERE id=mis_history.created_by) AS last_action_by from mis_history where mis_id='" . $id . "' order by id desc");
                                                        if($lastactionsql_result = mysqli_fetch_assoc($lastactionsql)){
                                                            // echo '<pre>';print_r($lastactionsql_result);echo '</pre>';die;
                                                            $his_type = $lastactionsql_result['type'];
                                                            

                                                            $lastactionuserid = $lastactionsql_result['created_by'];
                                                            $status_remark = $lastactionsql_result['remark'];
                                                            
                                                            if($mis_his_key==0){
                                                              $last_action_by = $lastactionsql_result['last_action_by'];  
                                                            }
                                                            $mis_his_key = $mis_his_key + 1;
                                                            $schedule_date = "";
                                                            if($his_type=='schedule'){
                                                                $schedule_date = $lastactionsql_result['schedule_date'];
                                                                $schedule_remark =$lastactionsql_result['remark']; 
                                                            }
                                                            
                                                            
                                                            $material = "";$material_req_remark = "";
                                                            if($his_type=='material_requirement' || $his_type=='material_dispatch'){
                                                                $material = $lastactionsql_result['material'];
                                                                $material_req_remark = $lastactionsql_result['remark'];
                                                                $material_condition = $lastactionsql_result['material_condition'];
                                                            }
                                                            $courier_agency = "";$pod = "";$serial_number="";$dispatch_date="";$material_dispatch_remark="";
                                                            if($his_type=='material_dispatch'){
                                                                $courier_agency = $lastactionsql_result['courier_agency'];
                                                                $pod = $lastactionsql_result['pod'];
                                                                $serial_number = $lastactionsql_result['serial_number'];
                                                                $dispatch_date = $lastactionsql_result['dispatch_date'];
                                                                $material_dispatch_remark = $lastactionsql_result['remark'];
                                                            }
                                                            $close_type = "";$close_remark = "";$close_created_at = "";$attachment="";
                                                            if($his_type=='close'){
                                                                $close_type = $lastactionsql_result['close_type'];
                                                                $close_remark = $lastactionsql_result['remark'];
                                                                $close_created_at = $lastactionsql_result['created_at'];
                                                                $attachment = $lastactionsql_result['attachment'];
                                                            }
                                                        }
                                                        
                                                        $matCondition = mysqli_query($con,"select * from mis_history where mis_id='".$id."' ORDER BY `mis_history`.`material_condition` DESC");
                                                        $matConditionResult = mysqli_fetch_assoc($matCondition); 
                                                        $material_condition = $matConditionResult['material_condition'];
                                                        
                                                        
                                                        
                                                ?>
                                                    <tr <? if ($aging_day > 3 && $status != 'close') { ?> style="background:#fe5d70c2;color:white;" <? } if ($status == 'close') { ?> style="background:#0ac282;color:white;" <?  } elseif ($status == 'schedule') {  ?> style="background:#6c757d;color:white;" <? } elseif ($status == 'open') {  ?> style="background:yellow;color:black;" <? }  ?>>
                                                        <!--<td><? echo ++$i; ?></td>-->
                                                        <!-- <th><a href="delete_mis.php?id=<? echo $id; ?>" <? if ($aging_day > 3 && $status != 'close') { ?> style="color:white"  <? } ?>>Delete</a></th>-->
                                                        
                                                        <td><? echo $counter; ?></td>
                                                        <td style=" background:white;    border: 1px solid black; ">
                                                            <a style=" text-decoration: none; font-weight: 700;" target="_blank" href="mis_detailsTest.php?id=<? echo $id; ?>" <? if ($aging_day > 3 && $status != 'close') { ?> style="color:white" <? } ?>>
                                                                <? echo ($sql_result['ticket_id'] ? $sql_result['ticket_id'] : '-'); ?>
                                                            </a>
                                                        </td>
                                                        
                                                        <td><? echo ($customer ? $customer : '-'); ?></td>

                                                        <td><? echo ($sql_result['bank'] ? $sql_result['bank'] : '-'); ?></td>
                                                        <td><? echo ($atmid ?$atmid : '-'); ?></td>

                                                        <td>
                                                            <? echo ( $sql_result['location'] ? $sql_result['location']: '-'); ?>

                                                        </td>
                                                        <td><? echo ($sql_result['city'] ? $sql_result['city']: '-'); ?></td>
                                                        <td><? echo ($sql_result['state'] ? $sql_result['state'] : '-'); ?></td>
                                                        <td><? echo ($sql_result['branch'] ? $sql_result['branch']: '-'); ?></td>
                                                        
                                                        
                                                        <td><? echo ($sql_result['call_type'] ? $sql_result['call_type']: '-'); ?></td>
                                                        <td><? echo ($sql_result['case_type'] ? $sql_result['case_type'] : '-'); ?></td>
                                                        
                                                        
                                                        <td><? echo ($sql_result['component'] ? $sql_result['component']: '-'); ?></td>
                                                        <td><? echo ($sql_result['subcomponent'] ? $sql_result['subcomponent']: '-'); ?></td>
                                                        <td><? echo ($status ? $status: '-'); ?></td>
                                                        <td><? echo ($status_remark ? $status_remark : '-'); ?></td>
                                                        <td><? echo ($schedule_date ? $schedule_date: '-');  ?></td>
                                                        <td><? echo ($schedule_remark ? $schedule_remark : '-'); ?></td>
                                                        <td><? echo ($material_condition ? $material_condition: '-'); ?></td>
                                                        <td><? echo ($material ? $material: '-');  ?></td>
                                                        <td><? echo ( $material_req_remark ? $material_req_remark: '-');  ?></td>
                                                        
                                                        <td><? echo ( $courier_agency ? $courier_agency: '-');  ?></td>
                                                        <td><? echo ( $pod ? $pod: '-');  ?></td>
                                                        <td><? echo ( $serial_number ? $serial_number: '-');  ?></td>
                                                        <td><? echo ( $dispatch_date ? $dispatch_date: '-');  ?></td>
                                                        <td><? echo ( $material_dispatch_remark ? $material_dispatch_remark: '-');  ?></td>

                                                        <td> <? echo (get_mis_history('oldMaterialDetails', 'close', $id) ? get_mis_history('oldMaterialDetails', 'close', $id) : '-') ; ?>  </td>

                                                        <td> <? echo ($sql_result['docket_no'] ? $sql_result['docket_no']: '-'); ?></td>
                                                        <td> <? echo ( $sql_result['footage_date'] ? $sql_result['footage_date']: '-'); ?> </td>
                                                        <td> <? echo ($sql_result['fromtime'] ? $sql_result['fromtime']: '-');?> </td>
                                                        <td><? echo ($sql_result['totime'] ? $sql_result['totime']: '-'); ?> </td>
                                                    
                                                        
                                                        <td>
                                                            <? if ($attachment != '') { ?>

                                                                <a target="_blank" href="http://cssmumbai.sarmicrosystems.com/css/dash/esir/<? echo $attachment;  ?>">http://cssmumbai.sarmicrosystems.com/css/dash/esir/<? echo $attachment;  ?></a>
                                                            <? } ?>

                                                        </td>
                                                        <td><? echo ($close_type ? $close_type: '-');  ?></td>
                                                        <td><? echo ($close_remark ? $close_remark : '-');  ?></td>
                                                        <td><? echo ( $last_action_by ? $last_action_by: '-'); ?></td>
                                                        <!--<td><? // echo $closed_date;  ?></td>-->
                                                        <td><? echo ($created_date ? $created_date: '-'); ?></td>
                                                        <td><? echo ($sql_result['created_at'] ? $sql_result['created_at']: '-'); ?></td>
                                                        <td><? echo ($createdBy ? $createdBy : '-'); ?></td>
                                                        <td><? echo ($bm_name ? $bm_name: '-'); ?></td>
                                                        <td><? echo ($diff->format("%a days") ? $diff->format("%a days"): '-'); ?></td>
                                                        <td><? echo ( $sql_result['remarks'] ? $sql_result['remarks'] : '-'); ?></td>
                                                        <td><? echo ($sql_result['eng_name'] ? $sql_result['eng_name']: '-'); ?></td>
                                                        <td><? echo ($sql_result['eng_contact'] ? $sql_result['eng_contact']: '-'); ?></td>
                                                        
                                                    </tr>


                                                <?  $counter++ ;   } ?>

                                            </tbody>
                                        </table>
                                        
                                        
                                        
                                        


                                    </div>




                                        <? 





$customer = $_REQUEST['customer'] ; 
$customer = http_build_query(array('customer' => $customer));

$status = $_REQUEST['status'] ; 
$status = http_build_query(array('status' => $status));



$atmid = $_REQUEST['atmid'];
$fromdt = $_REQUEST['fromdt'];
$todt = $_REQUEST['todt'];
$local_branch = $_REQUEST['local_branch'];
										
										
										
echo '<div class="pagination"><ul>';
if ($start_window > 1) {

    echo "<li><a href='?page=1&&atmid=$atmid&&$customer&&fromdt=$fromdt&&todt=$todt&&call_type=$call_type&&$status&&local_branch=$local_branch'>First</a></li>";
    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid='.$atmid.'&&'.$customer.'&&fromdt='.$fromdt.'&&todt='.$todt.'&&call_type='.$call_type.'&&'.$status.'&&local_branch='.$local_branch.'">Prev</a></li>';
}

for ($i = $start_window; $i <= $end_window; $i++) {
?>
    <li class="<? if ($i == $current_page) { echo 'active'; }?>" >
        <a href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&<? echo $customer; ?>&&fromdt=<? echo $fromdt; ?>&&todt=<? echo $todt; ?>&&call_type=<? echo $call_type; ?>&&<? echo $status; ?>&&local_branch=<? echo $local_branch; ?>" >
            <? echo $i;  ?>
        </a>        
    </li>

 <? }

if ($end_window < $total_pages) {

    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid='.$atmid.'&&'.$customer.'&&fromdt='.$fromdt.'&&todt='.$todt.'&&call_type='.$call_type.'&&'.$status.'&&local_branch='.$local_branch.'">Next</a></li>';
    echo '<li><a href="?page=' . $total_pages . '&&atmid='.$atmid.'&&'.$customer.'&&fromdt='.$fromdt.'&&todt='.$todt.'&&call_type='.$call_type.'&&'.$status.'&&local_branch='.$local_branch.'">Last</a></li>';
}
echo '</ul></div>';
										
										
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

                        <? } ?>

                        <script>
                            $('.update_remark').on('submit', function(e) {
                                e.preventDefault();
                                var remark = $(this).find("[name='update_remark']").val();
                                var misid = $(this).find("[name='misid']").val();
                                $.ajax({
                                    type: 'post',
                                    url: 'updatemisremark.php',
                                    data: 'remark=' + remark + '&&misid=' + misid,
                                    success: function(msg) {
                                        if (msg == 1) {
                                            swal('Updated !');
                                            setTimeout(function() {
                                                window.location.reload();
                                            }, 3000);


                                        } else if (msg == 0) {
                                            swal('Error in updated !');
                                        } else if (msg == 2) {
                                            swal('Remark should not be empty !');
                                        }
                                    }
                                });


                            });
                        </script>








                    </div>
                </div>


            </div>
        </div>
    </div>


<? include('footer.php');
} else { ?>

    <script>
        window.location.href = "login.php";
    </script>
<? }
?>

<script>
    $(document).ready(function() {
        $('#multiselect').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

        $('#multiselect_bm').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });



        $('#multiselect_banks').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
        
        $('#multiselect_status').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });




    });


    $("#show_filter").css('display', 'none');

    $("#hide_filter").on('click', function() {
        $("#filter").css('display', 'none');
        $("#show_filter").css('display', 'block');
    });
    $("#show_filter").on('click', function() {
        $("#filter").css('display', 'block');
        $("#show_filter").css('display', 'none');
    });



</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>-->




<script>
    //  $(document).ready(function() {
    //     $('.js-example-basic-single').select2();
    // });
</script>


</body>

</html>