<?php
require_once 'Classes/PHPExcel.php';
error_reporting(0);
// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a worksheet
$objPHPExcel->setActiveSheetIndex(0);
$worksheet = $objPHPExcel->getActiveSheet();

// Load your image
$imagePath = 'assets/Picture1.png'; // Replace with the actual image path

// Add the image to a specific cell (e.g., A1)
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Header Image');
$objDrawing->setDescription('Header Image');
$objDrawing->setPath($imagePath);
$objDrawing->setCoordinates('A1'); // Set the cell where the image should be inserted
$objDrawing->setWorksheet($worksheet);

// Adjust the cell size to make it look like a header
$worksheet->getRowDimension(1)->setRowHeight(100); // Adjust the height as needed

// Save the Excel file
$outputFilePath = 'output.xlsx'; // Replace with your desired output file path
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($outputFilePath);

echo 'Excel file with header-like image created successfully.';
?>
