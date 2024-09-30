<?php
// Start output buffering

require '../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PDS
{

    private $db;
    private $pds_id;
    private $file_path;
    public function __construct($db, $filePath, $pds)
    {
        $this->db = $db;
        $this->pds_id = $pds;
        $this->file_path = $filePath;
    }
    function getFilePath()
    {
        return $this->file_path;
    }
    function createPDSFile()
    {
        $query = 'SELECT * FROM view_pds WHERE personal_id = ? LIMIT 1';
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $this->pds_id);
        $statement->execute();
        $pds_info = $statement->get_result()->fetch_assoc();

        $inputFileName = '../files/pds.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);

        $sheet = $spreadsheet->getActiveSheet();

        $this->file_path = $this->file_path . 'pds_' . $this->pds_id . '.xlsx';
        $sheet->setCellValue('D10', $pds_info['surname']);
        $sheet->setCellValue('D11', $pds_info['first_name']);
        $sheet->setCellValue('D13', $pds_info['date_of_birth']);
        $sheet->setCellValue('I34', $pds_info['email_address']);
        $sheet->setCellValue('I33', $pds_info['mobile_no']);


        // Additional mappings
        $sheet->setCellValue('D22', $pds_info['height']);
        $sheet->setCellValue('D24', $pds_info['weight']);
        $sheet->setCellValue('D25', $pds_info['blood_type']);
        $sheet->setCellValue('D27', $pds_info['gsis_id_no']);
        $sheet->setCellValue('D29', $pds_info['pagibig_id_no']);
        $sheet->setCellValue('D31', $pds_info['philhealth_no']);
        $sheet->setCellValue('D32', $pds_info['sss_no']);
        $sheet->setCellValue('D33', $pds_info['tin_no']);

        $sheet->setCellValue('D36', $pds_info['spouse_surname']);
        $sheet->setCellValue('D37', $pds_info['spouse_first_name']);
        $sheet->setCellValue('D38', $pds_info['spouse_middle_name']);
        $sheet->setCellValue('D39', $pds_info['spouse_occupation']);

        $sheet->setCellValue('D43', $pds_info['father_surname']);
        $sheet->setCellValue('D44', $pds_info['father_first_name']);
        $sheet->setCellValue('D45', $pds_info['father_middle_name']);

        $sheet->setCellValue('D46', $pds_info['mother_maiden_name']);
        $sheet->setCellValue('D48', $pds_info['mother_first_name']);
        $sheet->setCellValue('D49', $pds_info['mother_middle_name']);

        $sheet->setCellValue('I37', $pds_info['child_name']);
        $sheet->setCellValue('M37', $pds_info['child_date_of_birth']);

        $sheet->setCellValue('L60', new DateTime());

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($this->file_path);
    }
    /* 
surname = d10
fname = d11
dob = d13
email = I34
contact = I33

height = D22
weight = D24
bloodtype = D25
GSIS = D27
pagibig = D29
phil = D31
sss = D32

TIN = D33

spouse surname= D36
spouse firstname = D37
spouse middle name = D38

father surname D43
father first name D44
middle name D45

mother surname D46
mother first name D48
middle name D49

chidlren name I 37
dob M37

Date L60
*/

   
}
