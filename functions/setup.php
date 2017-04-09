<?php

function brainworks_setup() {
	add_editor_style('theme/css/editor-style.css');
	add_theme_support('post-thumbnails');
	update_option('thumbnail_size_w', 170);
	update_option('medium_size_w', 470);
	update_option('large_size_w', 970);
}
add_action('init', 'brainworks_setup');

if (! isset($content_width))
	$content_width = 600;

function brainworks_excerpt_readmore() {
	//return '&nbsp; <a href="'. get_permalink() . '">' . '&hellip;' . '<div class="button-small text-center">' . __('Read more', 'brainworks') . ' <i class="fa fa-arrow-right"></i></div>' . '</a></p>';
    return '&nbsp; <a href="'. get_permalink() . '">' . '&hellip;' . ' <i class="fa fa-arrow-right button-style"></i>' . '</a>';
}
add_filter('excerpt_more', 'brainworks_excerpt_readmore');

// Add post formats support. See http://codex.wordpress.org/Post_Formats
add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));