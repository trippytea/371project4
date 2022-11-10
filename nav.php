<header>    
	<!--navigation bar start-->
    <nav class="navbar navbar-expand-lg navbar-dark bg dark">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand"><img src="images\w-logonav.png" width="auto" height="30px"></a>

            <!--navbar toggle icon-->
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Collapsable Menu-->
            <div class="collapse navbar-collapse " id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="addarticle.php" class="nav-item nav-link">Add Article</a>
                    <!--<a href="updateArticle.php" class="nav-item nav-link">Update Article</a> -->
                    <a href="register.php" class="nav-item nav-link">Sign up</a>
                     

                </div>
                <div class="navbar-nav ms-auto">
                <?php 
                if (!isset($_SESSION["name"])) {
                    ?>
                    <a href="login.php" class="nav-item nav-link">Log In</a>
                    <?php
                } else {
                    
                    ?>
                    <a href="index.php" class="nav-item nav-link"><?=$_SESSION["name"];?></a>
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