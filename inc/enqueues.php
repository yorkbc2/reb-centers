<?php
function bw_enqueues()
{
    /** Styles */
    wp_register_style('style-css', get_template_directory_uri() . '/style.css', false, null);
    wp_enqueue_style('style-css');

    /** Scripts */
    wp_register_script('html5shiv', 'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', array(), null, false);
    wp_register_script('respond', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', array(), null, false);
    
    wp_enqueue_style('slick-min-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', null, false);

    wp_enqueue_style('slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', null, false);

    wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
    wp_script_add_data('respond', 'conditional', 'lt IE 9');

    wp_enqueue_script('html5shiv');
    wp_enqueue_script('respond');

    wp_register_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(),
        null, true);
    wp_enqueue_script('modernizr');

    // wp_register_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'),
        // null, true);


    if ( ! WP_DEBUG) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri() . '/assets/js/jquery-1.12.4.min.js', array(), null,
            true);
    }
    //

    wp_enqueue_script("siema", "https://pawelgrzybek.com/siema/assets/siema.min.js", array(), null, true);
    
    wp_register_script('brainworks-js', get_template_directory_uri() . '/assets/js/brainworks.js', array('jquery'),
        null, true);
    wp_enqueue_script('brainworks-js');

    wp_register_script('review-js', get_template_directory_uri() . '/assets/js/review-form.js', array('jquery'),
        null, true);
    wp_enqueue_script('review-js');

    wp_register_script('upload-image-js', get_template_directory_uri() . '/assets/js/upload-image.js', array('jquery'),
        null, true);
    wp_enqueue_script('upload-image-js');

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular("rehab"))
    {
        wp_enqueue_script("redux", "https://cdnjs.cloudflare.com/ajax/libs/redux/4.0.1/redux.min.js", array(), null, true);
        wp_enqueue_script("reviews-list", get_template_directory_uri() . '/assets/js/reviews-list.js', array("redux"), null, true);
    }

    

}

add_action('wp_enqueue_scripts', 'bw_enqueues', 100);

function bw_wp_head()
{
    analytics_tracking_code('head');
}

add_action('wp_head', 'bw_wp_head', 20);

function bw_wp_footer()
{
    analytics_tracking_code('body');
}

add_action('wp_footer', 'bw_wp_footer', 20);
