<?php

class DBController {

    public $host = "localhost";
    public $dbUser = "root";
    public $dbPassword = "";
    public $dbName = "epay";
    public $connection;
    public function openConnection(){

        $this->connection = new mysqli($this->host, $this->dbUser, $this->dbPassword, $this->dbName);

        if ($this->connection->connect_error){

            echo "Error in connection: " . $this->connection->connect_error;
            return false;
        }
        else {
            return true;
        }
    }
    public function closeConnection(){
        
        if ($this->connection){
            $this->connection->close();
        }
        else {
            echo 'Connection already closed.';
        }

    }

    public function select($qry){

        $result = $this->connection->query($qry);

        if ($result){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        else {
            echo mysqli_error($this->connection);
            return false;
            
        }
    }
    public function insert($qry){

        $result = $this->connection->query($qry);

        if ($result){
            return $this->connection->insert_id;
        }
        else {
            echo mysqli_error($this->connection);
            return false;
            
        }
    }
    public function delete($qry){
        $result = $this->connection->query($qry);
    
        if ($result){
            return $this->connection->affected_rows;
        }
        else {
            echo mysqli_error($this->connection);
            return false;
        }
    }
    public function runQuery($qry) {
        $result = mysqli_query($this->connection, $qry);
        return $result;
    }
    public function getConnection() {
        return $this->connection;
    }
}

?>

