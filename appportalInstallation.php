<? session_start();
include('config.php');
error_reporting(0);
if($_SESSION['username']){ 
    

include('header.php');
$engid=$_REQUEST['engid'];

    $username = $_SESSION['username'];
    
    
    $usersql = mysqli_query($con,"select cust_id,zone from mis_loginusers where name='".$username."'");
	$userdata = mysqli_fetch_assoc($usersql);
	$_cust_ids = $userdata['cust_id'];
    $assigned_customers = explode(",",$_cust_ids);



?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com//polygon/adminty/files/assets/icon/ion-icon/css/ionicons.min.css">
<style>

.highlight{
    
    padding: 10px;
    box-shadow: 0px 0px 10px 2px rgb(0 0 0 / 40%);
    margin: 20px auto;
}
#kacha_copy {
    font-size: 1.7rem;
    color: #F6BB42;
    cursor: pointer;
    margin:10px;
}

.highlight:first-child .close_item {
    display:none;
}
    .tag-pill {
    padding-right: 0.6em;
    padding-left: 0.6em;
    border-radius: 10rem;
}

.tag {
    display: inline-block;
    padding: 0.35em 0.4em;
    font-size: 70%;
    font-weight: 600;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    /*border-radius: 0.18rem;*/
}
    .highlight{
        position:relative;
    }
    .close_item {
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
}

.tag-pill {
    cursor: pointer;
    position: absolute;
    top: 0;
    right: 0;
}
.tag-danger {
    background-color: #DA4453;
}

    label{
        color: #202c35;
        font-weight: 600;
    }
    input.form-control, input,select , select.form-control {
    border: none;ser
    margin: 10px auto;
    border-bottom: 1px solid #ac9292 ; 
}

.form-control:focus, input.form-control, input ,  select.form-control, select {
    background: transparent;
}

.form-control:focus {
    color: #55595c;
    background-color: #fff;
    border-color: #66afe9;
    outline: none;
    box-shadow: none;
    border: none;
}
input:focus , select:focus {
    border-bottom: 1px solid red !important;
}
label{
    font-size:13px;
}
span.imp{
    color:red;
}

</style>  

