<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');

    $username = $_SESSION['username'];
    
    
    $usersql = mysqli_query($con,"select cust_id,zone from mis_loginusers where name='".$username."'");
	$userdata = mysqli_fetch_assoc($usersql);
	$_cust_ids = $userdata['cust_id'];
    $assigned_customers = explode(",",$_cust_ids);


?>



<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">


<div style="text-align:right">
<a href="forms_master.php" class="btn btn-primary" target="_blank">View Forms masters</a>    
</div>



    <form action="process_dismantal_master.php" method="post">
        <input type="submit" class="btn btn-success" value="submit" />
        <br />
                <br />
        <div class="row">
        <div class="col-sm-6">
            <select class="form-control" name="customer">
                <option value="">-- select Customer --</option>
                <?  
                $i = 0;
                $con_sql = mysqli_query($con, "select * from contacts where type='c' ");
                while ($con_sql_result = mysqli_fetch_assoc($con_sql)) { 
                  if(in_array($con_sql_result['contact_first'],$assigned_customers)){
                ?>
                    <option value="<? echo $con_sql_result['contact_first']; ?>">
                        <? echo $con_sql_result['contact_first']; ?>
                    </option>
                <?
                    $i++;
                } } ?>
        </select>
        </div>
        <div class="col-sm-6">

            <select name="bank" id="bank" class="form-control" required>
                <option value="">--Select Bank --</option>
                <?
                
                $bank_sql = mysqli_query($con,"SELECT distinct(bank) as bank FROM `mis_newsite`");
                while($bank_sql_result = mysqli_fetch_assoc($bank_sql)){
                    ?>
                    
                   <option value="<? echo $bank_sql_result['bank'];?>"><? echo $bank_sql_result['bank'];?></option> 
                <? }
                
                ?>
            </select>
        </div>
            
        </div>
        
        
        <hr />
        <div id="result"></div>
        <input type="hidden" name="totalRecords" id="totalRecords" />
        
    </form>
    
    <br>
        <button class="btn btn-success" id="add">Add Question</button>


<style>
    .form-control:focus{
        box-shadow:none;
        border:none;
        border-bottom: 1px solid red;
    }
    .form-group{
        display:flex;
    }
    input.form-control{
        border:none;
        border-bottom:1px solid red;
    }
    
</style>
    <script>
        let counter = 1;

        function question(counter) {
            let q = `<div class="card">
                        <div class="card-block">
                            <div class="form-group">
                                <label>${counter} ) &nbsp;&nbsp;&nbsp;</label>
                                <input type="text" name="questionNum${counter}" class="form-control">
                            </div>
                            <div class="typeSelector">
                                <input type="radio" name="questionType${counter}" onchange="question_op(${counter},'text')" value="text">&nbsp; Text &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="questionType${counter}" onchange="question_op(${counter},'radio')" value="radio">&nbsp; Radio <button class="btn btn-primary" onclick="generateOptions(${counter},'radio')">Generate</button> &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="questionType${counter}" onchange="question_op(${counter},'checkbox')" value="checkbox">&nbsp; Checkbox <button class="btn btn-danger" onclick="generateOptions(${counter},'checkbox')">Generate</button> &nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="isImgReq${counter}" />  &nbsp; <b>Is Image Required field ?</b> &nbsp;&nbsp;&nbsp;
                            </div>
                            <br />
                            <div id="option${counter}"></div>
                        </div>
                    </div>`;
            return q;
        }


        $("#add").on('click', function () {
            let q = question(counter);
            $("#result").append(q);
        $("#totalRecords").val(counter)
            counter++;
                        
        });

        function question_op(counter, type) {
            option = `<input type="text" class="form-control customehide" name="option${counter}" />`
            $("#option" + counter).html(option)

        }


        function generateOptions(counter, type) {
            event.preventDefault();
            string = $("#option" + counter).find('input').val();
            string = string.replace(/,\s*$/, "");
            
            array = string.split(',');
            
            a = '';
            array.map((ar, i) => (
                ar.length > 0 ?
                a += `<input type="${type}" name="answer${counter}" value="${ar}" /> ${ar} &nbsp;&nbsp;&nbsp;`
                : ''
            ))
            $("#option" + counter).append(a);
            
            $("#option" + counter).find('.customehide').css('display','none')
        }

    </script>


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