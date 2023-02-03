<?php
//Including the head and session_start.
include ("modulos/head.php");

//We include the classes file so we can call the methods.
include ("classes/classes.php");

//Verifying the login time
require ("loginTimeVerification.php");

//Including the navigation file.
include("modulos/nav.php");
?>
<main class="container p-4 bg-login">
    <?php
    //Message when the tool has been added successfully.
            if(isset($_SESSION['message'])){
                $message = new alertButtons($_SESSION['message_alert'], $_SESSION['message']);
                $message -> buttonMessage();
    //Unsetting the message variables so the message fades after refreshing the page.             
                unset($_SESSION['message_alert'], $_SESSION['message']);   
            }
    ?>
    <!--item reset form -->
    <div class="p-4 row justify-content-center">
        <div class="col-auto text-center">
       
            <div class="card card-body bg-dark">
                <h4 class="my-2 text-success">Reset</h4>
                <form action="delProcess.php" method="POST">
    <!--Username input -->
                    <div class="form-group my-3">
                        <label class= "form-label text-light" for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" required autocomplete="off">
                    </div>
    <!--Password input -->
                    <div class="form-group my-3">
                        <label class= "form-label text-light" for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required autocomplete="off">
                    </div>
                    <p class="text-light">Aceptar</p>
    <!--confirmation inputs -->
                    <div class="form-check  form-check-inline">
                        <input type="radio" class="form-check-input" id="yes" name="validation" required value="1">
                        <label for="yes" class="form-check-label text-light">Sí</label>
                    </div>
                    <div class="form-check  form-check-inline">
                        <input type="radio" class="form-check-input" checked id="no" name="validation" value="0">
                        <label for="no" class="form-check-label text-light">No</label>
                    </div>
    <!--Submit button-->
                    <div class="form-group">
                        <input onclick="return confirm('¿Estás seguro que deseas eliminar todas las herramientas?')" type="submit" value="Reset" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php
//We include the footer (jquery, bootstrap and popper scripts).
include("modulos/footer.php");
?>