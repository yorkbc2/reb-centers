<?php 
	// Single page of the Psychology post type
	get_header();
	// _require("Rehab");
	$id = get_the_ID();
	$reviews = ReviewController::get_reviews($id, "psychology_review");
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
		<div class="row">
			<div class="col-md-4">
				<div class="card card--single flex-1">
					<img src="<?php the_post_thumbnail_url('large'); ?>" title="<?php the_title(); ?>">
				</div>
			</div>
			<div class="col-md-8">
				<div class="card card--spaces flex-2">
					<div class="card-header">
						<h2><?php the_title(); ?></h2>
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
							<?php $address = reb_combine_address(get_the_ID(), "bw-psycho-"); ?>
							<a href="<?php echo $address['link']; ?>" target="_blank">
								<?php echo $address['address']; ?>
							</a>
						</p>
						<p class="labeled">
							<label><?php _e("Телефон", "brainworks"); ?>:</label>
							<a href="tel:<?php echo get_post_meta(get_the_ID(), "bw-psycho-phone", true) ?>">
								<?php echo get_post_meta(get_the_ID(), "bw-psycho-phone", true) ?>
							</a>
						</p>
						<p class="labeled">
							<label><?php _e("E-mail", "brainworks"); ?>:</label>
							<a href="mailto:<?php echo get_post_meta(get_the_ID(), "bw-psycho-email", true) ?>">
								<?php echo get_post_meta(get_the_ID(), "bw-psycho-email", true) ?>
							</a>
						</p>
						<p class="labeled">
							<label><?php _e("Социальные сети", "brainworks"); ?>:</label>
							<?php
								if ($socials = parsed_socials(get_post_meta(get_the_ID(), "bw-psycho-socials")[0]))
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
		</div>
		<div class="flex-container">
			<div class="card card--nospaces">
				<div class="card-header with-spaces">
					<h3 class="muted small">
						<i class="fal fa-align-left"></i>&nbsp;&nbsp;<?php _e("О Центре", "brainworks"); ?>
					</h3>
				</div>
				<div class="card-content">
					<div class="tabs">
						<?php if ($tabs = get_tabs(get_the_ID(), "bw-psycho-", 3)): ?>
							<ul class="rehab-tabs">
							<?php foreach ($tabs["headers"] as $j=>$header): ?>
								<li>
									<a href="#<?php echo $j; ?>">
										<?php echo $header; ?>
									</a>
								</li>
							<?php endforeach; ?>
							</ul>
							<?php foreach ($tabs["content"] as $j=>$content): ?>
							<div class="tab" id="<?php echo $j; ?>">
								<?php echo $content; ?>
							</div>
							<?php endforeach; ?>							
						<?php endif; ?>
					</div>
					<div class="sp-md-2"></div>
				</div>
			</div>
		</div>
		
		<?php if (ReviewController::has_reviews($id, "psychology_review")) : ?>
		<div class="flex-container _vc">
			<div class="card card--nospaces">
				<div data-bind="foreach: reviews" class="card-content" id="reviews_list" 
					data-id="<?php echo $id; ?>" 
					data-user="<?php echo UserController::get_current_id(); ?>"
					data-type="psychology_review">
					<div class="r-review-item">
						<div class="review-thumbnail-container">
							<img data-bind="attr: {src: user_image}" width="100px" />
						</div>
						<div class="review-content-container">
							<div class="review-item-header">
								<a data-bind="attr: {
									href: '/user/' + post_author()
								}, text: user_name
								" target="_blank"></a>
								<small class="review-item-date" data-bind="text: post_date"></small>
							</div>
							<rating params="count: rating()"></rating>
							<div class="review-item-content" data-bind="text: post_content"></div>
							<div class="review-item-footer">
								<span class="clickable">Ответить <i class="fa fa-reply"></i></span>
								<font color="#ccc">|</font>
								<div data-bind="if: !liked()" style="display: inline-block;">
									<span class="clickable" data-bind="event: {click: $root.likePost.bind($data,1,ID)}">	
										<i class="fa fa-thumbs-up"></i>
										&nbsp;
										<span data-bind="text: likes"></span>
									</span>
									<font color="#ccc">|</font>
									<span class="clickable" data-bind="event: {click: $root.likePost.bind($data,0,ID)}">	
										<i class="fa fa-thumbs-down"></i>
										&nbsp;
										<span data-bind="text: dislikes"></span>
									</span>
								</div>
								<div data-bind="if: liked()" style="display: inline-block; color: #ccc; font-size: 14px;">
									Вы уже оценили эту рецензию 
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div class="card-footer text-center" data-bind="if: hasMoreReviews() === true">
					<div class="sp-md-2"></div>
					<button class="button-link load-more" data-bind="event: {click: loadMore}">
						Загрузить больше
					</button>
					<div class="sp-md-2"></div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<?php 
		$check = UserController::check();
		if ($check && !UserController::has_reviews(
			UserController::get_current_id(),
			"psychology_review",
			$id
		)): ?>
		<div class="flex-container">
			<div class="card text-center">
				<div class="card-header">
					<h2>Оставить отзыв</h2>
				</div>
				<div class="card-content">
					<review-form params="post_id: <?php echo get_the_ID() ?>,user_id: <?php echo UserController::get_current_id(); ?>,user_pass: '<?php echo UserController::get_current()->password; ?>',reply_to: 0,rating: true,post_type: 'psychology_review'"></review-form>
				</div>
			</div>
		</div>
		<?php elseif (!$check): ?>
		<div class="flex-container">
			<div class="card">
				<div class="card-content text-center">
					Чтобы оставить отзыв, нужно <a href="/auth">зарегистрироваться или войти</a> в учётную запись. 
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="sp-md-2"></div>
		<div class="col-md-12">
		<iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo urlencode(reb_combine_address(get_the_ID(), "bw-psycho-")["address"]); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
		<style>
			#gmap_canvas {
				width: 100%;
			}	
		</style>
		</div>
	</div>
	<div class="modal-window gallery-modal">
		<div class="modal-background"></div>
		<img class="gallery-modal-image">
		<div class="galler-modal-images-container">
		<div class="gallery-modal-images"></div>
		</div>
	</div>
	<div data-bind="if: showModal()">
		<div class="modal-window review-like-modal" style="display: none;">
			<div class="modal-background" data-bind="event: {click: hideModal}"></div>
			<div class="modal-content">
				<div class="card text-center">
					<div class="card-header">
						Упс...
					</div>
					<div class="card-content">
						<div class="sp-md-2"></div>
						<p>
							Чтобы оценить рецензию, Вам нужно зарегистрироваться или, если вы уже это сделали, войти в свой личный кабинет.
							<br />
							Для этого, перейдите по ссылке ниже.
						</p>
						<div class="sp-md-2"></div>
						<div>
							<button class="button-link" data-bind="event: {click: hideModal}">Назад</button>
							<a href="/auth" class="button-medium">Регистрация/Вход</a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
