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

// Define variables and initialize with empty values
$username = $password = ""; // variables value input
$username_err = $password_err = $login_err = ""; // variables error input

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  /*START VALIDATION*/

  // Check if username is empty
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
  } else if (!filter_input(INPUT_POST, 'username', FILTER_VALIDATE_EMAIL)) {
    $username_err = "Email address not valid";
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

  <title>MySQLi OO Style</title>
</head>

<body>
  <div class="vh-100 d-flex flex-column justify-content-center align-items-center">
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">

          <?php echo !empty($login_err) ? '<div class="alert alert-danger text-center">' . $login_err . '</div>' : ''; ?>

          <h1 class="text-center">Log In</h1>
          <p class="text-center text-muted">MySQLi OO Style</p>

          <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="login" novalidate autocomplete="off">

            <div class="form-group">
              <label for="exampleInputEmail1">E-mail</label>
              <input type="email" name="username" class="form-control <?= $username_err ? 'is-invalid' : '' ?>" value="<?= $username ? $username : '' ?>">
              <?= $username_err ? '<small class="form-text invalid-feedback">' . $username_err . '</small>' : '' ?>
            </div><!-- form-group -->

            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control <?= $password_err ? 'is-invalid' : '' ?>">
              <?= $password_err ? '<small class="form-text invalid-feedback">' . $password_err . '</small>' : '' ?>
            </div><!-- form-group -->

            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <a href="register.php" class="btn btn-link btn-block mt-2">Register</a>
          </form><!-- form -->

        </div><!-- card-body -->

        <a href="https://github.com/mzm-dev/mzm-mysqli" target="_blank">
          <div class="d-flex flex-column align-items-center m-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
            </svg>
          </div>
        </a>
      </div><!-- card -->
    </div><!-- col-md-4 -->
  </div><!-- div -->


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