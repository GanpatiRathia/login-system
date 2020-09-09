<?php 
	include 'core/init.php';
	$user_id = $_SESSION['user_id'];
	$verifyObj->authOnly();	
	if(isset($_POST['verify'])){
		$code = Validate::escape($_POST['verifyCode']);
		$verify = $verifyObj->verifyCode($code);
		
		if(!empty($code)){
	    	if($verify){
	    		if(date('Y-m-d', strtotime($verify->createdAt)) < date('Y-m-d')){
	    			$errors['verify'] = "Your verification code has been expired";
	    		}else{
	    			$userObj->update('verification',array('status' => '1'), array('user_id' => $user_id,'code' => $code));
	    			$userObj->redirect('home.php');
	    		}
	    	}else{
	    		$errors['verify'] = "Invalid verification code";
	    	}
       }else{
       	  $errors['verify'] = "Enter your verification code to verify your account!";
       }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Phone Verification</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>

<body class="body">
	<div class="wrapper">
		<div class="header-wrapper">
			<h1>Verify your code</h1>
			<h3>An verification code has been sent to your mobile number, Verify your code below.</h3>			
		</div><!--HEADER WRAPPER ENDS-->
		<div class="sign-div">
		<div class="sign-in">
			<div class="signIn-inner">
				<div class="input-div">
				<form method="POST">
				<input type="tel" name="verifyCode" placeholder="Enter Code">
				<button type="submit" name="verify">Verify</button>
				</form>
				</div>
			</div>
			<?php if(isset($errors['verify'])):?>
			<div class="sign-in-error">
				<?php echo $errors['verify'];?>
			</div>
		   <?php endif;?>
		</div>
		</div><!--CONTENT WRAPPER ENDS-->
		<div class="footer-wrapper">
			<div class="inner-footer-wrap">
			
			</div>
		</div><!--FOOTER WRAPPER ENDS-->
	</div><!--WRAPPER ENDS-->
</body>
</html>