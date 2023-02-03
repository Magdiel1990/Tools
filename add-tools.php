<?php
//Including the head (head, session_start, classes, database connection).
include ("modulos/head.php");

//Verifying the login time
require ("loginTimeVerification.php");

//Including the navigation file.
include ("modulos/nav.php");

//We include the classes file so we can call the methods.
include ("classes/classes.php");

//Including the database conenection.
include ("db/db.php");
?>
<main class="container p-4 text-center">
    <?php
    //Message when the tool has been added successfully.
        if(isset($_SESSION['message'])){
            $successAlert = new alertButtons($_SESSION['message_alert'], $_SESSION['message']);
            $successAlert -> buttonMessage();
    //Unsetting the message variables so the message fades after refreshing the page.
            unset($_SESSION['message_alert'], $_SESSION['message']);
        }
    ?>
    <h4>Ingreso de Datos</h4>

    <div class="row justify-content-center">      

        <div class="col-auto">
           
            <div class="card card-body">
            <!--Form for receiving the tools data that'll be added-->
                <form name="toolRegister" action="create.php" method="POST" onsubmit ="return validateForm()">
                <!--Input for receiving the tools-->
                    <div class="form-group form-floating">                
                        <input name= "tool" id="tool" type="text" class="form-control" minlength="4" maxlength="20" required autofocus>
                        <label for="tool" class="form-label">Herramienta:</label>
                    </div>
                <!--Input for receiving the quantity-->
                    <div class="form-group form-floating">
                        <input name= "quantity" id="quantity" type="number" min="1" max="50"  class="form-control" required>
                        <label for="quantity" class="form-label">Cantidad:</label>
                    </div>
                    
                <!--Location dropdown-->
                    <div class="form-group form-floating">
                        <select name="location" class="form-select" id="location" required>
                            <option selected></option>                
                    <?php
                //Making an object of the dropdownSelection class for getting the locations from the database.
                        $selectLocation = new dropdownSelection("location","id_location"," ");
                        $selectLocation-> selectDropdown($conn);                        
                    ?>
                        </select>
                        <label for="location" class="form-label">Ubicación:</label>
                    </div>

                <!--Color dropdown-->
                    <div class="form-group form-floating">
                        <select name="color" id="color" class="form-select" required>
                            <option selected></option>                
                    <?php
                //Making an object of the dropdownSelection class for getting the colors from the database.
                        $selectColor  = new dropdownSelection("color","id_color"," ");
                        $selectColor -> selectDropdown($conn);                        
                    ?>
                        </select>
                        <label for="color" class="form-label">Color:</label>
                    </div>
                <!--Input for receiving the description of the tool-->
                    <div class="form-group mb-3">  
                        <label for="description" class="form-label text-secondary">Descripción:</label>
                        <textarea id="description" name="description" class="form-control" minlength="4" maxlength="30"></textarea>
                    </div>
                <!--Button for adding the tool to the database-->
                    <div class="form-group btn-group btn-group-md">
                        <input type="submit" value="Registrar" class="btn btn-primary">
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
//We include the footer (jquery, bootstrap and popper scripts; and the closure of the database connection).        
include("modulos/footer.php");
?>