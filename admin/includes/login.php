<?php  
require_once("init.php");

if ($session->isSignedIn()) {
    redirect("index.php");
}

if (isset($_POST['submit'])) {
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // check user in database
    $userFound = User::verifyUser($username, $password);

    if ($userFound) {
        $session->login($userFound);
        redirect("index.php");
    } else {
        $theMessage = "Your username or password is incorrect";
    }

} else {
    $username = "";
    $password = "";
}


?>