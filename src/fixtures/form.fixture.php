<?php
$root_path = '/RRM-PHP-FORM';
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/standard.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/database.php');

class formFixture
{
    public $db;
    public $response = array();

    public function __construct() {
        $this->db = new Database();
    }


    function data_type($val) {
        return ((is_numeric($val)) ? 'i' : 's');
    }

    public function load($formObject = null) {
        // Create table
        (function($f){
            $sql = '
                CREATE TABLE IF NOT EXISTS applicants( 
                    id INT(12) AUTO_INCREMENT PRIMARY KEY,
                    firstname VARCHAR(30), lastname VARCHAR(30), email VARCHAR(50) NOT NULL,
                    teleNumber VARCHAR(30) NOT NULL, address1 TEXT, address2 VARCHAR(100),
                    postcode VARCHAR(15), town VARCHAR(30), county VARCHAR(30),
                    country VARCHAR(30), description TEXT, cv_path TEXT,
                    reg_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
            ';
            // Insert data into table
            $sql = (String) $sql;
            $query = $this->db->ExecuteQuery( $sql );
            if ($query) {
                (function($form){
                    $fieldIndex = 0;
                    $fQ = ''; // Field
                    $vQ = ''; // Value Placeholder
                    $dataTypeMap = '';  // Data type map
                    $values = []; // Values

                    foreach ($form as $key => $value) {
                        $key = str_replace('Form', '', $key);
                        $key = preg_replace('/[\x00-\x1F\x7F]/', '', $key);
                        if ($fieldIndex == 0) {
                            $fQ = "`$key`";
                            $vQ = " ? ";
                            $dataTypeMap = $this->data_type($value);
                        } else {
                            $fQ .= ", `$key`";
                            $vQ .= ", ? ";
                            $dataTypeMap .= ($key == 'postcode') ? 's' : $this->data_type($value);
                        }
                        
                        // Filter and assign values
                        $values[] = $this->db->escapeString($value);
                        $fieldIndex++;
                    }

                    array_unshift($values , $dataTypeMap); // Add datatyoe map to start of array
                    $query = "INSERT INTO `applicants` ($fQ) VALUES ($vQ)";
                    try {
                        
                        $id = $this->db->Insert($query, $values);
                        $this->response['id'] = $id;
                        $this->response['return'] = true;
                        return;

                    } catch (Exception $e) {
                        throw New Exception( $e->getMessage() );
                    }
                    $this->response['return'] = false;
                })($f);
            } else {
                echo "Error creating table";
            }
        })($formObject);
        
        // Return all response data
        return $this->response;
    }
}
?>
