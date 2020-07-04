<?php

class Car {

    private $name;
    private $wheels;
    private $doors;
    static $counter = 0;

    function __construct($name, $wheels, $doors) {
        $this->name = $name;
        $this->wheels = $wheels;
        $this->doors = $doors;
        self::$counter++;
    }

    function carDetails() {
        echo "\nModel: " . $this->name;
        echo "\nWheels count: " . $this->wheels;
        echo "\nDoors count: " . $this->doors;
    }
}

class Proton extends Car {

}

$proton = new Proton("Wira", 4, 4);
$proton->carDetails();
echo "\n" . Proton::$counter;


?>