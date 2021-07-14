<?php
$root_path = '/RRM-PHP-FORM';
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/config/db_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/standard.php');

class Database
{
    private $connection = null;
    
    function __construct() {
        try {
            $this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            if ($this->connection->connect_errno) {
                throw new Exception("Failed to connect to MySQL: (" . $this->connection->connect_errno . ") " . $this->connection->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    // Insert a row/s in a Database Table
    public function Insert( $query = "" , $params = [] ){
        try {
            $stmt = $this->executeStatement( $query , $params );
            $stmt->close();
            return $this->connection->insert_id;
            
        } catch(Exception $e) {
            echo $this->connection->error;
            throw new Exception($e->getMessage());   
        }		
    }


    // Select a row/s in a Database Table
    public function Select( $query = "" , $params = [] ){
        try {

            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
            $stmt->close();
            return $result;
		
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }


    // Update a row/s in a Database Table
    public function Update( $query = "" , $params = [] ){
        try {
		
            $this->executeStatement( $query , $params )->close();
		
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
	
        return false;
    }


    // Remove a row/s in a Database Table
    public function Remove( $query = "" , $parameters = [] ){
        try{
			
            $this->executeStatement( $query , $parameters );
			
        } catch(Exception $e) {
            throw new Exception($e->getMessage());   
        }		
    }


    // Execute queries
    public function ExecuteQuery( $query = "" ){
        try {
            
            $qry = $this->connection->query( $query );
            return ($qry) ? true : false;

        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    

    // execute statement
    private function executeStatement( $query = "" , $params = [] ){
        try {
            $stmt = $this->connection->prepare( $query );
            
            if($stmt === false) throw New Exception("Unable to do prepared statement: " . $query);		
            if( $params ) {
                call_user_func_array(array($stmt, 'bind_param'), Standard::refValues($params));
            }
            
            $stmt->execute();
            return $stmt;

        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }

    // Filter Illegal Characters from String
    public function escapeString( $string = "" ){
        return $this->connection->real_escape_string( $string );
    }
}
?>