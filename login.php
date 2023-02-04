<?php
//Including the head and session_start.
include ("modulos/head.php");

//We include the classes file so we can call the methods.
include ("classes/classes.php");

//Including the database connection.
include ("db/db.php");

//The POST infos are verified if they're set 
if(isset($_POST['username']) || isset($_POST['password'])){

//If they are set, are received.    
    $username = $_POST['username'];
    $password = $_POST['password'];

//The username and password are queried   
    $sql = "SELECT * FROM users WHERE username =  '$username' AND password = '$password'";

    $result = $conn -> query($sql);

//If the user doesn't exist, a message is sent.    
    if($result -> num_rows == 0){
        $_SESSION['message'] = "Usuario o contraseña incorrectos!";
        $_SESSION['message_alert'] = "danger";
    } else {
//If the user exists, the session variables are set, and the page is directed to the index.php
        $row = $result -> fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        $_SESSION["status"]  = $row["status"];

        header('Location: index.php');
    }
}
?>
<main class="container p-4 bg-login">
    <?php
    //Message the username or password are wrong.
    if(isset($_SESSION['message'])){
        $message = new alertButtons($_SESSION['message_alert'], $_SESSION['message']);
        $message -> buttonMessage();
    //Unsetting the message variables so the message fades after refreshing the page.             
        unset($_SESSION['message_alert'], $_SESSION['message']);   
    } 
    ?>
    <!--Login form-->
    <div class="p-4 row justify-content-center">
        <div class="col-auto text-center">
            <div class="card card-body">
                <h4 class="my-2">Login</h4>
                <form action="login.php" method="POST">
                <!--Username input-->
                    <div class="form-group my-3">    
                      <label class= "form-label" for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>
                <!--Password input-->   
                    <div class="form-group my-3">
                        <label class= "form-label" for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                 <!--Submit button-->
                    <div class="form-group">
                        <input type="submit" value="Get in" class="btn btn-primary">
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
include("modulos/footer.php");
?>








