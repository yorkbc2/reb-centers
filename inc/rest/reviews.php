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