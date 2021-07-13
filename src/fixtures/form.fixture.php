<?php
$root_path = '/RRM-PHP-FORM';
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/standard.php');

class formFixture extends Standard
{
    public function random_strings($length_of_string) {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    function data_type($val) {
        return ((is_numeric($val)) ? 'INT' : 'VARCHAR(15)');
    }

    public function load($formObject = null) {
        // Create table
        (function($f){
            $sql = "CREATE TABLE IF NOT EXISTS applications";
            $keyIndex = 0;
            $field = '';
            foreach ($f as $key => $value) {
                // Filter class name from array object
                $key = str_replace('Form', '', $key);

                // Set data types
                $type = $this->data_type($value);
                $type = ($key == 'email') ? 'VARCHAR(100)' : $type;
                $type = ($key == 'description') ? 'TEXT' : $type;
                $type = ($key == 'address1') ? 'TEXT' : $type;
                $type = ($key == 'address2') ? 'TEXT' : $type;
                $type = ($key == 'cv_path') ? 'TEXT' : $type;
                if ($keyIndex == 0) {
                    $field = $key." ".$type;
                } else {
                    $field .= ", ".$key." ".$type;
                }
                $keyIndex++;
            }
            $sql .= "(".$field.")";
            echo $sql;
            // echo json_encode($f);
        })($formObject);
        // Check if email already exists
    }
}
?>
