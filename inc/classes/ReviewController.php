<?php 

	interface IReviewController {
		public static function get_reviews($post_id);

		public static function add_review($post_id, $user_id, $content, $rating, $reply_to);
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
	}