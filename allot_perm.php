<?php 
include('config.php');

if($_SESSION['username']){ 

include('header.php');

error_reporting(0);
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">

            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <?php 
                                            $id = $_GET['id'];
                                            // echo $id;
                                            $sql = mysqli_query($con,"select * from mis_loginusers where id = '".$id."'");
                                            $sql_result = mysqli_fetch_assoc($sql);
                                            
                                            $zone = $sql_result['zone'];
                                            // echo $zone;
                                            $is_zone_empty = 1;
                                            if($zone!=''){
                                                $is_zone_empty = 0;
                                              $zone = explode (",", $zone);
                                            }
                                            
                                          	$user_customer = $sql_result['cust_id'];
                                        //   	print_r($zone);
                                          	
                                          	if($user_customer!=''){
                                            $user_customer = explode (",", $user_customer);
                                          	}else{
                                          	   $user_customer = array(); 
                                          	}
                                          	
                                          	$bankPermission = $sql_result['bankPermission'];
                                          	$bankPermission_AR = explode(',',$bankPermission);
                                          	
                                          	$callTypePermission = $sql_result['callTypePermission'];
                                          	$callTypePermission_AR = explode(',',$callTypePermission);
                                            
                                            // print_r($user_customer);
                                            ?>
                                        
                                        <form action="process_allot_perm_test.php" method="POST">
                                            <input type="hidden" name="userid" value="<?php echo $id; ?>">
                                            
                                            
                                            
                                            <h3>Call Type</h3>
                                            <div class="row">
                                                    
                                            
											    <?
											    $callTypeSql = mysqli_query($con,"select * from callType where status=1");
											    while($callTypeSql_resut = mysqli_fetch_assoc($callTypeSql)){
											        
											        $callTypeId = $callTypeSql_resut['id'];
											        $call_type = $callTypeSql_resut['call_type'];
											        ?>
											        
											        
                                                <div class="col-sm-12">
											        
											          <input type="checkbox" name="callTypes[]" value="<?php echo $callTypeId ; ?>"  <?php if(in_array($callTypeId,$callTypePermission_AR)){ echo 'checked' ; } ?> >
                                                           <?php echo $call_type; ?>
											        
											        
                                                </div>
											        <?
											        
											    }
											    
											    ?>
											    
											    </div>
											    
											    
											    <hr />
											    
											    <h3>Banks</h3>
                                            <div class="row">
                                                    
                                            
											    <?
											    $bankSql = mysqli_query($con,"select DISTINCT(bank) as bank FROM `mis_newsite` where status=1");
											    while($bankSql_resut = mysqli_fetch_assoc($bankSql)){
											        
											        $bankName = $bankSql_resut['bank'];
											        ?>
											        
											        
                                                <div class="col-sm-2">
											        
											          <input type="checkbox" name="banks[]" value="<?php echo $bankName ; ?>"   <?php if(in_array($bankName,$bankPermission_AR)){ echo 'checked' ; } ?>  >
                                                           <?php echo $bankName; ?>
											        
											        
											        
                                                </div>
											        <?
											        
											    }
											    
											    ?>
											    
											    </div>
											    
											    
											    
											    
											    
											    
											    
											    
											    <hr />
											    
											    
											    <h3>Customers</h3>
											<div class="row">
											    
											    
											    
											    
											    
											
												
														  <?php //$_client = $user_customer[$i];;
													        $_custsql = mysqli_query($con,"select contact_first from contacts where type='c'");
													       // and contact_first in ( 'AGS' ,'Diebold' ,'Euronet', 'Hitachi', 'FSS' ,'TATA','BajajFinan')
                                                            while($cust_sql_result = mysqli_fetch_assoc($_custsql)){
																$_cust = $cust_sql_result['contact_first'];
															 //   print_r($_cust);
													      ?>
													      <div class="col-sm-3">                                               
                                                           <input type="checkbox" name="cust_id[]" value="<?php echo $_cust?>"  <?php if(in_array($_cust,$user_customer)){ echo 'checked' ; } ?> >
                                                           <?php echo $_cust;?>
                                                        </div> 
														  
															<?php }
															        
															?>
														
														
												
											
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <?
                                                    $zone_sql = mysqli_query($con,"select distinct(zone) as zone from mis_branch_zone_master where zone <>'' order by zone");
                                                    while($zone_sql_result = mysqli_fetch_assoc($zone_sql)){ ?> 
                                                        <div class="col-sm-3">                                               
                                                           <input type="checkbox" class="zone" name="zone[]" value="<?php echo $zone_sql_result['zone']?>"  <?php if($is_zone_empty==0){ if(in_array($zone_sql_result['zone'],$zone)){ echo 'checked' ; } }?> >
                                                           <?php echo $zone_sql_result['zone'];?>
                                                        </div> 
                                                    <?php } ?>
                                                    
                                                    

                                            </div>
                                             
                                             <hr>
                                             <div class="custrow" id="here">
                                                 
                                             </div>
                                             
                                       
                                       <div class="row">
                                           <div class="col-sm-4">
                                               <br><br>
                                               <input type="submit" name="submit" class="btn btn-danger">
                                           </div>
                                       </div>
                                          
                                        </form>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <?php include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<?php }
    ?>
    
    
    <script>
    
    
    var userid = '<?php echo $_GET['id'];?>'
    var searchIDs = $('input.zone:checked').map(function(){
        
      return $(this).val();
        
    });
    

    
    var zone = searchIDs.get().join();
      $.ajax({
            type: "POST",
            url: 'perm_ajax.php',
            data: 'zone='+zone+'&user='+userid,
            success:function(msg) {
                $("#here").html(msg);
            }
          });

    
    $(document).on('change','.zone',function(){
   
    var searchIDs = $('input.zone:checked').map(function(){
        
      return $(this).val();
        
    });

      $.ajax({
            type: "POST",
            url: 'perm_ajax.php',
            data: 'zone='+searchIDs.get()+'&user='+userid,
            success:function(msg) {
                $("#here").html(msg);
            }
          });
    
});
    </script>

</body>

</html>
                                        
                                        