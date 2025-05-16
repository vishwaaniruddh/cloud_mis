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
                                        <style>
                                            html{
                                                text-transform: inherit !important;
                                            }
                                        </style>
                                        <?
                                        $boq_id = $_GET['id'];
                                        
                                        if(isset($boq_id)){ 
                                            
                                            if(isset($_REQUEST['contact_person_name'])){
                                                $contact_person_name = $_REQUEST['contact_person_name'];
                                                $contact_person_number = $_REQUEST['contact_person_number'];
                                                $address_type = $_REQUEST['address_type'];
                                                $address = $_REQUEST['address'];
                                                
                                                $boq_dispatch = "insert into boq_dispatch(boq_id,contact_person_name,contact_person_number,address_type,address,status) 
                                                values('".$boq_id."','".$contact_person_name."','".$contact_person_number."','".$address_type."','".$address."',1)";
                                                if(mysqli_query($con,$boq_dispatch)){ 
                                                $url = 'installation_process.php?id='.$boq_id;
                                                ?>
                                                   <script>
                                                       alert('Dispatch Info Added Successfully !');
                                            
                                                       window.location.href="<? echo $url; ?>";
                                                   </script> 
                                                <? }
                                                
                                            }
                                            
                                            ?>
                                            
                                            <form action="<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $boq_id; ?>" method="POST">
                                                
                                            <h5>Dispatch</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Contact Person Name</label>
                                                    <input type="text" name="contact_person_name" class="form-control" required>
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <label>Contact Person Number</label>
                                                    <input type="text" name="contact_person_number" class="form-control" required>
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Address Type</label>
                                                    <select class="form-control" id="address_type" name="address_type" required>
                                                        <option value="Branch">Branch</option>
                                                        <option value="Other" id="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-9"><label>Address</label> <input class="form-control" name="address" id="address" value="Branch" required></div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <input type="submit" class="btn btn-success" value="submit2">
                                            </div>
                                        </form>
                                            <? 
                                        }else{
                                            $atmid = $_REQUEST['atmid'];
                                            $atmid2 = $_REQUEST['atmid2']; 
                                            $atmid3 = $_REQUEST['atmid3']; 
                                            $serial_number = $_REQUEST['serial_number']; 
                                            $bank = $_REQUEST['bank']; 
                                            $customer = $_REQUEST['customer']; 
                                            $address = $_REQUEST['address'];
                                            $city = $_REQUEST['city']; 
                                            $state = $_REQUEST['state']; 
                                            $pincode = $_REQUEST['pincode']; 
                                            $engineer = $_REQUEST['engineer']; 
                                            $engineer_number = $_REQUEST['engineer_number']; 
                                            $bm_name = $_REQUEST['bm_name']; 
                                            $selection_type = $_REQUEST['selection_type']; 
                                            
                                            $material = $_REQUEST['material'];
                                            $qty = $_REQUEST['qty'];
                                            $remark= $_REQUEST['remark'];
                                            
                                            
                                            $sql = "insert into boq_raise(atmid,atmid2,atmid3,serial_number,bank,customer,address,city,state,pincode,engineer,engineer_number,bm_name,selection_type,status,created_at,created_by) 
                                                        values('".$atmid."','".$atmid2."','".$atmid3."','".$serial_number."','".$bank."','".$customer."','".$address."','".$city."','".$state."','".$pincode."','".$engineer."','".$engineer_number."','".$bm_name."','".$selection_type."',1,'".$datetime."','".$userid."' )";


                                                if(mysqli_query($con,$sql)){
                                                    $insert_id = $con->insert_id;
                                                    $i=0;
                                                        foreach($material as $matk=>$matv){
                                                            $detail_sql = "insert into boq_raise_detail(boq_id,material,qty,remark,status) 
                                                            values('".$insert_id."','".$matv."','".$qty[$i]."','".$remark[$i]."',1)";
                                                            mysqli_query($con,$detail_sql);
                                                            $i++;
                                                        }
                                                }    

                                                $url = 'installation_process.php?id='.$insert_id;
                                                ?>
                                                <script>
                                                    window.location.href="<? echo $url; ?>" ;
                                                </script>
                                                <?



                                        }
                                                
                                        
                                        ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
              <script>

 $(document).on('change','#address_type',function(){
        var address_type = $('#address_type').val();
        if(address_type=='Branch'){
            $('#address').val('Branch');
            $('#address').attr('readonly',true);
            $('#address').show();
        }
        if(address_type=='Other'){
            $('#address').val('');
            $('#address').attr('readonly',false);
        }
                            
 });
     
                

              </script>      
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