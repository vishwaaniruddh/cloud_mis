<?php session_start();
include('config.php');


if($_SESSION['username']){ 


include('header.php');


 
	$sql1 = mysqli_query($con,"SELECT * FROM mis_component where status=1");
		while($row1 = mysqli_fetch_assoc($sql1)) {
		$name1= $row1["name"];
        $id1= $row1["id"];
        $result1[] =  ['id'=>$name1,'name'=>$name1];
        
		}
		$data =  json_encode($result1);
		
		
		
  $sql2 = mysqli_query($con,"SELECT * FROM mis_subcomponent WHERE status=1 order by id desc");
		while($row2 = mysqli_fetch_assoc($sql2)) {
    		$model2= $row2["name"];
            $component_id= $row2["component_id"];
            $id = $row2['id'];
        
        $result2[] =  ['id'=>$id,'fk'=>$component_id,'name'=>$model2];
        
		}
		
	$data2 =  json_encode($result2);




$callTypePermission = $_SESSION['callTypePermission'];
$callTypePermission_AR = explode(',',$callTypePermission) ;

$bankPermission = $_SESSION['bankPermission'];
$bankPermission_AR = explode(',',$bankPermission);




?>

                                                          
   	<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript" src="typeahead.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  
<script>
    function addOptionTags() {
        GroupCount++;
        var sId = 'comp-'+GroupCount;
        var s = $('<select id="'+sId+'" class="form-control comp typeahead col-sm-4" name="comp[]"  required />');
        var s2 = $('<select id="subcomp-'+sId+'" class="form-control subcomp typeahead col-sm-4" name="subcomp[]" onchange="checkComp('+GroupCount+')" required />');
        var docket = $('<input type="text" name="docket_no[]" class="form-control col-sm-4" placeholder="Docket No." required>');
        
        $("<option value=''> Select comp</option>").appendTo(s);
        $("<option value=''> Select subcomp</option>").appendTo(s2);
    
        
        for(var val of Set1) {
            $("<option />", {value: val.id, text: val.name}).appendTo(s);
        }
            
            s.appendTo(".selectContainer");
            s2.appendTo(".selectContainer");
            docket.appendTo(".selectContainer");
        
        }
</script>

<style>
.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
    text-decoration: none;
    background-color: #bae4e6;
    outline: 0;
}


.dropdown-menu{
    /*display:block !important;*/
}
.col-sm-12{
        margin: 1% auto;
}
    .table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
th, td {
    white-space: nowrap;
}
th {
    text-align: inherit;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #404e67 !important;
}
    

    select, input {
        text-transform: uppercase;
}

@media (min-width: 576px) {
    .modal-dialog {
        max-width: 1500px;
        margin: 1.75rem auto;
           width: 100%;

    }    

}

