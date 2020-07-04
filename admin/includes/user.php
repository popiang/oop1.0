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
        return $user[0];
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
}

?>