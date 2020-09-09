<?php 
	include '../core/init.php';

	//check if user loggedIn 
	if(!$userObj->isLoggedIn()){
		$userObj->redirect('index.php');
	}else{
		$userObj->logout();
	}
?>