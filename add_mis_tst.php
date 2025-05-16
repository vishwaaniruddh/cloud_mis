<? session_start();
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







?>

                                                          
   	<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript" src="typeahead.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  


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
                                                            <input type="text" name="atmid" id="atmid" class="form-control" placeholder="Atm ID">
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
                                <? $con_sql = mysqli_query($con,"select * from contacts where type='c'");
                                   while($con_sql_result = mysqli_fetch_assoc($con_sql)){ ?>
                                      <option value="<? echo strtoupper($con_sql_result['contact_first']); ?>">
                                   <? echo strtoupper($con_sql_result['contact_first']); ?>
                                </option> 
                                   <? } ?>
                  		    </select>
                  		</div>


                		
                						
                						<div class="col-sm-2">
                						    <label class="label_label">Zone</label>
                    						<input class="form-control" type="text" name="zone" id="zone" value="<? echo $zone ; ?>">
                						</div>


                						
                						<div class="col-sm-2">
                						    <label class="label_label">City</label>
                    						<input class="form-control" type="text" name="city" id="city" value="<? echo $city; ?>" required>
                						</div>
                						
                						
                						
                  						<div class="col-sm-2">
                						    <label class="label_label">State</label>
                    						<select name="state"  id ="state" class="form-control" required>
                    						    <option value="">Select State</option>
                    						    <?
                    						        $state_sql = mysqli_query($con,"select * from state order by state");
                    						        while($state_sql_result = mysqli_fetch_assoc($state_sql)){ ?>
                    						            <option value="<? echo $state_sql_result['state']; ?>" <? if($state == $state_sql_result['state']){ echo 'selected'; } ?>>
                    						                <? echo $state_sql_result['state'];?>
                    						            </option>
                    						        <? } ?>
                    						</select>

                						</div>
                						<div class="col-sm-6">
                						    <label class="label_label">Locations</label>
                    						<input class="form-control" type="text" name="location" id="location" value="<? echo $location ; ?>">
                						</div>
                						
                						
                                            </div>
                                        <div class="row">
    
    
    <div class="col-sm-4">
        <label>Css Branch Name</label>
        <input type="text" class="form-control" name="branch" id="branch">
    </div>
    
    <div class="col-sm-4">
        <label>Css BM</label>
        <input type="text" class="form-control" name="bm" id="bm">
    </div>
    
    <div class="col-md-4">
		<label>Engineer</label>
		<select name = "engineer" id = "engineer" class="form-control js-example-basic-single w-100" >
		    <option value = "">Select</option>
		    <?php $engineer= mysqli_query($con,"SELECT * from mis_loginusers where designation=4 order by name ASC"); 
		        while($fetch_data = mysqli_fetch_assoc($engineer)){
		     ?>
		     <option value="<? echo $fetch_data['id'] ?>" <? if($_POST['engineer']==$fetch_data['id']){ echo 'selected'; }  ?>>
		         <?php echo ucwords($fetch_data['name']);?>
		     </option>
		     <? } ?>
		</select>
	</div>
    
    
    <div class="col-sm-4">
        <label>Call Receive From</label>
        <select class="form-control" name="call_receive" id="call_receive" reuqired>
            <option value="">Select</option>
            <option value="Customer">Customer</option>
            <option value="Internal">Internal</option>
        </select>

    </div>
</div>
                                            <hr>
                                <div class="row selectContainer" style="padding: 15px;"></div>
                                <br>
 <input type="button" id="add" class="btn btn-primary" onclick="addOptionTags()" value="Add More +">                                

                                <br><br>
                                
                                
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
                    
                    
    <? 
    }
else{ ?>
    
    <script>
        window.location.href="=login.php";
    </script>
<? }
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

                
                    
                }
                else{
                    alert('No Info With This ATM');
                    
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
        
        
        
var Set1 = <? echo $data; ?>;        
        
var Set2 = <? echo $data2; ?>;
                    
                    
                    
    function addOptionTags() {
        GroupCount++;
        var sId = 'comp-'+GroupCount;
        var s = $('<select id="'+sId+'" class="comp typeahead col-sm-4" name="comp[]"  required />');
        var s2 = $('<select id="subcomp-'+sId+'" class="subcomp typeahead col-sm-4" name="subcomp[]" onchange="checkComp('+GroupCount+')" required />');
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
        
        
        function LoadSet2Options(fk, set2Id) { debugger;
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
            var subcomp = $('#subcomp-comp-'+key).find('option:selected').text();
            var atmid = $('#atmid').val();
            $.ajax({
            type: "POST",
            url: 'add_mis_comp_check.php',
            data: {atmid:atmid,component:comp,subcomponent:subcomp},
            success:function(msg) {
                if(msg==1){
                    $('#subcomp-comp-'+key).val("");
                    swal("Warning !", "Firstly Close selected subcomponent for this atmid !", "error");
                }
            }
           });
        }
        
        


        $(".selectContainer").on('change', '.comp', function() { debugger;
            LoadSet2Options($(this).val(), "subcomp-"+$(this).attr("id"));
            var str = $(this).attr("id");
            var splitstr = str.split("-");
           // checkComp(splitstr[1]);
        });
        $(document).ready(function() {
            addOptionTags();
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