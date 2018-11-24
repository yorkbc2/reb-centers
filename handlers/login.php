<?php 
	require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
	if (!function_exists("login_handler"))
	{
		function login_handler() 
		{
			if (!isset($_POST["login"]) || !isset($_POST["password"]))
			{
				// Error message: ALl fields must be fullfilled
				return wp_redirect("/auth?error_message=1&type=login");
			}	
			$login = filter_str($_POST["login"]);
			$password = $_POST["password"];
			$remember = isset($_POST['remember']) ? true : false;

			$user = UserController::login($login, $password, $remember);
			if ($user)
			{
				return wp_redirect("/me");
			}
			else
			{
				// login or password is incorrect
				return wp_redirect("/auth?error_message=2&type=login");
			}
		}

		return login_handler();
	}
?>