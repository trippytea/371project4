<?php 
include 'db.php';
include 'nav.php';
ensure_logged_in();
?>
<!--php ends-->

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
<body>

<?php
# get profile pic
$name = $_SESSION['user'];
$picresult = $db->query("SELECT profilePic FROM users WHERE username = '$name'");
if ($picresult) {
    $rows = mysqli_fetch_assoc($picresult);
    if ($rows) {
    	$pic = $rows['profilePic'];
    }
}

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

$userresult = $db->query("SELECT postId FROM post WHERE username = '$name'");
$likeTotal = 0;
if ($userresult) {
    $rows = mysqli_fetch_assoc($userresult);
    if ($rows) {
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

?>

<div class="container mt-4 mt-lg-5">
    <div class="row">
		<!--coaching resources-->
		<div class="col-12 col-md-6 col-lg-4 order-1 order-md-1 order-lg-1 mb-2  centerContent">
            <div class="card mt-0 mt-lg-2" style="width: 50rem;">
				<div class="card-body">
					<img style="margin-top:-40px;" src="images\<?=$pic?>" class="" width="110px" height="auto" alt="goblin">
					<p class="" style="color: #1D3461; white-space:nowrap; display:inline-block;"><strong><?=$firstName?> <?=$lastName?></strong><br>
					<strong>Posts: <?=$postTotal?></strong><br>
					<strong>Likes: <?=$likeTotal?></strong>
					</p>
				</div>
        	</div>
        </div> <!--col end-->

	<!--view schedule-->
	<div class="col-12 col-md-6 col-lg-4 order-2 order-md-2 order-lg-2 mb-2 px-4 centerContent">
		<div class="card mt-0 mt-lg-2" style="width: 7rem;">
			<a href="view-schedules.php"><img class="card-img-top" src='images/view-schedule.svg' alt="view schedules"></a>
		<div class="card-body">
			<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>View Schedules</strong></h5>
		</div>
		</div>
	</div> <!--col end-->


	<div class="col-auto order-3 order-md-3 order-lg-3 mb-0 mt-3 mt-lg-4">

	</div>
<!-- row ends -->
</div>
</div> <!--container end-->



<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent" style='width:100%;'>Copyright &copy 2022 The Goblin Den</footer>
</html>