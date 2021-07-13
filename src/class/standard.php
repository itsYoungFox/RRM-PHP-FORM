<?php
$root_path = '/RRM-PHP-FORM';

require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/config/db_config.php');

class Standard
{
    public $db;
    
    function __construct() {
        $this->db = new mysqli(db_host, db_user, db_pass, db_name);
    }

    // filter post data
    public function filter_post_data($postObject) {
        $postData = array();
        foreach ($postObject as $key => $value) {
            $postData[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        }
        return $postData;
    }
}
?>