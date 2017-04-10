<?php
/*
Clean up wp_head()
*/

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Remove Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter('emoji_svg_url', '__return_false');

function deregister_scripts() {
  // disable embed.js
  wp_dequeue_script('wp-embed');
}

add_action('wp_footer', 'deregister_scripts');

/*
Show less info to users on failed login for security.
(Will not let a valid username be known.)
*/

function show_less_login_info() { 
    return "<strong>ERROR</strong>: Stop guessing!"; 
}
add_filter( 'login_errors', 'show_less_login_info' );

/*
Do not generate and display WordPress version
*/

function no_generator()  { 
    return ''; 
}
add_filter( 'the_generator', 'no_generator' );