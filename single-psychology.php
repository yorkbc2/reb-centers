<?php 
	// Single page of the Rehab post type
	get_header();
	$id = get_the_ID();
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
					<!-- <div class="card-content">
						<p class="labeled">
							<label>Рейтинг:</label>
							<span>
							<?php echo draw_stars(floor($rating)); ?>
							(<?php echo $rating; ?> из 5)
							</span>
						</p>
					</div> -->
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
		
		<!-- <?php if (ReviewController::has_reviews($post->id, "rehab_review")) : ?>
		<div class="flex-container _vc">
			<div class="card card--nospaces">
				<div data-bind="foreach: reviews" class="card-content" id="reviews_list" 
					data-id="<?php echo $post->id; ?>" 
					data-user="<?php echo UserController::get_current_id(); ?>"
					data-type="rehab_review">
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
		<?php endif; ?> -->
		
		<?php if (UserController::check()): ?>
		<!-- <div class="flex-container">
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
		</div> -->
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
		<div class="gallery-modal-images"></div>
	</div>

<?php get_footer(); ?>
