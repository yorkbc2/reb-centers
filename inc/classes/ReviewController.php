<?php 

	interface IReviewController {
		public static function get_reviews($post_id);

		public static function add_review($post_id, $user_id, $content, $rating, $reply_to);

		public static function has_reviews($post_id, $type);
	}

	class ReviewController implements IReviewController {
		public static function get_reviews($post_id, $type="rehab_review")
		{
			$query = new WP_Query([
				"post_type" => $type,
				"posts_per_page" => 100,
				"meta_query" => array(
			        array(
			            "key"     => "_post_id",
			            "value"   => array( $post_id ),
			            "compare" => "IN",
					),
					array(
						"key"     => "_reply_to",
						"value"   => array(0),
						"compare" => "IN"
					)
			    ),
			]);

			if ($query->have_posts())
			{
				return $query->posts;
			}
			else
			{
				return [];
			}
		}

		public static function add_review($post_id, $user_id, $content, $rating, $reply_to)
		{
			$review = new RehabReview($post_id, $user_id, $content, $rating, $reply_to);

			$review->save();

			return $review;
		}

		public static function get_review_user($review_id, $user_id)
		{	
			$user = UserController::get_user($user_id);
			return $user;
		}

		public static function get_rating($review_id)
		{
			return intval(get_post_meta($review_id, "_rating", true));
		}

		public static function has_reviews($post_id, $type)
		{
			$posts = get_posts([
				"post_type" => $type,
				"meta_query" => array(
			        array(
			            "key"     => "_post_id",
			            "value"   => array( $post_id ),
			            "compare" => "IN",
					)
			    )
			]);

			return sizeof($posts) > 0;
		}

		public static function has_replies($review_id, $type = "rehab_review")
		{
			return boolval(sizeof(self::get_replies($review_id, $type, 1)));
		}
		public static function get_replies($review_id, $type = "rehab_review", $limit = 100)
		{
			$posts = get_posts([
				"post_type" => $type,
				"meta_query" => array(
			        array(
			            "key"     => "_reply_to",
			            "value"   => array( $review_id ),
			            "compare" => "IN",
					)
				),
				"posts_per_page" => $limit
			]);

			return $posts;
		}
	}