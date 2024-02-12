<?php
require_once "../Models/user.php";
require_once "../Controllers/DBController.php";
class AuthController {

    protected $dbConnection;

    public function login(User $user){
        $this->dbConnection = new DBController;
        if ($this->dbConnection->openConnection()){
            $query = "select * from user where username = '$user->username' and password = '$user->password'";
            $result = $this->dbConnection->select($query);
            if ($result===false) {
                session_start();
                $_SESSION['errorMessage'] = 'Error in query';
                return false;
            }
            else {
                    if (count($result)==0){
                        session_start();
                        $_SESSION['errorMessage'] = "Wrong username or password";
                        return false;
                    }
                    else {
                        session_start();
                        $_SESSION['userID'] = $result[0]['id'];
                        $_SESSION['userUsername'] = $result[0]['username'];
                        $_SESSION['userFname'] = $result[0]['first_name'];
                        $_SESSION['userLname'] = $result[0]['last_name'];
                        $_SESSION['isUserAdmin'] = $result[0]['is_admin'];
                        return true;
                    }
                }
            }
        else {
                session_start();
                $_SESSION['errorMessage'] = 'A problem occurred.';
                return false;
            }
        }
    public function register(User $user){

        $this->dbConnection = new DBController;
        if ($this->dbConnection->openConnection()){

            $query = "INSERT INTO `user` (`email`, `first_name`, `last_name`, `password`, `username`, `is_admin`) VALUES ('$user->email', '$user->first_name', '$user->last_name', '$user->password', '$user->username', '0');";

            $result = $this->dbConnection->insert($query);

            if ($result){
                session_start();
                $_SESSION['userID'] = $result;
                $_SESSION['username'] = $user->username;
                $_SESSION['isAdmin'] = 0;
                return true;
            }
            else {
                session_start();
                $_SESSION['errorMessage'] = 'Something went wrong, please try again later.';
                return false;
            }

        }
    
    }
}
?>