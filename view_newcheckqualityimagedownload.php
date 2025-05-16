<?php
// ini_set('memory_limit', '-1');

include('config.php');

 $atmid = $_POST['atmid'];
//  $visitid = $_POST['id'];

// die;

function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }

if(isset($_POST['download'])){
    if($_POST['id']){
        $visitid = $_POST['id'];
        $fileName = $atmid.'_images'.'.zip'; 
        $getimagesql = "select link,key_name from newcheckquality_images_app where visitid='".$visitid."'"; 
        $getimagesdata = mysqli_query($con,$getimagesql);
    
        $imagesdata_array = array();
        $itemarray = array();
        if(mysqli_num_rows($getimagesdata)>0){
            while($getimages_result = mysqli_fetch_array($getimagesdata)){
                array_push($imagesdata_array,$getimages_result[0]);
                
                array_push($itemarray,$getimages_result[1]);
            }
        }
    
        if(count($imagesdata_array)>0){
            $files_to_zip = $imagesdata_array;
          
            $files = array(); /*Image array*/
            $files = $files_to_zip;
            
            
            # create new zip opbject
            $zip = new ZipArchive();
            
            # create a temp file & open it
            $tmp_file = tempnam('.','');
            $zip->open($tmp_file, ZipArchive::CREATE);
            
            # loop through each file
            foreach($files as $k => $file){
            
                # download file
                $download_file = curl_get_file_contents($file);
                $extention = pathinfo($file, PATHINFO_EXTENSION);
                
                $_fil_name = $itemarray[$k]."."."$extention";
                // #add it to the zip
                $zip->addFromString($_fil_name,$download_file);
               
            }
            
        //     # close zip
            $zip->close();
            
            # send the file to the browser as a download
            header('Content-disposition: attachment; filename='.$fileName);
            header('Content-type: application/zip');
            ob_clean();
	        flush();
            readfile($tmp_file);
            unlink($tmp_file);
          
          
        }
    }
}
?>
<script>
//   window.location = "view_newcheckquality_test.php";
</script>