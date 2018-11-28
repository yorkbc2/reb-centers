<?php 
	// Single page of the Rehab post type
	get_header();
	_require("Rehab");
	$id = get_the_ID();
	$post = new Rehab(get_the_ID());
	$reviews = ReviewController::get_reviews($id);
	$len = sizeof($reviews);
	$rating = 0;
	if ($len > 0)
	{
		$tmp_rating = 0;
		for ($i = 0; $i < $len; $i++)
		{
			$tmp_rating += ReviewController::get_rating($reviews[$i]->ID);
		}
		$rating = round($tmp_rating / $len, 1);
	}
?>

	<div class="container-fluid">
		<div class="sp-md-3"></div>
		<div class="flex-container">
			<div class="card card--single flex-1">
				<img src="<?php echo $post->get_thumbnail(); ?>" title="<?php echo $post->get_title(); ?>">
			</div>
			<div class="card card--spaces flex-1">
				<div class="card-header">
					<h2><?php echo $post->get_title(); ?></h2>
				</div>
				<div class="card-content">
					<p class="labeled">
						<label>Рейтинг:</label>
						<span>
						<?php echo draw_stars(floor($rating)); ?>
						(<?php echo $rating; ?> из 5)
						</span>
					</p>
				</div>
				<div class="card-footer">
					<p class="labeled">
						<label><?php _e("Адрес", "brainworks"); ?>:</label>
						<?php echo $post->get_address(true); ?>
					</p>
					<p class="labeled">
						<label><?php _e("Телефон", "brainworks"); ?>:</label>
						<a href="tel:<?php echo $post->get_phone(); ?>"><?php echo $post->get_phone(); ?></a>
					</p>
					<p class="labeled">
						<label><?php _e("E-mail", "brainworks"); ?>:</label>
						<a href="mailto:<?php echo $post->get_email(); ?>"><?php echo $post->get_email(); ?></a>
					</p>
					<p class="labeled">
						<label><?php _e("Социальные сети", "brainworks"); ?>:</label>
						<?php
							if ($socials = $post->get_socials_parsed())
							{
								echo '<ul class="default-socials">';
								foreach ($socials as $social)
								{
									?>
									<li>
										<a href="<?php echo $social['url']; ?>" class="social-link social-link-<?php echo $social["type"]; ?>" target="_blank">
											<i class="<?php echo $social['icon']; ?>"></i>
										</a>
									</li>
									<?php
								}
								echo '</ul>';
							}
						?>
					</p>
				</div>
			</div>
		</div>
		<div class="flex-container">
			<div class="card">
				<div class="card-header">
					<h2 class="muted small">
						<?php _e("О Центре", "brainworks"); ?>
					</h2>
				</div>
			</div>
		</div>
		
		<div class="flex-container _vc">
			<div class="card card--nospaces">
				<div class="card-content" id="reviews_list" data-id="<?php echo $post->id; ?>">

				</div>
				<div class="card-footer text-center">
					<div class="sp-md-2"></div>
					<button class="button-link load-more" style="display: none;">
						Загрузить больше
					</button>
					<div class="sp-md-2"></div>
				</div>
			</div>
		</div>
		
		<?php if (UserController::check()): ?>
		<div class="flex-container">
			<div class="card">
				<div class="card-content">
					<form class="review-form" action="/wp-json/brainworks/reviews/add" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
						<input type="hidden" name="reply_to" value="0">
						<input type="hidden" name="user_id" value="<?php echo UserController::get_current_id(); ?>">
						<input type="hidden" name="user_pass" value="<?php echo UserController::get_current()->password; ?>">
						<p class="labeled">
							<label>Ваша оценка:</label>
							<div class="rating-input">
								<label for="rating_1" data-label="Очень плохо"><i class="fal fa-star"></i></label>
								<input type="radio" name="rating" id="rating_1" value="1">
								<label for="rating_2" data-label="Плохо"><i class="fal fa-star"></i></label>
								<input type="radio" name="rating" id="rating_2" value="2">
								<label for="rating_3" data-label="Неплохо"><i class="fal fa-star"></i></label>
								<input type="radio" name="rating" id="rating_3" value="3">
								<label for="rating_4" data-label="Хорошо"><i class="fal fa-star"></i></label>
								<input type="radio" name="rating" id="rating_4" value="4">
								<label for="rating_5" data-label="Отлично"><i class="fal fa-star"></i></label>
								<input type="radio" name="rating" id="rating_5" value="5">
							</div>
						</p>
						<p class="labeled">
							<label for="content">Ваш отзыв:</label>
							<textarea name="content" id="content" placeholder="Введите Ваш отзыв"></textarea>
						</p>
						<div>
							<button type="submit" class="button-alt">
								Отправить
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>

<?php get_footer(); ?>