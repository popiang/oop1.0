<?php  

class Photo extends DB_Object {

    protected static $dbTableFields = array('title', 'description', 'filename', 'type', 'size');
    protected static $dbTable = "photos";
    public $id;
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;

}

?>