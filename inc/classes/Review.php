<?php 

	interface IReview {
		public function __construct($post_id, $user_id, $content, $rating, $reply_to);

		public function save();

		public function get_replies();

		public function set_type($type);
	}

	class Review implements IReview {
		public $post_id = 0;

		public $user_id = 0;
		
		public $content = "";
		
		public $rating = 0;
		
		public $reply_to = 0;

		public $type = "rehab_review";

		public function __construct(
			$post_id, 
			$user_id, 
			$content, 
			$rating,
			$reply_to = 0
		) 
		{
			$this->post_id  = $post_id;
			$this->user_id  = $user_id;
			$this->content  = $content;
			$this->rating   = $rating;
			$this->reply_to = $reply_to;
		}

		public function save() {
			$user = UserController::get_user($this->user_id);
			$post = get_posts([
				"post_type" => $this->type,
				"posts_per_page" => 1,
				"ID" => $this->post_id
			]);
			if (sizeof($post) > 0)
			{
				$post = $post[0];
			}
			$id = wp_insert_post([
				"post_type" => $this->type,
				"post_title" => $user->name . " об " . $post->post_title,
				"post_content" => $this->content,
				"post_author" => $this->user_id,
				"post_status" => "publish"
			]);

			if (is_wp_error($id))
			{	
				return false;
			}

			add_post_meta($id, "_reply_to", $this->reply_to, true);
			add_post_meta($id, "_rating", $this->rating, true);
			add_post_meta($id, "_post_id", $this->post_id, true);

			return $id;
		}

		public function set_type($type) {
			$this->type = $type;
		}

		public function get_replies() {
			$query = new WP_Query([
				"post_type" => $this->type,
				"posts_per_page" => 100,
				"meta_query" => array(
			        array(
			            "key"     => "_reply_to",
			            "value"   => array( $this->post_id ),
			            "compare" => "IN",
			        ),
			    ),
			]);

			if ($query->have_posts())
			{
				return $query->posts;
			} 
			else
			{
				return array();
			}
		}
	}