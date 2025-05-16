<?php  
session_start();
include('config.php');

if ($_SESSION['username']) {
    include('header.php');
    ?>
<style>
   .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
      line-height: 1.42857143; 
      border: inherit;
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
   }
</style>
<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <div class="main-body">
         <div class="page-wrapper">
            <div class="page-header">
               <div class="row align-items-end">
                  <div class="col-lg-8">
                     <div class="page-header-title">
                        <div class="d-inline">
                           <h4>My Profile</h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="page-body">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="cover-profile">
                        <div class="profile-bg-img">
                           <img class="profile-bg-img img-fluid" src="https://demo.dashboardpack.com/adminty-html/files/assets/images/user-profile/bg-img1.jpg" alt="bg-img">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     <div class="tab-header card">
                        <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                           <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#personal" role="tab" aria-selected="true">Personal Info</a>
                              <div class="slide"></div>
                              
                              
                           </li>
                        </ul>
                     </div>
                     <div class="tab-content">
                        <div class="tab-pane active" id="personal" role="tabpanel">
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="card-header-text">About Me</h5>
                                 <button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                 <i class="feather icon-edit"></i>
                                 </button>
                              </div>
                              <div class="card-block">
                                  <?php
                                  
                                  $edituser = $_REQUEST['usertoupdate'];
                                  $sql = mysqli_query($con,"select * from mis_loginusers where id='".$edituser."'");
                                  $sql_result = mysqli_fetch_assoc($sql);
                                  
                                  $name = $sql_result['name'];
                                  $dob = $sql_result['dob'];
                                  $address = $sql_result['address'];
                                  $email = $sql_result['uname'];
                                  $mobile = $sql_result['personalcontactno'];
                                  $bankname = $storedbankname = $sql_result['bankname'];
                                  $accountNumber = $sql_result['accountNumber'];
                                  $ifsc = $sql_result['ifsc'];
                                  ?>
                                 <div class="view-info" style="">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="general-info">
                                             <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                   <div class="table-responsive">
                                                      <table class="table m-0">
                                                         <tbody>
                                                            <tr><th scope="row">Full Name</th><td><? echo $name; ?></td></tr>
                                                            <tr><th scope="row">Birth Date</th><td><? echo $dob ; ?></td></tr>
                                                            <tr><th scope="row">Location</th><td><? echo $address ; ?></td></tr>
                                                            <tr><th scope="row">Bank Name</th><td><? echo $bankname; ?></td></tr>
                                                            <tr><th scope="row">Account Number</th><td><? echo $accountNumber; ?></td></tr>
                                                            <tr><th scope="row">IFSC Code</th><td><? echo $ifsc; ?></td></tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                                <div class="col-lg-12 col-xl-6">
                                                   <div class="table-responsive">
                                                      <table class="table">
                                                         <tbody>
                                                            <tr><th scope="row">Email</th><td><a href="#!"><? echo $email ; ?></a></td></tr>
                                                            <tr><th scope="row">Mobile Number</th><td><? echo $mobile ; ?></td></tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <?php
                        if(isset($_REQUEST["submit"])){
                            $fullname = $_REQUEST["fullname"]; 
                            $dob = $_REQUEST["dob"]; 
                            $address = $_REQUEST["address"]; 
                            $email = $_REQUEST["email"];
                            $mobile = $_REQUEST["mobile"];
                            $bankname = $_REQUEST["bankname"];
                            $accountNumber = $_REQUEST["accountNumber"];
                            $ifsc = $_REQUEST["ifsc"];
                            
                            $update = "update mis_loginusers set 
                                name='".$fullname."',
                                dob='".$dob."',
                                address='".$address."',
                                personalcontactno='".$mobile."',
                                bankname='".$bankname."',
                                accountNumber='".$accountNumber."',
                                ifsc='".$ifsc."'
                                where id='".$userid."'";
                            
                            if(mysqli_query($con, $update)){
                                ?>
                                <script>
                                    alert('Updated Successfully!');
                                    window.location.href='profileUpdate.php?usertoupdate=<?php echo $edituser ; ?>';
                                </script>


                                <?php
                            }
                        }
                        ?>

                        <div class="tab-pane" id="personal2" role="tabpanel">
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="card-header-text">About Me</h5>
                                 <button id="edit-cancel" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">Cancel</button>
                              </div>
                              <div class="card-block">
                                 <div class="view-info">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="general-info">
                                             <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                                 <input type="hidden" name="usertoupdate" value="<?php echo $edituser ; ?>" />
                                                                                   

                                                <div class="row">
                                                   <div class="col-lg-12 col-xl-6">
                                                      <div class="table-responsive">
                                                         <table class="table m-0">
                                                            <tbody>
                                                               <tr><th scope="row">Full Name</th><td><input type="text" name="fullname" class="form-control" value="<? echo $name; ?>" /></td></tr>
                                                               <tr><th scope="row">Birth Date</th><td><input type="date" name="dob" class="form-control" value="<? echo $dob; ?>" /></td></tr>
                                                               <tr><th scope="row">Location</th><td><input type="text" name="address" class="form-control" value="<? echo $address; ?>" /></td></tr>
                                                               <tr><th scope="row">Bank Name</th>
                                                                    <td>
                                                                    <select name="bankname" class="form-control">
                                                        <option value="">Select</option>
                                                        <?php 
                                                        $banksql = mysqli_query($con,"SELECT * FROM bank order by bank asc");
                                                        while($banksql_result = mysqli_fetch_assoc($banksql)){
                                                            $bankname = $banksql_result['bank'];
                                                            ?>
                                                            <option value="<?= $bankname; ?>" <?php if($bankname==$storedbankname){ echo 'selected';} ?>> <?= $bankname;  ?></option>
                                                            <?
                                                        }
                                                        
                                                        
                                                        ?>
                                                    </select>
                                                                    </td>
                                                               </tr>
                                                               <tr><th scope="row">Account Number</th><td><input type="text" name="accountNumber" class="form-control" value="<? echo $accountNumber; ?>" /></td></tr>
                                                               <tr><th scope="row">IFSC Code</th><td><input type="text" name="ifsc" class="form-control" value="<? echo $ifsc; ?>" /></td></tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                   <div class="col-lg-12 col-xl-6">
                                                      <div class="table-responsive">
                                                         <table class="table">
                                                            <tbody>
                                                               <tr><th scope="row">Email</th><td><input type="email" name="email" class="form-control" value="<? echo $email; ?>" /></td></tr>
                                                               <tr><th scope="row">Mobile Number</th><td><input type="text" name="mobile" class="form-control" value="<? echo $mobile; ?>" /></td></tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                   <div class="col-lg-12 col-xl-6">
                                                      <input type="submit" name="submit" value="Update" class="btn btn-success" />
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
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<script>
    $("#personal2").css('display', 'none');

$(document).on('click', "#edit-btn", function() {
    $("#personal").css('display', 'none');
    $("#personal2").css('display', 'block');
});

$(document).on('click', "#edit-cancel", function() {
    $("#personal").css('display', 'block');
    $("#personal2").css('display', 'none');
});

</script>



<? 
        include('./footer.php');
    
    
} else{ 


}?>








