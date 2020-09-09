<?php
	include 'core/init.php'; 
	$user_id = $_SESSION['user_id'];
	$user = $userObj->userData($user_id);
	$verifyObj->authOnly();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
<div class="home-wrapper">
	<div class="home-header-wrapper">
		<img src="assets/img/nature.jpg"/>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

	</div>
	<div class="home-content-wrapper">
	<div class="home-inner-content">
		<div class="home-left-content">
		<div class="home-left-inner">
			
			<div class="profile-box">
			<div class="profile-box-inner">
				
				<div class="profile-header">
					<div class="profile-img">
						<img src="assets/img/avatar.png"/>
					</div>
					<div class="profile-name">
						<a href="#"><?php echo $user->firstName.' '.$user->lastName;?></a>
					</div>
				</div><!--profile-header ends-->

				<div class="profile-content">
					<div class="profile-date-l">
						<?php $date = $user->joined;?>
						Joined Date: <?php echo date('F - Y', strtotime($date));?>
					</div>
					<div class="profile-dis">
					</div>
				</div><!--profile-content ends-->

				<div class="profile-footer">
					<button class="log-out" onclick="location.href='includes/logout.php';">Log out</button>
					<button class="setting" onclick="location.href='account/settings';">Settings</button>
				</div><!--profile-footer ends-->

			</div><!--profile-box ends-->
			</div><!--profile-box-inner ends-->

		</div><!--home-left-inner-->		
		</div><!--home-left-content-->
		<div class="home-right-content">
			
		</div><!--home-right-content ends-->
	</div><!--home-inner-content ends-->
	</div><!--home-content-wrapper ends-->
	<div class="home-footer-wrapper">
		
	</div><!--home-footer-wrapper ends-->
</div><!--home-wrapper ends-->
</body>
</html>