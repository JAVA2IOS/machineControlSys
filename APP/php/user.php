<?php

class user {
	/*
	 * 登陆
	 */
	public static function usrLogin () {
		$username = $_POST['user'];
		$password = $_POST['pwd'];
		echo '登陆成功';
	}
}	
?>