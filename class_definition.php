<?php

class Cars {


}

$my_classes = get_declared_classes();

foreach ($my_classes as $class) {
    echo "\n" . $class;
}



?>