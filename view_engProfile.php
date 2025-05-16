<? session_start();
include('config.php');

if ($_SESSION['username']) {

    include('header.php');
    
    $userid= $_GET['id'];
    $sql= mysqli_query($con,"select * from profile_details where user_id = '".$userid."' ");
    $sql_result = mysqli_fetch_assoc($sql);
    
    
    
?>

    <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
    <style>
        .select2-container .select2-selection--single {
            height: auto !important;
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
    margin: 0px auto;
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
                    <div class="page-body">
                        
                        <div class="card">
                            
                            <div class="card-block">

                                <h5>Profile Details</h5>
                                    <div class="row">
                                        <div class="col-md-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                              
                                                <div class="form-group">
                                                  <label for="fname">Full Name</label>
                                                  <input type="text" name="fname" id="fname" class="form-control" value="<? echo $sql_result['name'];?>" readonly>
                                                </div>
                                                
                                                <div class="form-group">
                                                  <label for="cnumber">Mobile No.</label>
                                                  <input type="text" class="form-control" id="cnumber" name="cnumber"  value="<? echo $sql_result['contact'];?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                  <label for="cemail">Email</label>
                                                  <input type="email" class="form-control" id="cemail" name="cemail"  value="<? echo $sql_result['email'];?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                  <label for="dob">Date of Birth</label>
                                                  <input type="text" class="form-control" id="dob" name="dob"  value="<? echo $sql_result['dob'];?>" readonly>
                                                </div>
                                                
                                                <div class="form-group">
                                                  <label for="qualification">Qualification</label>
                                                  <input type="text" class="form-control" id="qualification" name="qualification"  value="<? echo $sql_result['qualification'];?>" readonly>
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


<? include('footer.php');
} else { ?>

    <script>
        window.location.href = "login.php";
    </script>
<? }
?>



<style>
    .box {
        display: block;
        min-width: 300px;
        height: 300px;
        margin: 10px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
    }

    .upload-options {
        position: relative;
        height: 75px;
        background-color: #404e67;
        cursor: pointer;
        overflow: hidden;
        text-align: center;
        transition: background-color ease-in-out 150ms;
    }

    .upload-options:hover {
        background-color: #7fb1b3;
    }

    .upload-options input {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .upload-options label {
        display: flex;
        align-items: center;
        width: 100%;
        height: 100%;
        font-weight: 400;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        overflow: hidden;
    }

    .upload-options1 label::after {
        content: "Selfie with Panel Pox";
        font-family: "Material Icons";
        position: absolute;
        font-size: 1.5rem;
        color: #e6e6e6;
        top: calc(50% - 1.5rem);
        z-index: 0;
        width: 100%;
    }

    .upload-options2 label::after {
        content: "PIR Sensors";
        font-family: "Material Icons";
        position: absolute;
        font-size: 1.5rem;
        color: #e6e6e6;
        top: calc(50% - 1.5rem);
        z-index: 0;
        width: 100%;
    }

    .upload-options3 label::after {
        content: "EML Lock";
        font-family: "Material Icons";
        position: absolute;
        font-size: 1.5rem;
        color: #e6e6e6;
        top: calc(50% - 1.5rem);

        z-index: 0;
        width: 100%;
    }

    .upload-options4 label::after {
        content: "Full Backroom";
        font-family: "Material Icons";
        position: absolute;
        font-size: 1.5rem;
        color: #e6e6e6;
        top: calc(50% - 1.5rem);
        z-index: 0;
        width: 100%;
    }

    .upload-options5 label::after {
        content: "Full Lobby";
        font-family: "Material Icons";
        position: absolute;
        font-size: 1.5rem;
        color: #e6e6e6;
        top: calc(50% - 1.5rem);
        z-index: 0;
        width: 100%;
    }

    .upload-options6 label::after {
        content: "Out site snaps";
        font-family: "Material Icons";
        position: absolute;
        font-size: 1.5rem;
        color: #e6e6e6;
        top: calc(50% - 1.5rem);
        z-index: 0;
        width: 100%;
    }





    .upload-options label span {
        display: inline-block;
        width: 50%;
        height: 100%;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        vertical-align: middle;
        text-align: center;
    }

    .upload-options label span:hover i.material-icons {
        color: lightgray;
    }

    .js--image-preview {
        height: 225px;
        width: 100%;
        position: relative;
        overflow: hidden;
        background-image: url("");
        background-color: white;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .js--image-preview::after {
        content: "photo_size_select_actual";
        font-family: "Material Icons";
        position: relative;
        font-size: 1.5em;
        color: #e6e6e6;
        top: calc(50% - 2rem);
        left: 8%;
        z-index: 0;
    }

    .js--image-preview.js--no-default::after {
        display: none;
    }

    .js--image-preview:nth-child(2) {
        background-image: url("http://bastianandre.at/giphy.gif");
    }

    i.material-icons {
        transition: color 100ms ease-in-out;
        font-size: 2.25em;
        line-height: 55px;
        color: white;
        display: block;
    }

    .drop {
        display: block;
        position: absolute;
        background: rgba(95, 158, 160, 0.2);
        border-radius: 100%;
        transform: scale(0);
    }

    .animate {
        -webkit-animation: ripple 0.4s linear;
        animation: ripple 0.4s linear;
    }

    @-webkit-keyframes ripple {
        100% {
            opacity: 0;
            transform: scale(2.5);
        }
    }

    @keyframes ripple {
        100% {
            opacity: 0;
            transform: scale(2.5);
        }
    }
</style>


</body>

</html>