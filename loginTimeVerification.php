<?php
    //If the session is not started, it's redirected to the login page.
if ($_SESSION['username'] == "" && $_SESSION['password'] == ""){
    header('Location: login.php');
} else {
    //If the session is started, we verify if the variable 'time' is defined.
    if(isset($_SESSION['time']) ) {

    //Time in second for the session life.
        $inactive = 600;

    //We calculate the time of inactivity.
        $session_life = time() - $_SESSION['time'];

    // We compare.
            if($session_life > $inactive)
            {
    //We remove the session.
                session_unset();
    //We destroy the session.
                session_destroy();
    //We redirect the page.
                header("Location: login.php");
                exit();
            } else {  
    // If it's not close, we update.
                $_SESSION['time'] = time();
            }
    } else {
    //We activate the session time.
        $_SESSION['time'] = time();
    }
}
?>