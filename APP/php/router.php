<?php
	/*
	 * constant
	 */
	define("actionLogin","usrLogin");
	
	/*
	 * import file
	 */
	require 'user.php';
	
	/*
	 * action动作
	 */
	$action = $_POST['action'];
	
	switch($action){
		case actionLogin:
            user::usrLogin();
            break;
	}

?>