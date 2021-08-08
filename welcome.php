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
if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
  header("location: login.php");
  exit;
}

function logout_form($path, $msg = 'Are you sure you want to log out?')
{
    $form  = "<form action='$path' method='post' onsubmit=\"return confirm('$msg');\">";
    $form  .= "<button class='dropdown-item' type='submit'>Logout</button>";
    $form  .= "</form>";
    return $form;
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

</head>

<body>
  <div class="vh-100 d-flex flex-column justify-content-start align-items-center m-3">
    <div class="container">
      <div class="card">
        <div class="card-body">
          <h1>welcome <i><?= $_SESSION['username']; ?></i></h1>
          <ul class="list-unstyled w-25">
            <h6 class="dropdown-header">User</h6>
            <li><a class="dropdown-item" href="lists.php">Users List</a></li>
            <li><a class="dropdown-item" href="create.php">New User</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href=""><s>Profile</s></a></li>
            <li><?= logout_form('logout.php'); ?></li>
          </ul><!-- ul.list-unstyled -->
        </div><!-- card-body -->
      </div><!-- body -->
    </div><!-- col-md-4 -->
  </div><!-- div -->
  
  
</body>

</html>