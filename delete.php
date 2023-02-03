<?php
//Including the head and session_start.
include ("modulos/head.php");

//Including the database connection.
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
//Creation of the message of error deleting the tool.
        $_SESSION['message'] = 'Error al eliminar la herramienta!';
        $_SESSION['message_alert'] = "danger";

//The page is redirected to the index.php.
        header('Location: index.php');
    } else {
//Creation of the message of success deleting the tool.
        $_SESSION['message'] = 'Herramienta eliminada!';
        $_SESSION['message_alert'] = "success";

//After the tool has been deleted, the page is redirected to the index.php.
        header('Location: index.php');
    }
}
//Exiting the connection to the database.
$conn -> close(); 
//We include the footer (jquery, bootstrap and popper scripts).
include("modulos/footer.php");
?>