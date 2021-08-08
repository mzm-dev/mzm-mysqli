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

// Define variables and initialize with empty values
$username = $password = ""; // variables value input
$username_err = $password_err = $login_err = ""; // variables error input

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  /*START VALIDATION*/

  // Check if username is empty
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
  } else {
    $username = trim($_POST["username"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  /*END VALIDATION*/

  // Validate credentials, jika semua error variables empty 
  if (empty($username_err) && empty($password_err)) {

    // 1. Query SQL statement
    $sql = "SELECT id, username, password FROM users WHERE email = ?";

    // 2. Prepare a select statement
    $stmt = $mysqli->prepare($sql);

    // 3. Set parameters
    $param_username = $username;

    // 4. Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_username);

    // 5. Attempt to execute the prepared statement
    if ($stmt->execute()) {

      // 6. Get all result
      $result = $stmt->get_result();

      // 7. Check if username exists, if yes then verify password
      if ($result->num_rows == 1) {

        /* Fetch result row as an associative array.  
      Disebabkan set result hanya ingin gunakan 1 row data sahaja,
      while looping tidak diperlukan */
        $row = $result->fetch_array(MYSQLI_ASSOC);

        //password verify
        if (password_verify($password, $row['password'])) {

          // Store data in session variables
          $_SESSION["loggedin"] = true;
          $_SESSION["id"] = $row['id'];
          $_SESSION["username"] =  $row['username'];
          $_SESSION["email"] =  $row['email'];

          // Redirect user to welcome page
          header("location: welcome.php");
          exit();
        } else {
          // Password is not valid, display a generic error message
          $login_err = "Invalid username or password.";
        }
      } else {
        // Username doesn't exist, display a generic error message
        $login_err = "Invalid username or password.";
      }
    } else {
      echo "Oops! Something went wrong. Please try again later!!.";
      //for development purpose
      echo $stmt->error;
    }

    // Close statement
    $stmt->close();
  }
  // Close connection
  $mysqli->close();
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

  <title>Login</title>
</head>

<body>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-3 offset-md-4">
        <h1 class="text-center">Log In</h1>
        <?php
        if (!empty($login_err)) {
          echo '<div class="alert alert-danger text-center">' . $login_err . '</div>';
        }
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="login" novalidate>
          <div class="form-group">
            <label for="exampleInputEmail1">E-mail</label>
            <input type="email" name="username" class="form-control <?= $username_err ? 'is-invalid' : '' ?>" value="<?= $username ? $username : '' ?>">
            <?= $username_err ? '<small class="form-text invalid-feedback">' . $username_err . '</small>' : '' ?>

          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control <?= $password_err ? 'is-invalid' : '' ?>">
            <?= $password_err ? '<small class="form-text invalid-feedback">' . $password_err . '</small>' : '' ?>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Submit</button>
          <a href="register.php" class="btn btn-link btn-block">Register</a>
        </form>
      </div>
    </div>
  </div>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>