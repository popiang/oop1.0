<?php  

// auto load class if forgotten to be included
function classAutoLoader($class) {

    $class = strtolower($class);
    $path = "includes/{$class}.php";

    if (file_exists($path)) {
        require_once($path);
    } else {
        die("This file name {$class}.php was not found!");
    }
}

// registering the auto load function
spl_autoload_register('classAutoLoader');

// redirecting user to the provided location
function redirect($location) {
    header("Location: {$location}");
}

?>