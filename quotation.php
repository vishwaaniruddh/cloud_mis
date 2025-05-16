<? session_start();


if($_SESSION['username']){ 

include('header.php'); 
$ticket_id = $_GET['ticket']; 
                            
                            $sql = mysqli_query($con,"select * from calltracker where id='".$ticket_id."'");
                            $sql_result = mysqli_fetch_assoc($sql);
                            
                            $customer_code = $sql_result['customer'];
                            $customer = get_customer($customer_code);
                            $cust_id = get_custid_by_name($customer_code);
                            $atmid = $sql_result['atmid'];

?>
                                                                
   	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!--<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript" src="typeahead.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  
  

<style>
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
    
	.typeahead { 
	        border: 2px solid #FFF;
    border-radius: 4px;
    padding: 8px 12px;
    /* max-width: 300px; */
    /* min-width: 290px; */
    background: rgba(66, 52, 52, 0.5);
    color: #FFF;
    width: 100%;
	}
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;color:#FFF;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	/*.bgcolor {max-width: 550px;min-width: 290px;max-height:340px;padding: 100px 10px 130px;border-radius:4px;text-align:center;margin:10px;}*/
	.demo-label {font-size:1.5em;color: #686868;font-weight: 500;color:#FFF;}
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #1f3f41;
		outline: 0;
	}
	
ul.typeahead.dropdown-menu li a{
    color:black;
}
	.card .card-block .dropdown-menu>li>a:focus, .card .card-block .dropdown-menu>li>a:hover {
    background-color: blue;
}
.card .card-block a.dropdown-item:active, .card .card-block a.dropdown-item .active{
    color:white;
}


@media (min-width: 576px) {
    .modal-dialog {
        max-width: 1500px;
        margin: 1.75rem auto;
           width: 100%;

    }    

}

	</style>	

<script>
    

        
        
</script>


            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">

                            <div class="page-body">

                            
                            <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text"> Details </h5>
                                                            </div>
                                                            <div class="card-block">
                                                                <div class="view-info">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="general-info">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table m-0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <th scope="row">Ticket ID </th>
                                                                                                        <td><? echo $sql_result['ticketid'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Customer </th>
                                                                                                        <td><? echo $customer;?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">ATM ID</th>
                                                                                                        <td>
                                                                                                            <span><? echo $sql_result['atmid'];?></span>
                                                                                                            <button style="margin-left:20px;" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">View History</button>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Bank</th>
                                                                                                        <td><? echo $sql_result['bank'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Branch Manager</th>
                                                                                                        <td><? echo $sql_result['bm_name'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Location</th>
                                                                                                        <td><? echo $sql_result['locations'];?></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                                                                                                                            <tr>
                                                                                                        <th scope="row">City</th>
                                                                                                        <td><? echo $sql_result['city'];?></td>
                                                                                                    </tr>
                                                                                                    
                                                                                                        <th scope="row">State</th>
                                                                                                        <td><? echo $sql_result['state'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Zone</th>
                                                                                                        <td><? echo $sql_result['zone'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Type Of Call</th>
                                                                                                        <td><? echo $sql_result['call_type'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Status</th>
                                                                                                        <td><? echo $sql_result['status'];?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Description</th>
                                                                                                        <td><? echo $sql_result['call_description'];?></td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of general info -->
                                                                        </div>
                                                                        <!-- end of col-lg-12 -->
                                                                    </div>
                                                                    <!-- end of row -->
                                                                </div>
                                                            </div>
                                                            <!-- end of card-block -->
                                                        </div>
                            <? $customer= get_custid_by_name($customer_code); ?>
                            
                            <div class="card">

                                <div class="card-block">
                                      
                                      <div class="row">
                                                                <div class="col-sm-12">
                                                                    <h4 class="sub-title">Quatation</h4>
                                                            <form id="form" action="process_quotation.php" method="POST">
                                                                
                                                            <input type="hidden" name="atmid" value="<? echo $atmid; ?>">
                                                            <input type="hidden" name="customer_code" value="<? echo $customer_code; ?>">
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Select Beneficiary</label>
                                        <select name="beneficiary" class="form-control" style="background:gray;color:white;" required>
                                            <option value="">Select</option>
                                            <?
                                            $ben_sql = mysqli_query($con,"select hname,id,accno from rnm_fundaccounts where status=1 order by hname ASC");
                                            while($ben_sql_result = mysqli_fetch_assoc($ben_sql)){ ?>
                                                <option value="<? echo $ben_sql_result['id']; ?>">
                                                    <? echo $ben_sql_result['hname'] . ' - ' . $ben_sql_result['accno'];?>
                                                </option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row" id="here">
                                    
                                </div>

                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control grand_total" id="grand_total" name="grand_total" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="submit" class="btn btn-danger" value="submit">    
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="button" id="add" class="btn btn-primary" value="Add More +">
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
                </div>
            </div>
                    
                    
    


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <p>History #<span style="color:red;"><? echo $atmid;?></span></p>
        
        
        <table class="table">
    <thead>
      <tr>
        <th>#</th>

        <th>Ticket Id</th>
        <th>Amount</th>
        <th>Call Type</th>
        <th>Call Description</th>
      </tr>
    </thead>
    <tbody>
        <?
        $his_sql = mysqli_query($con,"select * from new_quotation where atmid='".$atmid."' order by quote_id desc");
        $i=1; 
        while($his_sql_result = mysqli_fetch_assoc($his_sql)){ 
        
        $id = $his_sql_result['ticket_id'];
        
        $call_sql = mysqli_query($con,"select * from calltracker where id = '".$id."'");
        $call_sql_result = mysqli_fetch_assoc($call_sql);
        
        $status = $call_sql_result['status'];
        $call_type = $call_sql_result['call_type'];
        $call_description = $call_sql_result['call_description'];
        
        ?>
            
            <tr>
                <td><? echo $i ; ?></td>

                <td><? echo $his_sql_result['quot_ticket_id'];?></td>
                <td>₹<? echo ' '. $his_sql_result['grand_total'];?></td>
                <td><? echo $call_type ;?></td>
                <td><? echo $call_description;?></td>
            </tr>
      
      
        <? $i++; } ?>
      
    </tbody>
  </table>
  
  
  
  
      </div>
    </div>

  </div>
</div>




   <script>

 
        
    var num = 1;
   grand_total = 0 ;
var count = 10;
var tax_amount= 0;
                    
    $(document).ready(function(){

    var e = '<div class="row input-form"><div class="col-sm-12"><label>Particulars</label><input type="hidden" name="call_tracker_id[]" value="<? echo $ticket_id; ?>"><select class="form-control" name="call_type[]" id="call_type1"><option value="">Select</option><? $callsql = mysqli_query($con,"select * from call_type where customer = '".$customer."'"); while($callsql_result = mysqli_fetch_assoc($callsql)){ ?><option value="<? echo $callsql_result['id'];?>" <? if($callsql_result['type'] == $sql_result['call_type']){ $call_detail_id=$callsql_result['id']; echo 'selected' ;} ?>><? echo ucwords(strtolower($callsql_result['type']));?></option><? } ?></select></div><div class="col-sm-2"><label>Work Details</label><input type="text" name="work_detail[]" class="form-control"></div><div class="col-sm-2"><label>Description</label><div class="bgcolor"><input type="text" name="txtName[]" id="txtName1" class="typeahead" required/></div></div><div class="col-sm-2"><label>Model</label><div class="bgcolor"><input type="text" name="txtModel[]" id="txtModel1" class="typeahead" required/></div></div><? $callsql = mysqli_query($con,"select * from call_type_details where id = '".$call_detail_id."'"); $callsql_result = mysqli_fetch_assoc($callsql); ?><div class="col-sm-1"><label>Unit</label><input type="text" class="form-control" name="unit[]" id="unit1" required></div><div class="col-sm-2"><label>Price</label><input type="text" class="form-control" id="price1" name="price[]" required></div><div class="col-sm-1"><label>Labour</label><input type="text"  class="form-control" id="labour1" name="labour[]" required></div><div class="col-sm-2"><label>Total</label><input type="text"  class="form-control total" id="total1" name="total[]" required></div><br><br></div>';
        $('#here').append($(e).html());


        $('#txtName1').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "get_callname.php",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {

						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
        
        $('#txtModel1').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "get_callmodel.php",
					data: 'query='+query+'&name='+$("#txtName1").val(),            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {

						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
    
    
    
    
    
    $("#txtModel1").on('change',function(){

            setTimeout(function(){
                $("input").blur();
                var name = $('#txtName1').val();
                var model = $('#txtModel1').val();
                var customer = '<? echo $customer; ?>';
                if(name && model){
 
                                $.ajax({
                                type: "POST",
                                url: 'get_price.php',
                                data: 'name='+name+'&model='+model+'&customer='+customer,
                                success:function(msg) {
                                    var obj = JSON.parse(msg);
                                    var unit = obj['unit'];
                                    var price = obj['price'];
                                    $("#unit1").val(unit);
                                    $("#price1").val(price);
                                    $("#total1").val(unit*price);
                                    total();
                                }
                            });    
                }
                else{
                    alert('Something Fishy betwen name and model');
                }
                
            }, 1000);
        });            
        
        
        
        // $("#tax1").on('change',function(){
        //     var unit = $("#unit1").val();
        //     var price = $("#price1").val();
        //     var tax = $(this).val();
            
        //     if(tax){
        //         this_total = unit*price;
        //         tax_amount = this_total*parseInt(tax)/100;
        //         this_total = this_total + tax_amount ; 
        //         $("#total1").val(this_total);
        //     }
        //     else{
        //         tax = 0 ;
        //         this_total = unit*price;
        //         $("#total1").val(this_total);
        //     }
        //                     total();
        // });
    
    
    
        $("#unit1").on('change',function(){
            var unit = $(this).val();
            var price = $("#price1").val();
            // var tax = $("#tax1").val();
            var labour = $("#labour1").val();
            
            if(!labour){
                labour = 0; 
            }
            if(price){
                var this_total = unit*price + parseInt(labour);; 
                $("#total1").val(this_total);
            // if(tax){
            //     tax_amount = this_total*parseInt(tax)/100;
            //     this_total = this_total + tax_amount ;
            //     $("#total1").val(this_total);
            // }
                total();
            }
            
        });
        
        $("#price1").on('change',function(){
            var price = $(this).val();
            var unit = $("#unit1").val();
            var labour = $("#labour1").val();
           if(!labour){
                labour = 0; 
            }
            if(unit){
                var this_total = unit*price + parseInt(labour); 
                $("#total1").val(this_total);

                    //  if(tax){
                    //     tax_amount = this_total*parseInt(tax)/100;
                    //     this_total = this_total + tax_amount ; 
                    //     $("#total1").val(this_total);
                    // }
                total();
            }
            


        });
        
        
        $("#labour1").on('change',function(){
            var labour = $(this).val();
            var price = $("#price1").val();
            var unit = $("#unit1").val();
            // if(unit){
                var this_total = unit*price + parseInt(labour); 
                $("#total1").val(this_total);
                    //  if(tax){
                    //     tax_amount = this_total*parseInt(tax)/100;
                    //     this_total = this_total + tax_amount ; 
                    //     $("#total"+num).val(this_total);
                    // }
                total();
            // }
        });



        

		
    // End Document ready
});
    // End  
    
    
    

        








        
        $("#add").on('click',function(){
            

        num++;
        


            var e = '<div class="row input-form"><div class="col-sm-12"><hr><label>Particulars</label><input type="hidden" name="call_tracker_id[]" value="<? echo $ticket_id; ?>"><select class="form-control" name="call_type[]" id="call_type'+num+'"><option value="">Select</option><? $callsql = mysqli_query($con,"select * from call_type where customer = '".$customer."'"); while($callsql_result = mysqli_fetch_assoc($callsql)){ ?><option value="<? echo $callsql_result['id'];?>" <? if($callsql_result['type'] == $sql_result['call_type']){ $call_detail_id=$callsql_result['id']; echo 'selected' ;} ?>><? echo ucwords(strtolower($callsql_result['type']));?></option><? } ?></select></div><div class="col-sm-2"><label>Work Details</label><input type="text" name="work_detail[]" class="form-control"></div><div class="col-sm-2"><label>Description</label><div class="bgcolor"><input type="text" name="txtName[]" id="txtName'+num+'" class="typeahead" required/></div></div><div class="col-sm-2"><label>Model</label><div class="bgcolor"><input type="text" name="txtModel[]" id="txtModel'+num+'" class="typeahead" required/></div></div><? $callsql = mysqli_query($con,"select * from call_type_details where id = '".$call_detail_id."'"); $callsql_result = mysqli_fetch_assoc($callsql); ?><div class="col-sm-1"><label>Unit</label><input type="text" class="form-control" name="unit[]" id="unit'+num+'" required></div><div class="col-sm-2"><label>Price</label><input type="text" class="form-control" id="price'+num+'" name="price[]" required></div><div class="col-sm-1"><label>Labour</label><input type="text"  class="form-control" id="labour'+num+'" name="labour[]" required></div><div class="col-sm-2"><label>Total</label><input type="text"  class="form-control total" id="total'+num+'" name="total[]" required></div><br><br></div>';
            
            $('#here').append($(e).html());



        $('#txtName'+num).typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "get_callname.php",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {

						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
        
        $('#txtModel'+num).typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "get_callmodel.php",
					data: 'query='+query+'&name='+$("#txtName"+num).val(),            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {

						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        }); 
        
        
        $("#txtModel"+num).on('change',function(){
            setTimeout(function(){
                $("input").blur();
                var name = $('#txtName'+num).val();
                var model = $('#txtModel'+num).val();
                var customer = '<? echo $customer; ?>';
                if(name && model){
                                $.ajax({

                                type: "POST",
                                url: 'get_price.php',
                                data: 'name='+name+'&model='+model+'&customer='+customer,
                                success:function(msg) {
                                    var obj = JSON.parse(msg);
                                    var unit = obj['unit'];
                                    var price = obj['price'];
                                    $("#unit"+num).val(unit);
                                    $("#price"+num).val(price);
                                    $("#total"+num).val(unit*price);
                                    total();
                                }
                            });    
                }
                
            }, 1000);
        });            
        
        $("#unit"+num).on('change',function(){
            var unit = $(this).val();
            var price = $("#price"+num).val();
            // var tax = $("#tax"+num).val();
            var labour = $("#labour"+num).val();
            
           if(!labour){
                labour = 0; 
            }
            if(price){
                var this_total = unit*price + parseInt(labour); 
                $("#total"+num).val(this_total);
                     if(tax){
                        tax_amount = this_total*parseInt(tax)/100;
                        this_total = this_total + tax_amount ; 
                        $("#total"+num).val(this_total);
                    }
                total();
            }
        });
        
        $("#price"+num).on('change',function(){
            var price = $(this).val();
            var unit = $("#unit"+num).val();
            var labour = $("#labour"+num).val();
           if(!labour){
                labour = 0; 
            }
            if(unit){
                var this_total = unit*price + parseInt(labour);; 
                $("#total"+num).val(this_total);
                    //  if(tax){
                    //     tax_amount = this_total*parseInt(tax)/100;
                    //     this_total = this_total + tax_amount ; 
                    //     $("#total"+num).val(this_total);
                    // }
                total();
            }
        });

        $("#labour"+num).on('change',function(){
            var labour = $(this).val();
            var price = $("#price"+num).val();
            var unit = $("#unit"+num).val();
            // if(unit){
                var this_total = parseInt(unit*price) + parseInt(labour) ; 
                $("#total"+num).val(this_total);
                    //  if(tax){
                    //     tax_amount = this_total*parseInt(tax)/100;
                    //     this_total = this_total + tax_amount ; 
                    //     $("#total"+num).val(this_total);
                    // }
                total();
            // }
        });
        
        // $("#tax"+num).on('change',function(){
        //     var unit = $("#unit"+num).val();
        //     var price = $("#price"+num).val();
        //     var tax = $(this).val();
            
        //     if(tax){
        //         this_total = unit*price;
        //         tax_amount = this_total*parseInt(tax)/100;
        //         this_total = this_total + tax_amount ; 
        //         $("#total"+num).val(this_total);
        //     }
        //     else{
        //         tax = 0 ;
        //         this_total = unit*price;
        //         $("#total"+num).val(this_total);
        //     }
        //                     total();
        // });


        
        });
        

function total(){
    var sum = 0;
    $(".total").each(function(){
        sum += +$(this).val();
    });
    $(".grand_total").val(sum);   
}
 






</script> 
    
    

    
    
    
<? } 
   else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? } ?>
    
       
    <script src="./files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="./files/assets/js/pcoded.min.js"></script>
    <script src="./files/assets/js/vartical-layout.min.js"></script>
    <script type="text/javascript" src="./files/assets/pages/dashboard/custom-dashboard.js"></script>
</body>

</html>
