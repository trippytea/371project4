<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>

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

<?php 
include 'db.php';
include 'nav.php';
ensure_logged_in();

#insert like submission
$name = $_SESSION['user'];
if (isset ($_GET['postId'])) {
	$getpostId = $_GET['postId'];
	$likeCheckResult = $db->query("SELECT * FROM postlike WHERE postId = '$getpostId'");
	if ($likeCheckResult) {
		$rows = mysqli_fetch_assoc($likeCheckResult);
		if ($rows) {
			$likedBy = $rows['likedBy'];
			if ($name == $likedBy) {
				$message = "You have already liked this post.";
				echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
			}
		} else {
			$postLikeStmnt = $db->prepare("INSERT INTO postlike(postId, likedBy) VALUES (?,?)");
			$postLikeStmnt->bind_param("ss", $getpostId, $name);
			$postLikeStmnt->execute();
		}
	} 
}

# get profile pic
$name = $_SESSION['user'];
$picresult = $db->query("SELECT profilePic FROM users WHERE username = '$name'");
if ($picresult) {
    $rows = mysqli_fetch_assoc($picresult);
    if ($rows) {
    	$pic = $rows['profilePic'];
    }
}

# get first and last name
$nameresult = $db->query("SELECT * FROM users WHERE username = '$name'");
if ($nameresult) {
    $rows = mysqli_fetch_assoc($nameresult);
    if ($rows) {
    	$lastName = $rows['lName'];
		$firstName = $rows['fName'];
    }
}
	
# get post count
$postresult = $db->query("SELECT count(postId) as total FROM post WHERE username = '$name'");
if ($postresult) {
    $rows = mysqli_fetch_assoc($postresult);
    if ($rows) {
    	$postTotal = $rows['total'];
    }
}

# get like count
$likeCountUser = $_SESSION['user'];
$userresult = $db->query("SELECT postId FROM post WHERE username = '$likeCountUser'");
$likeTotal = 0;
if ($userresult) {
    while ($rows = mysqli_fetch_assoc($userresult)) {
		$postId = $rows['postId'];
		$likeresult = $db->query("SELECT count(likeId) as total FROM postlike WHERE postId = '$postId'");
		if ($likeresult) {
    		$row = mysqli_fetch_assoc($likeresult);
    		if ($row) {
    			$likePostTotal = $row['total'];
				$likeTotal = $likeTotal + $likePostTotal;
   			}
    	}
    }
}

#insert post from submission
if (isset ($_POST['submit'])) {
	$newPost = $_POST['newPost'];
	date_default_timezone_set("America/Chicago");
	$date = date('Y/m/d h:i:s');
	$postStmnt = $db->prepare("INSERT INTO post(postContent, username, date) VALUES (?,?,?)");
	$postStmnt->bind_param("sss",$newPost,$_SESSION['user'],$date);
	$postStmnt->execute();
	header("location: index.php");
	exit();
}

?>
<!--php ends-->
<body>
<div class="container mt-4 mt-lg-5">
    <div class="row">
		<!--user profile section-->
		<div class="col-12 col-md-6 col-lg-4 order-1 order-md-1 order-lg-1 mb-2  centerContent">
            <div class="card mt-0 mt-lg-2 userBox" style="width: 18rem; height: 9.85rem;">
			<a href='user-home.php?name=<?=$name?>' style='text-decoration:none;'>
				<div class="card-body mt-3 ">
				<span>
					<img class='profileCard' src="images\<?=$pic?>" class="" height="auto" width="112px"  alt="goblin" style="margin-top:-6px;">
					<div style="float:right;"> 
						<p class="mt-2 ml-2" style="color: #e9f6f1; letter-spacing:.75px; margin-left:auto; white-space:nowrap; display:inline-block;">

							<strong><?=$_SESSION['user']?></strong><br>
							<strong>Posts: <?=$postTotal?></strong><br>
							<strong>Likes: <?=$likeTotal?></strong>
						</p>
					</div>
					</span>
				</div>
			</a>
        	</div>
        </div> <!--col end-->

	<!--user and friend post section-->
	<div class="col-12 col-md-6 col-lg-8 order-2 order-md-2 order-lg-2">
		<div>
		<div class="card-body">
		<h2>Create Post </h2>
					<form method='post' action="index.php" class='text-end'> 
						<input type="text" name='newPost' id='newPost' class="card-body w-100"  placeholder="Got something to say?">	
						<button class="btn-primary btn-lg btn-block mb-3 mt-2 " type="submit" name='submit'>Post</button>
					</form>
			</div>
			<div class="card-body postBox p-4" style="width:800px;"> <!--post styling-->
				<span>
					<?php
					$postresult = $db->query("SELECT * FROM post ORDER BY postId DESC");
					if($postresult) {
						while($postrows=mysqli_fetch_array($postresult)){
							$postId = $postrows['postId'];
							$postContent = $postrows['postContent'];
							$postUsername = $postrows['username'];
							$postDate = $postrows['date'];

							$friendResult = $db->query("SELECT * FROM friends WHERE friends.friendUsername='$postUsername' and friends.username='$name'");
							if ($friendResult) {
								$rows = mysqli_fetch_assoc($friendResult);
								if ($rows) {
									$postpicresult = $db->query("SELECT profilePic FROM users WHERE username = '$postUsername'");
									if ($postpicresult) {
										$rows = mysqli_fetch_assoc($postpicresult);
										if ($rows) {
											$postpic = $rows['profilePic'];
											?>
											<div style="width:100%;"> 
											<img class='profileCard' src="images\<?=$postpic?>" class="" width="112px" height="auto" alt="goblin" style="margin-top: -9.6rem;">
											<p class="mt-2 ml-2" style="color: #254441; letter-spacing:.75px; margin-left:auto; white-space:nowrap; display:inline-block;">
												<!-- style me plzzzz -->
												<strong><a href='user-home.php?name=<?=$postUsername?>' style='text-decoration:none;'><?=$postUsername?></a></strong><br>
												<strong><?=$postContent?></strong><br>
												<strong><?=calculate_time_span($postDate)?></strong><br>
												<a href="index.php?postId=<?php echo $postId;?>"> <button type="button" class= "btn btn-sm btn-success ">Like</button></a>
												<br><br>
											</p>
											</div>
										<?php
										}	

									}
								}
							}
						}
    				}?>					
				</span>
			</div>
		</div>
	</div> <!--col end-->
	</div> 	<!-- row ends -->
</div> <!--container end-->

<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent" style='width:100%;'>Copyright &copy 2022 The Goblin Den</footer>
</html>