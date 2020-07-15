<?php  

class DB_Object {

    public static function findAll() {
        return static::findByQuery("SELECT * FROM " . static::$dbTable);
    }

    public static function findById($id) {
        $result = static::findByQuery("SELECT * FROM " . static::$dbTable . " WHERE id = $id LIMIT 1");
        return !empty($result) ? $result[0] : false;
    }

    // execute passed over query
    public static function findByQuery($sql) {

        global $database;
        $objectArray = array();

        $resultSet = $database->query($sql);

        // create object for every row of result
        while ($row = mysqli_fetch_array($resultSet)) {
            $objectArray[] = static::instantiation($row);
        }

        return $objectArray;
    }

    // create object out of the array of record column
    private static function instantiation($record) {

        //get the calling class = sub class
        $callingClass = get_called_class();

        // create the object
        $object = new $callingClass;

        // assign attribute value to the object
        foreach ($record as $attribute => $value) {
            
            if ($object->hasTheAttribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        
        return $object;
    }

    // checking if the class has the attribute
    private function hasTheAttribute($attribute) {

        $object_properties = get_object_vars($this);

        return array_key_exists($attribute, $object_properties);
    }

    // get all the properties of this class
    protected function properties() {
        
        $properties = array();

        // looping the dbTableFields array variable
        foreach (static::$dbTableFields as $dbField) {
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

    // create or update user in database
    public function save() {
        isset($this->id) ? $this->update() : $this->create();
    }

    // create and insert new user into database
    private function create() {

        global $database;
        $properties = $this->cleanProperties();

        // dynamic insert sql statement
        $sql = "INSERT INTO " . static::$dbTable . " (" . implode(",", array_keys($properties)) . ") ";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->theInsertId();
            return true;
        } else {
            return false;
        }
    }

    // update user info in database
    private function update() {

        global $database;

        $properties = $this->cleanProperties();
        $properties_pairs = array();

        // create the assignment statement for the sql query
        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key} = '{$value}'";
        }

        // dynamic update sql script
        $sql = "UPDATE " . static::$dbTable . " SET ";
        $sql .= implode(",", $properties_pairs);
        $sql .= "WHERE id = '" . $database->escapeString($this->id) . "'";

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

}

?>