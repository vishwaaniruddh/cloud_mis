<?php

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
        $fileName = $atmid.'.zip'; 
        $getimagesql = "select link,key_name from newcheckquality_images_app where visitid='".$visitid."'"; 
        $getimagesdata = mysqli_query($con,$getimagesql);
        
        $imagesdata_array = array();
        $imagesname_array = array();
        if(mysqli_num_rows($getimagesdata)>0){
            while($getimages_result = mysqli_fetch_array($getimagesdata)){
                array_push($imagesdata_array,$getimages_result[0]);
            }
        }
 
        if(count($imagesdata_array)>0){
            $files_to_zip = $imagesdata_array;
          
            $files = array(); /*Image array*/
            $files = $files_to_zip;
            
            $rootPath = realpath($files_to_zip);
            echo $rootPath;
            // $names = array();
            // $names = $imagesname_array;
            
            
            # create new zip opbject
            // Initialize archive object
				// $zip = new ZipArchive();
				// $zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    //             $files = new RecursiveIteratorIterator(
				// 	new RecursiveDirectoryIterator($rootPath),
				// 	RecursiveIteratorIterator::LEAVES_ONLY
				// );
            
            # loop through each file
            // foreach($files as $file){
            
            //     # download file
            
            //     $download_file = curl_get_file_contents($file);
              
            //     print_r($download_file); echo '<br>';
            //     #add it to the zip
            //     $zip->addFromString(basename($file),$download_file);
              
            // }
            
            # close zip
            $zip->close();
            
            # send the file to the browser as a download
        //     header('Content-disposition: attachment; filename='.$fileName);
        //     header('Content-type: application/zip');
        //     ob_clean();
	       // flush();
        //     readfile($tmp_file);
        //     unlink($tmp_file);
          
          
        }
    }
}



// // Get real path for our folder
// 				$rootPath = realpath('zip_images1');

// 				// Initialize archive object
// 				$zip = new ZipArchive();
// 				$zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// 				// Initialize empty "delete list"
// 				// $filesToDelete = array();

// 				// Create recursive directory iterator
// 				/** @var SplFileInfo[] $files */
// 				$files = new RecursiveIteratorIterator(
// 					new RecursiveDirectoryIterator($rootPath),
// 					RecursiveIteratorIterator::LEAVES_ONLY
// 				);

// 				foreach ($files as $name => $file)
// 				{
// 					// Skip directories (they would be added automatically)
// 					if (!$file->isDir())
// 					{
// 						// Get real and relative path for current file
// 						$filePath = $file->getRealPath();
// 						$relativePath = substr($filePath, strlen($rootPath) + 1);

// 						// Add current file to archive
// 						$zip->addFile($filePath, $relativePath);

// 						// Add current file to "delete list"
// 						// delete it later cause ZipArchive create archive only after calling close function and ZipArchive lock files until archive created)
// 				// 		if ($file->getFilename() != 'important.txt')
// 				// 		{
// 				// 			$filesToDelete[] = $filePath;
// 				// 		}
// 					}
// 				}

// 				// Zip archive will be created only after closing object
// 				$zip->close();

?>