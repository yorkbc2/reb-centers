<?php 
    if (!function_exists("bw_register_rehab_reviews"))
    {
        function bw_register_rehab_reviews()
        {
            /**
             * Post Type: Reviews.
             */
            $labels = array(
                'name' => __('Отзывы об реб. центрах', 'brainworks'),
                'singular_name' => __('Отзыв: Реб центр', 'brainworks'),
            );

            $args = array(
                'label' => __('Отзывы об реб. центрах', 'brainworks'),
                'labels' => $labels,
                'description' => '',
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'delete_with_user' => false,
                'has_archive' => false,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'exclude_from_search' => false,
                'capability_type' => 'post',
                'map_meta_cap' => true,
                'hierarchical' => true,
                'query_var' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            );

            register_post_type('rehab_review', $args);
        }

        add_action('init', 'bw_register_rehab_reviews');
    }