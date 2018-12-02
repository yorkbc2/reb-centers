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
		<div class="row">
			<div class="col-md-4">
				<div class="card card--single flex-1">
					<img src="<?php echo $post->get_thumbnail(); ?>" title="<?php echo $post->get_title(); ?>">
				</div>
			</div>
			<div class="col-md-8">
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
						<?php if ($tabs = $post->get_tabs()): ?>
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
					<?php if ($images = $post->get_gallery()): ?>
					<section class="rehab-gallery-container">
					<div class="rehab-gallery siema">
						
							<?php foreach ($images as $image): ?>
							<div class="rehab-gallery-item">
								<img src="<?php echo $image['url']; ?>" class="gallery-image"
									data-source-width="<?php echo $image['width']; ?>"
									data-source-height="<?php echo $image['height']; ?>"
									height="100px"
									width="auto" />
							</div>
							<?php endforeach; ?>
						
					</div>
					<button type="button" class="rehab-gallery-arrow prev">
						<i class="fa fa-chevron-left"></i>
					</button>
					<button type="button" class="rehab-gallery-arrow next">
						<i class="fa fa-chevron-right"></i>
					</button>
					</section>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		<!-- <div class="flex-container _vc">
			<div class="card card--nospaces">
				<div class="card-content" id="reviews_list" data-id="<?php echo $post->id; ?>" data-user="<?php echo UserController::get_current_id(); ?>">

				</div>
				<div class="card-footer text-center">
					<div class="sp-md-2"></div>
					<button class="button-link load-more" style="display: none;">
						Загрузить больше
					</button>
					<div class="sp-md-2"></div>
				</div>
			</div>
		</div> -->

		<div class="flex-container _vc">
			<div class="card card--nospaces">
				<div data-bind="foreach: reviews" class="card-content" id="reviews_list" data-id="<?php echo $post->id; ?>" data-user="<?php echo UserController::get_current_id(); ?>">
					<div class="r-review-item">
						<div class="review-thumbnail-container">
							<img data-bind="attr: {src: user_image}" width="100px" />
						</div>
						<div class="review-content-container">
							<div class="review-item-header">
								<a data-bind="attr: {
									href: '/profile' + post_author
								}, text: user_name
								" target="_blank"></a>
								<small class="review-item-date" data-bind="text: post_date"></small>
							</div>
							<rating params="count: rating"></rating>
							<div class="review-item-content" data-bind="text: post_content"></div>
							<div class="review-item-footer">
								<span class="clickable">Ответить <i class="fa fa-reply"></i></span>
								<font color="#ccc">|</font>
								<span class="clickable">	
									<i class="fa fa-thumbs-up"></i>
									&nbsp;
									<span data-bind="text: likes"></span>
								</span>
								<font color="#ccc">|</font>
								<span class="clickable">	
									<i class="fa fa-thumbs-down"></i>
									&nbsp;
									<span data-bind="text: dislikes"></span>
								</span>
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
		
		<?php if (UserController::check()): ?>
		<div class="flex-container">
			<div class="card text-center">
				<div class="card-header">
					<h2>Оставить отзыв</h2>
				</div>
				<div class="card-content">
					<review-form params="post_id: <?php echo $post->id; ?>,user_id: <?php echo UserController::get_current_id(); ?>,user_pass: '<?php echo UserController::get_current()->password; ?>',reply_to: 0,rating: true"></review-form>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="sp-md-2"></div>
		<div>
		<iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo urlencode($post->get_address()["address"]); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
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
		<div class="gallery-modal-images"></div>
	</div>

<?php get_footer(); ?>
