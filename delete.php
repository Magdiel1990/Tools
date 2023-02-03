<?php
//Including the head (head, session_start, classes, database connection).
include ("modulos/head.php");

//Including the database conenection.
include ("db/db.php");

//Verifying that the id value comes with data.
if(isset($_GET['id'])){
//Saving the id in a variable.
$id = $_GET['id'];
//Deleting the register with the id received.
$sql = "DELETE FROM register WHERE id = $id";

$result = $conn -> query($sql);
//If there's no record with that id, a message is sent.
    if(!$result){
        //Creation of the message of success deleting the tool.
        $_SESSION['message'] = 'Error al eliminar la herramienta!';
        $_SESSION['message_alert'] = "danger";

        //After the tool has been added, the page is redirected to the index.php.
        header('Location: index.php');
    } else {
        //Creation of the message of success deleting the tool.
        $_SESSION['message'] = 'Herramienta eliminada!';
        $_SESSION['message_alert'] = "success";

        //Exiting the connection to the database.
        $conn -> close(); 
        //After the tool has been added, the page is redirected to the index.php.
        header('Location: index.php');
    }
}

//We include the footer (jquery, bootstrap and popper scripts; and the closure of the database connection).
include("modulos/footer.php");
?>