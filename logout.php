<?php
//We start the session.
    session_start();
//We remove the session.
    session_unset();
//We destroy the session.
    session_destroy();
//We redirect the page to the login.php.   
    header('Location: login.php');
    exit();
?>