<?php 
    if (!function_exists("bw_register_user_image"))
    {
        function bw_register_user_image()
        {

            $args = array(
                'supports' => array('editor'),
            );

            register_post_type('user_image', $args);
        }

        add_action('init', 'bw_register_user_image');
    }