.btn.focus, .btn:focus, .btn:hover {
    color: white;
    text-decoration: none;
}


	</style>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!--<a href="add_site.php" class="btn btn-dark">Takeover Form</a>-->
                                <br>
                            <div class="page-body">
                                
                                <div class="card">
                                    <div class="card-block">
                                    
                                        <form id="form" action="process_addMis.php" method="POST"> <!-- add_mis_process_check -->
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>ATM ID</label>
                                                        <div class="input-group input-group-button">
                                                            <input type="text" name="atmid" id="atmid" class="form-control" placeholder="Atm ID" required>
                                                        </div>
                                                </div>
                             
                             
						<div class="col-sm-4">
						    <label class="label_label">Bank</label>
                            <input type="text" name="bank" id="bank" class="form-control">
						</div>

                		<div class="col-sm-4">
                  			<label>Customer</label>
                  			<select class="form-control" id="customer" name="customer" required>
                  			    <option value="">Select Customer</option>
                                <?php $con_sql = mysqli_query($con,"select * from contacts where type='c'");
                                   while($con_sql_result = mysqli_fetch_assoc($con_sql)){ ?>
                                      <option value="<?php echo strtoupper($con_sql_result['contact_first']); ?>">
                                   <?php echo strtoupper($con_sql_result['contact_first']); ?>
                                </option> 
                                   <?php } ?>
                  		    </select>
                  		</div>
                  		</div>
                  		<div class="row">
                  		    <div class="col-sm-2">
                  		        <label class="label_label">Zone</label>
                  		        <input class="form-control" type="text" name="zone" id="zone" value="<?php echo $zone ; ?>">
                  		    </div>
                  		    
                  		    <div class="col-sm-2">
    						    <label class="label_label">City</label>
        						<input class="form-control" type="text" name="city" id="city" value="<?php echo $city; ?>" required>
    						</div>
    						
    						<div class="col-sm-2">
    						    <label class="label_label">State</label>
        						<select name="state"  id ="state" class="form-control" required>
        						    <option value="">Select State</option>
        						    <?php
        						        $state_sql = mysqli_query($con,"select * from state order by state");
        						        while($state_sql_result = mysqli_fetch_assoc($state_sql)){ ?>
        						            <option value="<?php echo $state_sql_result['state']; ?>" <?php if($state == $state_sql_result['state']){ echo 'selected'; } ?>>
        						                <?php echo $state_sql_result['state'];?>
        						            </option>
        						        <?php } ?>
        						</select>

    						</div>
    						<div class="col-sm-6">
    						    <label class="label_label">Locations</label>
        						<input class="form-control" type="text" name="location" id="location" value="<?php echo $location ; ?>">
    						</div>
						</div>
						<br>
						<div class="row">
                        	<div class="col-sm-3">
                                <label>Css Branch Name</label>
                                <input type="text" class="form-control" name="branch" id="branch">
                            </div>
                            
                            <div class="col-sm-3">
                                <label>Css BM</label>
                                <input type="text" class="form-control" name="bm" id="bm">
                            </div>
                            
                        <div class="col-sm-3">
						    <label class="label_label">Engineer</label>
                            <input type="text" name="engineer" id="engineer" class="form-control">
						</div>

                            
                            <div class="col-sm-3">
                                <label>Call Type</label>
                                <select name="call_type" id="call_type" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    
                                    <?
                                    $callTypesql = mysqli_query($con,"Select * from callType where status=1");
                                    while($callTypesql_result = mysqli_fetch_assoc($callTypesql)){
                                        
                                        $callTypeId = $callTypesql_result['id'];
                                        $call_type = $callTypesql_result['call_type'];
                                        
                                         if(in_array($callTypeId,$callTypePermission_AR)){ ?>
                                                <option value="<?php echo $call_type ;?>" >
                                                    <?php echo $call_type ;?>
                                                
                                                </option>
                                        <?php }
                                    }
                                    
                                    ?>

                                </select>
                            </div>
                            

                        </div>
                        
                        <hr>

<style>
#call_result{
    margin:30px;
}
#call_result .card{
    display: block;
    background: #e0e0e0;
    color: white;
    padding: 15px;    
}
#call_result label{
    color:black;
}
input:focus , select:focus{
    border: 3px solid red !important
}

