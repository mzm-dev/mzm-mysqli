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

// Check if the user is already logged in, if no then redirect him to login page
if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
  header("location: login.php");
  exit;
}

function delete_form($path, int $val, $msg = 'Are you sure you want to delete this record?')
{
  $form  = "<form action='$path' method='post' onsubmit=\"return confirm('$msg');\">";
  $form  .= "<button class='btn btn-danger' name='value' value='$val' type='submit'>Delete</button>";
  $form  .= "</form>";
  return $form;
}

// Define variables and initialize with empty values
$users = []; // variables valuu array
$users_err = ""; // variables error array empty

// 1. Query SQL statement
$sql = "SELECT * FROM users WHERE status = ?";

// 2. Prepare a select statement
$stmt = $mysqli->prepare($sql);

// 3. Set parameters
$param_status = 1;

// 4. Bind variables to the prepared statement as parameters
$stmt->bind_param("s", $param_status);

// 5. Attempt to execute the prepared statement
if ($stmt->execute()) {

  // 6. Get all result
  $result = $stmt->get_result();

  // 7. Check if username exists, if yes then verify password
  if ($result->num_rows > 0) {

    /* Fetch all result row as an associative array.*/
    $users  = $result->fetch_all(MYSQLI_ASSOC);
  } else {
    // Username doesn't exist, display a generic error message
    $users_err = "Users empty";
  }
} else {
  $users_err = "Oops! Something went wrong. Please try again later!!.";
  //for development purpose
  echo $stmt->error;
}

// Close connection
$mysqli->close();
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
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="mt-5 mb-3 clearfix">
          <h2 class="pull-left">User List</h2>
          <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New User</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (!empty($users_err)) {
          echo '<div class="alert alert-danger text-center">' . $users_err . '</div>';
        }
        ?>
        <table class="table table-bordered">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th></th>
          </tr>

          <?php

          foreach ($users as $user) : ?>
            <tr>
              <td><?= $user['id'] ?></td>
              <td><?= $user['username'] ?></td>
              <td><?= $user['email'] ?></td>
              <td style="width: 130px;">
                <div class="d-flex flex-row">
                  <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a>
                  <?= delete_form('delete.php', $user['id']) ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>

</body>

</html>