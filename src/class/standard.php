<?php
require_once(dirname(__FILE__) . '/config/db_config.php');

class stdlib
{
    public $db;
    
    function __construct() {
        $this->db = new mysqli(db_host, db_user, db_pass, db_name);
    }
}
?>