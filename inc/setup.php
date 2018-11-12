<?php

function bw_switch_theme()
{
    if (get_option('uploads_use_yearmonth_folders') == 1) {
        update_option('uploads_use_yearmonth_folders', '');
    }

    update_option('sidebars_widgets', array(
        'wp_inactive_widgets' => array(),
        'sidebar-widget-area' => array(),
        'sidebar-widget-area2' => array(),
        'footer-widget-area' => array(),
        'array_version' => 3
    ));

    $post_ids = array(1, 2, 3);

    foreach ($post_ids as $id) {
        wp_delete_post($id, true);
    }
}

add_action('after_switch_theme', 'bw_switch_theme');

function bw_setup()
{
    /** Translate Theme */
    load_theme_textdomain('brainworks', get_template_directory() . '/languages');

    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('widgets');
    add_theme_support('automatic-feed-links');
    add_theme_support("title-tag");
    add_theme_support("custom-header");
    add_theme_support("custom-background");
    add_theme_support('woocommerce');

    add_editor_style('theme/css/editor-style.css');

    update_option('thumbnail_size_w', 170);
    update_option('medium_size_w', 470);
    update_option('large_size_w', 970);
}

add_action('after_setup_theme', 'bw_setup');

if (!isset($content_width)) {
    $content_width = 600;
}

function bw_excerpt_readmore()
{
    //return '&nbsp; <a href="'. get_permalink() . '">' . '&hellip;' . '<div class="button-small text-center">' . __('Read more', 'brainworks') . ' <i class="fa fa-arrow-right"></i></div>' . '</a></p>';
    //return '&nbsp; <a href="' . get_permalink() . '">' . '&hellip;' . ' <i class="fa fa-arrow-right button-style"></i>' . '</a>';
    return '&nbsp; &hellip; <a class="button-style" style="padding: 0 5px" href="' . get_permalink() . '"><i class="fa fa-arrow-right"></i></a>';
}

add_filter('excerpt_more', 'bw_excerpt_readmore');

function page_excerpt()
{
    add_post_type_support('page', array('excerpt'));
}

add_action('init', 'page_excerpt');

/**
 * Add post formats support. See http://codex.wordpress.org/Post_Formats
 */
//add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

function bw_wp_nav_menu_args($args)
{
    $args['container'] = '';

    return $args;
}

//add_filter( 'wp_nav_menu_args', 'bw_wp_nav_menu_args' );

function bw_nav_menu_css_class($classes, $item, $args, $depth)
{
    if ($item->current) {
        foreach ($classes as $class) {
            if ($class === 'current-menu-item') {
                $classes[] = $depth > 0 ? 'sub-menu-item-current' : 'menu-item-current';
                break;
            }
        }
    }

    if ($depth > 0) {
        foreach ($classes as $key => $class) {
            if (preg_match('/^menu-item/', $class)) {
                $classes[$key] = 'sub-' . $class;
            }
        }
    }

    return $classes;
}

add_filter('nav_menu_css_class', 'bw_nav_menu_css_class', 10, 4);

function bw_nav_menu_link_attributes($atts, $item, $args, $depth)
{
    //$atts['itemprop'] = 'url';
    $atts['class'] = $depth > 0 ? 'sub-menu-link' : 'menu-link';

    return $atts;
}

add_filter('nav_menu_link_attributes', 'bw_nav_menu_link_attributes', 10, 4);

function bw_menu_no_link($nav_menu, $args)
{
    $theme_locations = array('main-nav', 'second-menu');

    if (in_array($args->theme_location, $theme_locations, true)) {

        $in_link = '!<li(.*?)class="(.*?)current-menu-item(.*?)"><a(.*?)class="(.*?)">(.*?)</a>!si';
        $out_link = '<li$1class="\\2current-menu-item\\3"><span class="$5">$6</span>';

        return preg_replace($in_link, $out_link, $nav_menu);

    }

    return $nav_menu;

}

//add_filter('wp_nav_menu', 'bw_menu_no_link', 10, 2);

/** Woocommerce */
// Override theme default specification for product # per row
if (!function_exists('bw_loop_shop_columns')) {
    function bw_loop_shop_columns($columns)
    {
        if (is_shop() || is_product_category() || is_product_tag()) {
            $columns = 3; // 3 products per row
        }

        return $columns;
    }
}

add_filter('loop_shop_columns', 'bw_loop_shop_columns', 4);

if (function_exists('is_shop') && function_exists('is_product_taxonomy')) {
    function bw_body_class($classes)
    {
        $classes = (array)$classes;

        // is_woocommerce() // is_shop() || is_product_taxonomy() || is_product()
        if (is_shop() || is_product_taxonomy()) {
            $classes[] = 'columns-3';
        }

        return $classes;
    }

    add_filter('body_class', 'bw_body_class');
}

function bw_loop_shop_per_page($cols)
{
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = 12;
    return $cols;
}

add_filter('loop_shop_per_page', 'bw_loop_shop_per_page', 20);

/**
 * Remove notice-error about license YITH WooCommerce Zoom Magnifier Premium
 */
if (class_exists('YIT_Plugin_Licence')) {
    $yit_plugin_licence = YIT_Plugin_Licence();
    remove_action('admin_notices', array($yit_plugin_licence, 'activate_license_notice'), 15);
}

function bw_breadcrumbs_localization($l10n)
{
    return array(
        'home' => __('Front page', 'brainworks'),
        'paged' => __('Page %d', 'brainworks'),
        '_404' => __('Error 404', 'brainworks'),
        'search' => __('Search results by query - <b>%s</b>', 'brainworks'),
        'author' => __('Author archve: <b>%s</b>', 'brainworks'),
        'year' => __('Archive by <b>%d</b> year', 'brainworks'),
        'month' => __('Archive by: <b>%s</b>', 'brainworks'),
        'day' => '',
        'attachment' => __('Media: %s', 'brainworks'),
        'tag' => __('Posts by tag: <b>%s</b>', 'brainworks'),
        'tax_tag' => __('%1$s from "%2$s" by tag: <b>%3$s</b>', 'brainworks'),
    );
}

add_filter('kama_breadcrumbs_default_loc', 'bw_breadcrumbs_localization', 10, 1);

