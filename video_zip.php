<?php 
// (A) NEW ZIP ARCHIVE OBJECT
$zip = new ZipArchive();
$zipfile = "demoB.zip";
//echo __DIR__ ;die;
$tozip = __DIR__ . "/checkqualityapp/43/";

// (B) OPEN/CREATE ZIP FILE
if ($zip->open($zipfile, ZipArchive::CREATE) === true) {
  // (B1) ADD ENTIRE FOLDER
  // Add all JPG PNG GIF files in "/test/" into the "inside/" folder of the zip archive
  echo $zip->addGlob($tozip . "*.{jpg,mp4}", GLOB_BRACE, [
    "add_path" => "inside/",
    "remove_all_path" => true
  ]) ? "Folder added to zip" : "Error adding folder to zip" ;

  // (B2) CLOSE ZIP
  echo $zip->close()
   ? "Zip archive closed" : "Error closing zip archive" ;
}

// (C) FAILED TO OPEN/CREATE ZIP FILE
else { echo "Failed to open/create $zipfile"; }


           