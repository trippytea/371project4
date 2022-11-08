<?php 
include 'db.php'; //connect to database
include 'nav.php'; //nav-bar
if (isset( $_POST['submit'] )) {
    $name = $_POST['name'];
    $result = $db->query("SELECT username FROM users WHERE username = '$name'");
    if ($result == true) {
        $rows = mysqli_fetch_assoc($result); 

        if (!$rows) {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
        
            if ($password == $password_confirm) {
                $password_hash = password_hash($password_confirm, PASSWORD_DEFAULT);
        
                $registerPrep = $db -> prepare("INSERT INTO users(username, password) VALUES (?, ?)");
                $registerPrep -> bind_param("ss", $name, $password_hash);
                $registerPrep -> execute();
                header("location: register.php?newUserSuccess");
                exit();
            }

        else {
            header("location: register.php?errp");
            exit();
          }
        }
        else {
            header("location: register.php?duplicateUser");
            exit();
        }
    }
}
?> <!--php ends-->

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>

	<!--Open Sans Font-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
	
	<!-- Font Awesome icon library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 	<!--<link rel="stylesheet" type="text/css" href="css\bootstrap.css"> if wanted offline-->

	<!-- custom CSS Stylesheet -->	  
    <link rel="stylesheet" type="text/css" href="styles.css";>
</head>

<body>
<img src="images\w-logo.png" class="mx-auto d-flex pt-5 pb-0" width="110px" height="auto" alt="wiki-woo logo">
    <div class="d-flex justify-content-center mx-auto">

    <form method="post" class="registerForm">
        <h1 class="mt-3 mb-3 centerContent ">Register User</h1>
        <?=$promptMessage()?> <!--call prompt message function-->
        <div class="form-outline mb-2">
            <input type="text" name="name" id="name" class="form-control form-control-lg" required/>
            <label class="form-label" for="name">Username</label>
        </div>

        <div class="password-container form-outline mb-2">
            <input type="password" name="password" id="password" class="form-control form-control-lg" required/>
            <i class="fa-solid fa-eye" id="eye"></i>
            <label class="form-label" for="password">Password</label>
        </div>

        <div class="password-container form-outline mb-2">
            <input type="password" name="password_confirm" id="password_confirm" class="form-control form-control-lg" required/>
            <i class="fa-solid fa-eye" id="eye2"></i>
            <label class="form-label" for="password_confirm">Confirm Password</label>
        </div>

            <button class="btn-primary btn-lg btn-block mb-3" type="submit" name='submit' value='Login'>Register</button>
            <br><a href="login.php" style="text-decoration:none;"> Click here to log in</a>
       
        </form>
        
    </div>

    <script> 
        //select password field and password_confirm field
        const passwordField = document.querySelector("#password");
        const password_confirmField = document.querySelector("#password_confirm");
        //select eye icon (regular) and eye2 icon (confirm)
        const eye= document.querySelector("#eye");
        const eye2= document.querySelector("#eye2");

        //event listener to toggle class from 'fa-solid fa-eye'(solid eye) to 'fa-eye-slash'(eye with slash) on click, 
        //and update password 'type' attribute
        eye.addEventListener("click", function() {
        this.classList.toggle("fa-eye-slash");

        //set type constant as text if password, or password if text
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        
        //set 'type' attribute of password_confirm field to type constant assigned above  
        passwordField.setAttribute("type", type);
    })
        //event listener to toggle class from 'fa-solid fa-eye'(solid eye) to 'fa-eye-slash'(eye with slash) on click, 
        //and update password 'type' attribute
        eye2.addEventListener("click", function() {
        this.classList.toggle("fa-eye-slash");

        //set type constant as text if password, or password if text
        const type = password_confirmField.getAttribute("type") === "password" ? "text" : "password";  
        
        //set 'type' attribute of password_confirm field to type constant assigned above          
        password_confirmField.setAttribute("type", type);
    })      
    </script>

	<!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Wiki-Woo!</footer>
</html>
