<?php
//Including the head (head, session_start, classes, database connection).
include ("modulos/head.php");

//Verifying the login time
require ("loginTimeVerification.php");

//Including the database conenection.
include ("db/db.php");

//We include the classes file so we can call the methods.
include ("classes/classes.php");

//We verify if the variables come with data.
if (isset($_POST['tool']) || isset($_POST['quantity']) || isset($_POST['location']) || isset($_POST['color']) || isset($_POST['description'])) {

    $tool = $_POST['tool'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];
    $color = $_POST['color'];
    $description = $_POST['description'];

    //Compruebo que no haya valores vacíos donde no se ameritan.
    if($tool != "" && $quantity != "" && $location != "" && $color != "") {        
    //Sanitation of the data written by the users
        $tool = filter_var(trim($tool), FILTER_SANITIZE_STRING);
        $quantity = filter_var(trim($quantity), FILTER_SANITIZE_NUMBER_INT);
        $description = filter_var(trim($description), FILTER_SANITIZE_STRING); 
    //Putting the tools names in lowercase.
        $tool = strtolower($tool);
    //Determining the id of the colors.
        $colorId = new idSelection('id_color', 'color', $color);
        $colorId = $colorId->idSelection($conn);

    //Determining the id of the locations.
        $locationId = new idSelection('id_location', 'location', $location);
        $locationId = $locationId->idSelection($conn);

    //Determining if the tool has already been added.
        $sql = "SELECT * FROM register WHERE tools = '$tool' AND description = '$description'";
        $rowCount = mysqli_num_rows($conn->query($sql));

    //If it's new, it can be added.
        if ($rowCount == 0) {
            $sql = "INSERT INTO register (quantity, `description`, tools, id_color, id_location)
            VALUES ($quantity, '$description', '$tool', $colorId, $locationId)";

            $result = $conn->query($sql);
    //If there's any error adding the tool, this message is seen.
            if(!$result){
    //Creating the session variable containing the messages when the tool is added.
            $_SESSION['message'] = "Error al agregar herramienta!";
            $_SESSION['message_alert'] = "danger";

    //After the tool has been added, the page is redirected to the add-tools.php.
            header('Location: add-tools.php');
            } else {
                    //Creating the session variable containing the messages when the tool is added.
            $_SESSION['message'] = "Herramienta agregada!";
            $_SESSION['message_alert'] = "success";

    //After the tool has been added, the page is redirected to the add-tools.php.
            header('Location: add-tools.php');
            }
        } else {
    //Creating the session variable containing the messages when the tool is added.
        $_SESSION['message'] = "Ya ha sido agregada!";
        $_SESSION['message_alert'] = "danger";

    //After the tool has been added, the page is redirected to the add-tools.php.
        header('Location: add-tools.php');
        }
    } else {
        //Creating the session variable containing the messages when the tool is added.
        $_SESSION['message'] = "Complete todos los campos!";
        $_SESSION['message_alert'] = "danger";

        //After the tool has been added, the page is redirected to the add-tools.php.
        header('Location: add-tools.php');
    }
} 

//Closing the connection.
$conn -> close();

//We include the footer (jquery, bootstrap and popper scripts; and the closure of the database connection).        
include("modulos/footer.php");
?>
