<?php
//Including the head and session_start.
include ("modulos/head.php");

//We include the classes file so we can call the methods.
include ("classes/classes.php");

//Including the database conenection.
include ("db/db.php");

//We verfy if the POST method comes with information
if(isset($_POST["username"]) && isset($_POST["password"])  && isset($_POST["validation"])){

//Receiving the variables.    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $acceptance = $_POST["validation"];

//If the username or password are wrong it's redirected to the index.php.
    if($acceptance == 0){
        header('Location: index.php');
    } else {
//If the username and password are right, the variables are verified whether they come null.
        if($username != "" && $password != "" && $acceptance != "") {
//If they come with information, they're sanitized.
            $username = filter_var(trim($username), FILTER_SANITIZE_STRING);
            $password  = filter_var(trim($password), FILTER_SANITIZE_STRING);
            $acceptance = filter_var(trim($acceptance), FILTER_SANITIZE_STRING);
//We verify if is the user is an Admin user who has the permition to perform the task.
            $sql = "SELECT * FROM users WHERE username =  '$username' AND password = '$password' AND status = 'Admin'";
            $result = $conn -> query($sql);
            $num_rows = $result -> num_rows;
//If it's not a Admin user, a message of rejection is sent.
            if($num_rows == 0){
            //Creating the session variable containing the messages when the tool is added.
            $_SESSION['message'] = "No tiene permiso para realizar esta acción!";
            $_SESSION['message_alert'] = "danger";
            
//The user is sent to index.php.
            header('Location: deleteAll.php');            
            } else {
//If it's an Admin user, the delection process is carried out.
                
//SQL file existance verification.
                $file ="sql/toolDB.sql";
//If the directory doesn't exist, it's created
                if(!is_file($file)){
                    mkdir($file, 0777);
                } 
//If the SQL file exists, we store in variables the data of the database.
                $database ="tools";
                $db_hostname = "127.0.0.1:3306";
                $db_username= "root";
                $db_password = "123456";
//We execute the sql file scripts
                $dsn = "mysql:dbname=$database;host=$db_hostname";
                $db = new PDO($dsn, $db_username, $db_password);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
                $sql = file_get_contents($file);
                $db->exec($sql);
            }
        } else {
//If the user don't fill the all required field, we respond with this message, and send him back to deleteAll.php.
            $_SESSION['message'] = "Ingrese su usuario y contraseña de Administrador";
            $_SESSION['message_alert'] = "danger";

            header('Location: deleteAll.php'); 
        }
    }
}

//Closing the connection.
$conn -> close();
?>