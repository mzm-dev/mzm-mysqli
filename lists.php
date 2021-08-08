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
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>List</title>

</head>

<body>
  <?php

  // Define variables and initialize with empty values
  $users = []; // variables valuu array
  $users_err = ""; // variables error array empty

  // 1. Query SQL statement
  $sql = "SELECT * FROM users";

  // 2. Prepare a select statement
  $stmt = $mysqli->prepare($sql);

  // 5. Attempt to execute the prepared statement
  if ($stmt->execute()) {

    // 6. Get all result
    $result = $stmt->get_result();

    // 7. Check if username exists, if yes then verify password
    if ($result->num_rows == 1) {

      /* Fetch all result row as an associative array.*/
      $users  = $result->fetch_all(MYSQLI_ASSOC);
    } else {
      // Username doesn't exist, display a generic error message
      $users_err = "Users empty";
    }
  } else {
    echo "Oops! Something went wrong. Please try again later!!.";
    //for development purpose
    echo $stmt->error;
  }

  // Close connection
  $mysqli->close();
  ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="mt-5 mb-3 clearfix">
          <h2 class="pull-left">Employees Details</h2>
          <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">

        <table class="table">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
          </tr>

          <?php

          foreach ($users as $user) : ?>
            <tr>
              <td><?= $user['id'] ?></td>
              <td><?= $user['username'] ?></td>
              <td><?= $user['email'] ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>

</body>

</html>