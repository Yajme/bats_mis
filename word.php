<?php
require('vendor/autoload.php');
use PhpOffice\PhpWord\TemplateProcessor;

$templateProcessor = new TemplateProcessor('./files/saln.docx');

$templateProcessor->setValue('date','September 30, 2024');
$templateProcessor->setValue('d_surname','Doe');
$templateProcessor->setValue('d_fname','John');
$templateProcessor->setValue('d_mi','A');
$templateProcessor->setValue('s_surname','Doe');
$templateProcessor->setValue('s_fname','Jane');
$templateProcessor->setValue('s_mi','G');
$templateProcessor->saveAs('./files/saln_1.docx');

echo ' done';
?>