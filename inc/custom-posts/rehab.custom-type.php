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

    function bw_rehabs_meta( $meta_boxes ) {
        $prefix = 'bw-reb-';

        $meta_boxes[] = array(
            'id' => 'reb_meta',
            'title' => esc_html__( 'Мета-данные про реб. центры.', 'brainworks' ),
            'post_types' => array('rehab'),
            'context' => 'advanced',
            'priority' => 'default',
            'autosave' => 'true',
            'fields' => array(
                array(
                    'id' => $prefix . 'city',
                    'type' => 'text',
                    'name' => esc_html__( 'Город', 'brainworks' ),
                ),
                array(
                    'id' => $prefix . 'region',
                    'type' => 'text',
                    'name' => esc_html__( 'Область', 'brainworks' ),
                ),
                array(
                    'id' => $prefix . 'address',
                    'type' => 'text',
                    'name' => esc_html__( 'Адрес', 'brainworks' ),
                ),
                array(
                    'id' => $prefix . 'socials',
                    'type' => 'fieldset_text',
                    'name' => esc_html__( 'Соц. сети', 'brainworks' ),
                    'rows' => 2,
                    'options' => array(
                        'url' => 'URL',
                    ),
                    'clone' => true
                ),
                array(
                    'id' => $prefix . 'email',
                    'name' => esc_html__( 'Email', 'brainworks' ),
                    'type' => 'email',
                ),
                array(
                    'id' => $prefix . 'phone',
                    'type' => 'text',
                    'name' => esc_html__( 'Номер телефона', 'brainworks' ),
                ),
            ),
        );

        return $meta_boxes;
    }
    add_filter( 'rwmb_meta_boxes', 'bw_rehabs_meta' );