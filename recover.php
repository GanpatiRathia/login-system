<?php 
	include 'core/init.php';

	if(isset($_POST['recover'])){
		$email  = Validate::escape($_POST['email']);

		if(!empty($email)){
			if(!Validate::filterEmail($email)){
				$errors['reset'] = "Invalid email format!";
			}else {
				if($user = $userObj->emailExist($email)){
					$link = $verifyObj->generateLink();
					$message  = "{$user->firstName}, Someone requested for new password, if you didn't requested new password then leave this email, however if you did then here's your reset link <a href='http://localhost/login-system/account/recover/{$link}'>Reset Password</a>";
					$subject = "Reset Password";
					$verifyObj->sendToMail($user->email, $message, $subject);
			    	$userObj->insert('recovery', array('user_id' => $user->user_id, 'code' => $link));
			    	$userObj->redirect('account/recover/?mail=sent');
				}else{
					$errors['reset'] = "Email doesn't exists";
				}
			}

		}else{
			$errors['reset'] = "Enter your email to reset your password";
		}
	}

	if(isset($_GET['verify'])){
    	$code = Validate::escape($_GET['verify']);
    	$verify = $verifyObj->verifyResetCode($code);
 
     	if($verify){
    		if(date('Y-m-d', strtotime($verify->createdAt)) < date('Y-m-d')){
    			$errors['verify'] = "Your verification link has been expired";
    		}else{
     			$userObj->redirect('password.php?password=true&verify='.$verify->code);
    		}
    	}else{
    		$errors['verify'] = "Invalid verification link";
    	}
    }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Reset your account password</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<div class="home-nav">
	<a href="<?php echo BASE_URL;?>home.php">Home</a>
</div>
<body class="body">
	<div class="wrapper">
		<div class="header-wrapper">
			<h1>Reset Password</h1>			
		</div><!--HEADER WRAPPER ENDS-->
		<div class="sign-div">
		<div class="sign-in">
		<?php if(isset($errors['verify'])):?>
			<center><div class="success-message"><?php echo $errors['verify'];?></div></center>
		<?php else:?>	
		<?php 
			if(isset($_GET['mail']) || !empty($_GET['mail'])){
				echo '<div class="success-message">An email has been sent to your email adress with reset password link</div>';
			}else {
		?>
			<div class="signIn-inner">
				<form method="POST">
				<div class="input-div">
				<input type="email" name="email" placeholder="Email">
				<button type="submit" name="recover">Send Link</button>
				</div> 
				</form>
			</div>
			<?php } if(isset($errors['reset'])):?>
			<div class="sign-in-error">
				<?php echo $errors['reset'];?>
			</div>
		    <?php endif;?>
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