<?php
/*
All the functions are in the PHP pages in the `functions/` folder.
*/

require_once locate_template('/functions/helpers.php');
require_once locate_template('/functions/admin.php');
require_once locate_template('/functions/login.php');
require_once locate_template('/functions/customizer.php');

require_once locate_template('/functions/breadcrumbs.php');
require_once locate_template('/functions/cleanup.php');
require_once locate_template('/functions/custom-logo.php');
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
    
    
function brainworks_breadcrumbs_localization($l10n) {
  return array(
    'home'       => __('Front page', 'brainworks'),
    'paged'      => __('Page %d', 'brainworks'),
    '_404'       => __('Error 404', 'brainworks'),
    'search'     => __('Search results by query - <b>%s</b>', 'brainworks'),
    'author'     => __('Author archve: <b>%s</b>', 'brainworks'),
    'year'       => __('Archive by <b>%d</b> year', 'brainworks'),
    'month'      => __('Archive by: <b>%s</b>', 'brainworks'),
    'day'        => '',
    'attachment' => __('Media: %s', 'brainworks'),
    'tag'        => __('Posts by tag: <b>%s</b>', 'brainworks'),
    'tax_tag'    => __('%1$s from "%2$s" by tag: <b>%3$s</b>', 'brainworks'),  );
}

add_filter('kama_breadcrumbs_default_loc', 'brainworks_breadcrumbs_localization', 10, 1);
    
}