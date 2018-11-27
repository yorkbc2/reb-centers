<?php 
	interface IUserController {

		/**
		 * Login into service
		 * @param  string $login User login
		 * @param  string $password User password
		 * @param boolean $remember Is user must be remembered
		 * @return boolean True, if user logged in
		 */
		public static function login($login, $password, $remember);

		/**
		 * Register user
		 * @param  string $login     User nickname to log into the service
		 * @param  string $password  User password
		 * @param  string $name      User name
		 * @param  string $born_date User born date (01.01.1970 - d.m.Y format)
		 * @param  string $address   User's location
		 * @param  string $problem   User's problem
		 * @return boolean           True, if user is registered
		 */
		public static function register(
			$login, 
			$password, 
			$name, 
			$born_date, 
			$address, 
			$problem
		);

		/**
		 * Check user in database.
		 * @param  string $login User's login to chec
		 * @return boolean       True, if user exists;
		 */
		public static function exists($login);

		/**
		 * Insert meta values
		 * @param  number $id         User's id
		 * @param  array $array_meta  Meta in array (key => value)
		 * @return void             
		 */
		public static function insert_meta($id, $array_meta);

		/**
		 * Is user logged into the service
		 * @return boolean 
		 */
		public static function check();

		/**
		 * Logout user from the service
		 * @return void
		 */
		public static function logout();

		/**
		 * Get current user
		 * @return array 
		 */
		public static function get_current();

		/**
		 * Calculate reputation based on fullfilled meta
		 * Updates _reputation user meta
		 * @param  number $id 
		 * @return void
		 */
		public static function calculate_reputation($id);

		/**
		 * Returns users's id
		 * @return number 
		 */
		public static function get_current_id();

		/**
		 * Returns User by ID
		 * @param number $user_id 
		 * @return User
		 */
		public static function get_user($user_id);

		
		/**
		 * Test user data on correctness
		 * @param number $user_id 
		 * @param string $user_pass
		 * @return number
		 */
		public static function test_user($user_id, $user_pass);
	}

	class UserController implements IUserController {
		private static $default_meta = array(
			"_sex" => "N/A",
			"_date_born" => "N/A",
			"_date_registered" => "N/A",
			"_problem" => "N/A",
			"_address" => "N/A",
			"_reputation" => 0,
			"_progress" => 0,
			"_likes" => 0,
			"_about" => "N/A"
		);

		public static function login($login, $password, $remember = false)
		{
			$user = wp_signon(array(
				"user_login" => filter_str($login),
				"user_password" => $password,
				"remember" => $remember 
			), false);

			if (is_wp_error($user)) 
			{
				print_r($user->get_error_message());
				return false;
			}

			return true;
		}

		public static function register(
			$login, 
			$password, 
			$name, 
			$born_date, 
			$address, 
			$problem
		) 
		{
			$login = filter_str($login);
			if (!self::exists($login))
			{
				$splitted_name = explode(" ", $name);
				$userdata = array(
					"user_login" => $login,
					"user_pass" => $password,
					"user_nicename" => $login,
					"first_name" => $splitted_name[0],
					"last_name" => $splitted_name[1],
					"display_name" => $name
				);

				$id = wp_insert_user($userdata);

				if (!is_wp_error($id))
				{
					$user_meta = self::$default_meta;
					
					$user_meta["_date_born"] = $born_date;
					$user_meta["_address"] = $address;
					$user_meta["_problem"] = $problem;

					self::insert_meta($id, $user_meta);

					self::calculate_reputation($id);

					return true;
				}
				else 
				{
					return false;
				}
			}
			else 
			{
				return false;
			}	
		}

		public static function exists($login) 
		{
			return username_exists($login);
		}

		public static function check() 
		{
			return is_user_logged_in();
		}

		public static function insert_meta($id, $array_meta) 
		{
			foreach ($array_meta as $key=>$value) 
			{
				add_user_meta($id, $key, $value, true);
			}
		}

		public static function get_current() 
		{
			$user = wp_get_current_user();

			if ($user->exists())
			{
				if (class_exists("User"))
				{
					return new User($user);
				}
				else 
				{
					return $user;
				}
			}
		}

		public static function get_current_id()
		{
			return get_current_user_id();
		}

		public static function logout()
		{
			wp_logout();
		}

		public static function calculate_reputation($id=0) 
		{
			$progress_scores = array(
				"_sex", "_address", "_about", "_problem", "_date_born"
			);
			$progress = 0;
			if (!$id)
			{
				$id = self::get_current_id();
			}
			foreach ($progress_scores as $meta)
			{
				$check = get_user_meta($id, $meta, true);
				if (!empty($check) && $check !== "N/A" && $check != "0" && $check != "Не выбран")
				{
					$progress += 10;
				}
			}
			update_user_meta($id, "_reputation", $progress);
		}

		public static function get_user($user_id)
		{
			$user = get_user_by("id", $user_id);
			if ($user)
			{
				return new User($user);
			}
			return false;			
		}

		public static function test_user($user_id, $user_pass)
		{
			$user = self::get_user($user_id);
			if ($user)
			{
				if ($user->password === $user_pass)
				{
					return 1;
				}
				return 0;
			}
			return -1;
		}
	}	
?>