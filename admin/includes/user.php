<?php  

class User extends DB_Object{

    protected static $dbTableFields = array('username', 'password', 'first_name', 'last_name');
    protected static $dbTable = "users";
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

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

} // end of class

?>

