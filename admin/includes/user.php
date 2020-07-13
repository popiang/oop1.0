<?php  

class User {

    protected static $dbTableFields = array('username', 'password', 'first_name', 'last_name');
    protected static $dbTable = "users";
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function findAllUsers() {
        return self::findThisQuery("SELECT * FROM users");
    }

    public static function findById($id) {
        $user = self::findThisQuery("SELECT * FROM users WHERE id = $id LIMIT 1");
        return !empty($user) ? $user[0] : false;
    }

    // execute passed over query
    public static function findThisQuery($sql) {

        global $database;
        $objectArray = array();

        $resultSet = $database->query($sql);

        // create object for every row of result
        while ($row = mysqli_fetch_array($resultSet)) {
            $objectArray[] = self::instantiation($row);
        }

        return $objectArray;
    }

    // create object out of the array of record column
    private static function instantiation($record) {

        // create the object
        $user = new self;

        // assign attribute value to the object
        foreach ($record as $attribute => $value) {
            
            if ($user->has_the_attribute($attribute)) {
                $user->$attribute = $value;
            }
        }
        
        return $user;
    }

    // checking if the class has the attribute
    private function has_the_attribute($attribute) {

        $object_properties = get_object_vars($this);

        return array_key_exists($attribute, $object_properties);
    }

    // get all the properties of this class
    protected function properties() {
        
        $properties = array();

        // looping the dbTableFields array variable
        foreach (self::$dbTableFields as $dbField) {
            // checking if the field exist in the class
            if (property_exists($this, $dbField)) {
                // assign the value of the field of this class object to the respective field
                $properties[$dbField] = $this->$dbField;
            } 
        }

        return $properties;
    }

    // clean the properties using function from database class
    protected function cleanProperties() {

        global $database;

        $cleanProperties = array();

        foreach ($this->properties() as $key => $value) {
            $cleanProperties[$key] = $database->escapeString($value); 
        }

        return $cleanProperties;
    }

    // verify user from login page
    public static function verifyUser($username, $password) {
        
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM " . self::$dbTable . " WHERE ";
        $sql .= "username = '$username' AND ";
        $sql .= "password = '$password' ";
        $sql .= "LIMIT 1";

        $user = self::findThisQuery($sql);

        return !empty($user) ? $user[0] : false;
    }    

    // create or update user in database
    public function save() {
        isset($this->id) ? $this->update() : $this->create();
    }

    // create and insert new user into database
    public function create() {

        global $database;
        $properties = $this->cleanProperties();

        // dynamic insert sql statement
        $sql = "INSERT INTO " . self::$dbTable . " (" . implode(",", array_keys($properties)) . ") ";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

        // $sql = "INSERT INTO " . self::$dbTable . " (username, password, first_name, last_name) ";
        // $sql .= "VALUES ('";
        // $sql .= $database->escapeString($this->username) . "', '";
        // $sql .= $database->escapeString($this->password) . "', '";
        // $sql .= $database->escapeString($this->first_name) . "', '";
        // $sql .= $database->escapeString($this->last_name) . "')";

        if ($database->query($sql)) {
            $this->id = $database->theInsertId();
            return true;
        } else {
            return false;
        }
    }

    // update user info in database
    public function update() {

        global $database;

        $properties = $this->cleanProperties();
        $properties_pairs = array();

        // create the assignment statement for the sql query
        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key} = '{$value}'";
        }

        // dynamic update sql script
        $sql = "UPDATE " . self::$dbTable . " SET ";
        $sql .= implode(",", $properties_pairs);
        $sql .= "WHERE id = '" . $database->escapeString($this->id) . "'";

        // $sql = "UPDATE " . self::$dbTable . " SET ";
        // $sql .= "username = '" . $database->escapeString($this->username) . "', ";
        // $sql .= "password = '" . $database->escapeString($this->password) . "', ";
        // $sql .= "first_name = '" . $database->escapeString($this->first_name) . "', ";
        // $sql .= "last_name = '" . $database->escapeString($this->last_name) . "' ";
        // $sql .= "WHERE id = '" . $database->escapeString($this->id) . "'";

        $database->query($sql);

        return mysqli_affected_rows($database->connection) == 1 ? true : false;
    }

    // delete user in database
    public function delete() {

        global $database;

        $sql = "DELETE FROM " . self::$dbTable . " WHERE ";
        $sql .= "id = " . $database->escapeString($this->id);

        $database->query($sql);

        return mysqli_affected_rows($database->connection) == 1 ? true : false;
    }

} // end of class

?>

