<?php
$db = new mysqli('localhost', 'INFX371', 'P*ssword', 'social');

if($db === false){
  die("ERROR: Could not connect. ". mysqli_connect_error());
}

#if no session, start an empty session
if (!isset($_SESSION)) { session_start(); }

function is_password_correct ($email, $password, $db) {
    $inputemail = ($email);
    $result = $db->query("SELECT password FROM users WHERE email = '$inputemail'");
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
    if (!isset($_SESSION["user"])) {
      header("Location: login.php?loginReq");
      exit();
    }
  }

  function calculate_time_span($date){
    date_default_timezone_set("America/Chicago");
    $datetime1 = new DateTime(); // Today's Date/Time
    $datetime2 = new DateTime($date);
    $interval = $datetime1->diff($datetime2);
    $days = $interval->format("%D");
    $hours = $interval->format("%H") - 12;
    $minutes = $interval->format("%I");

    if ($days < 1 && $hours < 1 && $minutes < 1) {
      return "Less than a minute ago.";
    }

    elseif ($days < 1 && $hours < 1 && $minutes == 1) {
      return "1 minute ago.";
    }
    
    elseif ($days < 1 && $hours < 1) {
        return $minutes." minutes ago.";
    }
    elseif ($days <1 && $hours >= 1) {
      return $hours ." hours ".$minutes." minutes ago.";
    }
    else {
      return $days." days ago.";
    }
}


#message to display if login credentials do not match database, password does not match, or registration is successful
$promptMessage = function() {
  if (isset($_GET['err'])) {
      $message = "Invalid credentials, please try again.";
      echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }

  if (isset($_GET['emailError'])) {
    $message = "Emails do not match.";
    echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
}

if (isset($_GET['emailExists'])) {
  $message = "Email already exists.";
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

  if (isset($_GET['loginReq'])) {
    $message = "You must be logged in.";
    echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
};