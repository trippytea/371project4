<header>    
<script src="https://kit.fontawesome.com/8b7ae18a46.js" crossorigin="anonymous"></script>
	<!--navigation bar start-->
    <nav class="navbar navbar-expand-lg navbar-dark bg dark">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand"><img src="images\Goblin_logo_white.svg" width="auto" height="30px"></a>

            <!--navbar toggle icon-->
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Collapsable Menu-->
            <div class="collapse navbar-collapse " id="navbarCollapse">
                <div class="navbar-nav">
                <ul class="navbar-nav">
                  
                    
                </div>
                <div class="navbar-nav ms-auto">    
                    <?php 
                    if (!isset($_SESSION["user"])) {
                        ?>
                        <a href="register.php" class="nav-item nav-link">Register</a>  
                        <a href="login.php" class="nav-item nav-link">Log In</a>
                        <?php
                    } else if (isset($_SESSION["user"])) {
                    
                        ?>
                        <a href="index.php" class="nav-item nav-link"><i class="fa-sharp fa-solid fa-house" style="color:#e9f6f1;padding:5px;"></i></a>
                        <a href="index.php" class="nav-item nav-link"><i class="fa-solid fa-envelope" style="color:#e9f6f1;padding:5px;"></i></a>
                        <a href="index.php" class="nav-item nav-link"><i class="fa-solid fa-bell" style="color:#e9f6f1;padding:5px;"></i></a>
                        <a href="index.php" class="nav-item nav-link"><i class="fa-solid fa-user" style="color:#e9f6f1;padding:5px;"></i></a>
                        <a href="index.php" class="nav-item nav-link"><i class="fa-solid fa-gear" style="color:#e9f6f1;padding:5px;"></i></a>
                        <a href="index.php" class="nav-item nav-link"><i class="fa-solid fa-user-group" style="color:#e9f6f1;padding:5px;"></i></a>
                        <a href="logout.php" class="nav-item nav-link"><i class="fa-solid fa-square-up-right" style="color:#e9f6f1;padding:5px;"></i></a>
                        <a href="index.php" class="nav-item nav-link user"><?=$_SESSION["user"]?></a>
                        <?php
                    }
                    ?>        	
                </div>
            </div>
        </div>
    </nav>
    <!--navigation bar end-->
</header>
