<?php  

require_once("new_config.php");

class Database {

    public $connection;

    function __construct() {
        $this->open_db_connection();
    }

    // create connection to db
    public function open_db_connection() {
     
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_errno) {
            die("Database connection failed. " . mysqli_error($this->connection->connect_error));
        }
    }

    // execute query
    public function query($sql) {
        
        $result = $this->connection->query($sql);

        $this->confirm_query($result);

        return $result;
    }

    // check query run
    private function confirm_query($result) {
        if (!$result) {
            die("Query failed" . $this->connection->error);
        }
    }

    // sanitize query variables
    public function escapeString($string) {
        return $this->connection->real_escape_string($string);
    }

    // get the latest insert id
    public function theInsertId() {
        return mysqli_insert_id($this->connection);
    }
}

$database = new Database();
