<?php

function brainworks_setup() {
  //Translate Theme
  load_theme_textdomain( 'brainworks', get_template_directory().'/languages' );

  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');
  add_theme_support('widgets');
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( "title-tag" );
  add_theme_support( "custom-header" );
  add_theme_support( "custom-background" );
  add_theme_support( 'woocommerce' );

  add_editor_style('theme/css/editor-style.css');

  update_option('thumbnail_size_w', 170);
  update_option('medium_size_w', 470);
  update_option('large_size_w', 970);
}

add_action('after_setup_theme', 'brainworks_setup');

if (! isset($content_width))
	$content_width = 600;

function brainworks_excerpt_readmore() {
	//return '&nbsp; <a href="'. get_permalink() . '">' . '&hellip;' . '<div class="button-small text-center">' . __('Read more', 'brainworks') . ' <i class="fa fa-arrow-right"></i></div>' . '</a></p>';
    return '&nbsp; <a href="'. get_permalink() . '">' . '&hellip;' . ' <i class="fa fa-arrow-right button-style"></i>' . '</a>';
}

add_filter('excerpt_more', 'brainworks_excerpt_readmore');

function page_excerpt() {
  add_post_type_support('page', array('excerpt'));
}

add_action('init', 'page_excerpt');

// Add post formats support. See http://codex.wordpress.org/Post_Formats
add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

function brainworks_wp_nav_menu_args( $args ) {
    $args['container'] = '';

    return $args;
}

//add_filter( 'wp_nav_menu_args', 'brainworks_wp_nav_menu_args' );

function brainworks_nav_menu_css_class( $classes, $item, $args, $depth ) {

    if ( $item->current ) {
        foreach ( $classes as $key => $class ) {
            if ( $class === 'current-menu-item' ) {
                $classes[ $key ] .= ' menu-item-current';
            }
        }
    }

    if ( $depth > 0 ) {
        foreach ( $classes as $key => $class ) {
            $classes[ $key ] = 'sub-' . $class;
        }
    }

    return $classes;
}

add_filter( 'nav_menu_css_class', 'brainworks_nav_menu_css_class', 10, 4 );

function brainworks_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    //$atts['itemprop'] = 'url';
    $atts['class'] = $depth > 0 ? 'sub-menu-link' : 'menu-link';

    return $atts;
}

add_filter( 'nav_menu_link_attributes', 'brainworks_nav_menu_link_attributes', 10, 4 );
