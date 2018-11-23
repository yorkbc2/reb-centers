<?php 
	
	class Rehab {
		/**
		 * ID of the post
		 * @var number | null
		 */
		$id = null;

		/**
		 * Rehab name
		 * @var string
		 */
		$title = "";

		/**
		 * Rehab content
		 * @var string
		 */
		$content = "";

		/**
		 * Rehab address (array of address and google link)
		 * @var string
		 */
		$address = ["address" => "", "link" => ""];

		/**
		 * Rehab image
		 * @var string
		 */
		$thumbnail = "";



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

		public function get_title($thumbnail) {
			$this->thumbnail = $thumbnail;
			return;
		}

		private function get_post() {
			$post = get_post($this->id);
			if ($post) {
				$this->title = $post->post_title;
				$this->address = reb_combine_address($this->id);
				$this->thumbnail = get_the_post_thumbnail_url($this->id, "large");
				$this->content = $post->post_content;
			}
		}
	}