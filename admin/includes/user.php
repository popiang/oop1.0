<?php  

class User {

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

    // verify user from login page
    public static function verifyUser($username, $password) {
        
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '$username' AND ";
        $sql .= "password = '$password' ";
        $sql .= "LIMIT 1";

        $user = self::findThisQuery($sql);

        return !empty($user) ? $user[0] : false;
    }    

    // create and insert new user into database
    public function create() {

        global $database;

        $sql = "INSERT INTO users (username, password, first_name, last_name) ";
        $sql .= "VALUES ('";
        $sql .= $database->escapeString($this->username) . "', '";
        $sql .= $database->escapeString($this->password) . "', '";
        $sql .= $database->escapeString($this->first_name) . "', '";
        $sql .= $database->escapeString($this->last_name) . "')";

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

        $sql = "UPDATE users SET ";
        $sql .= "username = '" . $database->escapeString($this->username) . "', ";
        $sql .= "password = '" . $database->escapeString($this->password) . "', ";
        $sql .= "first_name = '" . $database->escapeString($this->first_name) . "', ";
        $sql .= "last_name = '" . $database->escapeString($this->last_name) . "' ";
        $sql .= "WHERE id = '" . $database->escapeString($this->id) . "'";

        $database->query($sql);

        return mysqli_affected_rows($database->connection) == 1 ? true : false;
    }

} // end of class

?>