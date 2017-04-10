<?php
/*
All the functions are in the PHP pages in the `functions/` folder.
*/

require_once locate_template('/functions/cleanup.php');
require_once locate_template('/functions/setup.php');
require_once locate_template('/functions/enqueues.php');
require_once locate_template('/functions/navbar.php');
require_once locate_template('/functions/widgets.php');
require_once locate_template('/functions/index-pagination.php');
require_once locate_template('/functions/split-post-pagination.php');
require_once locate_template('/functions/feedback.php');

add_theme_support( 'automatic-feed-links' );
add_theme_support( "title-tag" );
add_theme_support( "custom-header" );
add_theme_support( "custom-background" );

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
add_theme_support( 'woocommerce' );
    
//Translate Theme
load_theme_textdomain( 'brainworks', get_template_directory().'/languages' ); 
    
}