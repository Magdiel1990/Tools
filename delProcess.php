<?php
//We include the classes file so we can call the methods.
include ("classes/classes.php");

//Including the head (head, session_start, classes, database connection).
include ("modulos/head.php");

//Including the database conenection.
include ("db/db.php");

if(isset($_POST["username"]) && isset($_POST["password"])  && isset($_POST["validation"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $acceptance = $_POST["validation"];
    if($acceptance == 0){
        header('Location: index.php');
    } else {
        if($username != "" && $password != "" && $acceptance != "") {
            $username = filter_var(trim($username), FILTER_SANITIZE_STRING);
            $password  = filter_var(trim($password), FILTER_SANITIZE_STRING);
            $acceptance = filter_var(trim($acceptance), FILTER_SANITIZE_STRING);

            $sql = "SELECT * FROM users WHERE username =  '$username' AND password = '$password' AND status = 'Admin'";
            $result = $conn -> query($sql);
            $num_rows = $result -> num_rows;

            if($num_rows == 0){
            //Creating the session variable containing the messages when the tool is added.
            $_SESSION['message'] = "No tiene permiso para realizar esta acción!";
            $_SESSION['message_alert'] = "danger";
            
            //After the tool has been added, the page is redirected to the index.php.
            header('Location: deleteAll.php');            
            } else {
                $file ="sql/toolDB.sql";
                $database ="tools";
                $db_hostname = "127.0.0.1:3306";
                $db_username= "root";
                $db_password = "123456";

                $dsn = "mysql:dbname=$database;host=$db_hostname";
                $db = new PDO($dsn, $db_username, $db_password);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
                $sql = file_get_contents($file);
                $db->exec($sql);
            }
        } else {
            //Creating the session variable containing the messages when the tool is added.
            $_SESSION['message'] = "Ingrese su usuario y contraseña de Administrador";
            $_SESSION['message_alert'] = "danger";

            //After the tool has been added, the page is redirected to the index.php.
            header('Location: deleteAll.php'); 
        }
    }
}
?>