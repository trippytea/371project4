<?php
$db = new mysqli('localhost', 'INFX371', 'P*ssword', 'wiki');

if($db === false){
  die("ERROR: Could not connect. ". mysqli_connect_error());
}

#if no session, start an empty session
if (!isset($_SESSION)) { session_start(); }


function is_password_correct ($name, $password, $db) {
    $inputName = ($name);
    $result = $db->query("SELECT password FROM users WHERE username = '$inputName'");
    $rows = mysqli_fetch_assoc($result); 
    if ($rows) {
      foreach ($rows as $hash) {
        return password_verify($password, $hash); #returns true
      }

    } else {
      return FALSE;   # user not found
    }
  }

#if $_SESSION['name'] is not set, redirect to login page
function ensure_logged_in() {
    if (!isset($_SESSION["name"])) {
      header("Location: login.php?loginReq");
      exit();
    }
  }

  #message to display if login credentials do not match database, password does not match, or registration is successful
$promptMessage = function() {
  if (isset($_GET['err'])) {
      $message = "Invalid credentials, please try again.";
      echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['errp'])) {
      $message = "Passwords do not match.";
      echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['duplicateUser'])) {
    $message = "User already exists.";
    echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
}
  if (isset($_GET['newUserSuccess'])) {
    $message = "Registered new user successfully!";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
}

  if (isset($_GET['articleAdded'])) {
    $message = "Article added successfully!";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }

  if (isset($_GET['loginReq'])) {
    $message = "You must be logged in.";
    echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }

  if (isset($_GET['articleError'])) {
    $message = "Article added successfully!";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['updateteamsuccess'])) {
    $message = "Article updated successfully!";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  
};