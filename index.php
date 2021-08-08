<?php
/*
* Example MySQLi for Object oriented style
* PHP MySQL API
* PHP 5, PHP 7, PHP 8
* 
* @category   CategoryName
* @package    PackageName
* @author     Mohamad Zaki Mustafa <mzm@ns.gov.my>
*/

// Include config file
require_once "config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
    header("location: welcome.php");
    exit;
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>MySQLi OO Style</title>
    <style>
        body,
        html {
            height: 100%;
        }
    </style>
</head>

<body>

    <div class="vh-100 d-flex flex-column justify-content-center align-items-center">
        <h1>MySQLi OO Style</h1>
        <div>
            <a class="btn btn-primary btn-lg" href="login.php">Login</a>
        </div><!-- div -->
    </div><!-- div -->

</body>

</html>