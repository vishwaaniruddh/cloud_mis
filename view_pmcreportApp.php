<?php
include('config.php');

$atmid = $_POST['atmid'] ?? '';
$visitid = $_POST['id'] ?? '';

if(isset($_POST['download']) && !empty($visitid)) {
    $fileName = $atmid . '_pmcreport.zip';

    // Define possible directories
    $tozip = __DIR__ . "/pmcreportappchecknow/" . $visitid . "/";
    if (!file_exists($tozip)) {
        $tozip = __DIR__ . "/pmcreportapp/" . $visitid . "/";
    }

    if (!file_exists($tozip)) {
        die("Error: Directory not found.");
    }

    // Create a temporary zip file
    $tmp_file = tempnam(sys_get_temp_dir(), 'zip');
    $zip = new ZipArchive();

    if ($zip->open($tmp_file, ZipArchive::CREATE) === true) {
        // Add files manually since addGlob() does not support paths directly
        foreach (glob($tozip . "*.{jpg,mp4}", GLOB_BRACE) as $file) {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        // Send the file to the browser for download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($tmp_file));

        ob_clean();
        flush();
        readfile($tmp_file);

        unlink($tmp_file); // Delete temp file
    } else {
        die("Error: Unable to create ZIP file.");
    }
}
?>