</style>                                      
                                
                            <div id="call_result">

                                
                            </div>
                                
                                
                            <div class="row">    
                                <div class="col-sm-12">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks"></textarea>
                                </div>
                                    
                            </div>                                
                            <br>
                            <div class="row">
                                <div class="col-sm-2">
                                    <input type="submit" id="submit" class="btn btn-danger" value="submit">    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                                
                                
                                <div id="show_history"></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            
            
            <script>
            
            $(document).ready(function(){
                $("#atmid").focus();
            })
            
                $(document).on('change','#call_type',function(){
                    let call_type = $("#call_type").val();
                    console.log(call_type);
                    $("#call_result").html('');
                    if(call_type=='Project'){


                        let a = `<div class="card row" id="Project_section" >
                                <div class="col-sm-12">
                                    <label>Call Receive From</label>
                                    <select class="form-control" name="call_receive" id="call_receive" reuqired>
                                        <option value="">Select</option>
                                        <option value="Customer / Bank">Customer / Bank</option>
                                        <option value="Internal">Internal</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 selectContainer" style="padding: 15px;"></div>

                                <div class="col-sm-4">
                                    <input type="button" id="add" class="btn btn-primary" onclick="addOptionTags()" value="Add More +">
                                </div>    
                            </div>`;
                        $("#call_result").html(a);  
                        $("#add").click();


                    }else if(call_type=='Service'){


                        // addOptionTags();


                        let a = `<div class="card row" id="Service_section" >
                                <div class="col-sm-12">
                                    <label>Call Receive From</label>
                                    <select class="form-control" name="call_receive" id="call_receive" reuqired>
                                        <option value="">Select</option>
                                        <option value="Customer / Bank">Customer / Bank</option>
                                        <option value="Internal">Internal</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 selectContainer" style="padding: 15px;"></div>

                                <div class="col-sm-4">
                                    <input type="button" id="add" class="btn btn-primary" onclick="addOptionTags()" value="Add More +">
                                </div>    
                            </div>`;
                        $("#call_result").html(a);  
                        $("#add").click();
                        
                    }else if(call_type=='Footage'){

                           let a = `<div class="card row" id="Footage_section" >
                                
                                <div class="col-sm-3">
                                    <label>Call Receive from</label>
                                    <select name="call_receive" class="form-control" required>
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
                                    </select>
                                    
                                </div>
                                
                                
                                <div class="col-sm-3">
                                    <label>Docket No</label>
                                    <input type="text" name="docket_no" class="form-control" required>
                                </div>
                                <div class="col-sm-3">
                                    <label>Request by</label>
                                    <input type="text" name="footage_requestBy" class="form-control" required>
                                </div>
                                
                                <div class="col-sm-3">
                                    <label>Footage Format </label>
                                    <input type="text" name="footage_format" class="form-control" required>
                                </div>
                                <div class="col-sm-3">
                                    <label>Request Footage Date</label>
                                    <input type="date" name="footage_date" class="form-control" value="<?php echo $date; ?>" />
                                </div>
                                <div class="col-sm-3">
                                    <label> From </label>
                                    <input type="time" name="fromtime" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                    <label> To </label>
                                    <input type="time" name="totime" class="form-control" />
                                </div>
                                    
                                <div class="col-sm-3">
                                    <label> TXN Time </label>
                                    <input type="time" name="footage_txn_time" class="form-control" />
                                </div>
                                
                            </div>`;
                        $("#call_result").html(a);    
                    }else if(call_type=='Other'){
                        // let a = `<div class="card row" id="Other_section" >Other</div>`;
                        // $("#call_result").html(a);
                    }
                })
            </script>
            
            
                    
    <?php 
    }
