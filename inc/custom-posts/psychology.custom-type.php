<?php 
    if (!function_exists("bw_register_psychology"))
    {
        function bw_register_psychology()
        {
            /**
             * Post Type: Reviews.
             */
            $labels = array(
                'name' => __('Психологи', 'brainworks'),
                'singular_name' => __('Психолог', 'brainworks'),
            );

            $args = array(
                'label' => __('Психологи', 'brainworks'),
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

            register_post_type('psychology', $args);
        }

        add_action('init', 'bw_register_psychology');
    }

    function bw_psycho_meta( $meta_boxes ) {
        $prefix = 'bw-psycho-';

        $meta_boxes[] = array(
            'id' => 'psycho_meta',
            'title' => esc_html__( 'Мета-данные про психолога', 'brainworks' ),
            'post_types' => array('psychology'),
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
                array(
                    'id' => $prefix . 'tab1_name',
                    'type' => 'text',
                    'name' => esc_html__( 'Таб 1: название', 'brainworks')
                ),
                array(
                    'id' => $prefix . 'tab1_content',
                    'type' => 'wysiwyg',
                    'name' => esc_html__( 'Таб 1: Контент', 'brainworks')
                ),
                array(
                    'id' => $prefix . 'tab2_name',
                    'type' => 'text',
                    'name' => esc_html__( 'Таб 2: название', 'brainworks')
                ),
                array(
                    'id' => $prefix . 'tab2_content',
                    'type' => 'wysiwyg',
                    'name' => esc_html__( 'Таб 2: Контент', 'brainworks')
                ),
                array(
                    'id' => $prefix . 'tab3_name',
                    'type' => 'text',
                    'name' => esc_html__( 'Таб 3: название', 'brainworks')
                ),
                array(
                    'id' => $prefix . 'tab3_content',
                    'type' => 'wysiwyg',
                    'name' => esc_html__( 'Таб 3: Контент', 'brainworks')
                ),
                array(
                    'id' => $prefix . 'about',
                    'type' => 'wysiwyg',
                    'name' => esc_html__( 'О себе', 'brainworks')
                ),
            ),
        );

        return $meta_boxes;
    }
    add_filter( 'rwmb_meta_boxes', 'bw_psycho_meta' );