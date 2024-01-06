<?php
require_once PROJECT_ROOT_PATH . "/Model/User.php";

class Database
{
    protected $connection = null;

    public function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            if ( mysqli_connect_errno() )
                throw new Exception("Could not connect to database.");
        } catch ( Exception $e ) {
            throw new Exception($e->getMessage());
        }
    }

    public function execute( $query = "", $params = [] ) {
        try {
            $stmt = $this->executeStatement($query, $params);
            //$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            if ($stmt->field_count > 0) {
                // If the statement is a SELECT statement, fetch the results
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            } else {
                // If the statement is an INSERT statement, return the inserted ID
                $result = $stmt->insert_id;
            }
            $stmt->close();
            if ( !is_null($stmt) )
                return $result;
        } catch ( Exception $e ) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    private function executeStatement( $query = "", $params = [] ) {
        try {
            $stmt = $this->connection->prepare($query);
            if ( $stmt === false )
                throw new Exception("Unable to do prepared statement: " . $query);
            if ( $params ) {
                $vars = array_slice($params, 1);
                $stmt->bind_param($params[0], ...$vars);
            }
            $stmt->execute();
            return $stmt;
        } catch ( Exception $e ) {
            throw new Exception($e->getMessage());
        }
    }

}
