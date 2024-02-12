<?php
require_once '../Models/user.php';
require_once '../Controllers/AuthController.php';
require_once '../Controllers/AuthController.php';


$errorMessage ="";

$db = new DBController;


if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])){
    if ($_POST['fname'] && $_POST['lname'] && $_POST['email'] && $_POST['username'] && $_POST['password']) {

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            if (strlen($_POST['password']) > 8){

                if (preg_match("/[a-z]/i", $_POST['password'])){

                    if (preg_match("/[0-9]/i", $_POST['password'])){

                        $db->openConnection();
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $query = "select * from user where username='$username'";
                        $result1 = $db->select($query);
                        
                        if (!$result1){
                            print_r($result);
                            $query = "select * from user where email='$email'";
                            $result2 = $db->select($query);
                            print_r($result);

                            if (!$result2){
                                $fname = $_POST['fname'];
                                $lname = $_POST['lname'];
                                $password = $_POST['password'];
                                $user = new User;
                                $user->first_name = $fname;
                                $user->last_name = $lname;
                                $user->username = $username;
                                $user->email = $email;
                                $user->password = $password;
                                $controller = new AuthController;
                                $controller->register($user);
        
                                if ($controller){
                                    header('location: index.php');
                                }
        
                                else {
                                    session_start();
                                    $_SESSION['errorMessage'] = 'Something went wrong';
                                    header('location: signin.php');
                                }
                            }
                            else {
                                session_start();
                                $_SESSION['errorMessage'] = 'This email is taken, please try another email.';
                                header('location: signin.php');
                            }

                        }
                        else{
                            session_start();
                            $_SESSION['errorMessage'] = 'This uername is taken, please try another username.';
                            header('location: signin.php');
                        }
                    }

                    else {
                        session_start();
                        $_SESSION['errorMessage'] = 'Password must contain atleast one digit';
                        header('location: signin.php');
                    }
                }

                else {
                    session_start();
                    $_SESSION['errorMessage'] = 'Password must contain atleast one letter';
                    header('location: signin.php');
                }

            }
            else {
                session_start();
                $_SESSION['errorMessage'] = 'Please enter a strong password';
                header('location: signin.php');
            }
        }
        else{
            session_start();
            $_SESSION['errorMessage'] = 'Please enter a valid email address';
            header('location: signin.php');
        }
    }
    else {
        session_start();
        $_SESSION['errorMessage'] = 'Please fill all fields.';
        header('location: signin.php');
    }
}
?>