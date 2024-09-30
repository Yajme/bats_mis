<?php
require '../vendor/autoload.php';
require '../model/conn.php';
use PhpOffice\PhpWord\TemplateProcessor;

class Travelform {

    private $db;
    private $tofe_id;

    public function __construct($db, $tofe_id) {
        $this->db = $db;
        $this->tofe_id = $tofe_id;
    }

    function createForm() {
        // Fetch data from the database
        $statement = $this->db->prepare("SELECT * FROM view_tof_names WHERE tofe_id = ?");
        $statement->bind_param("i", $this->tofe_id);
        $statement->execute();
        $tof_info = $statement->get_result()->fetch_assoc();

        // Load template
        $templateProcessor = new TemplateProcessor('../files/TORF.docx');

        // Set placeholders dynamically
        for ($i = 1; $i <= 20; $i++) {
            $name  =$tof_info['e_id'.$i.'_name'];
            $name = $name =='N/A' ? '' : $name;
            $templateProcessor->setValue('emp_'.$i,$name);
        }

        // Save the generated document to a temporary file
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
        $templateProcessor->saveAs($temp_file);

        // Send the file for download
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="TravelForm_'.$this->tofe_id.'.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));

        // Read and output the file content
        readfile($temp_file);

        // Delete the temporary file
        unlink($temp_file);
    }
}

// Handle the request and trigger the form creation
if (isset($_GET['tofe_id'])) {
    $id = $_GET['tofe_id'];
    $tof = new Travelform($conn, $id);
    $tof->createForm();
}
?>
