<?php
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize the session
    session_start();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to login page
    header("location: login.php");
    exit;
}

header("location: login.php");
exit;
