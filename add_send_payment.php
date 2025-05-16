<? session_start();
    
    include('config.php');
    if($_SESSION['username']){
    include('header.php'); 
    
    $selectsql = "select fund_remark from mis_fund_remarks";
    $select_table=mysqli_query($con,$selectsql);

?>

<style>
    label {
    font-weight: 900;
    font-size: 16px;
}
</style>      

        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="card">
                                <div class="card-block">
                                    <form id="form" method="POST" action="process_add_payment.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Select Type</label>
                                                    <select id="type" name="type[]" class="form-control" onchange="addNewField(this.value)" required>
                                                        <option value="">Select Type</option>
                                                        <option value="SALARY-PAYROLL">SALARY-PAYROLL</option>
                                                        <option value="Vendor payment" selected>Vendor payment</option>
                                                        <option value="UTILITY">UTILITY</option>
                                                        <option value="UTILITY-BILLS">UTILITY-BILLS</option>
                                                        <option value="RNM-FUNDS">RNM-FUNDS</option>
                                                      <!--  <option value="E - Surveillance">E - Surveillance</option>
                                                        <option value="Bajaj">Bajaj</option>
                                                        <option value="GPS">GPS</option>
                                                        <option value="UPS">UPS</option>
                                                        <option value="DVR">DVR</option>
                                                        <option value="Other">Other</option>-->
                                                    </select>
                                                    <br>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                           
                                        	<div class="col-sm-4">
                                                <label>Person Name</label>
                                                    <div class="input-group input-group-button">
                                                        <input type="text" name="atmid[]" id="atmid1" class="form-control" placeholder="Person Name" required>
                                                    </div>
                                            </div>
                                            
                                            
                                           <!-- <div class="col-sm-4">
                    						    <label class="label_label">Bank</label>
                                                <input type="text" name="bank[]" id="bank1" class="form-control" required>
                    						</div> -->
                    
                                    		<div class="col-sm-4">
                                      			<label>Customer</label>
                                      			<select class="form-control" id="customer1" name="customer[]" required>
                                      			    <!--<option value="">Select Customer</option>-->
                                      			    <option value="Comfort">Comfort</option>
                                                    <? /*$con_sql = mysqli_query($con,"select * from contacts where type='c'");
                                                       while($con_sql_result = mysqli_fetch_assoc($con_sql)){ ?>
                                                          <option value="<? echo $con_sql_result['contact_first']; ?>">
                                                       <? echo $con_sql_result['contact_first']; ?>
                                                    </option> 
                                                       <? }*/ ?>
                                      		    </select>
                                      		</div>


                		
                						
                					<!--	<div class="col-sm-4">
                						    <label class="label_label">Zone</label>
                    						<input class="form-control" type="text" name="zone[]" id="zone1" value="<? echo $zone ; ?>" required>
                						</div> -->


                						
                						<div class="col-sm-4">
                						    <label class="label_label">City</label>
                    						<input class="form-control" type="text" name="city[]" id="city1" value="<? echo $city; ?>" required>
                						</div>
                						
                						
                						
                  						<div class="col-sm-4">
                						    <label class="label_label">State</label>
                    						<select name="state[]"  id ="state1" class="form-control" required>
                    						    <option value="">Select State</option>
                    						    <?
                    						        $state_sql = mysqli_query($con,"select * from state order by state");
                    						        while($state_sql_result = mysqli_fetch_assoc($state_sql)){ ?>
                    						            <option value="<? echo $state_sql_result['state']; ?>" <? if($state == $state_sql_result['state']){ echo 'selected'; } ?>>
                    						                <? echo $state_sql_result['state'];?>
                    						            </option>
                    						        <? } ?>
                    						</select>
                                            <br>
                						</div>
                						<div class="col-sm-8" >
                						    
                						    <label class="label_label">Locations</label>
                    						<input class="form-control" type="text" name="location[]" id="location1" value="<? echo $location ; ?>">
                    					    <br>	
                						</div>
                						
                						<div class="col-sm-4">
                                                <label>Select Work</label>
                                                <select name="subtype[]" onchange="selectWork(1,this.value)" class="form-control" required >
                                                   <!-- <option value="">Select Work</option>-->
                                                    <option value="fixed_cost" selected>Fixed cost</option>
                                                    <!--<option value="approval">Approval</option>-->
                                                </select>
                                                <br>
                                        </div>
                						
                						<div class="col-sm-4" >
                						    <label class="label_label">Approved By</label>
                    						<input class="form-control" required type="text" name="approved_by[]" id="approved_by1" value="">
                    				   </div>
                						
                						
                                        
                                        <div class="col-sm-4">
                                                <label>Fund Request Details</label>
                                                <select class="form-control" id="fundDetails1" onchange="fundDetails(1)">
                                                    <option value="">Select</option>
                                                    <? while($fundremarkrow=mysqli_fetch_assoc($select_table)){ 
                                                               
                                                            ?>
                                                            <option value="<? echo $fundremarkrow['fund_remark'] ?>"><? echo $fundremarkrow['fund_remark'] ?></option>
                                                            <? } ?>
                                                   <!-- <option value="Footage Submit Charge">Footage Submit Charge</option>
                                                    <option value="CD Charges">CD Charges</option>
                                                    <option value="New E-Surveillance Installation Charge">New E-Surveillance Installation Charge</option>
                                                    <option value="Re-Installation Charge">Re-Installation Charge</option>
                                                    <option value="E-Surveillance Dismantle Charge">E-Surveillance Dismantle Charge</option>
                                                    <option value="Site Visit Charge">Site Visit Charge</option>
                                                    <option value="SIM Recharge">SIM Recharge</option>
                                                    <option value="">Other</option> -->
                                                </select>
                                                <br>
                                                <input type="hidden" name="fundDetails[]" id="fundReqDetails1" value="">
                                                <input class="form-control" type="text" id="fundDetails_other1" style="display:none;" onchange="setfundDetails(1)">
                                                <span style="display:none;" id="backSelect1" onclick="selectBack(1)">Back Select</span>
                                                <br>
                                        </div>
                                        
                                        
                						<div class="col-sm-4">
                						    <label class="label_label">Required Amount</label>
                    						<input class="form-control required_amount" type="text" name="required_amount[]" id="required_amount1" required>
                						    <br>
                    						
                						</div>
                						<div class="col-sm-4">
                                                <label>Payee Type</label>
                                                <select name="payee_type" class="form-control" required>
                                                    <option value="Vendor">Vendor</option>
                                                    <option value="Employee">Employee</option>
                                                </select>
                                                <br>
                                        </div>
                                        
                                        <div class="col-sm-4">
                						    <label class="label_label">Beneficiary Name</label>
                    						<input class="form-control" type="text" name="beneficiary_name" id="beneficiary_name" required>
                						<br>
                						</div>


                						<div class="col-sm-4">
                						    <label class="label_label">Account Number</label>
                    						<input class="form-control" type="text" name="account_number" id="account_number" required>
<br>
                						</div>
                						
                						

                						<div class="col-sm-4">
                						    <label class="label_label">IFSC Code</label>
                    						<input class="form-control" type="text" name="ifsc_code" id="ifsc_code" required>

<br>    
                						</div>
                						
                						<div class="col-sm-4">
                						    <label class="label_label">Attach</label>
                    						<input class="form-control" type="file" name="image" id="file" >
    <br>
                						</div>
                						
                						<div class="col-sm-12">
                						    <label class="label_label">Remark</label>
                    						<input class="form-control" type="text" name="remark" id="remark" required>
        <br>
                						</div>
                						
                						<div class="col-sm-4">
                						    <label class="label_label">Month</label>
                    						<select name="month" class="form-control" required>
                						        <option value="">Select</option>
                                                <option value="JANUARY">JANUARY</option>
                                                <option value="FEBRUARY">FEBRUARY</option>
                                                <option value="MARCH">MARCH</option>
                                                <option value="APRIL">APRIL</option>
                                                <option value="MAY">MAY</option>
                                                <option value="JUNE">JUNE</option>
                                                <option value="JULY">JULY</option>
                                                <option value="AUGUST">AUGUST</option>
                                                <option value="SEPTEMBER">SEPTEMBER</option>
                                                <option value="OCTOBER">OCTOBER</option>
                                                <option value="NOVEMBER">NOVEMBER</option>
                                                <option value="DECEMBER">DECEMBER</option>
                                            </select>

<br>    
                						</div>
                						
                						<div class="col-sm-4">
                						    <label class="label_label">Year</label>
                    						<select name="year" class="form-control" required>
                						        <option value="">Select</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>    
    <br>
                						</div>
                						
                						<div class="col-sm-4" id="bill_date_div" style="display:none;">
                						    <label class="label_label">Bill Date</label>
                    						<input class="form-control" type="date" name="bill_date" id="bill_date" value=""  placeholder="yyyy-mm-dd">
<br>
                						</div>
                						
                						

                						<div class="col-sm-4" id="due_date_div" style="display:none;">
                						    <label class="label_label">Due Date</label>
                    						<input class="form-control" type="date" name="due_date" id="due_date"  value="" placeholder="yyyy-mm-dd">

<br>    
                						</div>
                						
                						<div class="col-sm-4" id="invoice_no_div" style="display:none;">
                						    <label class="label_label">Invoice No.</label>
                    						<input class="form-control" type="text" name="invoice_no" id="invoice_no"  value="">

<br>    
                						</div>
                                            
                                          
                                        <div class="col-sm-12"  id="add_row1">    
                                            <hr>
                    						<br>
                						</div>
                						
                					<!--	<div class="col-sm-12">
                						  <div class="col-sm-2">
                                            <input type="button" id="add" class="btn btn-primary" value="Add More +">
                                          </div>
                                          
                                            <br>
                    						<hr>
                    						<br>
                						</div> -->
                				
                						
                				<!--		<div class="col-sm-4">
                						    <label class="label_label">Total Approval Amount</label>
                    						<input class="form-control" type="text" readonly id="total_approval_amount">
                						<br>
                						</div>
                						
                						<div class="col-sm-4">
                						    <label class="label_label">Total Required Amount</label>
                    						<input class="form-control" readonly type="text" id="total_required_amount">
                						<br>
                						</div>  -->
                                            
                                            
                                            
                                            
                                          
                                            
                						
                						
                						
                						
                						
                						
                						
                						
                						<div  class="col-sm-12">
                						    <br><input type="hidden" id="totalrow" name="totalrow" value="1">
                						    <input type="submit" name="submit" value="submit" class="btn btn-success">
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
                    
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="auth/login.php";
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
                    var local_branch = obj['local_branch'];
                    
                    // alert(customer); 
                    // $("#customer").val(customer);       $('#customer').attr('readonly', true);
                    $("#bank").val(bank);               $('#bank').attr('readonly', true);
                    $("#site_address").val(location);   $('#site_address').attr('readonly', true);
                    $("#location").val(city);           $('#location').attr('readonly', true);
                    $("#zone").val(region);             $('#zone').attr('readonly', true);
                    $("#state").val(state);             $('#state').attr('readonly', true);
                    $("#city").val(city);               $('#city').attr('readonly', true);
                }
                else{
                    alert('No Info With This ATM');
                    
                    $("#customer").val('');       $('#customer').attr('readonly', false);
                    $("#bank").val('');               $('#bank').attr('readonly', false);
                    $("#site_address").val('');   $('#site_address').attr('readonly', false);
                    $("#location").val('');           $('#location').attr('readonly', false);
                    $("#zone").val('');            $('#zone').attr('readonly', false);
                
                    
                }


            }
});
           
        });
        
        var form = document.getElementById("form"); 
        
        form.setAttribute( "autocomplete", "off" ); 

        var num=1;

           $("#add").on('click',function(){
            var key = num;
             num++;
            $("#totalrow").val(num); 
           // var e = '<div class="row input-form"><div class="col-sm-12"><hr><label>Particulars</label><input type="hidden" name="call_tracker_id[]" value="<? echo $ticket_id; ?>"><select class="form-control" name="call_type[]" id="call_type'+num+'"><option value="">Select</option><? $callsql = mysqli_query($con,"select * from call_type where customer = '".$customer."'"); while($callsql_result = mysqli_fetch_assoc($callsql)){ ?><option value="<? echo $callsql_result['id'];?>" <? if($callsql_result['type'] == $sql_result['call_type']){ $call_detail_id=$callsql_result['id']; echo 'selected' ;} ?>><? echo ucwords(strtolower($callsql_result['type']));?></option><? } ?></select></div><div class="col-sm-2"><label>Work Details</label><input type="text" name="work_detail[]" class="form-control"></div><div class="col-sm-2"><label>Description</label><div class="bgcolor"><input type="text" name="txtName[]" id="txtName'+num+'" class="typeahead" required/></div></div><div class="col-sm-2"><label>Model</label><div class="bgcolor"><input type="text" name="txtModel[]" id="txtModel'+num+'" class="typeahead" required/></div></div><? $callsql = mysqli_query($con,"select * from call_type_details where id = '".$call_detail_id."'"); $callsql_result = mysqli_fetch_assoc($callsql); ?><div class="col-sm-1"><label>Unit</label><input type="text" class="form-control" name="unit[]" id="unit'+num+'" required></div><div class="col-sm-2"><label>Price</label><input type="text" class="form-control" id="price'+num+'" name="price[]" required></div><div class="col-sm-1"><label>Labour</label><input type="text"  class="form-control" id="labour'+num+'" name="labour[]" required></div><div class="col-sm-2"><label>Total</label><input type="text"  class="form-control total" id="total'+num+'" name="total[]" required></div><br><br></div>';
            var new_html = '<div class="col-sm-4"><label>ATM ID</label><div class="input-group input-group-button">';
            new_html += '<input type="text" name="atmid[]" id="atmid'+num+'" class="form-control" placeholder="Atm ID" required></div></div>';
            new_html += '<div class="col-sm-4"><label class="label_label">Bank</label><input type="text" name="bank[]" id="bank'+num+'" class="form-control" required></div>';
            new_html += '<div class="col-sm-4"><label>Customer</label>';
            new_html += '<select class="form-control" id="customer'+num+'" name="customer[]" required>';
            new_html += '<option value="">Select Customer</option>';
                <? $con_sql = mysqli_query($con,"select * from contacts where type='c'");
                   while($con_sql_result = mysqli_fetch_assoc($con_sql)){ $contact = $con_sql_result['contact_first']; ?>
            new_html += '<option value="<? echo $contact; ?>"><? echo $contact; ?></option>'; 
                <? } ?>
            new_html += '</select></div>';
            new_html +=	'<div class="col-sm-4"><label class="label_label">Zone</label>';
            new_html += '<input class="form-control" type="text" required name="zone[]" id="zone'+num+'" value="<? echo $zone ; ?>"></div>';
            new_html +=	'<div class="col-sm-4"><label class="label_label">City</label>';
            new_html +=	'<input class="form-control" required type="text" name="city[]" id="city1" value="<? echo $city; ?>"></div>';
            new_html +=	'<div class="col-sm-4"><label class="label_label">State</label>';
            new_html +=	'<select name="state[]" required id ="state'+num+'" class="form-control" >';
            new_html +=	'<option value="">Select State</option>';
				    <?
				        $state_sql = mysqli_query($con,"select * from state order by state");
				        while($state_sql_result = mysqli_fetch_assoc($state_sql)){ $_resstate = $state_sql_result['state'];?>
			new_html +=	'<option value="<? echo $_resstate; ?>" <? if($state == $_resstate){ echo "selected"; } ?>><? echo $_resstate;?> </option>';
				        <? } ?>
			new_html +=	'</select><br></div>';
            new_html +=	'<div class="col-sm-12"><label class="label_label">Locations</label>';
            new_html +=	'<input class="form-control" required type="text" name="location[]" id="location'+num+'" value="<? echo $location ; ?>"><br></div>';
            new_html += '<div class="col-sm-4"><label>Select Work</label><select onchange="selectWork('+num+',this.value)" name="subtype[]" required class="form-control">';
            new_html += '<option value="">Select Work</option><option value="fixed_cost">Fixed cost</option><option value="approval">Approval</option></select>';
            new_html += '<br></div>';
            new_html += '<div class="col-sm-4" ><label class="label_label">Approved By</label>';
            new_html += '<input class="form-control" required type="text" name="approved_by[]" id="approved_by'+num+'" value=""></div>';
            new_html += '<div class="col-sm-4"><label>Select Type</label><select name="type[]" required class="form-control">';
            new_html += '<option value="">Select Type</option>';
            new_html += '<option value="E - Surveillance">E - Surveillance</option>';
            new_html += '<option value="Bajaj">Bajaj</option>';
            new_html += '<option value="GPS">GPS</option>';
            new_html += '<option value="UPS">UPS</option>';
            new_html += '<option value="DVR">DVR</option>';
            new_html += '<option value="Other">Other</option>';
            new_html += '</select><br></div>';
            new_html += '<div class="col-sm-4"><label>Fund Request Details</label><select class="form-control" id="fundDetails'+num+'" onchange="fundDetails('+num+')">>';
            new_html += '<option value="Footage Submit Charge">Footage Submit Charge</option>';
            new_html += '<option value="CD Charges">CD Charges</option>';
            new_html += '<option value="New E-Surveillance Installation Charge">New E-Surveillance Installation Charge</option>';
            new_html += '<option value="Re-Installation Charge">Re-Installation Charge</option>';
            new_html += '<option value="E-Surveillance Dismantle Charge">E-Surveillance Dismantle Charge</option>';
            new_html += '<option value="Site Visit Charge">Site Visit Charge</option>';
            new_html += '<option value="SIM Recharge">SIM Recharge</option><option value="">Other</option>';
            new_html += '</select><br>';
            new_html += '<input type="hidden" name="fundDetails[]" value="Footage Submit Charge" id="fundReqDetails'+num+'">';
            new_html += '<input class="form-control" type="text" id="fundDetails_other'+num+'" style="display:none;" onchange="setfundDetails('+num+')">';
            new_html += '<span style="display:none;" id="backSelect'+num+'" onclick="selectBack('+num+')">Back Select</span><br></div>';
            new_html += '<div class="col-sm-4"><label class="label_label">Approval Amount</label>';
            new_html += '<input class="form-control approved_amount" value="0" type="text" required name="approval_amount[]" id="approval_amount'+num+'">';
            new_html += '<br></div>';
            new_html += '<div class="col-sm-4" id="add_row1"><label class="label_label">Required Amount</label>';
            new_html += '<input class="form-control required_amount" type="text" name="required_amount[]" id="required_amount'+num+'"><br></div>';
            new_html += '<div class="col-sm-12" id="add_row'+num+'"><hr><br></div>';
           
            $('#add_row'+key).after(new_html);
            
          });
          
          
          $("body").on("change", ".required_amount", function () { 
            var total_required_amount=0;
            $('.required_amount').each(function(){
                total_required_amount += parseFloat(this.value);  // Or this.innerHTML, this.innerText
            });
            $("#total_required_amount").val(total_required_amount);
          }); 
          
          
          $("body").on("change", ".approved_amount", function () {  
            var total_approved_amount=0;
            $('.approved_amount').each(function(){
                total_approved_amount += parseFloat(this.value);  // Or this.innerHTML, this.innerText
            });
            $("#total_approval_amount").val(total_approved_amount);
          }); 
         
          function fundDetails(key){
              var selectedValue = $("#fundDetails"+key).val();
              if(selectedValue==""){
                  $("#fundDetails_other"+key).css('display','block');
                  $("#backSelect"+key).css('display','block');
                  $("#fundDetails"+key).css('display','none');
              }
              else{
                  $('#fundReqDetails'+key).val(selectedValue);
              }
          }
          
          function setfundDetails(key){ debugger;
              var Value = $("#fundDetails_other"+key).val();
              $("#fundReqDetails"+key).val(Value);
          }
          
         function selectBack(key){
              $("#fundDetails"+key).css('display','block');
              $("#fundDetails_other"+key).css('display','none');
              $("#backSelect"+key).css('display','none');
             // $("#fundDetails"+key).prop('required',true);
             $('#fundReqDetails'+key).val('Footage Submit Charge');
             $("#fundDetails"+key).val('Footage Submit Charge');
          }
          
          function selectWork(key,val){ debugger;
              if(val=='fixed_cost'){
              $("#approved_by"+key).prop('required',false);
              $("#approval_amount"+key).prop('required',false);
              $("#approved_by"+key).prop('readonly',true);
              $("#approval_amount"+key).prop('readonly',true);
              }else{
                  $("#approved_by"+key).prop('required',true);
              $("#approval_amount"+key).prop('required',true);
              $("#approved_by"+key).prop('readonly',false);
              $("#approval_amount"+key).prop('readonly',false);
              }
          }
          
          function addNewField(val){
              if(val=='UTILITY'){
                  $("#bill_date_div").css('display','block');
                  $("#due_date_div").css('display','block');
                  $("#invoice_no_div").css('display','block');
              }else{
                  $("#bill_date_div").css('display','none');
                  $("#due_date_div").css('display','none');
                  $("#invoice_no_div").css('display','none');
              }
          }
          
    </script>
</body>

</html>