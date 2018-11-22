<?php 
    if (!function_exists("bw_register_rehabs"))
    {
        function bw_register_rehabs()
        {
            /**
             * Post Type: Reviews.
             */
            $labels = array(
                'name' => __('Реабилитационные центры', 'brainworks'),
                'singular_name' => __('Реабилитационный центр', 'brainworks'),
            );

            $args = array(
                'label' => __('Реабилитационные центры', 'brainworks'),
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
                'hierarchical' => true,
                'query_var' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            );

            register_post_type('rehab', $args);
        }

        add_action('init', 'bw_register_rehabs');
    }