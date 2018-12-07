<?php 
	require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
	if (!function_exists("register_handler"))
	{
		function register_handler() {
			$required_fields = array("login", "password", "r_password", "name", "born_date", "address", "problem", "accept");
			$user_data = array();
			
			if (empty($_POST)) 
			{	
				wp_redirect("/auth?error_message=1&type=register");
				return;
			}

			

			foreach ($required_fields as $field) 
			{
				if (!isset($_POST[$field]))
				{
					wp_redirect("/auth?error_message=2&type=register");
					return; 
				}
				if ($field === "born_date")
				{
					$parsed_date = strtotime($_POST["born_date"]);
					if ($parsed_date > round(microtime(true)) || !$parsed_date)
					{
						wp_redirect("/auth?error_message=7&type=register");
						break;
					}
					$user_data[$field] = date("d.m.Y", $parsed_date);
					continue;
				}
				if ($field === "password" || $field === "r_password") {
					$user_data[$field] = $_POST[$field];
					continue;
				}
				$len = mb_strlen($_POST[$field]);
				if ($len < 1 || $len > HANDLER_MAXIMUM_LETTERS)
				{
					wp_redirect("/auth?error_message=6&type=register");
					break;
				}

				if ($field === "name")
				{
					$splitted_name = explode(" ", $_POST[$field]);
					if (sizeof($splitted_name) != 2)
					{
						wp_redirect("/auth?error_message=8&type=register");
						break;
					}
				}

				$user_data[$field] = filter_str($_POST[$field]);
			}			


			if ($user_data["password"] !== $user_data["r_password"]) {
				// Error message: Passwords must be equal
				wp_redirect("/auth?error_message=5&type=register");
				return;
			}
			

			if ($user_data["accept"] != "Y") {
				// Error message: You must accept the rules
				wp_redirect("/auth?error_message=4&type=register");
				return;
			}

			if (UserController::register(
				$user_data["login"],
				$user_data["password"],
				$user_data["name"],
				$user_data["born_date"],
				$user_data["address"],
				$user_data["problem"]
			))
			{
				UserController::login($user_data["login"], $user_data["password"]);
				wp_redirect("/me?new_user");
				return;
			}
			else 
			{
				// Error message: User with this login exist;
				wp_redirect("/auth?error_message=3&type=register");
				return;
			}
		}

		return register_handler();
	}
?>