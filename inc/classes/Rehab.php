<?php 
	
	class Rehab {
		/**
		 * ID of the post
		 * @var number | null
		 */
		static $id = 0;

		/**
		 * Rehab name
		 * @var string
		 */
		static $title = "";

		/**
		 * Rehab content
		 * @var string
		 */
		static $content = "";

		/**
		 * Rehab address (array of address and google link)
		 * @var array
		 */
		static $address = ["address" => "", "link" => ""];

		/**
		 * Rehab image
		 * @var string
		 */
		static $thumbnail = "";

		/**
		 * Phone number of Rehab
		 * @var string
		 */
		static $phone = "";


		/**
		 * An email of rehab
		 * @var string
		 */
		static $email = "";

		/**
		 * Array of social link of rhab
		 * @var array
		 */
		static $socials = [];



		public function __construct($id) {
			$this->id = $id;

			$this->get_post();
		}

		public function get_title() {
			return $this->title;
		}

		public function set_title($title) {
			$this->title = $title;
			return;
		}

		public function get_content() {
			return $this->content;
		}

		public function set_content($content) {
			$this->content = $content;
			return;
		}

		public function get_thumbnail() {
			return $this->thumbnail;
		}

		public function set_thumbnail($thumbnail) {
			$this->thumbnail = $thumbnail;
			return;
		}

		public function get_address($is_link = false) {
			if (!$is_link) return $this->address;

			$output = '<a href="%s" target="_blank">%s</a>';
			return sprintf($output, $this->address["link"], $this->address["address"]);
		}

		public function get_phone() { return $this->phone; }
		public function set_phone($phone) {
			$this->phone = $phone;
			return;
		}

		public function get_email() { return $this->email; }
		public function set_email($email) {
			$this->email = $email;
			return;
		}

		public function get_socials() { return $this->socials; }
		public function set_socials($socials) {
			$this->socials = $socials;
			return;
		}

		private function get_post() {
			$post = get_post($this->id);
			if ($post) {
				$this->title = $post->post_title;
				$this->address = reb_combine_address($this->id);
				$this->thumbnail = get_the_post_thumbnail_url($this->id, "large");
				$this->content = $post->post_content;
				$this->phone = get_post_meta($this->id, "bw-reb-phone", true);
				$this->email = get_post_meta($this->id, "bw-reb-email", true);
				$this->socials = get_post_meta($this->id, "bw-reb-socials");
			}
		}
	}