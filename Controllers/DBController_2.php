<?php
    $dbHost="localhost";
    $dbUser="root";
    $dbPassword="";
    $dbName="epay";


    $connection = new mysqli($dbHost,$dbUser,$dbPassword,$dbName);
        
    if(!$connection){
        die("Connection error");
    }


?>