<style>
html{
    text-transform: inherit !important;
}
    nav{
        display:none !important;
    }
    .pcoded[theme-layout="vertical"][vertical-placement="left"][vertical-nav-type="expanded"][vertical-effect="shrink"] .pcoded-content {
    margin-left: 0;
}
.line-on-side {
    border-bottom: 1px solid #dadada;
    line-height: 0.1em;
    margin: 10px 0 20px;
}
.line-on-side span {
    background: #F6F7FB;
    padding: 0 10px;
}
</style>

            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                <h2 class="card-subtitle line-on-side center font-small-3 pt-2">
                                    <span>CSS App Portal</span>
                                </h2>
                                <div class="card">
                                    <div class="card-block">
                                        <ul class="nav">
                                              <li class="nav-item">
                                                <a class="nav-link active" aria-current="page" id="project" href="appportalInstallation.php?engid=<? echo $engid; ?>">Project</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="sites" href="appportalSitestest.php?engid=<? echo $engid; ?>">Sites</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="ATMVisit" href="appportal.php?engid=<? echo $engid; ?>">ATM Visit</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" href="appvisitrecords.php?engid=<? echo $engid; ?>">Visit Records</a>
                                              </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                
                                
                                <form action="installation_process.php" method="POST">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>ATM ID <span class="imp">*</span></label>
                                                        <input type="text" class="form-control" name="atmid" id="atmid">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>ATM ID 2</label>
                                                        <input type="text" class="form-control" name="atmid2">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>ATM ID 3</label>
                                                        <input type="text" class="form-control" name="atmid3">
                                                    </div>
                                                    
                                                    <div class="col-sm-3">
                                                        <label>Tracker Number</label>
                                                        <input type="text" class="form-control" name="serial_number" id="serial_number">
                                                    </div>
                                                </div>
                                            <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Bank <span class="imp">*</span></label>
                                                        <select class="form-control" id="bank" name="bank">
                                                            <option value="">SELECT</option>
                                                            <?
                                                            $bank_sql = mysqli_query($con,"select distinct(bank) as bank from boq where status=1");
                                                            while($bank_sql_result = mysqli_fetch_assoc($bank_sql)){ 
                                                            $bank_result = $bank_sql_result['bank'];
                                                            ?>
                                                                
                                                                <option value="<? echo $bank_result; ?>"><? echo strtoupper($bank_result); ?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
    
                                                        <label>Customer <span class="imp">*</span></label>
                                                        <select class="form-control" name="customer" required>
                                                            <option value=""> SELECT </option>
                                                            <?  
                                                            $i = 0;
                                                            $con_sql = mysqli_query($con, "select * from contacts where type='c' ");
                                                            while ($con_sql_result = mysqli_fetch_assoc($con_sql)) { 
                                                              if(in_array($con_sql_result['contact_first'],$assigned_customers)){
                                                            ?>
                                                                <option value="<? echo $con_sql_result['contact_first']; ?>">
                                                                    <? echo strtoupper($con_sql_result['contact_first']); ?>
                                                                </option>
                                                            <?
                                                                $i++;
                                                            } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>Address</label>
                                                        <input type="text" name="address" class="form-control"> 
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                        <label>City</label>
                                                        <input type="text" name="city" class="form-control"> 
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label>State</label>
                                                        <input type="text" name="state" class="form-control"> 
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label>Pincode</label>
                                                        <input type="text" name="pincode" class="form-control"> 
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                        <label>Engineer Name</label>
                                                        designation
                                                        <select name="engineer" class="form-control" required>
                                                            <option value="">SELECT</option>
                                                            <?
                                                            $eng_sql = mysqli_query($con,"select * from mis_loginusers where designation=4 and user_status=1");
                                                            while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?>
                                                                <option><? echo strtoupper($eng_sql_result['name']);?></option>    
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label>Engineer Number</label>
                                                        <input type="text" name="engineer_number" class="form-control"> 
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label>BM Name</label>
                                                        <input type="text" name="bm_name" class="form-control"> 
                                                    </div>
                                                    
                                                    
                                                </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card result_card">
                                        <div class="card-block">
                                            <div class="row">
                                                <br>
                                                
                                                <input class="selection_type" type="radio" name="selection_type" value="partial" checked="checked">Partial &nbsp;&nbsp;&nbsp;
                                                <input class="selection_type" type="radio" name="selection_type" value="full">Full 
                                                
                                                <br>
                                            </div>
                                            <div id="here"></div>
                                            <div id="here_f"></div>
                                            <div class="row">
                                                <i class="ion-plus-circled add_boq" id="kacha_copy"></i>
                                            </div>
                                            <br>
                                            <input type="submit" class="btn btn-success" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
        <script>
        
        $('form').on('submit',function() {
            atmid = $("#atmid").val().length;
            serial_number = $("#serial_number").val().length;
            if(atmid > 0 || serial_number > 0 ){
                
            }else{
                alert('Please Fill ATMID Or Serial Number !') ;
                return false;    
            }
            
        });
        
        $(".result_card").css('display','none');
        
        $(document).on('change','#bank',function(){
           
           bank = $("#bank").val();
           if(bank){
                window.history.replaceState(null, null, "?bank="+bank);
                $('input[name="selection_type"]').filter("[value='partial']").click();
                $(".result_card").css('display','block');
            }
            else{
                window.history.replaceState(null, null, "");
                $(".result_card").css('display','none');
            }
        });
        
        $(document).on('change','.selection_type',function(){
                   bank = $("#bank").val();
                   selection_type = $(this).val();
                   if(selection_type=='full'){
                       $("#here").html('');
                       $.ajax({
                           type:"POST",
                           url: 'get_boq_json.php',
                           data:'bank='+bank,
                           success :function(msg){
                                data = JSON.parse(msg)
                                data.forEach((item, index)=>{
                                    datahtml = '<div class="row highlight kacha_items">';
                                    datahtml += '<div class="col-sm-8 material"><label>Material</label><input type="text" list="boq_list" name="material[]" class="form-control" value="'+item.boq+'"></div>';
                                    datahtml += '<div class="col-sm-1 qty"><label> Quantity </label><input type="text" name="qty[]" class="form-control" value="'+item.qty+'"></div>';
                                    datahtml += '<div class="col-sm-3  remark"><label>Remark</label><input type="text" name="remark[]" class="form-control"></div>';
                                    datahtml += ' <span class="tag tag-pill tag-danger close_item">x</span> </div>';
                                    $("#here_f").append(datahtml);
                                });
                           }
                        });    
                   }else{
                       $("#here_f").html('');
                       $("#kacha_copy").click();
                       
                   }
                   
               
               });

        
        kacha_i = 1 ;
        var kacha_trigger = $('#kacha_copy');
            kacha_trigger.off('click').on('click', function(){
            let a = '<div class="row highlight kacha_items" index="'+kacha_i+'">';
                a += '<div class="col-sm-8 material"><label>Material</label><input type="text" list="boq_list" name="material[]" class="form-control">';
                a+= '<datalist id="boq_list">';
                a+= ' <? $sql = mysqli_query($con,"select * from boq where status=1"); while($sql_result = mysqli_fetch_assoc($sql)){ $boq = $sql_result['boq'];  echo "<option>$boq</option>";  } ?>';                   
                a+= '</datalist></div>';
                a += '<div class="col-sm-1 qty"><label> Quantity </label><input type="text" name="qty[]" class="form-control"></div>';
                a += '<div class="col-sm-3 remark"><label>Remark</label><input type="text" name="remark[]" class="form-control"></div>';
                a += ' <span class="tag tag-pill tag-danger close_item">x</span> </div>';
                $("#here").append(a);
                kacha_i++;
            });
             
             
            $(document).ready(function(){
                 $("#kacha_copy").click();
            });
             $(document).on('click',".close_item",function(){
                $(this).parent().remove();
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