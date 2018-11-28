<?php 

	if (!function_exists("rest_add_review"))
	{
		function rest_add_review(WP_REST_Request $req)
		{
			$user_id = $req->get_param("user_id");
			$user_pass = $req->get_param("user_pass");
			$post_id = $req->get_param("post_id");
			$rating = $req->get_param("rating");
			$content = $req->get_param("content");
			$reply_to = $req->get_param("reply_to");

			$content = filter_str($content);
			$rating = intval($rating);
			
			if ($rating < 1 || $rating > 5)
			{
				return ["success" => false, "error" => "Rating is undefined!"];
			}

			$user = get_user_by("ID", $user_id);
			if (!$user)
			{
				return ["success" => false, "error" => "User isn't found!"];
			}
			else
			{
				if ($user->user_pass !== $user_pass)
				{
					return ["success" => false, "error" => "Please, don't change markup!"];
				}
			}

			$rehab_review = new RehabReview(
				$post_id, 
				$user_id, 
				$content, 
				$rating,
				$reply_to
			);

			$rehab_review->set_type("rehab_review");

			$rehab_review->save();

			return ["success" => true, "error" => null, "review" => $rehab_review];
		}

		add_action( "rest_api_init", function () {
			register_rest_route( "brainworks", "reviews/add", array(
				"methods" => "POST",
				"callback" => "rest_add_review",
			) );
		} );
	}

	if (!function_exists("rest_get_reviews"))
	{
		function rest_get_reviews(WP_REST_Request $req)
		{
			$post_id = $req->get_param("post_id");
			$page = $req->get_param("page");
			$limit = $req->get_param("limit");

			$query = new WP_Query([
				"post_type" => "rehab_review",
				"paged" => $page,
				"posts_per_page" => $limit,
				"meta_query" => array(
			        array(
			            "key"     => "_post_id",
			            "value"   => array( $post_id ),
			            "compare" => "IN",
			        ),
			    )
			]);

			if ($query->have_posts())
			{
				$reviews = $query->posts;
				foreach ($reviews as $index=>$review) {
					$user = UserController::get_user($review->post_author);

					$reviews[$index]->user_image = UserController::get_image($user->id);
					$reviews[$index]->user_name  = $user->name;
					$reviews[$index]->rating     = ReviewController::get_rating($review->ID);
					$reviews[$index]->post_date  = date("d/m/Y H:i", strtotime($review->post_date));
					$reviews[$index]->post_content = esc_html($review->post_content);
				}
				return ["data" => $reviews, "count" => $query->found_posts];
			}
			return false;
		}

		add_action( "rest_api_init", function () {
			register_rest_route( "brainworks", "reviews/get", array(
				"methods" => "GET",
				"callback" => "rest_get_reviews",
			) );
		} );
	}