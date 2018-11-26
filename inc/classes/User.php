<?php 

	interface IUser {
		public function get_age();
	}
	
	class User implements IUser {
		public $id = 0;

		public $login = "";

		public $name = "";

		public $progress = 0;

		public $address = "";

		public $date_born = "";

		public $likes = 0;

		public $sex = "";

		public $problem = "";

		public $reputation = 0;

		public $about = "";

		public function __construct(WP_User $user) {
			$this->id = $user->ID;
			$this->login = $user->user_login;
			$this->name = $user->display_name;
			$this->password = $user->user_pass;

			$this->progress = get_user_meta($this->id, "_progress", true);
			$this->address = get_user_meta($this->id, "_address", true);
			$this->date_born = get_user_meta($this->id, "_date_born", true);
			$this->sex = get_user_meta($this->id, "_sex", true);
			$this->likes = get_user_meta($this->id, "_likes", true);
			$this->problem = get_user_meta($this->id, "_problem", true);
			$this->about = get_user_meta($this->id, "_about", true);
			$this->reputation = get_user_meta($this->id, "_reputation", true);
		}

		public function get_age() {
			$year = intval(date("Y"));
			$user_date = intval(date("Y", strtotime($this->date_born)));
			return $year - $user_date;
		}
	}