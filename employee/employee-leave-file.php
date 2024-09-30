<?php
ob_start(); // Start output buffering

require '../vendor/autoload.php';
require '../model/conn.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class EmployeeLeave {

    private $db;
    private $emp_id;

    public function __construct($conn, $emp_id) {
        $this->db = $conn;
        $this->emp_id = $emp_id;

    }

    function CreateEmployeeLeave() {
        $statement = $this->db->prepare("SELECT * FROM employeedetails WHERE employee_id = ?");
        $statement->bind_param("i", $this->emp_id);
        $statement->execute();
        $resultleaveinfo = $statement->get_result();

        $leaveType = [
            'vacation' => 'B11',
            'sick' => 'B15',
            'emergency'=> 'B21'
        ];
        if ($resultleaveinfo->num_rows > 0) {
            $emp_info = $resultleaveinfo->fetch_assoc();
            $spreadSheet = IOFactory::load('../files/CS Form No. 6, Revised 2020 (Application for Leave) (Fillable).xlsx');
            $sheet = $spreadSheet->getActiveSheet();

            // Setting Name
            $FullName = $emp_info['last_name'] . ', ' . $emp_info['first_name'];
            $sheet->setCellValue('E5', $FullName);

            // Setting Position
            $position = $emp_info['position'];
            $sheet->setCellValue('F6', $position);

            // Date of Filing
            $dateToday = new DateTime();
            $formattedDate = $dateToday->format('Y-m-d');
            $sheet->setCellValue('D6', $formattedDate);


            // Correct Headers
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Application for Leave.xlsx"');
            header('Cache-Control: max-age=0');

            // Write the file to the output
            $writer = IOFactory::createWriter($spreadSheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }
    }
}

if (isset($_GET['emp_id'])  ) {
    $id = $_GET['emp_id'];

    $empLeave = new EmployeeLeave($conn, $id);
    $empLeave->CreateEmployeeLeave();
}

ob_end_clean(); // Clean (erase) the output buffer and turn off output buffering
?>
