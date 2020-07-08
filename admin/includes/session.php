<?php  

class Session {

    private $signedIn = false;
    public $userId;
    public $msg;

    function __construct() {
        session_start();
        $this->checkLogin();
        $this->checkMessage();
    }

    private function checkLogin() {
        if (isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
            $this->signedIn = true;
        } else {
            unset($this->userId);
            $this->signedIn = false;
        }
    }

    public function isSignedIn() {
        return $this->signedIn;
    }

    public function login($user) {
        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $this->userId = $_SESSION['user_id'];
            $this->signedIn = true;
        }
    }

    public function logout() {
        unset($this->userId);
        unset($_SESSION['user_id']);
        $this->signedIn = false;
    }

    public function message($msg = "") {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    public function checkMessage() {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
}

$session = new Session();

?>