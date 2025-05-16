<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
 <style>
    .select2-container .select2-selection--single{height: auto !important;}
 </style>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
    
                            <form id="form" action="process_add_n.php" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>ATM ID</label>
                                                        <div class="input-group input-group-button">
                                                           <!-- <input type="text" name="atmid" id="atmid" class="form-control " placeholder="Atm ID">-->
                                                             <select class="form-control js-example-basic-single w-100" id="atmid" name="atmid" required>
                            <option value="">Select ATM ID</option>
                                <?  $atm_sql = mysqli_query($con,"SELECT atmid FROM `mis_newsite`");
                                   while($atm_sql_result = mysqli_fetch_assoc($atm_sql)){  ?>
                                      <option value="<? echo strtoupper($atm_sql_result['atmid']); ?>">
                                   <?  echo strtoupper($atm_sql_result['atmid']); ?>
                                </option> 
                                   <? } ?>
                          </select>
                                                        </div>
                                                </div>
                             
                             
            <div class="col-sm-4">
                <label class="label_label">Bank</label>
                            <input type="text" name="bank" id="bank" class="form-control" readonly>
            </div>

                    <div class="col-sm-4">
                        <label>Customer</label>
                         <input type="text" name="customer" id="customer" class="form-control" readonly required>
                        <!--<select class="form-control" id="customer" name="customer" required>
                            <option value="">Select Customer</option>
                                <? /* $con_sql = mysqli_query($con,"select * from contacts where type='c'");
                                   while($con_sql_result = mysqli_fetch_assoc($con_sql)){ */ ?>
                                      <option value="<? //echo strtoupper($con_sql_result['contact_first']); ?>">
                                   <? // echo strtoupper($con_sql_result['contact_first']); ?>
                                </option> 
                                   <?// } ?>
                          </select>-->
                      </div>


                    
                            
                            <div class="col-sm-2">
                                <label class="label_label">Zone</label>
                                <input class="form-control" type="text" name="zone" id="zone" value="<? echo $zone ; ?>" readonly>
                            </div>


                            
                            <div class="col-sm-2">
                                <label class="label_label">City</label>
                                <input class="form-control" type="text" name="city" id="city" value="<? echo $city; ?>" required readonly>
                            </div>
                            
                            
                            
                              <div class="col-sm-2">
                                <label class="label_label">State</label>
                                 <input type="text" name="state" id="state" class="form-control" readonly required>
                               <!-- <select required name="state"  id ="state" class="form-control" required>
                                    <option value="">Select State</option>
                                    <? /*
                                        $state_sql = mysqli_query($con,"select * from state order by state");
                                        while($state_sql_result = mysqli_fetch_assoc($state_sql)){ */ ?>
                                            <option value="<?// echo $state_sql_result['state']; ?>"><?// echo $state_sql_result['state'];?></option>
                                        <? //} ?>
                                </select>-->

                            </div>
                            <div class="col-sm-6">
                                <label class="label_label">Locations</label>
                                <input class="form-control" type="text" name="location" id="location" value="<? echo $location ; ?>" readonly>
                            </div>
                            
                            
                                            </div>
                                        <br>
                                        <div id="last_visit_info"></div>    
                                            <br>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                     <label>Select Type</label>
                                                    <select class="form-control" id="tabselect" name="tabselect">
                                                        <option value=""> Select </option>
                                                        <option value="rms">RMS</option>
                                                        <option value="dvr">DVR Activity</option>
                                                        <option value="cloud">Cloud</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                                <br />
                                                <div class="col-sm-6">
                                                    <label>Select Engineer</label>
                                                    <select class="form-control js-example-basic-single w-100" name="engineer" id="engineer" onchange="engcon(this)">
                                                        <option value="">Select Engineer</option>
                                                        <? $eng_sql = mysqli_query($con,"select * from mis_loginusers");
                                                        while($eng_sql_result = mysqli_fetch_assoc($eng_sql)){ ?>
                                                            <option value="<? echo $eng_sql_result['id']; ?> "> <? echo $eng_sql_result['name']; ?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <label>Contact Number</label>
                                                    <input type="text" name="eng_contact" id="eng_contact" class="form-control">
                                                    <br>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                    <div class="wrapper row">
                                      <div class="box col-sm-3">
                                        <div class="js--image-preview"></div>
                                        <div class="upload-options upload-options1">
                                          <label>
                                            <input name="SelfiewithPanelPox" type="file" class="image-upload" accept="image/*" required/>
                                          </label>
                                        </div>
                                      </div>
                                      <div class="box col-sm-3">
                                        <div class="js--image-preview"></div>
                                        <div class="upload-options upload-options2">
                                          <label>
                                            <input name="PIRSensors" type="file" class="image-upload" accept="image/*" required/>
                                          </label>
                                        </div>
                                      </div>
                                      <div class="box col-sm-3">
                                        <div class="js--image-preview"></div>
                                        <div class="upload-options upload-options3">
                                          <label>
                                            <input name="EMLLock" type="file" class="image-upload" accept="image/*" required/>
                                          </label>
                                        </div>
                                      </div>
                                      <div class="box col-sm-3">
                                        <div class="js--image-preview"></div>
                                        <div class="upload-options upload-options4">
                                          <label>
                                            <input name="FullBackroom" type="file" class="image-upload" accept="image/*" required/>
                                          </label>
                                        </div>
                                      </div>
                                      <div class="box col-sm-3">
                                        <div class="js--image-preview"></div>
                                        <div class="upload-options upload-options5">
                                          <label>
                                            <input name="FullLobby" type="file" class="image-upload" accept="image/*" required/>
                                          </label>
                                        </div>
                                      </div>
                                      
                                      <div class="box col-sm-3">
                                        <div class="js--image-preview"></div>
                                        <div class="upload-options upload-options6">
                                          <label>
                                            <input name="Outsitesnaps" type="file" class="image-upload" accept="image/*" required/>
                                          </label>
                                        </div>
                                      </div>
                                      
                                     <!-- <input type="file" name="videoFile" required/>-->
                                      
                                    </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                              <div class="row" id="tabresult"></div>
                                            
                                            
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-danger">
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
        window.location.href="login.php";
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
    
        <script>
        
        function initImageUpload(box) {
  let uploadField = box.querySelector('.image-upload');

  uploadField.addEventListener('change', getFile);

  function getFile(e){
    let file = e.currentTarget.files[0];
    checkType(file);
  }
  
  function previewImage(file){
    let thumb = box.querySelector('.js--image-preview'),
        reader = new FileReader();

    reader.onload = function() {
      thumb.style.backgroundImage = 'url(' + reader.result + ')';
    }
    reader.readAsDataURL(file);
    thumb.className += ' js--no-default';
  }

  function checkType(file){
    let imageType = /image.*/;
    if (!file.type.match(imageType)) {
      throw 'Datei ist kein Bild';
    } else if (!file){
      throw 'Kein Bild gew채hlt';
    } else {
      previewImage(file);
    }
  }
  
}

// initialize box-scope
var boxes = document.querySelectorAll('.box');

for (let i = 0; i < boxes.length; i++) {
  let box = boxes[i];
  initDropEffect(box);
  initImageUpload(box);
}



/// drop-effect
function initDropEffect(box){
  let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;
  
  // get clickable area for drop effect
  area = box.querySelector('.js--image-preview');
  area.addEventListener('click', fireRipple);
  
  function fireRipple(e){
    area = e.currentTarget
    // create drop
    if(!drop){
      drop = document.createElement('span');
      drop.className = 'drop';
      this.appendChild(drop);
    }
    // reset animate class
    drop.className = 'drop';
    
    // calculate dimensions of area (longest side)
    areaWidth = getComputedStyle(this, null).getPropertyValue("width");
    areaHeight = getComputedStyle(this, null).getPropertyValue("height");
    maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));

    // set drop dimensions to fill area
    drop.style.width = maxDistance + 'px';
    drop.style.height = maxDistance + 'px';
    
    // calculate dimensions of drop
    dropWidth = getComputedStyle(this, null).getPropertyValue("width");
    dropHeight = getComputedStyle(this, null).getPropertyValue("height");
    
    // calculate relative coordinates of click
    // logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
    x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10)/2);
    y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10)/2) - 30;
    
    // position drop and animate
    drop.style.top = y + 'px';
    drop.style.left = x + 'px';
    drop.className += ' animate';
    e.stopPropagation();
    
  }
}




      
      
        $("#tabselect").on("change",function(){    
            
            var status = $(this).val();
            $("#tabresult").html('');
            
            if(status=='rms'){
                $("#rms_only").css('display','block');
                var html = '<div id="rms_only"><div class="row"><div class="col-sm-4"> <label>EML Working Status </label> <select required name="eml" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>Panic Switch Status </label>    <select required name="panic" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>Two way Status </label>    <select required name="twoway" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>Hooder connect to hood door</label>    <select required name="hooder" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>All atm machine sensor Status </label>    <select required name="machine_sensor" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>Shutter Sensor</label>    <select required name="shutter" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>Glass break Sensors</label>    <select required name="glass_break_sensor" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>PIR Sensor</label>    <select required name="pir" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>AC Connection</label>    <select required name="acCon" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>Relay Connection Data </label>    <select required name="relayCon" class="form-control"> <option value=""> Select </option> <option value="working">working</option> <option value="not working">not working</option> <option value="faulty">faulty</option> <option value="not install">not install</option> <option value="missing">missing</option> <option value="not required">not required</option>    </select></div><div class="col-sm-4">    <label>Panel Battery Backup Status </label>    <select required name="panel_battery" class="form-control"> <option value=""> Select </option> <option value="more than 4 hours - good">more than 4 hours - good</option> <option value="less than 4 hours - bad">less than 4 hours -  bad</option> <option value="Not Required">Not Required</option>    </select></div><div class="col-sm-4">    <label>Count In Panel Battery </label>    <select required name="count_panel_battery" class="form-control">        <option value=""> Select </option>        <option value="1">1</option>        <option value="2">2</option>        <option value="3">3</option>        <option value="missing">Missing</option>    </select></div></div><hr> <div class="row"><div class="col-sm-4">    <label>Panel Name</label>    <input type="text" name="panel_name" class="form-control"></div><div class="col-sm-4">    <label>Router Name</label>    <input type="text" name="router_name" class="form-control"></div><div class="col-sm-4">    <label>router id</label>    <input type="text" name="router_id" class="form-control"></div> </div> <br>  <div class="row">  <div class="col-sm-12">    <label>Remark</label>    <input type="text" name="remark" class="form-control">    <br><br></div></div></div>';
                                
                                
                 html += '<div class="col-sm-2"><label>DVR Status</label><select class="form-control" name="status" required><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option> </select> </div>                                                  <div class="col-sm-2"><label>1st Camera</label> <select required name="cam1" class="form-control" required><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select> </div>                                                     <div class="col-sm-2"><label>2nd  Camera</label> <select required name="cam2" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select></div>                                           <div class="col-sm-2"> <label>3rd Camera</label> <select required name="cam3" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select> </div>                                                   <div class="col-sm-2"><label>4th Camera</label> <select required name="cam4" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select></div>                                                    <div class="col-sm-2"> <label>HDD Status</label> <select required name="hdd_status" required class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select> </div>';
            }else if(status=='dvr'){
                $("#rms_only").css('display','none');
                var html = '<div class="col-sm-3"> <label>DVR Name</label> <select required name="status" class="form-control"><option value=""> Select </option> <option value="hikvision"> Hikvision </option><option value="CPPLUS"> CPPLUS </option> <option value="CPPLUS_INDIA"> CPPLUS_INDIA </option> <option value="DAHUVA"> DAHUVA </option> </select> </div> <div class="col-sm-3"><label>1st Camera</label> <select required name="cam1" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select> </div>                                                     <div class="col-sm-3"><label>2nd  Camera</label> <select required name="cam2" required class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select></div>                                           <div class="col-sm-3"> <label>3rd Camera</label> <select required name="cam3" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select> </div>                                                   <div class="col-sm-3"><label>4th Camera</label> <select required name="cam4" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select></div>                                                    <div class="col-sm-3"> <label>HDD Status</label> <select required name="hdd_status" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select> </div>                                             <div class="col-sm-3"><label>Router Name</label><input required type="text" name="routername" class="form-control"></div>    <div class="col-sm-3"><label>Router ID</label><input required type="text" name="routerid" class="form-control"></div>   ';
            }else if(status=='cloud'){
                $("#rms_only").css('display','none');
                var html = '<div class="col-sm-3"> <label>IP Camera</label> <select required name="ip_cam" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select> </div>                                                     <div class="col-sm-3"><label>SD Card Status</label> <select required name="sd_card_status" class="form-control"><option value=""> Select </option> <option value="working"> Working </option><option value="not_working"> Not Working </option><option value="faulty"> Faulty </option> <option value="not_install"> Not Install </option> <option value="missing"> Missing </option>  <option value="not_require"> Not Require </option></select></div>                            <div class="col-sm-3"><label>Router Name</label><input required type="text" name="routername" class="form-control"></div>    <div class="col-sm-3"><label>Router ID</label><input required type="text" name="routerid" class="form-control"></div> ';
            }else if(status=='other'){
                $("#rms_only").css('display','none');
                var html ='<div class="col-sm-6"> <label>DVR Name</label> <select required name="status" class="form-control"><option value=""> Select </option> <option value="Footage"> Footage </option><option value="Visit"> Visit </option><option value="installation"> Installation </option><option value="Service"> Service </option></select></div>                                                                           <div class="col-sm-6"> <label>Status</label> <select required class="form-control"  id="other_statussss" onchange="other_status(this)" ><option value="Open">Open</option><option value="Close">Close</option>   <option value="">Other</option></select></div>                                        <input required type="hidden" name="other_statuss" id="fundReqDetails" value="Open"><br>                             <input required class="form-control" type="text" id="fundDetails_other" style="display:none;" onchange="setfundDetails()"> <span style="display:none;" id="backSelect" onclick="selectBack()">Back Select</span>';        
            }
            $("#tabresult").html(html);

        
        });

      
      
            function other_status(val){
                var selectedValue = val.value;

                if(selectedValue==""){
                    $("#fundDetails_other").css('display','block');
                    $("#backSelect").css('display','block');
                    $("#fundDetails").css('display','none');
                }
                else{
                    $('#fundReqDetails').val(selectedValue);
                }
                

      }





