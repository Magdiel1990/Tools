<?php
//Including the head and session_start.
include ("modulos/head.php");

//Verifying the login time
require ("loginTimeVerification.php");

//We include the classes file so we can call the methods.
include ("classes/classes.php");

//Including the database connection.
include ("db/db.php");

//Verifying that the id value comes with data.
if(isset($_GET['id'])) {
//Saving the id in a variable.
    $id = $_GET['id'];
//Verifying if there's any register with that id.
    $sql = "SELECT r.quantity, r.tools, c.color , l.location, r.description
            FROM register as r inner join `location` as l on r.id_location = l.id_location
            inner join color as c on c.id_color = r.id_color WHERE id = $id";

    $result = $conn -> query($sql);
//if there's any, I get out the values from the database.
    if($result -> num_rows == 1){
        $row = $result -> fetch_assoc();
        $tool = $row['tools'];
        $quantity = $row['quantity'];
        $location= $row['location'];
        $color = $row['color'];
        $description = $row['description'];        
    }  
}
//if there comes data from the form, They are received.
if(isset($_POST['update'])){
    $id = $_GET['id'];
    $tool = $_POST['tools'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];
    $color = $_POST['color'];
    $description = $_POST['description'];

//Compruebo que no haya valores vacíos donde no se ameritan.
    if($tool != "" && $quantity != "" && $location != "" && $color != "" && $id != "") {

//Sanitation of the data written by the users
        $tool = filter_var(trim($tool), FILTER_SANITIZE_STRING);
        $quantity = filter_var(trim($quantity), FILTER_SANITIZE_NUMBER_INT);
        $description = filter_var(trim($description), FILTER_SANITIZE_STRING);

//Determining the id of the locations.
        $LocationId = new idSelection('id_location', 'location', $location);
        $LocationId = $LocationId->idSelection($conn);

//Determining the id of the colors.
        $colorId = new idSelection('id_color', 'color', $color);
        $colorId = $colorId->idSelection($conn);

//Updating of the registers.
        $sql = "UPDATE register SET quantity = $quantity, tools = '$tool', id_location = $LocationId, id_color = $colorId  , description= '$description' WHERE id = $id";
        $conn -> query($sql);

//After the tool has been updated, the page is redirected to the index.php.
        header("Location: index.php");
    } else {
//Creating the session variables containing the messages when all the fields are not filled.
      $_SESSION['message'] = "Complete todos los campos!";
      $_SESSION['message_alert'] = "danger";

//After the tool has been added, the page is redirected to the update.php.
      header('Location: update.php');
    }
}

//Including the navigation file.
include("modulos/nav.php");

?>
<!--Formulario para actualizar datos.-->
<main class="container p-4 text-center"> 
    <?php
//Message when the tool has been added successfully.
        if(isset($_SESSION['message'])){
            $message = new alertButtons($_SESSION['message_alert'], $_SESSION['message']);
            $message -> buttonMessage();
//Unsetting the message variables so the message fades after refreshing the page.
            unset($_SESSION['message_alert'], $_SESSION['message']);
        }
    ?>
    <h4>Editar registro</h4>     
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card card-body">
                <form action="update.php?id=<?php echo $_GET['id'] ?>" method="POST">
                    <!--Input for updating the tools-->    
                    <div class="form-group">
                      <input type="text" name="tools" minlength="4" maxlength="20" value="<?php echo $tool ?>" required class="form-control" placeholder="Actualiza el nombre">
                    </div>
                    <!--Input for updating the quantity-->
                    <div class="form-group">
                      <input type="number" name="quantity" min="1" max="50" value="<?php echo $quantity ?>" class="form-control" placeholder="Actualiza la cantidad">
                    </div>
                    <!--Location dropdown-->
                    <div class="form-group">
                        <select class="form-control" name="location">
                        <?php
                    //Making an object of the dropdownSelection class for getting the locations from the database.
                        $selectLocation = new dropdownSelection("location", "location","");
                        $selectLocation->selectDropdown($conn);
                        ?>
                        </select>
                    </div>
                    <!--Color dropdown-->
                    <div class="form-group">
                        <select class="form-control" name="color">
                        <?php
                    //Making an object of the dropdownSelection class for getting the colors from the database.
                        $selectColor = new dropdownSelection("color", "color","");
                        $selectColor->selectDropdown($conn);
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" minlength="4" maxlength="40" placeholder="Actualice la descripción"><?php echo $description ?></textarea>
                    </div>
                    <!--Input for updating the description of the tool and button for getting back to index.php-->
                    <div class="form-group btn-group btn-group-md">
                        <input type="submit" name="update" value="Actualizar" class="btn btn-success"> 
                        <a href='index.php' class='btn btn-secondary' title="Volver a inicio"><i class="fa-solid fa-right-from-bracket"></i></a>  
                    </div>
                </form>
            </div>
        </div>
    </div>    
</main>
<?php
//Closing the connection.
$conn -> close();

//We include the footer (jquery, bootstrap and popper scripts).
include("modulos/footer.php")
?>