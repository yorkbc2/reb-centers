<?php 
	// Single page of the Rehab post type
	get_header();
	_require("Rehab");
	$post = new Rehab(get_the_ID());
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
				<!-- <div class="card-content"></div> -->
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
	</div>

<?php get_footer(); ?>