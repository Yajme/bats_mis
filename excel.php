<?php
require 'vendor/autoload.php';

//https://github.com/PHPOffice/PHPWord
//PHPSpreadsheets

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;




try {
    // Load the existing Excel file
    $inputFileName = './files/pds.xlsx';
    $spreadsheet = IOFactory::load($inputFileName);

    // Get the active sheet (or choose another sheet by index or name)
    $sheet = $spreadsheet->getActiveSheet();

    // Modify some cells
    $sheet->setCellValue('D10', 'Some Value');   // Modify value in cell A1
     // Modify formula in cell C3

    // Save the modified file (you can overwrite the original or save as a new file)
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('modified-file.xlsx');  // Or save as the original file

    echo "Excel file modified successfully.";
} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    echo "Error loading file: " . $e->getMessage();
}
    
?>