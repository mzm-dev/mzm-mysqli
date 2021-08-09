<?php

// Include config file
require_once "config.php";

// Check if the user is already logged in, if no then redirect him to login page
if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("location: login.php");
    exit;
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    if (
        isset($_POST["value"]) && !empty($_POST["value"]) //semak jika value wujud
        && filter_var($_POST["value"], FILTER_VALIDATE_INT) //semak jika value adalah integer 
        && $_POST["value"] != $_SESSION["id"] //semak jika value bukan id session user
    ) {

        // 1. Query SQL statement
        $sql = "DELETE FROM users WHERE id = ?";

        // 2. Prepare a select statement
        $stmt = $mysqli->prepare($sql);

        // 3. Set parameters        
        $param_id = $_POST["value"];      

        // 4. Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);

        // 5. Attempt to execute the prepared statement
        if ($stmt->execute()) {

            header("location: lists.php");
            exit;
        } else {
            //for development purpose
            echo $stmt->error;
            die;
        }

        // Close statement
        $stmt->close();

        // Close connection
        $mysqli->close();
    }

    header("location: lists.php");
    exit;
}

header("location: welcome.php");
exit;
