<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function disable(id){

        Swal.fire({
              title: 'Are you sure?',
              text: "Think twice to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Proceed it!'
            }).then((result) => {
              if (result.isConfirmed) {
                
                   jQuery.ajax({
                            type: "POST",
                            url: 'disable_user.php',
                           data: 'id='+id,
                                success:function(msg) {
                                    
                                    if(msg==1){
                                            Swal.fire(
                                              'Updated!',
                                              'Status has been changed.',
                                              'success'
                                            );
                                            
                                            setTimeout(function(){ 
                                        window.location.reload();
                                    }, 2000);
                                    
                                    }else if(msg==0 || msg==2){
                                        
                                        Swal.fire(
                                         'Cancelled',
                                          'Your imaginary file is safe :)',
                                          'error'
                                            );
                                            
                                            
            
                                    }
                                    
                                }
                   });
            
            
              }
            })

    }
</script>

<style>
    .notbtn{
        background: transparent;
        border: none;
        color: blue;
        text-decoration: underline;
    }
</style>


<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <form action="process_add_user.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Email / userid</label>
                                                    <input type="email" name="uname" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Password</label>
                                                    <input type="password" name="pwd" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Contact</label>
                                                    <input type="number" id="contact" name="contact" class="form-control" onkeypress="return validInput(event);" >
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Designation</label>
                                                    <select name="designation" class="form-control">
                                                        <option value=""> -- Select -- </option>
                                                        <option value="1">Admin</option>
                                                        <option value="2">Back Office</option>
                                                        <option value="4">Engineer</option>  
                                                    </select>
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Bank</label>
                                                    <select name="bankname" class="form-control">
                                                        <option value="">Select</option>
                                                        <?php 
                                                        $banksql = mysqli_query($con,"SELECT * FROM bank order by bank asc");
                                                        while($banksql_result = mysqli_fetch_assoc($banksql)){
                                                            $bankname = $banksql_result['bank'];
                                                            ?>
                                                            <option value="<?= $bankname; ?>"><?= $bankname;  ?></option>
                                                            <?
                                                        }
                                                        
                                                        
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Account Number</label>
                                                    <input type="text" id="accountNumber" name="accountNumber" class="form-control" >
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>IFSC</label>
                                                    <input type="text" id="ifsc" name="ifsc" class="form-control" >
                                                </div>
                                                
                                                
                                                
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-danger">
                                                </div>                                                
                                            </div>

                                        </form>
                                        
                                        
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User ID</th>
                                                    <th>Name</th>
                                                    <th>Desgination</th>
                                                    <th>Username</th>
                                                    
                                                    <?if($userid==318 || $userid==46 || $userid==24 || $userid==651){ ?>
                                                        <th>Password</th>
                                                    <? } ?>
                                                    
                                                    
                                                    <th>Contact No.</th>
                                                    <th>Status</th>
                                                    <th>action</th>
                                                    <th>Active / Inactive </th>
                                                    <th>Designation</th>
                                                    <th>Service Executive</th>
                                                    <th>Address</th>
                                                    <th>Bank</th>
                                                    <th>Account Number</th>
                                                    <th>IFSC CODE</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from mis_loginusers where user_status=1");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                    $serviceExecutiveStatus=0 ; 
                                                  if($sql_result['user_status']==0){
                                                      $user_status = 'Inactive';
                                                      $makeuser_status = 'Make Active';
                                                      $status_class = 'text-danger';
                                                  }else{
                                                      $user_status = 'Active';
                                                      $makeuser_status = 'Make Inactive';
                                                      $status_class = 'text-success';
                                                  }
                                                  $serviceExecutiveStatus = $sql_result['serviceExecutive'];
                                                  $desgination = $sql_result['designation']; 
                                                  $personalcontactno = $sql_result['personalcontactno']; 
                                                  
                                                    $address = $sql_result['address']; 

                                                  
                                                  
                                                ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td>
                                                            <form action="./admin_profileUpdate.php" method="GET">
                                                                <input type="hidden" name="usertoupdate" value="<?php echo $sql_result['id']; ?>">
                                                                <input class="notbtn" type="submit" value="<? echo $sql_result['id'] ; ?>" />  
                                                            </form>

                                                        <td>
                                                            <? echo ucwords(strtolower($sql_result['name'])); ?>
                                                        </td>
                                                        <td>
                                                            <?
                                                            if($desgination==4){
                                                                echo 'Engineer' ; 
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['uname']; ?></td>
                                                        


                                                    <?php if($userid==318 || $userid==46 || $userid==24 || $userid==651){ ?>
                                                        <td style="text-transform: initial;"><? echo $sql_result['pwd']; ?></td>
                                                    <? } ?>
                                                        <td style="text-transform: initial;">
                                                            <? echo $sql_result['contact'] . ' ' . $sql_result['personalcontactno']; ?>
                                                        </td>
                                                        <td class="<? echo $status_class; ?>"><? echo $user_status;?></td>
                                                        <td>
                                                            <a class="btn btn-danger" href="allot_perm.php?id=<? echo $sql_result['id']; ?>">Permission</a>
                                                            <a class="btn btn-warning" href="allotmenu_perm.php?id=<? echo $sql_result['id'];  ?>">Menu Permission</a>
                                                            <a class="btn btn-primary" href="statusAccess.php?id=<? echo $sql_result['id'];  ?>" target="_blank">Status Access </a>
                                                        </td>
                                                        <td><a href="#" class="btn btn-danger" onclick="disable(<? echo $sql_result['id']; ?>)"><? echo $makeuser_status;?></a></td>
                                                        <td><a href="edit_designation.php?id=<? echo $sql_result['id']; ?>"><input type="submit" name="edit" id="edit" class="btn btn-warning" value="Edit"></a></td>
                                                        <td>
                                                            <input type="checkbox" class="serviceExecutive" value="<? echo $sql_result['id']; ?>"  
                                                            <? if($serviceExecutiveStatus==1){ echo 'checked'; }?>
                                                            />
                                                        </td>
                                                        <td><?= $address; ?></td>
                                                        <td><?php echo $sql_result['bankname'];?></td>
                                                        <td><?php echo $sql_result['accountNumber'];?></td>
                                                        <td><?php echo $sql_result['ifsc'];?></td>


                                                    </tr>    
                                                <? $i++; }?>
                                                
                                            </tbody>
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
<script>
function validInput(e) {
  e = (e) ? e : window.event;
  a = document.getElementById('contact');
  cPress = (e.which) ? e.which : e.keyCode;

  if (cPress > 31 && (cPress < 48 || cPress > 57)) {
    return false;
  } else if (a.value.length >= 10) {
    return false;
  }

  return true;
}

$(document).ready(function(){
  // Attach the event handler to the checkbox
  $('.serviceExecutive').change(function(){
    if($(this).is(':checked')){
      // Checkbox is checked
      console.log('Checkbox checked');
    } else {
      // Checkbox is unchecked
      console.log('Checkbox unchecked');
    }
  });
});



  $('.serviceExecutive').change(function(){
      
      let id = $(this).val();
  
    if($(this).is(':checked')){
        
        $.ajax({
              url: 'serviceExecutive.php',
              type : 'POST',
              data : "userid="+id+"&type=1",
              success: function(data) {
                console.log(data);
              }
        });
  
  
    } else {
      $.ajax({
              url: 'serviceExecutive.php',
              type: 'POST',
              data : "userid="+id+"&type=0",
              success: function(data) {
                console.log(data);
              }
        });
    }
  });
  


</script>


</body>

</html>