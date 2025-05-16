<?
include('config.php');

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
        $fileName = 'my-archive.zip';
        $getimagesql = "select link from misvisit_images where misvisitid='".$visitid."'"; 
        $getimagesdata = mysqli_query($con,$getimagesql);
        $imagesdata_array = array();
        if(mysqli_num_rows($getimagesdata)>0){
            while($getimages_result = mysqli_fetch_array($getimagesdata)){
                array_push($imagesdata_array,$getimages_result[0]);
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
            foreach($files as $file){
              // echo $file;die;
                # download file
             //   $download_file = file_get_contents($file);
                $download_file = curl_get_file_contents($file);
                #add it to the zip
                $zip->addFromString(basename($file),$download_file);
            
            }
            
            # close zip
            $zip->close();
            
            # send the file to the browser as a download
            header('Content-disposition: attachment; filename=download.zip');
            header('Content-type: application/zip');
            ob_clean();
	        flush();
            readfile($tmp_file);
            unlink($tmp_file);
          /*
                $zipname = 'file.zip';
                $zip = new ZipArchive;
                $zip->open($zipname, ZipArchive::CREATE);
                foreach ($files as $file) {
                  $zip->addFile($file);
                }
                $zip->close();
                        
                header('Content-Type: application/zip');
                header('Content-disposition: attachment; filename='.$zipname);
                header('Content-Length: ' . filesize($zipname));
                readfile($zipname); */
          
        }
    }
}
?>
<script>
  window.location = "view_newvisit.php";
</script>