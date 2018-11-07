<?php

function bw_register_cpts_reviews()
{

    /**
     * Post Type: Reviews.
     */
    $labels = array(
        'name' => __('Reviews', 'brainworks'),
        'singular_name' => __('Review', 'brainworks'),
    );

    $args = array(
        'label' => __('Reviews', 'brainworks'),
        'labels' => $labels,
        'description' => '',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'delete_with_user' => false,
        'show_in_rest' => true,
        'rest_base' => '',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'has_archive' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'reviews', 'with_front' => true),
        'query_var' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('reviews', $args);
}

add_action('init', 'bw_register_cpts_reviews');

function bw_review_get_meta_box($meta_boxes)
{
    $prefix = 'review-';

    $meta_boxes[] = array(
        'id' => 'additional',
        'title' => esc_html__('Additional', 'brainworks'),
        'post_types' => array('reviews'),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => 'true',
        'fields' => array(
            array(
                'id' => $prefix . 'display',
                'name' => esc_html__('Enable/Disable', 'brainworks'),
                'type' => 'checkbox',
                'desc' => esc_html__('Display review on Home page.', 'brainworks'),
            ),
            array(
                'id' => $prefix . 'facebook',
                'type' => 'url',
                'name' => esc_html__('Facebook URL', 'brainworks'),
                'placeholder' => 'https://www.facebook.com',
            ),
            array(
                'id' => $prefix . 'instagram',
                'type' => 'url',
                'name' => esc_html__('Instagram URL', 'brainworks'),
                'placeholder' => 'https://www.instagram.com',
            ),
        ),
    );

    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'bw_review_get_meta_box');
