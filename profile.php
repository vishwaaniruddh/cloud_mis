<? session_start();
include('config.php');


if($_SESSION['username']){ 


include('header.php');

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

<style>
    /*Profile Pic Start*/
.picture-container{
    position: relative;
    cursor: pointer;
    text-align: center;
}
.picture{
    width: 106px;
    height: 106px;
    background-color: #999999;
    border: 4px solid #CCCCCC;
    color: #FFFFFF;
    border-radius: 50%;
    /*margin: 0px auto;*/
    overflow: hidden;
    transition: all 0.2s;
    -webkit-transition: all 0.2s;
}
.picture:hover{
    border-color: #2ca8ff;
}
.content.ct-wizard-green .picture:hover{
    border-color: #05ae0e;
}
.content.ct-wizard-blue .picture:hover{
    border-color: #3472f7;
}
.content.ct-wizard-orange .picture:hover{
    border-color: #ff9500;
}
.content.ct-wizard-red .picture:hover{
    border-color: #ff3b30;
}
.picture input[type="file"] {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    opacity: 0 !important;
    position: absolute;
    top: 0;
    width: 100%;
}

.picture-src{
    width: 100%;
    
}
/*Profile Pic End*/
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
                                    
                                        <form class="form-sample" id="forms" action="add_calltracker.php" method="POST" enctype="multipart/form-data" >
                    						<div class="row">
                    						    
                                                <div class="col-md-6 grid-margin stretch-card">
                                                    
                                                    <div class="card">
                                                    <div class="card-body">
                                                      <h3 class="card-title"><u>Create Profile</u></h3>
                                                      <br>
                                                          <div class="form-group">
                                                              <label>Upload Image</label>
                                                            
                                                                <div class="picture-container">
                                                                    
                                                                    <div class="picture">
                                                                        
                                                                        <img src="profile_images/person-user-icon.png" class="picture-src" id="wizardPicturePreview" title="">
                                                                        <input type="file" id="wizard-picture" class="">
                                                                        
                                                                    </div>
                                                                     
                                                                </div>
                                                            
                                                          </div>
                                                          
                                                          <div class="form-group">
                                                          <label for="atmid">Full Name</label>
                                                          <input type="text" name="fname" id="fname" class="form-control">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                          <label for="address">Address</label>
                                                          <textarea type="text" class="form-control" id="address" name="address" rows="5" cols="25" placeholder="Address" required></textarea>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                          <label for="cnumber">Contact</label>
                                                          <input type="text" class="form-control" id="cnumber" name="cnumber" placeholder="Contact" onkeypress="return isNumber(event)" maxlength="10" required>
                                                        </div>
                                                        <div class="form-group">
                                                          <label for="cemail">Email</label>
                                                          <input type="email" class="form-control" id="cemail" name="cemail" placeholder="Email" required>
                                                        </div>
                                                        <div class="form-group">
                                                          <label for="pin">Pincode</label>
                                                          <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" required>
                                                        </div>
                                                        
                                                        <button type="submit" name="sub" class="btn btn-primary mr-2"  style="float:right">Submit</button>
                                                        
                                                      </form>
                                                    </div>
                                                  </div>
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
                    
                    
    <? 
    }
else{ ?>
    
    <script>
        window.location.href="=login.php";
    </script>
<? }
    ?>

<script>
    $(document).ready(function(){
// Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
        readURL(this);
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
} 
</script>

       
    <script src="../files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../files/assets/js/pcoded.min.js"></script>
    <script src="../files/assets/js/vartical-layout.min.js"></script>
    <!--<script type="text/javascript" src="../files/assets/pages/dashboard/custom-dashboard.js"></script>-->
    
    
</body>

</html>