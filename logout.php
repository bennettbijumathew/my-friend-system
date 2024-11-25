<?php
    // Starts the session. 
    session_start(); 

    // Unsets all of the session variables.
    session_unset(); 

    // Destroys all of the data associated with the session.
    session_destroy();

    // Redirects user to index.php
    header("location:index.php");
?>