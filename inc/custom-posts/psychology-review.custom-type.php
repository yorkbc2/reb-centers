<?php 
    if (!function_exists("bw_register_psychology_reviews"))
    {
        function bw_register_psychology_reviews()
        {
            /**
             * Post Type: Psychology.
             */
            $labels = array(
                'name' => __('Отзывы об психологах', 'brainworks'),
                'singular_name' => __('Отзыв: Психологи', 'brainworks'),
            );

            $args = array(
                'label' => __('Отзывы об психологах', 'brainworks'),
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

            register_post_type('psychology_review', $args);
        }

        add_action('init', 'bw_register_psychology_reviews');
    }