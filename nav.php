<header>    
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
                    <a href="index.php" class="nav-item nav-link">Home</a>
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
                        <a href="index.php" class="nav-item nav-link"><?=$_SESSION["user"]?></a>
                        <a href="logout.php" class="nav-item nav-link">Log Out</a>
                        <?php
                    }
                    ?>        	
                </div>
            </div>
        </div>
    </nav>
    <!--navigation bar end-->
</header>
