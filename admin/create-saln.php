<?php
require '../vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Style\Font;
class SALN {
    private $db;
    private $file_path;
    private $saln_id;

    public function __construct($db,$file_path,$saln_id) {
        $this->db = $db;
        $this->file_path = $file_path;
        $this->saln_id = $saln_id;
    }
function getFilePath(){
    return $this->file_path;
}
function changeColor($word){
    $coloredText = '<w:r><w:rPr><w:color w:val="000000"/></w:rPr><w:t>' .$word . '</w:t></w:r>';

    return $coloredText;
}
    function CreateSALNFile(){
        $query = 'SELECT * FROM view_saln WHERE saln_id = ?';
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $this->saln_id);
        $statement->execute();
        $saln_info = $statement->get_result()->fetch_assoc();

        //Change All the color:
        foreach($saln_info as $key=>$value){
            $saln_info[$key] = $this->changeColor($value);
        }
         // Load template
         $templateProcessor = new TemplateProcessor('../files/saln.docx');
         $templateProcessor->setValue('date',$saln_info['date']);
         $templateProcessor->setValue('d_surname',$saln_info['declarant_last_name']);
         $templateProcessor->setValue('d_fname',$saln_info['declarant_first_name']);
         $templateProcessor->setValue('d_mi',$saln_info['declarant_mi']);
         $templateProcessor->setValue('d_address',$saln_info['declarant_address']);

         $templateProcessor->setValue('d_position',$saln_info['declarant_position']);
         $templateProcessor->setValue('d_agency',$saln_info['declarant_agency']);
         $templateProcessor->setValue('d_office_address',$saln_info['declarant_office_address']);

         $templateProcessor->setValue('s_surname',$saln_info['spouse_last_name']);
         $templateProcessor->setValue('s_fname',$saln_info['spouse_first_name']);
         $templateProcessor->setValue('s_position',$saln_info['spouse_position']);
         $templateProcessor->setValue('s_agency',$saln_info['spouse_agency']);
         $templateProcessor->setValue('s_office_address',$saln_info['spouse_office_address']);

         //SetChild
         $templateProcessor->setValue('child_1',$saln_info['child_name']);
         $templateProcessor->setValue('child_1_dob',$saln_info['child_dob']);
         $templateProcessor->setValue('child_1_age',$saln_info['child_age']);
         
         //Assets ${descripnt_1}
         $templateProcessor->setValue('descripnt_1',$saln_info['asset_description']);
         $templateProcessor->setValue('kind_1',$saln_info['asset_kind']);
         $templateProcessor->setValue('e_location_1',$saln_info['asset_location']);
         $templateProcessor->setValue('a_value_1',$saln_info['asset_assessed_value']);
         $templateProcessor->setValue('m_value_1',$saln_info['asset_market_value']);
         $templateProcessor->setValue('yea_1',$saln_info['asset_acquisition_date']);
         $templateProcessor->setValue('mode_1',''); //Empty Column in table
         $templateProcessor->setValue('aq_cost_1',$saln_info['asset_acquisition_cost']);

         //Personal Property
         $templateProcessor->setValue('p_property_description_1',$saln_info['personal_property_description']);
         $templateProcessor->setValue('p_property_aq_1',$saln_info['personal_property_year_acquired']);
         $templateProcessor->setValue('p_aq_amt_1',$saln_info['personal_property_cost']);
         //Liabilities
         $templateProcessor->setValue('lia_n_1',$saln_info['liability_nature']);
         $templateProcessor->setValue('lia_name_1',$saln_info['liability_name']);
         $templateProcessor->setValue('lia_balance_1',$saln_info['liability_balance']);

         //Business
         $templateProcessor->setValue('b_name_1',$saln_info['business_name']);
         $templateProcessor->setValue('b_add_1',$saln_info['business_address']);
         $templateProcessor->setValue('b_nature_1',$saln_info['business_nature']);
         $templateProcessor->setValue('b_aq_1',$saln_info['business_date_of_acquisition']);

         //relatives
         $templateProcessor->setValue('r_name_1',$saln_info['relative_name']);
         $templateProcessor->setValue('r_rls_1',$saln_info['relative_relationship']);
         $templateProcessor->setValue('r_position_1',$saln_info['relative_position']);
         $templateProcessor->setValue('r_agency_1',$saln_info['relative_agency_and_address']);
         
         $this->file_path = $this->file_path . 'SALN_'.$this->saln_id.'.docx';
         $savePath = $this->file_path;
         $templateProcessor->saveAs($savePath);
    }
}


?>