<?php
require_once '../Controllers/AuthController.php';
require_once '../Models/user.php';

$errorMessage = "";

if (isset($_POST['username']) && isset($_POST['password'])){
    if ($_POST['username'] && $_POST['password']){

        $user = new User();
        $controller = new AuthController;
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];

        if ($controller->login($user)){

            if (!isset($_SESSION['userID'])){
                session_start();
            }

            if ($_SESSION['isUserAdmin'] == 0){

                header("location: index.php");
            }
            else {
                header("location: admin-order.php");
            }

        }

        else {
            if (!isset($_SESSION['userID'])){
                session_start();
            }

            $_SESSION['errorMessage'] = 'Invalid username or password';

            header("location: login.php");

        }

    }
    else {
        if (!isset($_SESSION['userID'])){
            session_start();
        }

        $_SESSION['errorMessage'] = 'Please fill the empty data';

        header("location: login.php");
    }
}
?>