else{ ?>
    
    <script>
        window.location.href="=login.php";
    </script>
<?php }
    ?>
    
    
    
    
    























    <script>
        $("#atmid").on('change',function(){
           var atmid = $("#atmid").val();
           
           $.ajax({
            type: "POST",
            url: 'get_atm_data.php',
            data: 'atmid='+atmid,
            success:function(msg) {
                
                console.log(msg);
                 
                if(msg !=0 ){
                    var obj = JSON.parse(msg);
                    var customer = obj['customer'];
                    var bank = obj['bank'];
                    var location = obj['location'];
                    var city = obj['city'];
                    var state = obj['state'];
                    var region = obj['region'];
                    var bm = obj['bm'];
                    var branch = obj['branch'];
                    var engineer = obj['engineer'];
                    
                    
                    if(!customer){
                        $("#customer").focus();
                    }else{
                        $("#customer").val(customer);               $('#customer').attr('readonly', true);
                    }



                    
                    if(!bank){
                        $("#bank").focus();
                    }else{
                        $("#bank").val(bank);               $('#bank').attr('readonly', true);
                    }
                    
                    if(!engineer){
                        $("#engineer").focus();
                    }else{
                        $("#engineer").val(engineer);               $('#engineer').attr('readonly', true);
                    }
                    
                    
                    if(!location){
                        $("#location").focus();
                    }else{
                        $("#location").val(location);           $('#location').attr('readonly', true);                        
                    }
                    
                    if(!region){
                        $("#zone").focus();
                    }else{
                        $("#zone").val(region);             $('#zone').attr('readonly', true);
                    }
                    
                    if(!state){
                        $("#state").focus();
                    }else{
                        $("#state").val(state);             $('#state').attr('readonly', true);                    
                    }
                    
                    if(!city){
                        $("#city").focus();
                    }else{
                        $("#city").val(city);               $('#city').attr('readonly', true);
                        
                    }
                    
                    if(!branch){
                        $("#branch").focus();
                    }else{
                        $("#branch").val(branch);               $('#branch').attr('readonly', true);
                        
                    }
                    
                    if(!bm){
                        $("#bm").focus();
                    }else{
                        $("#bm").val(bm);               $('#bm').attr('readonly', true);
                        
                    }
                    
                    
                    
                    if(customer && bank && location && region && state && city && branch && bm){
                        $("#call_receive").focus();
                    }
                    
                    $("#call_type").focus();

                
                    
                }
                else{
                    alert('No Info With This ATM');
                    
                    $("#atmid").val('');
                    
// $('input[type="text"], textarea').attr('readonly','readonly');
            // $('select').prop('disabled', true);       
                }


            }
});



           $.ajax({
            type: "POST",
            url: 'show_history.php',
            data: 'atmid='+atmid,
            success:function(msg) {
                $("#show_history").html(msg);
            }
           });




           
        });
        
        form.setAttribute( "autocomplete", "off" ); 
// someFormElm.setAttribute( "autocomplete", "off" );




    </script>
    
    
    
    
    
        <script>
        var GroupCount = 0;
        
        
        
var Set1 = <?php echo $data; ?>;        
        
var Set2 = <?php echo $data2; ?>;
                    
                    
                    
        
        
        function LoadSet2Options(fk, set2Id) { 
            var op = $("#"+set2Id);
            op.empty();
            var html = '<option value="">Select SubComponent</option>';
            op.html(html);
            for(var val of Set2) {
                if(val.fk == fk) {
                    $("<option />", {value: val.id, text: val.name}).appendTo(op);
                }
            }
        }
        
        
        function checkComp(key) {
            var comp = $('#comp-'+key).find('option:selected').text(); 
            console.log(comp);
            var subcomp = $('#subcomp-comp-'+key).find('option:selected').text();
            var atmid = $('#atmid').val();
            $.ajax({
            type: "POST",
            url: 'add_mis_comp_check.php',
            data: {atmid:atmid,component:comp,subcomponent:subcomp},
            success:function(msg) {
                console.log('msg = ' + msg );
                if(msg==1){
                    $('#subcomp-comp-'+key).val("");
                    swal("Warning !", "Firstly Close selected subcomponent for this atmid !", "error");
                }
            }
           });
        }
        
        


        $(document).on('change', '.comp', function() {
            LoadSet2Options($(this).val(), "subcomp-"+$(this).attr("id"));
            var str = $(this).attr("id");
            var splitstr = str.split("-");
           // checkComp(splitstr[1]);
        });

        
        
        
        
$('#but_add').click(function(){
  var newel = $('.input-form:last').clone();
  $(newel).insertAfter(".input-form:last");
 });
        
        
</script>



       
    <script src="../files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../files/assets/js/pcoded.min.js"></script>
    <script src="../files/assets/js/vartical-layout.min.js"></script>
    <script type="text/javascript" src="../files/assets/pages/dashboard/custom-dashboard.js"></script>
    
    
</body>

</html>