function selectBack(){
    
  $("#fundDetails").css('display','block');
  $("#fundDetails_other").css('display','none');
  $("#backSelect").css('display','none');
  $("#other_statussss").val('Open');
}


  function setfundDetails(){ 
      var Value = $("#fundDetails_other").val();
      $("#fundReqDetails").val(Value);
  }
      
      $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        
      
        function engcon(id){

           $.ajax({
            type: "POST",
            url: 'get_eng_data.php',
            data: 'id='+id.value,
            success:function(msg) {
                $("#eng_contact").val(msg);    
            } });
        }
        
        
        $("#atmid").on('change',function(){ debugger;
           var atmid = $("#atmid").val();
           
           $.ajax({
            type: "POST",
            url: 'visit_atm_data.php',
            data: 'atmid='+atmid,
            success:function(msg) { debugger;
                console.log(msg);
                if(msg !=0 ){
                    var obj = JSON.parse(msg);
                    var customer = obj['customer'];
                    var bank = obj['bank'];
                    var location = obj['location'];
                    var city = obj['city'];
                    var state = obj['state'];
                    var region = obj['region'];
                    var engineer = obj['engineer'];
                    var created_at = obj['created_at'];
                    

                   $("#last_visit_info").html('<h5>Last Visit Date : '+ created_at+'</h5><h5>Last Visit Engineer Name : '+ engineer+'</h5>');


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
                    
                    if(customer && bank && location && region && state && city){
                        $("#call_receive").focus();
                    }

                
                    
                }
                else{
                    alert('No Info With This ATM');
                    
                    $("#customer").val('');     //  $('#customer').attr('readonly', false);
                    $("#bank").val('');         //      $('#bank').attr('readonly', false);
                    $("#location").val('');     //      $('#location').attr('readonly', false);
                    $("#zone").val('');         //   $('#zone').attr('readonly', false);
                
                    
                }


            }
           });
});
</script>


</body>

</html>