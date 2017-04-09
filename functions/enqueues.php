<?php 
function brainworks_enqueues() {

	/* Styles */
    wp_register_style('style-css', get_template_directory_uri() . '/style.css', false, null);
    wp_enqueue_style('style-css');

	/* Scripts */
	wp_enqueue_script( 'jquery' );
    
    wp_register_script('modernizr',  'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', false, null, true);
	wp_enqueue_script('modernizr');

	wp_register_script('brainworks-js', get_template_directory_uri() . '/scripts/brainworks.js', false, null, true);
	wp_enqueue_script('brainworks-js');
    

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'brainworks_enqueues', 100);