<?php
//Connection to the database.
$hostname = "127.0.0.1:3306";
$username = "root"; 
$password = "123456"; 
$database = "tools";
    
$conn = new mysqli($hostname, $username, $password, $database);
    
// Check connection
if ($conn->connect_error) {
    die("Error en conexión: " . $conn->connect_error);
}
?>