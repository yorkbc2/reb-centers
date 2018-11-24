<?php 

	if (!function_exists("register_handler"))
	{
		function register_handler() {
			$required_fields = array("login", "password", "name", "born_date", "address", "problem", "accept");
			$user_data = array();
			
			if (empty($_POST)) 
			{	
				// Error message: Fields must be fullfilled
				return wp_redirect("/auth?error_message=1&type=register");
			}

			foreach ($required_fields as $field) 
			{
				if (!isset($_POST[$field]))
				{
					// Error message: All required fields must be REQUIRED
					return wp_redirect("/auth?error_message=2&type=register");
				}

				$user_data[$field] = filter_str($_POST[$field]);
			}

			if ($user_data["accept"] != "Y") {
				// Error message: You must accept the rules
				return wp_redirect("/auth?error_message=4&type=register");
			}

			if (User::register(
				$user_data["login"],
				$user_data["password"],
				$user_data["name"],
				$user_data["born_date"],
				$user_data["address"],
				$user_data["problem"]
			))
			{
				User::login($user_data["login"], $user_data["password"]);
				return wp_redirect("/me?new=1");
			}
			else 
			{
				// Error message: User with this login exist;
				return wp_redirect("/auth?error_message=3&type=register");
			}
		}

		add_action("admin_post_user_register", "register_handler");
	}

?>