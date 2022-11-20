<?php 
include 'db.php'; //connect to database
include 'nav.php'; //nav-bar
if (isset( $_POST['submit'] )) {
    $email = trim($_POST['email']);
    $confirmEmail = trim($_POST['confirmEmail']);
    $firstName = trim($_POST['fname']);
    $lastName = trim($_POST['lname']);
    $username = trim($_POST['user']);    

    if ($email != $confirmEmail) {
        header("location: register.php?emailError");
        exit();
    }

    $emailresult = $db->query("SELECT email FROM users WHERE email = '$email'");
    if ($emailresult) {
        $rows = mysqli_fetch_assoc($emailresult);
        if ($rows) {
        header("location: register.php?emailExists");
        exit();
    }
    }

    $result = $db->query("SELECT username FROM users WHERE username = '$username'");
    if ($result) {
        $rows = mysqli_fetch_assoc($result); 
        if (!$rows) {
            
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if ($password == $password_confirm) {

                $goblinPics = array("goblin1.png", "goblin2.png", "goblin3.png", "goblin4.png", "goblin5.png");
                $randomIndex = rand(0, 4);
                $goblin = $goblinPics[$randomIndex];
                
                $password_hash = password_hash($password_confirm, PASSWORD_DEFAULT);
                $registerPrep = $db -> prepare("INSERT INTO users(username, fName, lName, email, password, profilePic) VALUES (?, ?, ?, ?, ?, ?)");
                $registerPrep -> bind_param("ssssss", $username, $firstName, $lastName, $email, $password_hash, $goblin);
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

<body class='reg'>
<img src="images\cave_logo.png" class="mx-auto d-flex pt-5" width="110px" height="auto" alt="logo">

    <div class="d-flex justify-content-center mx-auto mb-4">
    <form method="post" class="registerForm">
        <h1 class="mb-3 centerContent ">Register Goblin</h1>
        <?=$promptMessage()?> <!--call prompt message function-->
        <div class="form-outline mb-2">
            <label class="form-label" for="user">Username</label>
            <input type="text" name="user" id="user" class="form-control form-control-lg" minlength='2' maxlength='50' required/>
        </div>
        <div class="form-outline mb-2">
            <label class="form-label" for="fname">First Name</label>
            <input type="text" name="fname" id="fname" class="form-control form-control-lg" minlength='2' maxlength='50' required/>
        </div>
        <div class="form-outline mb-2">
            <label class="form-label" for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" class="form-control form-control-lg" minlength='2' maxlength='50' required/>
        </div>
        <div class="form-outline mb-2">
            <label class="form-label" for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control form-control-lg" minlength='2' maxlength='50' required/>
        </div>

        <div class="form-outline mb-2">
            <label class="form-label" for="email">Confirm Email</label>
            <input type="text" name="confirmEmail" id="confirmEmail" class="form-control form-control-lg" minlength='2' maxlength='50' required/>
        </div>

        <div class="password-container form-outline mb-2">
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control form-control-lg" required/>
            <i class="fa-solid fa-eye" id="eye"></i>
        </div>

        <div class="password-container form-outline mb-2">
            <label class="form-label" for="password_confirm">Confirm Password</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control form-control-lg" required/>
            <i class="fa-solid fa-eye" id="eye2"></i>
        </div>

            <button class="btn-primary btn-lg btn-block mb-3 mt-2" type="submit" name='submit' value='Login'>Register</button>
            <br>Have an account?<a href="login.php" style="text-decoration:none;"> Click here to log in</a>
       
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
<footer class="centerContent">Copyright &copy 2022 The Goblin Den</footer>
</html>