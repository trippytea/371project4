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
if (isset ($_GET['postId'])) {
	$getpostId = $_GET['postId'];
	$userCheck = $_SESSION['user'];
	$likeCheckResult = $db->query("SELECT * FROM postlike WHERE postId = '$getpostId' and likedBy = '$userCheck'");
	if ($likeCheckResult) {
		if ($rows = mysqli_fetch_assoc($likeCheckResult)) {
			$unlikeResult = $db->query("DELETE FROM postlike WHERE postId = '$getpostId' and likedBy = '$userCheck'");
		} else {
			$postLikeStmnt = $db->prepare("INSERT INTO postlike(postId, likedBy) VALUES (?,?)");
			$postLikeStmnt->bind_param("ss", $getpostId, $_SESSION['user']);
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
$likeCountUser = $name;
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

#insert comment
if (isset ($_POST['commentBtn'])) {
	$comment = $_POST['comment'];
	$postId = $_POST['postId'];
	echo "<pre>".$comment."</pre>";
	echo "<pre>".$postId."</pre>";
	#date_default_timezone_set("America/Chicago");
	#$date = date('Y/m/d h:i:s');
	$commentStmnt = $db->prepare("INSERT INTO comment(commentContent, postId, username) VALUES (?,?,?)");
	$commentStmnt->bind_param("sss",$comment,$postId,$_SESSION['user']);
	$commentStmnt->execute();
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
            <div class="card mt-0 mt-lg-2 userBox" style="width: 21rem; height: 9.85rem;">
			<a href='user-home.php?name=<?=$name?>' style='text-decoration:none;'>
			<div class="card-body mt-3 centerContent">
				<span>
				<img class='profileCard me-2' src="images\<?=$pic?>" height="112px" width="112px" alt="goblin" style="margin-top: 2px;">
				<div style="float:right;"> 
						<p style="color: #e9f6f1; letter-spacing:.75px; white-space:nowrap; display:inline-block;">
							<strong><?=$firstName." ".$lastName?></strong><br>
							<strong><?=$name?></strong><br>
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
						<button class="btn-primary btn-lg btn-block mt-2 " type="submit" name='submit'>Post</button>
					</form>
			</div>
			<div class="col-12 col-md-6 col-lg-8 order-2 order-md-2 order-lg-2 text-center text-lg-start" style="width:800px;"> <!--post styling-->
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
											<!--each individual post-->
											<div class='mb-3' style="width:100%;"> 
												<?php
												echo "
												<div class='p-2 w-75'>
												<div><img class='profileCard mx-3' src='images/".$postpic."
												'height=auto; width=50px; alt='goblin' style='margin-top:10px; float:left;'></div>
												<div class='mt-2' style='overflow:hidden';>
												Posted by <a href='user-home.php?name=$postUsername' style='text-decoration:none;'>".$postUsername."
												</a> ".calculate_time_span($postDate)."<br>
												$postContent<br>"?>

												<?php
												# get like count for the post
														$sql = "SELECT count(likeId) as total FROM postlike WHERE postId = '$postId'";
														$likePostResult = mysqli_query($db, $sql);
														if ($likePostResult) {
    														$likePostRow = mysqli_fetch_assoc($likePostResult);
    														if ($likePostRow) {
    															$likePostCount = $likePostRow['total'];
																echo "<a href='index.php?postId=$postId'><button type='button' class='btn btn-sm btn-success'>
																Like ($likePostCount)</button></a>";

   															}
    													}
														$sql = "SELECT count(commentId) as total FROM comment WHERE postId = '$postId'";
														$commentCountResult = mysqli_query($db, $sql);
														if ($commentCountResult) {
    														$commentCountRow = mysqli_fetch_assoc($commentCountResult);
    														if ($commentCountRow) {
    															$commentCount = $commentCountRow['total'];
   															}
    													}
    										#comment form
												echo "
												<form method='post' action='index.php' class='d-inline'>
												<button class='btn btn-sm btn-success' name='commentBtn' id='commentBtn' 
													value='submit'>Comment ($commentCount)</button>
												<input type='text' name='comment' id='comment' maxlength='60' style='width:250px;' 
													placeholder=' Add a comment'></input>
												<input type='hidden' value='$postId' name='postId' id='postId'></input>
												</form>	
												</div>
											</div>
											";
										#comment logic
										$commentsql = "SELECT * FROM comment WHERE postId = '$postId'";
										$commentResult = mysqli_query($db, $commentsql);
										if ($commentResult) {
											$commentRow = mysqli_fetch_all($commentResult);
												for ($i=0; $i < count($commentRow); $i++) {
												$comment = $commentRow[$i][1];
												$commentUser = $commentRow[$i][3];

												$commentPicSql = "SELECT profilePic FROM users WHERE username = '$commentUser'";
												$commentPicResult = mysqli_query($db, $commentPicSql);
												$commentPicRow = mysqli_fetch_assoc($commentPicResult);
												if ($commentPicRow) {
													$commentPic = $commentPicRow['profilePic'];
												echo "<div style='margin-left:120px; margin-top:1%;'><img src='images/$commentPic' width='25px' class='me-1'>
													<a href='user-home.php?name=$commentUser' style='text-decoration:none;'>".$commentUser."</a>
													  <div style='margin-left:36px;'>$comment</div></div>";
												}
										}					
										}
										echo "</div>"; 
										#end individual posts
									}
									}
									}
								}
							}
						}
    				
					?>				
				</span>
			</div>
		</div>
		<br>
	</div> <!--col end-->
	</div> 	<!-- row ends -->
</div> <!--container end-->

<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent" style='width:100%;'>Copyright &copy 2022 The Goblin Den</footer>
</html>