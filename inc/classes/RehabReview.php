<?php 
	
		class RehabReview extends Review {
			public function __constuct(
				$post_id, 
				$user_id, 
				$content, 
				$rating,
				$reply_to = 0
			) {
				$this->post_id  = $post_id;
				$this->user_id  = $user_id;
				$this->content  = $content;
				$this->rating   = $rating;
				$this->reply_to = $reply_to;

				$this->set_type("rehab_review");
			}

			
		}