<?php 
	include 'core/init.php';

	if(isset($_GET['password']) || isset($_GET['verify'])){
		if(!empty($_GET['password']) || !empty($_GET['verify'])){
			$code = Validate::escape($_GET['verify']);
	    	$verify = $verifyObj->verifyResetCode($code);

	    	if($verify){
	    		if(date('Y-m-d', strtotime($verify->createdAt)) < date('Y-m-d')){
	    			$errors['verify'] = "Your password reset link has been expired";
	    		}else{
	    			$userObj->update('recovery',array('status' => '1'), array('user_id' => $verify->user_id,'code' => $code));
 	    		}
	    	}else{
	    		$errors['verify'] = "Invalid password reset link";
	    	}
		}else{
			$userObj->redirect('index.php');
		}
	}

	if(isset($_POST['reset'])){
		$password        = $_POST['rPassword'];
		$passwordAgain   = $_POST['rPasswordAgain'];

		if(!empty($password)){
			if($password !== $passwordAgain){
				$errors['reset'] = "Password does not match";
			
			}else if (Validate::length($password, 5, 20)){
				$errors['reset'] = "Password must be between in 5 - 20 charaecters";
			}else{
				$hash = $userObj->hash($password);
				$userObj->update('users', array('password' => $hash), array('user_id' => $verify->user_id));
				$userObj->redirect('password.php?success=true');
			}
		}else{
			$errors['reset'] = "Enter your new password!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create New Password</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<body class="body">
<div class="home-nav">
	<a href="<?php echo BASE_URL;?>home.php">Home</a>
</div>
	<div class="wrapper">
		<div class="header-wrapper">
			<h1>Reset your password</h1>
			<h3>Enter your new password to change!</h3>			
		</div><!--HEADER WRAPPER ENDS-->
		<div class="sign-div">
		<div class="sign-in">
			<?php if(isset($_GET['success'])):?>
				<div class="success-message">Your password has been changed, now you can <a href="http://localhost/login-system">Login</a></div>
			<?php else:?>
			<div class="signIn-inner">
				<?php if(isset($errors['verify'])):?>
					<center><div class="success-message"><?php echo $errors['verify'];?></center>
				<?php else:?>
				<form method="POST">
				<div class="input-div">
				<input type="Password" name="rPassword"    placeholder="Password">
				<input type="password" name="rPasswordAgain" placeholder="Cofirm Password">
				<button type="submit" name="reset">Reset</button>
				</form>
				</div>
				<?php if(isset($errors['reset'])):?>
				<div class="error shake-horizontal"><?php echo $errors['reset'];?></div>
				<?php endif;?>
			<?php endif;?>
		<?php endif;?>
			</div>
		</div>
		</div><!--CONTENT WRAPPER ENDS-->
		<div class="footer-wrapper">
			
		</div><!--FOOTER WRAPPER ENDS-->
	</div><!--WRAPPER ENDS-->
</body>
</html>